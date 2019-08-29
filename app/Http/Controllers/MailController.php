<?php

namespace App\Http\Controllers;
// use App\Article_pc;
use App\Rate_pc;
use App\Rate_orgtech;
use App\Jobs\SendEmailRawMessage;
use Illuminate\Http\Request;

class MailController extends Controller
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
    public function mailconfirm($hash, $type)
    {
        if($type == 'org'){
            $confirm = Rate_orgtech::where('hash', $hash)->firstOrFail();
        } else {
            $confirm = Rate_pc::where('hash', $hash)->firstOrFail();
        }
        if ($confirm->count()) {
            if (!$confirm->confirmed) {
                $confirm->confirmed = 1;
                $confirm->save();
                dispatch(new SendEmailRawMessage(
                    [
                       'email' => $confirm->email,
                       'message' => 'Вы успешно подтвердили ставку на лот.',   
                    ])
                );
                $m = [
                    'title' => 'Успешное подтверждение',
                    'message' => 'Вы успешно подтвердили ставку на лот. Ожидайте завершения аукциона.'
                ];
                return view('messages.confirm', compact('m'));

            } else {
                $m = [
                    'title' => 'Повторное подтверждение',
                    'message' => 'Этот лот уже был подтвержден'
                ];
                return view('messages.confirm', compact('m'));
            }
        }

    }
}
