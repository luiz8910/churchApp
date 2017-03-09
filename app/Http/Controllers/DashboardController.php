<?php

namespace App\Http\Controllers;

use App\Repositories\CountRepository;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;
use File;

class DashboardController extends Controller
{
    use CountRepository;

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

        return view('dashboard.index', compact('countPerson', 'countGroups', 'events'));
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

            $json .= '{
                "title" : '.'"'.$event->name.'"'.',
                "id": '.'"'.$event->id.'"'.',
                "start": '.'"'.$event->eventDate.'"'.'
            }'.$x.'';
        }

        $json .= ']';

        File::put(public_path('js/events.json'), $json);
    }
}
