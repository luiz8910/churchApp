<?php

namespace App\Jobs;


use App\Services\PaymentServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PaymentApproved implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $event_id;
    public $x;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($x, $event_id)
    {

        $this->x = $x;
        $this->event_id = $event_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentServices $paymentServices)
    {
        $paymentServices->createTransaction($this->x, $this->event_id);
    }
}
