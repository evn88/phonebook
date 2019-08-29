<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use App\Rate_orgtech;
use App\Article_orgtech;

class SendEmailOrgtech implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $r_org = new Rate_orgtech;

        $this->data = $data;
        $this->data['org'] = Article_orgtech::findOrFail($data['org_id']);
        $this->data['price'] = $r_org->where('orgtech_id', $data['org_id'])->sum('price') +  $this->data['org']['start_price'];
        $last_booking = $r_org->where('orgtech_id', $data['org_id'])->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
        $this->data['hash'] = $last_booking->hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('mail.confirmation_org', $this->data, function($message)
        {
            $message->from('service.informer@corp.voel.ru', 'Сервис бронирования техники');
            $message->to($this->data['email'])->subject('Подтверждение ставки');
            // $message->cc('e.vershkov@voel.ru');
        });
        Log::info('send mail Orgtech ok: '.$this->data['email']);
    }
}
