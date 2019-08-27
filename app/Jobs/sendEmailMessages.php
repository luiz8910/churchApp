<?php

namespace App\Jobs;

use App\Repositories\EventSubscribedListRepository;
use App\Repositories\PersonRepository;
use App\Services\MessageServices;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendEmailMessages implements ShouldQueue
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
    public function handle(MessageServices $messageServices, PersonRepository $personRepository,
                           EventSubscribedListRepository $listRepository)
    {

        $list = $listRepository->findByField('event_id', $this->event_id);

        foreach ($list as $item)
        {
            $person = $personRepository->findByField('id', $item->person_id)->first();

            $messageServices->sendMessageEmail($person);
        }


    }
}
