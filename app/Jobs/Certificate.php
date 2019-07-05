<?php

namespace App\Jobs;

use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Services\MessageServices;
use App\Traits\ConfigTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class Certificate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ConfigTrait;
    private $event_id;
    private $org_id;
    /**
     * @var null
     */
    private $person_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event_id, $org_id, $person_id = null)
    {
        //
        $this->event_id = $event_id;
        $this->org_id = $org_id;
        $this->person_id = $person_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EventRepository $eventRepository, PersonRepository $personRepository,
                           ChurchRepository $churchRepository, MessageServices $messageServices)
    {
        $event = $eventRepository->findByField('id', $this->event_id)->first();

        if($event)
        {
            if($this->person_id)
            {
                $person = $personRepository->findByField('id', $this->person_id)->first();

                if ($person)
                {
                    if($person->email)
                    {
                        echo 'Realizando Download...';

                        $messageServices->sendCertificate($person->user, $person, $event);
                    }

                }
            }

            else{

                $i = 0;

                $people = DB::table('event_person')
                    ->where([
                        'event_id' => $this->event_id,
                        'check-in' => 1
                    ])->get();

                foreach ($people as $item)
                {
                    $person = $personRepository->findByField('id', $item->person_id)->first();

                    if ($person)
                    {
                        if($person->email)
                        {
                            echo 'Realizando Download...';

                            $messageServices->sendCertificate($person->user, $person, $event);

                            $i++;

                            if($i == 10)
                            {
                                $i = 0;
                                sleep(1);
                            }
                        }

                    }

                }
            }
        }

    }
}
