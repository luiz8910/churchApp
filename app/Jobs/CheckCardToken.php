<?php

namespace App\Jobs;

use App\Repositories\CreditCardRepository;
use App\Services\PaymentServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckCardToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $event_id;
    private $data;

    /**
     * Create a new job instance.
     *
     * @param $card_token
     */
    public function __construct($data, $event_id)
    {

        $this->data = $data;

        $this->event_id = $event_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentServices $paymentServices, CreditCardRepository $creditCardRepository)
    {
        sleep(10);

        do{

            $status = $paymentServices->check_card($this->data, $this->event_id);

            echo 'status: ' . $status . '\n';

        }while($status =! 1);

    }
}
