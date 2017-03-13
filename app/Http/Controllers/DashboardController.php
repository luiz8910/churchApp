<?php

namespace App\Http\Controllers;

use App\Repositories\CountRepository;
use App\Repositories\EventRepository;
use App\Repositories\NotifyRepository;
use Illuminate\Http\Request;
use File;

class DashboardController extends Controller
{
    use CountRepository, NotifyRepository;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $events = $this->eventRepository->all();

        $this->json();

        $notify[] = $this->notify();

        //dd($notify);

        return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify'));
    }

    public function json()
    {
        $events = $this->eventRepository->all();

        $length = count($events);

        $i = 0;

        $x = ',';

        $json = '[';

        foreach ($events as $event)
        {
            $i++;

            if($i == $length)
            {
                $x = "";
            }

            $event->allDay = $event->allDay == 1 ? "true" : "false";


            $json .= '{
                "title" : '.'"'.$event->name.'"'.',
                "id": '.'"'.$event->id.'"'.',
                "start": '.'"'.$event->eventDate."T".$event->startTime.'"'.',
                "end": '.'"'.$event->endEventDate.'"'.',
                "url": '.'"events/'.$event->id.'/edit"'.',
                "allDay": '.'"'.$event->allDay.'"'.'
            }'.$x.'';
        }

        $json .= ']';

        File::put(public_path('js/events.json'), $json);
    }
}
