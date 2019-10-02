<?php

namespace App\Http\Controllers\Api;

use App\Filial;
use App\Departament;
use App\People;
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


    /** Собираем json с данными телефонного справочника для frontend */
    public function json()
    {
        $data = [];

        $f_index = $d_index = $p_index = 0;

        $filials = Filial::orderBy('order','asc')->get();
            foreach($filials as $fkey=>$f)
            {
                // echo '<b>'. $f->name . '</b></br>';
                $data['filials'][$f_index] = $f->toArray();

                //находим все подразделения в филиале, создаем массив ключей
                $departament_keys = People::where('filial_id', $f->id)->get('departament_id')->groupBy('departament_id')->keys();

                foreach(Departament::find($departament_keys)->sortBy('order') as $dkey=>$dep)
                {
                    // print_r($dep->name.'<br>');
                    //получаем все подразделения
                    $data['filials'][$f_index]['departaments'][$d_index] = $dep->toArray();

                    // echo $dep->name . '<br>';
                    //находим всех людей
                    foreach(People::where([['departament_id', '=', $dep->id],['filial_id', '=', $f->id]])->get()->sortByDesc('order') as $pkey=>$p)
                    {
                        $data['filials'][$f_index]['departaments'][$d_index]['people'][$p_index] = $p->toArray();
                        // echo $p->name . '<br>';
                        $p_index++;
                    }
                    $d_index++;
                }
                $f_index++;
            }

        //для отладки:
        // $path = storage_path()."/app/json/contacts.json";
        // $json = json_decode(file_get_contents($path), true);

        return $data;
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