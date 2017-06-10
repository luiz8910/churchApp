<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Models\Event;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Services\AgendaServices;
use App\Services\EventServices;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Repositories\EventRepository;
use App\Traits\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
     * EventController constructor.
     * @param EventRepository $repository
     * @param StateRepository $stateRepository
     * @param UserRepository $userRepository
     * @param GroupRepository $groupRepository
     * @param PersonRepository $personRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(EventRepository $repository, StateRepository $stateRepository,
                                UserRepository $userRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository, RoleRepository $roleRepository,
                                EventServices $eventServices, AgendaServices $agendaServices)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->personRepository = $personRepository;
        $this->roleRepository = $roleRepository;
        $this->eventServices = $eventServices;
        $this->agendaServices = $agendaServices;
    }


    public function index()
    {
        /*
         * Variáveis gerais p/ todas as páginas
         *
         */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        //Fim Variáveis

        /*
         * Lista de Eventos
         */
        $events = Event::where('church_id', $this->getUserChurch())->paginate(5);

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

        //Recupera a semana atual
        $days = $this->agendaServices->findWeek();

        //Contador de semanas
        $cont = 1;

        //Listagem até a 6° semana por padrão
        while ($cont < 6)
        {
            $time = $cont == 1 ? 'next' : $cont;

            $days = array_merge($days, $this->agendaServices->findWeek($time));

            $cont++;
        }

        //Retorna todos os eventos
        $allEvents = $this->eventServices->allEvents();

        //Recupera o mês atual
        $thisMonth = $this->agendaServices->thisMonth();

        //Ano Atual
        $ano = date("Y");

        /*
         * Fim Agenda
         */

        return view("events.index", compact('countPerson', 'countGroups', 'state',
            'events', 'notify', 'qtde', 'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'ano'));
    }


    public function nextMonth($thisMonth)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        //Fim Variáveis

        /*
         * Lista de Eventos
         */
        $events = Event::where('church_id', $this->getUserChurch())->paginate(5);

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
        $allEvents = $this->eventServices->allEvents();

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

        //dd($days);

        return view("events.index", compact('countPerson', 'countGroups', 'state',
            'events', 'notify', 'qtde', 'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'next', 'ano'));
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

        $notify = $this->notify();

        $qtde = count($notify);

        $groups = $this->groupRepository->findByField('church_id', \Auth::getUser()->church_id);

        if($id)
        {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'id', 'notify', 'qtde', 'groups'));
        }
        else{
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'notify', 'qtde', 'groups'));
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

        $data['createdBy_id'] = \Auth::getUser()->id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        $endEventDate = $request->get('endEventDate');

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        else{
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }

        //$data["church_id"] = \Auth::getUser()->church_id;

        if($data["group_id"] == "")
        {
            $data["group_id"] = null;
        }

        //dd($data);

        $event = $this->repository->create($data);

        $this->sendNotification($data, $event);

        if($data["frequency"] != "Encontro Unico")
        {
            $this->eventServices->newEventDays($event->id, $data['eventDate'], $data['frequency']);
        }

        $this->setChurch_id($event);

        return redirect()->route('event.index');
    }

    public function setChurch_id($event)
    {
        Event::where(['id' => $event->id])
            ->update(
                ['church_id' => \Auth::getUser()->church_id]
            );
    }

    public function sendNotification($data, $event)
    {
        $user = [];

        event(new AgendaEvent($event));

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
            ->where('role_id', $this->getLeaderRoleId())
            ->select('users.id')
            ->get();

        while ($i < count($join))
        {
            $user[] = User::find($join[$i]->id);
            $i++;
        }

        \Notification::send($user, new Notifications($data['name'], 'events/'.$event->id.'/edit'));
    }


    public function edit($id)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $church_id = $this->getUserChurch();

        $event = $this->repository->find($id);

        $location = $this->formatGoogleMaps($event);

        $event->eventDate = $this->formatDateView($event->eventDate);
        $event->endEventDate = $this->formatDateView($event->endEventDate);

        $notify = $this->notify();

        $qtde = count($notify);

        $eventDays = $this->eventServices->eventDays($id);

        foreach ($eventDays as $eventDay) {
            $eventDay->eventDate = $this->formatDateView($eventDay->eventDate);
        }

        $check = "check-in";

        $eventFrequency = $this->eventServices->eventFrequency($id);

        $eventPeople = $this->eventServices->eventPeople($id);

        foreach ($eventPeople as $item)
        {
            $item->name = $this->personRepository->find($item->person_id)->name;
            $item->frequency = $this->eventServices->userFrequency($id, $item->person_id);
        }

        $group = $event->group or null;

        $groups = $this->groupRepository->findByField('church_id', $church_id);

        $sub = false;

        $canCheckIn = $this->eventServices->canCheckIn($id);
        

        if($canCheckIn)
        {
            $sub = $this->eventServices->isSubscribed($id);
        }

        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles', 'event', 'location',
            'notify', 'qtde', 'eventDays', 'eventFrequency', 'check', 'eventPeople',
            'group', 'groups', 'sub', 'canCheckIn'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['createdBy_id'] = $this->repository->find($id)->createdBy_id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        $endEventDate = $request->get('endEventDate');

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
}
