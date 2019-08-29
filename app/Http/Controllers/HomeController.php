<?php

namespace App\Http\Controllers;
use App\Article_pc;
use App\Rate_pc;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $comps = Article_pc::all();
        // //проверка брони
        // foreach ($comps as &$pc){
        //     if ($r_pc = Rate_pc::where('pc_id','=', $pc->id)->sum('price')){ //суммируем сумму перекупок
        //         $pc->start_price = $pc->start_price + $r_pc;    //прибавляем к начальной стоимости
        //         $pc->is_booked = true; //ставим пометку о перекупе
        //         $pc->booked_user = Rate_pc::where('pc_id','=', $pc->id)->orderBy('id','desc')->first()->username; //кто последний купил
        //     }
        // }
        // unset($pc);

        return view('home', compact('comps'));
    }
}
