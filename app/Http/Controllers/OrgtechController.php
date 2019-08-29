<?php

namespace App\Http\Controllers;
use Validator;
use App\Rate_orgtech;
use App\Article_orgtech;
use App\Jobs\SendEmailOrgtech;
use App\Jobs\DeleteNotConfirmed;
use App\Jobs\SendEmailRawMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrgtechController extends Controller
{
    private function current_data() { return Carbon::now(); }
    private function open_auction() { return Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_OPEN_DATA')); }
    private function closed_auction() { return Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_CLOSED_DATA')); }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orgtech');
    }

    public function total(){
        $orgtechs = Article_orgtech::orderBy('year')->get();
        // $current = Carbon::now();
        // $closed = Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_CLOSED_DATA'));

        //проверка брони
        foreach ($orgtechs as &$org){
            $r_org = new Rate_orgtech;
            if ($r_org->where('orgtech_id', $org->id)->count()) { //суммируем сумму перекупок
                
                $last_booking = $r_org->where('orgtech_id', $org->id)->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
                $r_sum = $r_org->where('orgtech_id', $org->id)->confirmed()->sum('price'); //сумма всех заявок для брони
                $org->total_price = $org->start_price + $r_sum;    //прибавляем к начальной стоимости
                if ($last_booking->confirmed){
                    $org->is_booked = true; //ставим пометку о перекупе
                } else {
                    if ($last_booking->hash) { $org->reserved = true; }
                    $org->is_booked = false; //ставим пометку о перекупе
                }

                $org->booked_user = $last_booking->username; //кто последний купил
                $org->booked_filial = $last_booking->area; //кто последний купил
                $org->booked_date = $last_booking->created_at; //когда забронировали/перекупили
                $org->booked_confirm_date =  $last_booking->updated_at; //когда подтвердил
                $org->booked_count = $r_org->where('orgtech_id', $org->id)->count();
                
                $d_plus10 = (new Carbon($org->booked_date))->addDays(30);
                $org->booked_end_days = $this->current_data()->diffInDays($d_plus10, false); //дней до закрытия брони
                $org->booked_end_date = $d_plus10->format('d.m.Y'); //дата закрытия брони
            }
            // $org->booked_closed = $this->current_data()->greaterThan($this->closed_auction());
        }
        unset($org);
        return view('totalorg', compact('orgtechs'));
    }

    public function json()
    {
        $orgtechs = Article_orgtech::orderBy('year')->get();

        //проверка брони
        foreach ($orgtechs as &$org){
            $r_org = new Rate_orgtech;
            if ($r_org->where('orgtech_id', $org->id)->count()) { //суммируем сумму перекупок
                
                $last_booking = $r_org->where('orgtech_id', $org->id)->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
                $r_sum = $r_org->where('orgtech_id', $org->id)->confirmed()->sum('price'); //сумма всех заявок для брони
                $org->start_price = $org->start_price + $r_sum;    //прибавляем к начальной стоимости
                if ($last_booking->confirmed){
                    $org->is_booked = true; //ставим пометку о перекупе
                } else {
                    if ($last_booking->hash) { $org->reserved = true; }
                    $org->is_booked = false; //ставим пометку о перекупе
                }

                $org->booked_user = $last_booking->username; //кто последний купил
                $org->booked_date = $last_booking->created_at; //когда забронировали/перекупили
                
                // $d_plus10 = (new Carbon($org->booked_date))->addDays(30);
                // $org->booked_end_days = $this->current_data()->diffInDays($d_plus10, false); //дней до закрытия брони
                // $org->booked_end_date = $d_plus10->format('d.m.Y (H:m)'); //дата закрытия брони
            }
            if($this->current_data()->lessThan($this->open_auction()) || $this->current_data()->greaterThan($this->closed_auction())) $pc->booked_closed = true;
        }
        unset($org);

        return $orgtechs->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $current = Carbon::now();
        // $closed = Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_CLOSED_DATA'));
        $v = Validator::make($request->all(), [
                'orgtech_id' => 'required|integer',
                'username'  => 'required|max:255',
                'area'  => 'required|max:255',
                'email' => array(
                    'required',
                    'regex:/(\w{0,}.\w{0,}.\w{0,})(?=@(zavmes|sevmes|surmes|mmes|kmes|prmes|jmes|corp|)(.|)voel.ru)/ui',
                )
            ]);

        if ($v->fails())
        {
            Log::info($v->errors());
            return view('errors.store')->withErrors($v);
        }

        
        if(!($this->current_data()->lessThan($this->open_auction()) || $this->current_data()->greaterThan($this->closed_auction()))) {
            $last_booking = Rate_orgtech::where('orgtech_id', $request->orgtech_id)->orderBy('id', 'desc')->first();
            if($last_booking){
                $last_user_email = $last_booking->email;
                $last_user_name = $last_booking->username;
        
                //редиректим и уведомляем для тех кто хочет забронировать неподтвержденных
                //например если не обновить страницу и забронировать лот который уже забронировал кто-то другой ранее.
                $busy_confirmed = ($last_booking->hash && !$last_booking->confirmed) ? true:false; //определем ожидает ли подтверждения лот
                if($busy_confirmed){
                    dispatch(new SendEmailRawMessage(
                        [
                            'email' => $request->email,
                            'message' => 'Лот, который вы пытаетесь забронировать/перекупить в данный момент ожидает подтверждения от другого пользователя: '. $last_user_name 
                            .'. Дождитесь завершения и попробуйте снова.',   
                        ])
                    );
                    return redirect(route('orgtech.index'));
                }
        
                if($last_user_email){
                    //уведомляем о перекупе если есть email
                    $event_rebooking = (($last_booking->hash || !$last_booking->hash) && $last_booking->confirmed) ? true:false; //если пытаются перекупить
                    $org_info = Article_orgtech::where('id', $request->orgtech_id)->first();
                    if($event_rebooking){
                        dispatch(new SendEmailRawMessage(
                            [
                               'email' => $last_user_email,
                               'message' => '
                                Пользователь: '. $request->username .', только что сделал ставку на ваш лот:
                                -----------------------------------------       
                                ' . $org_info->inventar .' 
                                '. $org_info->type .'
                                '. $org_info->model .'
                                -----------------------------------------',   
                            ])
                        );
                    }
                } else {
                    Log::info('e-mail для пользователя '. $last_user_name .' не указан, сообщение небыло отправлено.');
                }
            }
            
            //сохраняем ставку
            $org = new Rate_orgtech;
            $org->username = $request->username;
            $org->orgtech_id = $request->orgtech_id;
            $org->area = $request->area;
            $org->email = $request->email;
            $org->ip = $request->ip;
            $org->hash = hash('sha256', $request->ip.'_'.$request->email.'_'.$current);
            (Rate_orgtech::where('orgtech_id', $request->orgtech_id)->count()) ? $org->price = 500 : $org->price = 0;
            $org->save();   
    
            //отправляем почту в очердь
            dispatch(new SendEmailOrgtech(
                [
                    'org_id' => $request->orgtech_id,
                    'username' => $request->username,
                    'email' => $request->email,
                    'price' => $org->price,   
                ])
            );
            
            //запускаем через 5 минут проверку, если не подтвердили удаляем запись.
            dispatch(new DeleteNotConfirmed($org->hash, 'org'))->delay(Carbon::now()->addMinutes(5));
            return redirect(route('orgtech.index'));
        }
        return view('errors.auction_closed', [
            'closed' => $this->closed_auction()->format('d.m.Y H:m:s'),
            'open'   => $this->open_auction()->format('d.m.Y H:m:s')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}