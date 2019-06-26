<?php

namespace App\Jobs;

use App\Models\Person;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\PersonRepository;
use App\Services\MessageServices;
use App\Services\qrServices;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class SendQrEmail implements ShouldQueue
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
    public function handle(PersonRepository $personRepository, EventRepository $eventRepository,
                           MessageServices $messageServices, EventSubscribedListRepository $listRepository, qrServices $qrServices)
    {

        $i = 0;
        $users_count = 0;

        $event = $eventRepository->findByField('id', $this->event_id)->first();

        if($event)
        {
            $list = $listRepository->findByField('event_id', $this->event_id);

            if($list)
            {
                foreach ($list as $item)
                {
                    $person = $personRepository->findByField('id', $item->person_id)->first();

                    if($person && $person->user)
                    {
                        $user = $person->user;

                        if($person->qrCode == null)
                        {
                            $qrServices->generateQrCode($item->person_id);
                        }

                        $qrCode = "https://beconnect.com.br/" . $person->qrCode;

                        $messageServices->welcome_sub($user, $event, $qrCode);

                        DB::table('msg_jobs')
                            ->insert([
                                'person_id' => $item->person_id,
                                'channel' => 'email',
                                'responseCode' => 200,
                                'responseText' => 'OK',
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);

                        $users_count++;

                        $i++;

                        if($i == 10)
                        {
                            sleep(1);
                            $i = 0;
                        }
                    }

                }

                $person = Person::where(['id' => 21])->first();

                $user = $person->user;

                \Notification::send($user, new \App\Notifications\Test($users_count));
            }


        }


    }
}
