<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Rate_pc;
use App\Rate_orgtech;

class DeleteNotConfirmed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $hash;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hash, $type)
    {
        $this->type = $type;
        $this->hash = $hash;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    { 
        if($this->type === 'pc'){
            $pc = new Rate_pc;
        } else {
            $pc = new Rate_orgtech;
        }
        $data = $pc->where('hash', $this->hash)->get();
        $this->email = $data[0]['email'];
        
        Log::info('delete lot handle hash: '.$this->hash);
        Log::info('delete lot handle email: '.$this->email);
        if(!$data[0]['confirmed']){
            $pc->where('hash', $this->hash)->delete();
            Log::info('Lot deleted '. $this->hash);

            Mail::raw('Ваша ставка была удалена так как вы не прошли подтверждение', function($message)
            {
                $message->from('service.informer@corp.voel.ru', 'Сервис бронирования техники');
                $message->to($this->email)->subject('Ставка удалена');
            });
        } else {
            Log::info('Lot NOT deleted '. $this->hash);
        }
    }
}
