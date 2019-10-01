<?php

namespace App\Http\Controllers\Api;

use App\Filial;
use App\Departament;
use App\People;
use App\FilialDepartamentPeople;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    // private function current_data() { return Carbon::now(); }
    // private function open_auction() { return Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_OPEN_DATA')); }
    // private function closed_auction() { return Carbon::createFromFormat('d.m.Y H:i:s', env('AUCTION_CLOSED_DATA')); }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('computer');
    }


    public function json()
    {
        // $people = People::has('filial')->get();
        // dd($people[0]->filial->name);
        $i = 0;

        //TODO: Надо менять структуру отношений, так велосипед выходит :(

        $data = [
            // 'filials' => [
            //     [
            //         'id'=>'0',
            //         'name'=>'ЦРПБ',
            //         'departaments'=>[
            //             [
            //                 'id'=>'1',
            //                 'name'=>'Администрация',
            //                 'people'=>[
            //                     [
            //                         'id'=>'1',
            //                         'name'=>'Egor',
            //                         'profession'=>'CEO',
            //                         'tel'=>'1081'
            //                     ],
            //                     [
            //                         'id'=>'2',
            //                         'name'=>'Serg',
            //                         'profession'=>'CEO',
            //                         'tel'=>'1081'
            //                     ]
            //                 ]
            //             ],
            //             [
            //                 'id'=>'2',
            //                 'name'=>'Контрольное управление',
            //                 'people'=>[
            //                     [
            //                         'id'=>'3',
            //                         'name'=>'Виноградов А.В.',
            //                         'profession'=>'CEO',
            //                         'tel'=>'1081'
            //                     ],
            //                     [
            //                         'id'=>'4',
            //                         'name'=>'Текутов',
            //                         'profession'=>'CEO',
            //                         'tel'=>'1081'
            //                     ]
            //                 ]
            //             ]
            //         ]
            //     ],
            //     [
            //         'id'=>'1',
            //         'name'=>'ЖМЭС',
            //     ]

            // ]
        ];
        // dd($data);

        $buffer_f = '';
        $buffer_d = '';
        $filials = Filial::orderBy('order','asc')->get();


            foreach($filials as $fkey=>$f)
            {
                $data['filials'][$fkey] = $f;
                // echo '<b>'. $f->name . '</b></br>';

                //находим все отделы в филиале, создаем массив ключей
                $departament_keys = People::where('filial_id', $f->id)->get('departament_id')->groupBy('departament_id')->keys();
                foreach(Departament::find($departament_keys)->sortBy('order') as $dkey=>$dep){
                    // print_r($dep->name);
                    $data['filials'][$fkey]['departaments'][$dkey] = $dep;

                    // echo $dep->name . '<br>';
                    //находим всех людей
                    // foreach(People::where('departament_id', $dep->id)->get()->sortByDesc('order') as $pkey=>$p){
                    //     $data['filials'][$fkey]['departaments'][$dkey]['people'][$pkey] = $p;
                    //     // echo $p->name . '<br>';
                    // }
                }
            }
            // dd($data);
        $json = $data;


        // $path = storage_path()."/app/json/contacts.json";
        // $json = json_decode(file_get_contents($path), true);
        // dd($json);
        return $json;
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
        //
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