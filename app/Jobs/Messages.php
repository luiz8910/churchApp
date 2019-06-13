<?php

namespace App\Jobs;

use App\Repositories\EventSubscribedListRepository;
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




    }
}
