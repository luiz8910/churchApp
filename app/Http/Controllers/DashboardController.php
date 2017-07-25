<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RecentEvents;
use App\Models\RecentGroups;
use App\Models\RecentUsers;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Traits\ConfigTrait;
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
    use CountRepository, NotifyRepository, DateRepository, FormatGoogleMaps, ConfigTrait;

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
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(EventRepository $eventRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository, VisitorRepository $visitorRepository,
                                AgendaServices $agendaServices, EventServices $eventServices,
                                UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
        $this->agendaServices = $agendaServices;
        $this->eventServices = $eventServices;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }


    public function index()
    {

        /*
        * Variáveis gerais p/ todas as páginas
        *
        */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        //Fim Variáveis

        $church_id = Auth::user()->church_id;

        $events = Event::where('church_id', $church_id)->paginate(5);

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $id = Auth::user()->person_id;

        $person = $this->personRepository->find($id);

        $group_ids = [];

        for ($i = 0; $i < count($person->groups); $i++)
        {
            $group_ids[] = $person->groups[$i]->id;
        }

        $groups = DB::table("groups")
                    ->whereIn("id", $group_ids)
                    ->paginate(5);


        if(count($groups) == 0)
        {
            $groups = null;
        }

        $event_person = [];

        $nextEvent = null;

        if($groups)
        {
            foreach ($groups as $group)
            {
                $g = $this->groupRepository->find($group->id);

                $group->sinceOf = $this->formatDateView($g->sinceOf);

                $countMembers[] = count($g->people->all());
            }
        }

        if (count($events) == 0)
        {
            return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
                'countMembers', 'street', 'groups', 'event_person', 'nextEvent', 'leader'));
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

            // Incluir dados da coluna criado por ( foto e primeiro nome )

            $user = $this->userRepository->find($event->createdBy_id)->person;

            $event->createdBy_name = $user->name;

            $event->imgProfileUser = $user->imgProfile;


            if($eventDate[$i] != null)
            {
                $eventDate[$i]->eventDate = $this->formatDateView($eventDate[$i]->eventDate);
            }
            else{
                array_pop($eventDate);
                $i--;
            }

            $i++;
        }


        //dd($eventDate);

        if(!empty($eventDate))
        {
            if($eventDate[0] != null)
            {
                for ($i = 0; $i < count($eventDate); $i++)
                {

                    if($eventDate[$i] != null) {
                        $event_person[$i] = $this->eventRepository->find($eventDate[$i]->event_id);

                        if ($event_person[$i]->group_id != null) {
                            $event_person[$i]->group_name = $this->groupRepository->find($event_person[$i]->group_id)->name;
                        }
                    }
                }
            }
        }




        $nextEvent = $this->eventServices->getNextEvent();

        $nextEvent[1] = $this->formatDateView($nextEvent[1]);

        $event = $this->eventRepository->find($nextEvent[0]);

        $street = $event->street;

        $location = $this->formatGoogleMaps($event);

        //Dia Atual
        $today = date("Y-m-d");

        //Recupera todos os meses
        $allMonths = $this->agendaServices->allMonths();

        //Recuperar todos os dias da semana
        $allDays = $this->agendaServices->allDaysName();

        //Recupera a semana atual
        $days = $this->agendaServices->findWeek();

        //Contador de semanas
        $cont = 1;

        //Numero de Semanas
        $numWeek = $this->getDefaultWeeks();

        //Listagem até a 6° semana por padrão
        while ($cont < $numWeek)
        {
            $time = $cont == 1 ? 'next' : $cont;

            $days = array_merge($days, $this->agendaServices->findWeek($time));

            $cont++;
        }

        //Retorna todos os eventos
        $allEvents = $this->eventServices->allEvents($church_id);

        $allEventsNames = [];
        $allEventsTimes = [];
        $allEventsFrequencies = [];
        $allEventsAddresses = [];

        foreach ($allEvents as $allEvent) {
            $e = $this->eventRepository->find($allEvent->event_id);

            //Nome de todos os eventos
            $allEventsNames[] = $e->name;

            //Hora de inicio de todos os eventos
            $allEventsTimes[] = $e->startTime;

            //Frequência de todos os eventos
            $allEventsFrequencies[] = $e->frequency;

            //Todos os endereços
            $allEventsAddresses[] = $e->street . ", " . $e->neighborhood . "\n" . $e->city . ", " . $e->state;
        }


        //Recupera o mês atual
        $thisMonth = $this->agendaServices->thisMonth();

        //Ano Atual
        $ano = date("Y");

        /*
         * Fim Agenda
         */

        /*
         * Início Recent Users, Group e Events
         * */

        $recent_users = RecentUsers::where([
            'church_id' => $church_id
        ])->get();

        $recent_groups = RecentGroups::where([
            'church_id' => $church_id
        ])->get();

        $recent_events = RecentEvents::where([
            'church_id' => $church_id
        ])->get();

        $qtde_users = count($recent_users);
        $qtde_groups = count($recent_groups);
        $qtde_events = count($recent_events);

        $people = [];
        $groups_recent = [];
        $events_recent = [];

        if($qtde_users > 0)
        {
            foreach ($recent_users as $recent_user)
            {
                $p = $this->personRepository->find($recent_user->person_id);

                $p->role_id = $this->roleRepository->findByField('id', $p->role_id)->first()->name;

                $people[] = $p;
            }
        }

        if($qtde_groups > 0)
        {
            foreach ($recent_groups as $item)
            {
                $g = $this->groupRepository->find($item->group_id);

                $g->owner_id = $this->userRepository->find($g->owner_id)->person;

                $g->imgCreatorProfile = $g->owner_id->imgProfile;

                $g->owner_id = $g->owner_id->name . " " . $g->owner_id->lastName;

                $g->sinceOf = $this->formatDateView($g->sinceOf);

                $groups_recent[] = $g;
            }
        }

        if($qtde_events > 0)
        {
            foreach ($recent_events as $item)
            {
                $e = $this->eventRepository->find($item->event_id);

                $e->createdBy_id = $this->userRepository->find($e->createdBy_id)->person;

                $e->imgCreatorProfile = $e->createdBy_id->imgProfile;

                $e->createdBy_id = $e->createdBy_id->name . " " . $e->createdBy_id->lastName;

                $e->group_id = $e->group_id ? $this->groupRepository->find($e->group_id)->name : 'Sem Grupo';

                $nextEventRecent = $this->eventServices->getNextEvent($e->id);

                $e->nextEvent = $this->formatDateView($nextEventRecent[1]);

                $events_recent[] = $e;
            }
        }

        //dd($events_recent);

        /*
         * Fim Recentes
         * */

        return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde', 'event',
            'countMembers', 'nextEvent', 'location', 'street', 'groups', 'eventDate', 'event_person',
            'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'ano', 'allEventsNames', 'allEventsTimes',
            'allEventsFrequencies', 'allEventsAddresses', 'numWeek',
            'people', 'groups_recent', 'events_recent', 'qtde_users', 'qtde_groups', 'qtde_events', 'leader'));
    }

    public function oldindex()
    {

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $events = $this->eventRepository->paginate(5);

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $id = Auth::getUser()->person_id;

        $person = $this->personRepository->find($id);

        //Paginação de Grupo está com bug
        $groups = $person->groups()->paginate(5) or null;

        $event_person = [];

        $nextEvent = null;

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
                'countMembers', 'street', 'groups', 'event_person', 'nextEvent'));
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

            // Incluir dados da coluna criado por ( foto e primeiro nome )

            $user = $this->userRepository->find($event->createdBy_id)->person;

            $event->createdBy_name = $user->name;

            $event->imgProfileUser = $user->imgProfile;


            if($eventDate[$i] != null)
            {
                $eventDate[$i]->eventDate = $this->formatDateView($eventDate[$i]->eventDate);
            }
            else{
                array_pop($eventDate);
                $i--;
            }

            $i++;
        }


        //dd($eventDate);

        if(!empty($eventDate))
        {
            if($eventDate[0] != null)
            {
                for ($i = 0; $i < count($eventDate); $i++)
                {

                    if($eventDate[$i] != null) {
                        $event_person[$i] = $this->eventRepository->find($eventDate[$i]->event_id);

                        if ($event_person[$i]->group_id != null) {
                            $event_person[$i]->group_name = $this->groupRepository->find($event_person[$i]->group_id)->name;
                        }
                    }
                }
            }
        }




        $nextEvent = $this->getNextEvent();

        $nextEvent[1] = $this->formatDateView($nextEvent[1]);

        $event = $this->eventRepository->find($nextEvent[0]);

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


        return view('dashboard.index', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde', 'event',
            'days', 'nextMonth', 'nextMonth2', 'allEvents', 'countMembers', 'nextEvent', 'location', 'street',
            'nextMonth3', 'nextMonth4', 'nextMonth5', 'nextMonth6', 'prevMonth', 'prevMonth2',
            'prevMonth3', 'prevMonth4', 'prevMonth5', 'prevMonth6',
            'allMonths', 'allDays', 'groups', 'eventDate', 'event_person'));
    }

    public function visitors(Request $request)
    {
        $data = $request->all();

        dd($data);
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

        $allMonths = $this->agendaServices->allMonths();

        //Recupera a semana atual
        $days = $this->agendaServices->findWeek();
        
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


    public function calendario()
    {
        return view('calendario');
    }

    public function menu()
    {
        return view('testes.menu');
    }
}
