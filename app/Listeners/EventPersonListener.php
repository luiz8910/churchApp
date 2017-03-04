<?php

namespace App\Listeners;

use App\Events\PersonEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventPersonListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PersonEvent  $event
     * @return void
     */
    public function handle(PersonEvent $event)
    {
        //
    }
}
