<?php

namespace App\Listeners;

use App\Events\PendingQuestion;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendingQuestionListener
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
     * @param  PendingQuestion  $event
     * @return void
     */
    public function handle(PendingQuestion $event)
    {
        //
    }
}
