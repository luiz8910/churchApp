<?php

namespace App\Http\Controllers;

use App\Repositories\VisitorRepository;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Repositories\EventRepository;
use App\Traits\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;
use File;
use App\Services\AgendaServices;
use App\Services\EventServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use CountRepository, NotifyRepository, DateRepository, FormatGoogleMaps;

    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var AgendaServices
     */
    private $agendaServices;
    /**
     * @var EventServices
     */
    private $eventServices;

    public function __construct(EventRepository $eventRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository, VisitorRepository $visitorRepository,
                                AgendaServices $agendaServices, EventServices $eventServices)
    {
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
        $this->agendaServices = $agendaServices;
        $this->eventServices = $eventServices;
    }

    public function index()
    {

        if(!Auth::getUser()->person)
        {
            return $this->visitors();
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $events = $this->eventRepository->all();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $id = Auth::getUser()->person_id;

        $person = $this->personRepository->find($id);

        $groups = $person->groups()->paginate() or null;

        if($groups)
        {
            foreach ($groups as $group)
            {
                $group->sinceOf = $this->formatDateView($group->sinceOf);
                $countMembers[] = count($group->people->all());
            }
        }

        if (count($events) == 0)
        {
            return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
                'countMembers', 'street', 'groups'));
        }

        $eventDate = [];
        $i = 0;

        foreach ($events as $event)
        {
            $eventDate[] = DB::table('event_person')
                ->where(
                    [
                        'event_id' => $event->id,
                        'person_id' => Auth::user()->person_id,
                        'show' => 0,
                        'deleted_at' => null
                    ])
                ->first();

            $eventDate[$i]->eventDate = $this->formatDateView($eventDate[$i]->eventDate);
            $i++;
        }


        $event_person = [];

        foreach ($eventDate as $item)
        {
            $event_person[] = $this->eventRepository->find($item->event_id);
        }



        $nextEvent = $this->getNextEvent();

        $event = $this->eventRepository->find($nextEvent->event_id);

        $street = $event->street;

        $location = $this->formatGoogleMaps($event);

        $days = $this->agendaServices->findWeek();

        $nextWeek = $this->agendaServices->findWeek('next');

        $prevWeek = $this->agendaServices->findWeek('prev');

        $twoWeeks = $this->agendaServices->findWeek('2 weeks');

        $allEvents = $this->eventServices->allEvents();

        for($i = 0; $i < 7; $i++) { array_push($days, $nextWeek[$i]); }

        for($i = 0; $i < 7; $i++) { array_push($days, $twoWeeks[$i]); }

        foreach ($days as $day) { array_push($prevWeek, $day); }

        $days = $prevWeek;

        $nextMonth = [];
        $nextMonth2 = [];
        $nextMonth3 = [];
        $nextMonth4 = [];
        $nextMonth5 = [];
        $nextMonth6 = [];

        $prevMonth = [];
        $prevMonth2 = [];
        $prevMonth3 = [];
        $prevMonth4 = [];
        $prevMonth5 = [];
        $prevMonth6 = [];

        $prevMonth = array_merge($prevMonth, $this->agendaServices->findMonth(-1));
        $prevMonth = array_merge($prevMonth, $this->agendaServices->findMonth(-1, 'next'));
        $prevMonth = array_merge($prevMonth, $this->agendaServices->findMonth(-1, '2 weeks'));

        $prevMonth2 = array_merge($prevMonth2, $this->agendaServices->findMonth(-2));
        $prevMonth2 = array_merge($prevMonth2, $this->agendaServices->findMonth(-2, 'next'));
        $prevMonth2 = array_merge($prevMonth2, $this->agendaServices->findMonth(-2, '2 weeks'));

        $prevMonth3 = array_merge($prevMonth3, $this->agendaServices->findMonth(-3));
        $prevMonth3 = array_merge($prevMonth3, $this->agendaServices->findMonth(-3, 'next'));
        $prevMonth3 = array_merge($prevMonth3, $this->agendaServices->findMonth(-3, '2 weeks'));

        $prevMonth4 = array_merge($prevMonth4, $this->agendaServices->findMonth(-4));
        $prevMonth4 = array_merge($prevMonth4, $this->agendaServices->findMonth(-4, 'next'));
        $prevMonth4 = array_merge($prevMonth4, $this->agendaServices->findMonth(-4, '2 weeks'));

        $prevMonth5 = array_merge($prevMonth5, $this->agendaServices->findMonth(-5));
        $prevMonth5 = array_merge($prevMonth5, $this->agendaServices->findMonth(-5, 'next'));
        $prevMonth5 = array_merge($prevMonth5, $this->agendaServices->findMonth(-5, '2 weeks'));

        $prevMonth6 = array_merge($prevMonth6, $this->agendaServices->findMonth(-6));
        $prevMonth6 = array_merge($prevMonth6, $this->agendaServices->findMonth(-6, 'next'));
        $prevMonth6 = array_merge($prevMonth6, $this->agendaServices->findMonth(-6, '2 weeks'));

        //$p = AgendaServices::findMonth(1, 'prev');

        $nextMonth = array_merge($nextMonth, $this->agendaServices->findMonth(1));
        $nextMonth = array_merge($nextMonth, $this->agendaServices->findMonth(1, 'next'));
        $nextMonth = array_merge($nextMonth, $this->agendaServices->findMonth(1, '2 weeks'));

        $nextMonth2 = array_merge($nextMonth2, $this->agendaServices->findMonth(2));
        $nextMonth2 = array_merge($nextMonth2, $this->agendaServices->findMonth(2, 'next'));
        $nextMonth2 = array_merge($nextMonth2, $this->agendaServices->findMonth(2, '2 weeks'));

        $nextMonth3 = array_merge($nextMonth3, $this->agendaServices->findMonth(3));
        $nextMonth3 = array_merge($nextMonth3, $this->agendaServices->findMonth(3, 'next'));
        $nextMonth3 = array_merge($nextMonth3, $this->agendaServices->findMonth(3, '2 weeks'));

        $nextMonth4 = array_merge($nextMonth4, $this->agendaServices->findMonth(4));
        $nextMonth4 = array_merge($nextMonth4, $this->agendaServices->findMonth(4, 'next'));
        $nextMonth4 = array_merge($nextMonth4, $this->agendaServices->findMonth(4, '2 weeks'));

        $nextMonth5 = array_merge($nextMonth5, $this->agendaServices->findMonth(5));
        $nextMonth5 = array_merge($nextMonth5, $this->agendaServices->findMonth(5, 'next'));
        $nextMonth5 = array_merge($nextMonth5, $this->agendaServices->findMonth(5, '2 weeks'));

        $nextMonth6 = array_merge($nextMonth6, $this->agendaServices->findMonth(6));
        $nextMonth6 = array_merge($nextMonth6, $this->agendaServices->findMonth(6, 'next'));
        $nextMonth6 = array_merge($nextMonth6, $this->agendaServices->findMonth(6, '2 weeks'));

        $allMonths = $this->agendaServices->allMonths();

        $allDays = $this->agendaServices->allDaysName();

        //dd($notify);

        return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
            'days', 'nextMonth', 'nextMonth2', 'allEvents', 'countMembers', 'nextEvent', 'location', 'street',
            'nextMonth3', 'nextMonth4', 'nextMonth5', 'nextMonth6', 'prevMonth', 'prevMonth2',
            'prevMonth3', 'prevMonth4', 'prevMonth5', 'prevMonth6',
            'allMonths', 'allDays', 'groups', 'eventDate', 'event_person'));
    }

    public function visitors()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $events = $this->eventRepository->all();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $groups = null;

        if (count($events) == 0)
        {
            return view('dashboard.visitors', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
                'countMembers', 'street', 'groups'));
        }

        $groups = $this->groupRepository->paginate();

        foreach ($groups as $group)
        {
            $group->sinceOf = $this->formatDateView($group->sinceOf);
            $countMembers[] = count($group->people->all());
        }

        $allMonths = AgendaServices::allMonths();

        //Recupera a semana atual
        $days = AgendaServices::findWeek();
        
        return view('dashboard.visitors', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
            'street', 'groups', 'countMembers', 'allMonths', 'days'));
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

    public function getNextEvent()
    {
        $today = date("Y-m-d");

        return DB::table("event_person")
            ->where("eventDate", ">=", $today)
            ->first();
    }
}
