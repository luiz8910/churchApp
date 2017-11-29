<?php

namespace App\Http\Controllers;

use App\Cron\CronEvents;
use App\Events\AgendaEvent;
use App\Models\Event;
use App\Models\EventSubscribedList;
use App\Models\RecentEvents;
use App\Models\User;
use App\Repositories\FrequencyRepository;
use App\Repositories\RoleRepository;
use App\Services\AgendaServices;
use App\Services\EventServices;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Repositories\EventRepository;
use App\Traits\EmailTrait;
use App\Traits\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;


class EventController extends Controller
{
    use CountRepository, DateRepository, FormatGoogleMaps, NotifyRepository, ConfigTrait;
    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var AgendaServices
     */
    private $agendaServices;
    /**
     * @var FrequencyRepository
     */
    private $frequencyRepository;

    /**
     * EventController constructor.
     * @param EventRepository $repository
     * @param StateRepository $stateRepositoryTrait
     * @param UserRepository $userRepository
     * @param GroupRepository $groupRepository
     * @param PersonRepository $personRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(EventRepository $repository, StateRepository $stateRepositoryTrait,
                                UserRepository $userRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository, RoleRepository $roleRepository,
                                EventServices $eventServices, AgendaServices $agendaServices,
                                FrequencyRepository $frequencyRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepositoryTrait;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->personRepository = $personRepository;
        $this->roleRepository = $roleRepository;
        $this->eventServices = $eventServices;
        $this->agendaServices = $agendaServices;
        $this->frequencyRepository = $frequencyRepository;
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

        $state = $this->stateRepository->all();

        //Fim Variáveis

        $church_id = $this->getUserChurch();
        /*
         * Lista de Eventos
         */
        $events = Event::where([
            'church_id' => $church_id,
            'deleted_at' => null
        ])->paginate(5);

        /*$events = $this->repository->findWhere([
            'church_id' => $church_id
        ]);*/



        $sub = false;

        /*
         * Foreach para Formatação de datas e nome do grupo pertencente se houver
         */
        foreach ($events as $event) {

            $event->eventDate = $this->formatDateView($event->eventDate);

            if($event->group_id)
            {
                $event['group_name'] = $this->groupRepository->find($event->group_id)->name;
            }

            //Check-in e Check-out

            $canCheckIn = $this->eventServices->canCheckIn($event->id);

            if($canCheckIn)
            {
                $sub = $this->eventServices->isSubscribed($event->id);

                $event->checkIn = $sub ? false : true;
            }
            else{
                $event->checkIn = null;
            }

            $event->user_createdBy_id = $this->userRepository->find($event->createdBy_id)->person;

            //echo($event->id);

            //echo '<br>';
        }

        //dd($events);

        /*
         * Notificação, e quantidades de novas notificações
         */
        $notify = $this->notify();

        $qtde = count($notify) or 0;

        //Fim notificação

        /*
         * Inicio Agenda
         */

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
            $e = $this->repository->find($allEvent->event_id);

            //Nome de todos os eventos
            $allEventsNames[] = $e->name;

            //Hora de inicio de todos os eventos
            $allEventsTimes[] = $e->startTime;

            //Frequência de todos os eventos
            $allEventsFrequencies[] = $e->frequency;

            //Todos os endereços
            $allEventsAddresses[] = $e->street . ", " . $e->number . " - " . $e->neighborhood . "\n" . $e->city . ", " . $e->state;
        }


        //Recupera o mês atual
        $thisMonth = $this->agendaServices->thisMonth();

        //Ano Atual
        $ano = date("Y");

        //dd($events[0]->church_id);

        $role = $this->getUserRole();

        /*
         * Fim Agenda
         */

        //dd($events);

        return view("events.index", compact('countPerson', 'countGroups', 'state',
            'events', 'notify', 'qtde', 'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'ano', 'allEventsNames', 'allEventsTimes',
            'allEventsFrequencies', 'allEventsAddresses', 'numWeek', 'church_id',
            'leader', 'role', 'events_pag'));
    }


    public function nextMonth($thisMonth, $church_id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $leader = $this->getLeaderRoleId();

        //Fim Variáveis

        $church_id = $church_id ? $church_id : $this->getUserChurch();

        /*
         * Lista de Eventos
         */
        $events = Event::where('church_id', $church_id)->paginate(5);

        /*
         * Foreach para Formatação de datas e nome do grupo pertencente se houver
         */
        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);

            if($event->group_id)
            {
                $event['group_name'] = $this->groupRepository->find($event->group_id)->name;
            }

            //$event->created_at = $this->formatDateView($event->created_at);
        }

        /*
         * Notificação, e quantidades de novas notificações
         */
        $notify = $this->notify();

        $qtde = count($notify) or 0;

        //Fim notificação

        /*
         * Inicio Agenda
         */

        //Dia Atual
        $today = date("Y-m-d");

        //Recupera todos os meses
        $allMonths = $this->agendaServices->allMonths();

        //Recuperar todos os dias da semana
        $allDays = $this->agendaServices->allDaysName();

        //Retorna todos os eventos
        $allEvents = $this->eventServices->allEvents($church_id);

        $allEventsNames = [];
        $allEventsTimes = [];
        $allEventsFrequencies = [];
        $allEventsAddresses = [];

        foreach ($allEvents as $allEvent) {
            $e = $this->repository->find($allEvent->event_id);

            //Nome de todos os eventos
            $allEventsNames[] = $e->name;

            //Hora de inicio de todos os eventos
            $allEventsTimes[] = $e->startTime;

            //Frequência de todos os eventos
            $allEventsFrequencies[] = $e->frequency;

            //Todos os endereços
            $allEventsAddresses[] = $e->street . ", " . $e->neighborhood . "\n" . $e->city . ", " . $e->state;
        }

        //Ano Atual
        $ano = date("Y");

        $nextMonth = $thisMonth + 1;

        if($thisMonth == 12)
        {
            $ano++;
            $nextMonth = 1;
        }
        elseif ($thisMonth == -1){
            $ano--;
            $nextMonth = 12;
        }


        $date = date_create();

        date_date_set($date, $ano, $nextMonth, 1);

        $firstDayNumber = date_format($date, "w");

        $stop = false;

        $days = [];

        $i = 0;

        $x = $firstDayNumber == 0 ? 7 : $firstDayNumber;

        while($x != 1)
        {
            // $i = 0, 1, 2, 3

            $x--; //3, 2, 1, 0

            $x *= -1; //-3, -2, -1, 0

            date_add($date, date_interval_create_from_date_string($x. "days"));

            //$days[$i] = date_create($date);

            $days[$i] = date_format($date, "Y-m-d");

            //echo "1 : " . $days[$i] . "<br>";

            date_date_set($date, $ano, $nextMonth, 1);

            $x *= -1;

            $i++;
        }

        while(!$stop)
        {
            $days[$i] = date_create(date_format($date, "Y-m-d"));

            $days[$i] = date_format($days[$i], "Y-m-d");

            date_add($date, date_interval_create_from_date_string("1 day"));

            $month = date_format(date_create($days[$i]), "n");

            //echo "2: " . $days[$i] . "<br>";

            //$dayNumber = date_format(date_create($days[$i]), "w");

            $i++;

            if($month != $nextMonth)
            {
                $stop = true;
                array_pop($days);
            }
        }

        //Recupera o próximo mês
        $thisMonth = $nextMonth;

        /*
         * Fim Agenda
         */


        $next = true;

        //Recupera o cargo do usuário no sistema
        $role = $this->getUserRole();


        //dd(count($days));

        return view("events.index", compact('countPerson', 'countGroups', 'state',
            'events', 'notify', 'qtde', 'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'next', 'ano', 'allEventsNames', 'allEventsTimes',
            'allEventsFrequencies', 'allEventsAddresses', 'church_id', 'leader', 'role'));
    }

    public function oldindex()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $events = $this->repository->paginate(5);


        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);

            if($event->group_id)
            {
                $event['group_name'] = $this->groupRepository->find($event->group_id)->name;
            }

            //$event->created_at = $this->formatDateView($event->created_at);
        }

        $user = $this->userRepository->find(\Auth::getUser()->id);

        //$event_user[] = $user->person->events ? $user->person->events->all() : null;

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $days = AgendaServices::findWeek();

        $nextWeek = AgendaServices::findWeek('next');

        $prevWeek = AgendaServices::findWeek('prev');

        $twoWeeks = AgendaServices::findWeek('2 weeks');

        $allEvents = EventServices::allEvents();

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

        $prevMonth = array_merge($prevMonth, AgendaServices::findMonth(-1));
        $prevMonth = array_merge($prevMonth, AgendaServices::findMonth(-1, 'next'));
        $prevMonth = array_merge($prevMonth, AgendaServices::findMonth(-1, '2 weeks'));

        $prevMonth2 = array_merge($prevMonth2, AgendaServices::findMonth(-2));
        $prevMonth2 = array_merge($prevMonth2, AgendaServices::findMonth(-2, 'next'));
        $prevMonth2 = array_merge($prevMonth2, AgendaServices::findMonth(-2, '2 weeks'));

        $prevMonth3 = array_merge($prevMonth3, AgendaServices::findMonth(-3));
        $prevMonth3 = array_merge($prevMonth3, AgendaServices::findMonth(-3, 'next'));
        $prevMonth3 = array_merge($prevMonth3, AgendaServices::findMonth(-3, '2 weeks'));

        $prevMonth4 = array_merge($prevMonth4, AgendaServices::findMonth(-4));
        $prevMonth4 = array_merge($prevMonth4, AgendaServices::findMonth(-4, 'next'));
        $prevMonth4 = array_merge($prevMonth4, AgendaServices::findMonth(-4, '2 weeks'));

        $prevMonth5 = array_merge($prevMonth5, AgendaServices::findMonth(-5));
        $prevMonth5 = array_merge($prevMonth5, AgendaServices::findMonth(-5, 'next'));
        $prevMonth5 = array_merge($prevMonth5, AgendaServices::findMonth(-5, '2 weeks'));

        $prevMonth6 = array_merge($prevMonth6, AgendaServices::findMonth(-6));
        $prevMonth6 = array_merge($prevMonth6, AgendaServices::findMonth(-6, 'next'));
        $prevMonth6 = array_merge($prevMonth6, AgendaServices::findMonth(-6, '2 weeks'));

        //$p = AgendaServices::findMonth(1, 'prev');

        $nextMonth = array_merge($nextMonth, AgendaServices::findMonth(1));
        $nextMonth = array_merge($nextMonth, AgendaServices::findMonth(1, 'next'));
        $nextMonth = array_merge($nextMonth, AgendaServices::findMonth(1, '2 weeks'));

        $nextMonth2 = array_merge($nextMonth2, AgendaServices::findMonth(2));
        $nextMonth2 = array_merge($nextMonth2, AgendaServices::findMonth(2, 'next'));
        $nextMonth2 = array_merge($nextMonth2, AgendaServices::findMonth(2, '2 weeks'));

        $nextMonth3 = array_merge($nextMonth3, AgendaServices::findMonth(3));
        $nextMonth3 = array_merge($nextMonth3, AgendaServices::findMonth(3, 'next'));
        $nextMonth3 = array_merge($nextMonth3, AgendaServices::findMonth(3, '2 weeks'));

        $nextMonth4 = array_merge($nextMonth4, AgendaServices::findMonth(4));
        $nextMonth4 = array_merge($nextMonth4, AgendaServices::findMonth(4, 'next'));
        $nextMonth4 = array_merge($nextMonth4, AgendaServices::findMonth(4, '2 weeks'));

        $nextMonth5 = array_merge($nextMonth5, AgendaServices::findMonth(5));
        $nextMonth5 = array_merge($nextMonth5, AgendaServices::findMonth(5, 'next'));
        $nextMonth5 = array_merge($nextMonth5, AgendaServices::findMonth(5, '2 weeks'));

        $nextMonth6 = array_merge($nextMonth6, AgendaServices::findMonth(6));
        $nextMonth6 = array_merge($nextMonth6, AgendaServices::findMonth(6, 'next'));
        $nextMonth6 = array_merge($nextMonth6, AgendaServices::findMonth(6, '2 weeks'));

        $allMonths = AgendaServices::allMonths();

        $allDays = AgendaServices::allDaysName();

        //dd(count($days));

        return view('events.index', compact('countPerson', 'countGroups', 'state', 'allEvents',
            'events', 'notify', 'qtde', 'days', 'nextMonth', 'nextMonth2',
            'nextMonth3', 'nextMonth4', 'nextMonth5', 'nextMonth6', 'prevMonth', 'prevMonth2',
            'prevMonth3', 'prevMonth4', 'prevMonth5', 'prevMonth6','allMonths', 'allDays'));
    }

    public function create($id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $frequencies = $this->frequencyRepository->all();

        $notify = $this->notify();

        $qtde = count($notify);

        $groups = $this->groupRepository->findByField('church_id', $this->getUserChurch());

        if($id)
        {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles',
                'id', 'notify', 'qtde', 'groups', 'frequencies', 'leader'));
        }
        else{
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles',
                'notify', 'qtde', 'groups', 'frequencies', 'leader'));
        }


    }

    public function testEventNotification()
    {
        $event = Event::find(1);

        event(new AgendaEvent($event));

        $user[] = User::find(1);

        $user[] = User::find(11);

        \Notification::send($user, new Notifications($event->name, 'events/'.$event->id.'/edit'));
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $data['createdBy_id'] = \Auth::user()->id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        if(!$data['eventDate'])
        {
            $request->session()->flash('invalidDate', 'Insira a data do primeiro encontro');
            return redirect()->back()->withInput();
        }

        $verifyFields = $this->verifyRequiredFields($data, 'event');

        if($verifyFields)
        {
            \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
            return redirect()->route("event.create")->withInput();
        }

        $endEventDate = $request->get('endEventDate');

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        else{
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }

        if($data["group_id"] == "")
        {
            $data["group_id"] = null;
        }

        if($data["frequency"] == $this->biweekly())
        {
            $firstDay = substr($data['eventDate'], 8, 2);

            if($data['day'][0] != $firstDay)
            {
                $request->session()->flash('invalidDate', 'Data do Próximo evento está inválida');
                return redirect()->back()->withInput();
            }
            else{
                $day = $data['day'][0];
                $data['day_2'] = $data['day'][1];

                unset($data['day']);

                $data['day'] = $day;
            }
        }

        $data["city"] = ucwords($data["city"]);

        $event = $this->repository->create($data);

        if($data["group_id"] == null)
        {
            unset($data['group_id']);
        }

        $this->sendNotification($data, $event);

        if($data["frequency"] != $this->unique())
        {
            $this->eventServices->newEventDays($event->id, $data['eventDate'], $data['frequency']);
        }
        else{
            $show = $event->eventDate == date("Y-m-d") ? 1 : 0;
            $person_id = \Auth::user()->person_id;

            DB::table('event_person')
                ->insert([
                    'event_id' => $event->id,
                    'person_id' => $person_id,
                    'eventDate' => $event->eventDate,
                    'show' => $show
                ]);

            $this->eventServices->subAllMembers($event->id, $event->eventDate, $person_id);
        }

        $this->setChurch_id($event);

        $this->eventServices->newRecentEvents($event->id, $this->getUserChurch());

        return redirect()->route('event.index');
    }

    public function setChurch_id($event)
    {
        Event::where(['id' => $event->id])
            ->update(
                ['church_id' => $this->getUserChurch()]
            );
    }

    public function sendNotification($data, $event)
    {
        try{
            $user = [];

            if (isset($data['group_id']))
            {
                $group = $this->groupRepository->find($data['group_id']);

                $people = $group->people->all();

                $i = 0;

                while ($i < count($people))
                {
                    $user[] = $people[$i]->user;
                    $i++;
                }
            }

            $i = 0;

            $join = DB::table('people')
                ->crossJoin('users', 'users.person_id', '=', 'people.id')
                ->where(
                    [
                        'role_id' => $this->getLeaderRoleId(),
                        'users.church_id' => $this->getUserChurch(),
                        'people.deleted_at' => null
                    ])
                ->select('users.id')
                ->get();



            while ($i < count($join))
            {
                $user[] = User::find($join[$i]->id);
                $i++;
            }

            event(new AgendaEvent($event, $user));

            Notification::send($user, new Notifications($data['name'], 'events/'.$event->id.'/edit'));

        }catch (\Exception $exception){

            echo $exception->getMessage();

        }

    }


    public function edit($id, $church_id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $frequencies = $this->frequencyRepository->all();

        $leader = $this->getLeaderRoleId();

        if($this->getUserChurch() == null)
        {
            $church_id = 1;
        }
        else{
            $church_id = $this->getUserChurch();
        }

        $model = $this->repository->find($id);

        $location = $this->formatGoogleMaps($model);

        $model->eventDate = $this->formatDateView($model->eventDate);
        $model->endEventDate = $this->formatDateView($model->endEventDate);

        $notify = $this->notify();

        $qtde = count($notify);

        $eventDays = $this->eventServices->eventDays($id);

        foreach ($eventDays as $eventDay) {
            $eventDay->eventDate = $this->formatDateView($eventDay->eventDate);
        }

        $check = "check-in";

        $eventFrequency = $this->eventServices->eventFrequency($id);

        $eventPeople = $this->eventServices->eventPeople($id);

        $arr = [];
        $people = [];

        foreach ($eventPeople as $item) {
            $arr[] = $item->person_id;
            /*$e = $this->personRepository->find($item->person_id);
            $e->frequency = $this->eventServices->userFrequency($id, $item->person_id);

            $eventPeople[] = $e;*/
        }

        $eventPeople = DB::table('people')
            ->whereIn('id', $arr)
            ->paginate(5);

        foreach ($eventPeople as $item)
        {
            //$item->name = $this->personRepository->find($item->person_id)->name;
            $item->frequency = $this->eventServices->userFrequency($id, $item->id);
        }

        //dd($arr);

        //dd($eventPeople);

        $group = $model->group or null;

        $groups = $this->groupRepository->findByField('church_id', $church_id);

        $sub = false;

        $canCheckIn = $this->eventServices->canCheckIn($id);

        if($canCheckIn)
        {
            $sub = $this->eventServices->isSubscribed($id);
        }


        $createdBy_id = $this->userRepository->find($model->createdBy_id)->person_id;

        $createdBy = $this->userRepository->find($model->createdBy_id)->person;

        if($model->frequency != $this->unique())
        {
            $nextEventDate = DB::table('event_person')
                ->select('eventDate')
                ->where(
                    [
                        'event_id' => $id,
                        'show' => 0
                    ]
                )->first();

            $nextEventDate = $nextEventDate != null ? $this->formatDateView($nextEventDate->eventDate) : null;
        }
        else{
            $nextEventDate = $model->eventDate;
        }


        $preposicao = '';

        $weekly = $this->weekly();

        $monthly = $this->monthly();

        $biweekly = $this->biweekly();

        if($model->frequency == $weekly)
        {
            if($model->day == "Sabado" || $model->day == "Domingo")
            {
                $preposicao = "todo";
            }
            else{
                $preposicao = "toda";
            }
        }
        elseif($model->frequency == $monthly || $model->frequency == $biweekly){
            $preposicao = "todo dia";
        }

        $model->sub = count($this->eventServices->getListSubEvent($id));

        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles',
            'model', 'location', 'notify', 'qtde', 'eventDays', 'eventFrequency', 'check',
            'eventPeople', 'group', 'groups', 'sub', 'canCheckIn', 'createdBy_id', 'createdBy',
            'nextEventDate', 'leader', 'preposicao', 'frequencies', 'church_id', 'leader'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['createdBy_id'] = $this->repository->find($id)->createdBy_id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        $endEventDate = $request->get('endEventDate');

        if(!$data['eventDate'])
        {
            $request->session()->flash('invalidDate', 'Insira a data do primeiro encontro');
            return redirect()->back()->withInput();
        }

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        else
        {
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }

        if($data["group_id"] == "")
        {
            $data["group_id"] = null;
        }

        if($data["frequency"] == "Quinzenal")
        {
            $firstDay = substr($data['eventDate'], 8, 2);

            if($data['day'][0] != $firstDay)
            {
                $request->session()->flash('invalidDate', 'Data do Próximo evento está inválida');
                return redirect()->back()->withInput();
            }
            else{
                $day = $data['day'][0];
                $data['day_2'] = $data['day'][1];

                unset($data['day']);

                $data['day'] = $day;
            }
        }

        $data["city"] = ucwords($data["city"]);

        $this->repository->update($data, $id);

        $this->eventServices->changeEventDays($id);

        return redirect()->route('event.index');
    }


    public function check($id)
    {
        $event = Event::where('id', $id)->first();

        $user = \Auth::getUser();

        $date = date_create(date('Y-m-d'));

        $event_person = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'person_id' => $user->person_id,
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 1
            ])->get();

        if(count($event_person) > 0)
        {
            DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $user->person_id,
                    'eventDate' => date_format($date, "Y-m-d")
                ])->update(['check-in' => 0]);

            echo json_encode(['status' => false]);
        }else{
            $event->people()->attach($user->person_id, [
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 1
            ]);

            echo json_encode(['status' => true]);
        }

    }



    public function checkInEvent($id)
    {
        return $this->eventServices->check($id);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * */
    public function checkOutEvent($id)
    {
        return $this->eventServices->checkOut($id);
    }


    public function destroy($id)
    {
        $event = $this->repository->find($id);

        $name = $event->name;

        DB::table('event_person')
            ->where(['event_id' => $id])
            ->update(['deleted_at' => Carbon::now()]);

        RecentEvents::where('event_id', $id)->delete();

        EventSubscribedList::where('event_id', $id)->delete();

        $event->delete();

        return json_encode([
                'status' => true,
                'name' => $name
            ]);
    }

    public function destroyMany(Request $request)
    {
        $i = 0;

        $data = $request->all();


        while($i < count($data['input']))
        {
            $this->repository->delete($data['input'][$i]);

            DB::table('event_person')
                ->where('event_id', $data['input'][$i])
                ->update(['deleted_at' => Carbon::now()]);

            $i++;
        }

        \Session::flash('event.deleted', 'Os eventos selecionados foram excluidos');

        return redirect()->route('event.index');
    }

    public function getListEvents()
    {

        $events = $this->repository->all();

        $header[] = 'Nome';
        $header[] = 'Frequência';
        $header[] = 'Criado Por';
        $header[] = 'Grupo';

        $i = 0;

        $text = "";

        while($i < count($events))
        {
            $events[$i]->createdBy_id = $this->userRepository->find($events[$i]->createdBy_id)->person->name;

            $events[$i]->group_id = $events[$i]->group_id ? $this->groupRepository->find($events[$i]->group_id)->name : "Sem Grupo";

            $x = $i == (count($events) - 1) ? "" : ",";

            $text .= '["'.$events[$i]->name.'","'.''.$events[$i]->frequency.''.'","'.''.$events[$i]->createdBy_id.''.'","'.''.$events[$i]->group_id.'"'.']'.$x.'';

            $i++;
        }

        $json = '{
              "content": [
                {
                  "table": {
                    "headerRows": 1,
                    "widths": [ "*", "auto", 100, "*" ],
            
                    "body":[
                      ["'.$header[0].'", "'.$header[1].'", "'.$header[2].'", "'.$header[3].'"],
                      '.$text.'
                    ]
                  }
                }
              ]
            }';

        if (env('APP_ENV') == "local")
        {
            File::put(public_path('js/print.json'), $json);
        }
        else{
            File::put(getcwd() . '/js/print.json', $json);
        }

    }


    public function excel($format)
    {
        $data = $this->repository->all(['name', 'group_id', 'createdBy_id', 'eventDate', 'endEventDate', 'startTime',
            'endTime', 'frequency', 'day', 'allDay', 'description', 'street', 'neighborhood', 'city',
            'zipCode', 'state']);

        $info = [];

        for ($i = 0; $i < count($data); $i++) {

            $info[$i]["Name"] = $data[$i]->name;

            $info[$i]["Grupo"] = $data[$i]->group_id ? $this->groupRepository->find($data[$i]->group_id)->name : "Sem Grupo";

            $info[$i]["Criado Por"] = $this->userRepository->find($data[$i]->createdBy_id)->person->name;

            $info[$i]["Data do Evento"] = $data[$i]->eventDate;

            $info[$i]["Fim do Evento"] = $data[$i]->endEventDate;

            $info[$i]["Hora de Ínicio"] = $data[$i]->startTime;

            $info[$i]["Hora de Término"] = $data[$i]->endTime;

            $info[$i]["Frequência"] = $data[$i]->frequency;

            $info[$i]["Dia"] = $data[$i]->day;

            $info[$i]["Dia Todo"] = $data[$i]->allDay == 1 ? "Sim" : "Não";

            $info[$i]["Descrição"] = $data[$i]->description;

            $info[$i]["Logradouro"] = $data[$i]->street;

            $info[$i]["Bairro"] = $data[$i]->neighborhood;

            $info[$i]["Cidade"] = $data[$i]->city;

            $info[$i]["CEP"] = $data[$i]->zipCode;

            $info[$i]["UF"] = $data[$i]->state;
        }

        Excel::create('Eventos', function($excel) use ($info) {

            // Set the title
            //$excel->setTitle('Our new awesome title');

            // Call them separately
            //$excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Eventos', function ($sheet) use ($info){
               $sheet->fromArray($info);
            });

        })->export($format);

        return redirect()->route('event.index');
    }

    public function imgEvent(Request $request, $event)
    {
        $file = $request->file('file');

        $event = $this->repository->find($event);

        $imgName = 'uploads/event/' . $event->id . '-' . $event->name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/event', $imgName);

        DB::table('events')->
            where('id', $event->id)->
            update(['imgEvent' => $imgName]);

        return redirect()->route('event.edit', ['event' => $event->id]);
    }

    //Função de teste somente, não tem uso em produção
    public function Cron()
    {
        $cron = new CronEvents();

        $cron->setNextEvents();
    }
    //Função de teste somente, não tem uso em produção
    public function Cron2()
    {
        /*$today = date_create();

        date_add($today, date_interval_create_from_date_string("1 day"));

        $today = date_format($today, "Y-m-d");*/

        $today = date("Y-m-d");
        //dd($today);



        $events = DB::table('event_person')
            ->where(
                [
                    'eventDate' => $today,
                    'show' => 0,
                    'deleted_at' => null
                ]
            )
            ->get();


        if(count($events) > 0)
        {
            DB::table('event_person')
                ->where(
                    [
                        'eventDate' => $today,
                        'show' => 0,
                        'deleted_at' => null
                    ]
                )->update(['show' => 1]);

            foreach ($events as $event)
            {
                $e = Event::find($event->event_id);

                $last = DB::table('event_person')
                    ->where(
                        [
                            'event_id' => $event->event_id,
                            'deleted_at' => null
                        ]
                    )
                    ->orderBy('eventDate', 'desc')
                    ->first();


                if($e->frequency == $this->daily())
                {
                    $this->setDays($event, $last, '1 day');
                }
                elseif ($e->frequency == $this->weekly())
                {
                    $todayNumber = date('w');

                    $dayNumber = $this->eventServices->getDayNumber($e->day);

                    if($todayNumber == $dayNumber)
                    {
                        $this->setDays($event, $last, '7 days');
                    }

                }
                elseif($e->frequency == $this->monthly())
                {
                    $todayNumber = date('d');

                    if($todayNumber == $e->day)
                    {
                        $this->setDays($event, $last);
                    }
                }
            }

        }else return 0;


    }

    public function setDays($event, $last, $days = null)
    {
        $lastEvent = date_create($last->eventDate);

        if(!$days)
        {
            $day = date_format($lastEvent, "d");
            $month = date_format($lastEvent, "m");
            $year = date_format($lastEvent, "Y");

            $month++;

            if($month == 13)
            {
                $month = 01;
                $year++;
            }

            $nextEvent = date_create($year."-".$month."-".$day);


        }else{
            $nextEvent = date_add($lastEvent, date_interval_create_from_date_string($days));
        }



        DB::table('event_person')
            ->insert(
                [
                    'event_id' => $event->event_id,
                    'person_id' => $event->person_id,
                    'eventDate' => date_format($nextEvent, "Y-m-d"),
                    'show' => 0
                ]
            );
    }

    /*
     * Lista de inscritos no evento $id
     */
    public function getSubEventList($id)
    {
        /*
         * Lista variáveis comuns
         */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $notify = $this->notify();

        $qtde = count($notify);

        //Fim Variáveis comuns

        $sub = $this->eventServices->getListSubEvent($id);

        $person_sub = [];

        $arr = [];

        foreach ($sub as $item) {
            $arr[] = $item->person_id;

            $attendance[] = count(DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $item->person_id,
                    'check-in' => 1
                ])->get());
        }

        $person_sub = DB::table('people')
            ->whereIn('id', $arr)
            ->paginate(5);

        $event = $this->repository->find($id);

        $people = DB::table('people')
            ->where(
                [
                    'church_id' => $this->getUserChurch(),
                    'deleted_at' => null
                ])
            ->whereNotIn('id', $arr)
            ->get();



        //dd($arr);

        return view('events.subscriptions',
            compact('people', 'countPerson', 'countGroups', 'leader',
                'notify', 'qtde', 'event', 'sub', 'person_sub', 'attendance'));
    }

    /*
     * Usado para inscrever um usuário no evento $event
    */
    public function eventSub(Request $request, $event)
    {
        $data = $request->all();

        if($data["person_id"] != "")
        {
            $role = $this->getUserRole();

            $leader = $this->roleRepository->find($this->getLeaderRoleId())->name;

            if(($event->group_id && $role == $leader) || (!$event->group_id))
            {
                $exists = $this->eventServices->subEvent($event, $data["person_id"]);

                if($exists){
                    $request->session()->flash('event.sub', 'O usuário foi inscrito');
                }
                else{
                    $request->session()->flash('event.sub', 'Este usuário ja está inscrito');
                }
            }
        }

        return redirect()->back();
    }

    public function UnsubUser($person_id, $event_id)
    {
        $this->eventServices->UnsubUser($person_id, $event_id);

        return json_encode(['status' => 'true']);
    }


    /**
     * @param $id = $id do evento
     */
    public function check_auto($id, $check)
    {

        DB::table('events')
            ->where([
                'id' => $id
            ])
            ->update([
                'check_auto' => $check
            ]);

        return json_encode(['status' => true]);
    }


    // ----------------------------------------------------- API --------------------------------------------------------------------------------------- //

    public function getEventsApi()
    {
        $today = date_create();

        $events = DB::table('event_person')
                        ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.eventDate',
                            'events.startTime', 'events.endTime', 'events.street', 'events.number', 'events.city',
                            'events.frequency')
                        ->join('events', 'event_person.event_id', 'events.id')
                        ->whereDate('event_date', '>', $today)
                        ->whereNull('events.deleted_at')
                        ->orderBy('event_person.eventDate')
                        ->distinct()
                        ->get();

        /*$events = $events->keyBy('id');

        $events->forget(103);*/
        //dd($events);
        $events = $events->unique('id');

        $events = $events->values()->all();

        foreach ($events as $event)
        {
            $person = $this->userRepository->find($event->createdBy_id)->person;
            $event->img_user = $person->imgProfile;
            $event->createdBy_id = $person->name . " " . $person->lastName;
            $event->eventDate = $this->formatDateView($event->eventDate);
            $event->sub = count($this->eventServices->getListSubEvent($event->id));
        }

        //dd($events);

        return json_encode($events);
    }

}
