<?php

use App\Jobs\SendEmailComputers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/computer', 'ComputerController', ['only' => [
    'index', 'store'
]]);
Route::resource('/orgtech', 'OrgtechController', ['only' => [
    'index', 'store'
]]);

Route::get('/computer/total', 'ComputerController@total');
Route::get('/orgtech/total', 'OrgtechController@total');


Route::get('/mailconfirm/{hash}/{type}/', 'MailController@mailconfirm')->name('mailconfirm');



Auth::routes();

