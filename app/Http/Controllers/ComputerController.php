<?php

namespace App\Http\Controllers;
use Validator;
use App\Rate_pc;
use App\Article_pc;
use App\Jobs\SendEmailComputers;
use App\Jobs\DeleteNotConfirmed;
use App\Jobs\SendEmailRawMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComputerController extends Controller
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
        return view('computer');
    }

    public function total()
    {
        $comps = Article_pc::orderBy('year')->get();
        
        //проверка брони
        foreach ($comps as &$pc){
            $r_pc = new Rate_pc;
            if ($r_pc->where('pc_id', $pc->id)->count()) { //суммируем сумму перекупок

                $last_booking = $r_pc->where('pc_id', $pc->id)->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
                $r_sum = $r_pc->where('pc_id', $pc->id)->confirmed()->sum('price'); //сумма всех заявок для брони
                $pc->total_price = $pc->start_price + $r_sum;    //прибавляем к начальной стоимости
                if ($last_booking->confirmed){
                    $pc->is_booked = true; //ставим пометку о перекупе
                } else { 
                    if ($last_booking->hash) { $pc->reserved = true; } 
                    $pc->is_booked = false; 
                }

                $pc->booked_user = $last_booking->username; //кто последний купил
                $pc->booked_filial = $last_booking->area; //кто последний купил
                $pc->booked_date = $last_booking->created_at; //когда забронировали/перекупили
                $pc->booked_confirm_date = $last_booking->updated_at; //когда подтвердил
                $pc->booked_count = $r_pc->where('pc_id', $pc->id)->count();

                $d_plus10 = (new Carbon($pc->booked_date))->addDays(30); //+3 часа
                $pc->booked_end_days = $this->current_data()->diffInDays($d_plus10, false); //дней до закрытия брони
                $pc->booked_end_date = $d_plus10->format('d.m.Y (H:m)'); //дата закрытия брони
            }
            // $pc->booked_closed = $this->current_data()->greaterThan($this->closed_auction());
        }
        unset($pc);
        return view('totalpc', compact('comps'));
    }

    public function json()
    {
        $comps = Article_pc::orderBy('year')->get();
        
        //проверка брони
        foreach ($comps as &$pc){
            $r_pc = new Rate_pc;
            if ($r_pc->where('pc_id', $pc->id)->count()) { //суммируем сумму перекупок

                $last_booking = $r_pc->where('pc_id', $pc->id)->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
                $r_sum = $r_pc->where('pc_id', $pc->id)->confirmed()->sum('price'); //сумма всех заявок для брони
                $pc->start_price = $pc->start_price + $r_sum;    //прибавляем к начальной стоимости
                if ($last_booking->confirmed){
                    $pc->is_booked = true; //ставим пометку о перекупе
                } else { 
                    if ($last_booking->hash) { $pc->reserved = true; } 
                    $pc->is_booked = false; 
                }

                $pc->booked_user = $last_booking->username; //кто последний купил
                $pc->booked_date = $last_booking->created_at; //когда забронировали/перекупили

            }
            if($this->current_data()->lessThan($this->open_auction()) || $this->current_data()->greaterThan($this->closed_auction())) $pc->booked_closed = true;
        }
        unset($pc);

        return $comps->toJson();
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
        $closed = $this->closed_auction();
        $v = Validator::make($request->all(), [
                'pc_id' => 'required|integer',
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
            $last_booking = Rate_pc::where('pc_id', $request->pc_id)->orderBy('id', 'desc')->first();
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
                    return redirect(route('computer.index'));
                }
        
                if($last_user_email){
                    
                    //уведомляем о перекупе если есть email
                    $event_rebooking = (($last_booking->hash || !$last_booking->hash) && $last_booking->confirmed) ? true:false; //если пытаются перекупить
                    $pc_info = Article_pc::where('id', $request->pc_id)->first();
                    if($event_rebooking){
                        dispatch(new SendEmailRawMessage(
                            [
                               'email' => $last_user_email,
                               'message' => '
                                Пользователь: '. $request->username .', только что сделал ставку на ваш лот:
                                -----------------------------------------       
                                ' . $pc_info->inventar .' 
                                ' . $pc_info->pcconfig .'
                                ' . $pc_info->monitor . '
                                -----------------------------------------',   
                            ])
                        );
                    }
                } else {
                    Log::info('e-mail для пользователя '. $last_user_name .' не указан, сообщение небыло отправлено.');
                }
            }
            
            // сохраняем ставку
            $pc = new Rate_pc;
            $pc->username = $request->username;
            $pc->pc_id = $request->pc_id;
            $pc->area = $request->area;
            $pc->email = $request->email;
            $pc->ip = $request->ip;
            $pc->hash = hash('sha256',$request->ip  .'_'. $request->email .'_'. $this->current_data());
            (Rate_pc::where('pc_id', $request->pc_id)->count()) ? $pc->price = 500 : $pc->price = 0;
            $pc->save(); 
    
            //отправляем почту в очердь
            dispatch(new SendEmailComputers(
                [
                    'pc_id' => $request->pc_id,
                    'username' => $request->username,
                    'email' => $request->email,
                    'price' => $pc->price,   
                ])
            );
            
            //запускаем через 5 минут проверку, если не подтвердили удаляем запись.
            dispatch(new DeleteNotConfirmed($pc->hash, 'pc'))->delay(Carbon::now()->addMinutes(5));
            return redirect(route('computer.index'));
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