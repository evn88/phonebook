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
        foreach (FilialDepartamentPeople::with('filial','departament','people')->get() as $fdp)
        {
            if ($fdp->filial->name === $buffer_f)
            {
                $f_key = array_search($fdp->filial->name, array_column($data['filials'], 'name'));
                $data['filials'][$f_key] = $fdp->filial;
                // dd($f_key);

            }
            else
            {
                $data['filials'][] = $fdp->filial;
                $buffer_f = $fdp->filial->name;
            }

            $i++;
        }
        // dd($data);
        $json = $data;

        //  $json = '{
        //     "filials": [
        //       {
        //         "id": 1,
        //         "name": "ЦРПБ",
        //         "departaments": [
        //           {
        //             "id":1,
        //             "name": "OIT",
        //             "people": [
        //               { "id":1, "name": "Вершков Егор Николаевич", "profession":"Администратор безопасности ИТ", "tel":"1084"},
        //               { "id":2, "name": "Зубенко Сергей Владимирович", "profession":"Главный инженер", "tel":"1083"}
        //             ]
        //           },
        //           {
        //             "id":2,
        //             "name": "Служба связи",
        //             "people": [
        //               { "id":3, "name": "Федотов Иван", "profession":"Зам. генерального директора по реализации услуг и правовым вопросам", "tel":"1081"},
        //               { "id":4, "name": "Мисюряев Михаил", "profession":"Зам. генерального директора по капитальному строительству и общим вопросам", "tel":"1082"},
        //               { "id":5, "name": "Мисюряев Михаил", "profession":"Зам. генерального директора по капитальному строительству и общим вопросам", "tel":"1082"},
        //               { "id":6, "name": "Мисюряев Михаил", "profession":"Зам. генерального директора по капитальному строительству и общим вопросам", "tel":"1082"}
        //             ]
        //           }
        //         ]
        //       }

        //     ]
        // }';

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