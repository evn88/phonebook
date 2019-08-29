<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmailRawMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $arr;
    protected $email;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr)
    {
        $this->email = $arr['email'];
        $this->msg = $arr['message'];
        Log::info('send raw message email: '.$this->email);
        Log::info('send raw message msg: '.$this->msg);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 
        Mail::raw($this->msg, function($message)
        {
            $message->from('noreply@voel.ru', 'Сервис бронирования техники');
            $message->to($this->email)->subject('Уведомление');
        });
        Log::info('send raw message email ok: '.$this->email);
    }
}
