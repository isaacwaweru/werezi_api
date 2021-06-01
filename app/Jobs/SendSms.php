<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FutureFast\Tradesk\SMS;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message, $phone_number;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone_number, $message)
    {
        $this->message = $message;
        $this->phone_number = $phone_number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sms = SMS::config([
            'app_key' => '5FDC981F2B6B5',
            'app_secret' => 'tpTH3YzqQjEgS98OTZE8'
        ]);
    
        $sms->to($this->phone_number)->message($this->message)->send();
    }
}
