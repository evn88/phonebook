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
        // $comps = Article_pc::all();

        return view('home');
    }
}
