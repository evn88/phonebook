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
use App\Rate_pc;
use App\Article_pc;
use DaveJamesMiller\Breadcrumbs\Exception;

class SendEmailComputers implements ShouldQueue
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
        $r_pc = new Rate_pc;

        $this->data = $data;
        $this->data['comp'] = Article_pc::findOrFail($data['pc_id']);
        $this->data['price'] = $r_pc->where('pc_id', $data['pc_id'])->sum('price') +  $this->data['comp']['start_price'];
        $last_booking = $r_pc->where('pc_id', $data['pc_id'])->orderBy('id','desc')->first(); //последняя запись о брони/перекупке
        $this->data['hash'] = $last_booking->hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('mail.confirmation_pc', $this->data, function($message)
        {
            $message->from('service.informer@corp.voel.ru', 'Сервис бронирования техники');
            $message->to($this->data['email'])->subject('Подтверждение ставки');
            // $message->cc('e.vershkov@voel.ru');
        });

        Log::info('send mail computers ok: '.$this->data['email']. ' '. $this->data['comp'] );
    }
}