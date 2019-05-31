<?php

namespace App\Jobs;

use App\Services\MessageServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Messages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $event_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event_id)
    {
        //
        $this->event_id = $event_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = new MessageServices();

        //$data['number'] = '5515997454531';//'5511993105830';

        $message->send_QR_WP($this->event_id);

        sleep(10);


    }
}
