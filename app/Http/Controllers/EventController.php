<?php

namespace App\Http\Controllers;

use App\Cron\CronEvents;
use App\Events\AgendaEvent;
use App\Jobs\Certificate;
use App\Jobs\CheckCardToken;
use App\Jobs\Messages;
use App\Jobs\PaymentApproved;
use App\Jobs\PaymentMail;
use App\Jobs\sendEmailMessages;
use App\Jobs\SendQrEmail;
use App\Jobs\Test;
use App\Jobs\Teste;
use App\Mail\welcome_sub;
use App\Models\Bug;
use App\Models\Event;
use App\Models\EventSubscribedList;
use App\Models\RecentEvents;
use App\Models\User;
use App\Repositories\ChurchRepository;
use App\Repositories\CourseDescRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\CreditCardRepositoryEloquent;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\FrequencyRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ResponsibleRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Repositories\VisitorRepository;
use App\Services\AgendaServices;
use App\Services\ChurchServices;
use App\Services\EventServices;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Services\MessageServices;
use App\Services\PaymentServices;
use App\Services\PeopleServices;
use App\Services\qrServices;
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
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class EventController extends Controller
{
    use CountRepository, DateRepository, FormatGoogleMaps, NotifyRepository, ConfigTrait,
        UserLoginRepository, EmailTrait, PeopleTrait;
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
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;
    /**
     * @var ChurchServices
     */
    private $churchServices;
    /**
     * @var qrServices
     */
    private $qrServices;
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var PeopleServices
     */
    private $peopleServices;
    /**
     * @var MessageServices
     */
    private $messageServices;
    /**
     * @var ResponsibleRepository
     */
    private $responsibleRepository;
    /**
     * @var PaymentServices
     */
    private $paymentServices;
    /**
     * @var CreditCardRepository
     */
    private $creditCardRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var CourseDescRepository
     */
    private $courseRepository;

    /**
     * EventController constructor.
     * @param EventRepository $repository
     * @param StateRepository $stateRepositoryTrait
     * @param UserRepository $userRepository
     * @param GroupRepository $groupRepository
     * @param PersonRepository $personRepository
     * @param RoleRepository $roleRepository
     * @param EventServices $eventServices
     * @param AgendaServices $agendaServices
     * @param FrequencyRepository $frequencyRepository
     * @param VisitorRepository $visitorRepository
     */
    public function __construct(EventRepository $repository, StateRepository $stateRepositoryTrait,
                                UserRepository $userRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository, RoleRepository $roleRepository,
                                EventServices $eventServices, AgendaServices $agendaServices,
                                FrequencyRepository $frequencyRepository, VisitorRepository $visitorRepository,
                                SessionRepository $sessionRepository, ChurchRepository $churchRepository,
                                ChurchServices $churchServices, qrServices $qrServices,
                                EventSubscribedListRepository $listRepository, PeopleServices $peopleServices,
                                MessageServices $messageServices, ResponsibleRepository $responsibleRepository,
                                PaymentServices $paymentServices, CreditCardRepository $creditCardRepository,
                                PaymentRepository $paymentRepository, CourseDescRepository $courseRepository)
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
        $this->visitorRepository = $visitorRepository;
        $this->sessionRepository = $sessionRepository;
        $this->churchRepository = $churchRepository;
        $this->churchServices = $churchServices;
        $this->qrServices = $qrServices;
        $this->listRepository = $listRepository;
        $this->peopleServices = $peopleServices;
        $this->messageServices = $messageServices;
        $this->responsibleRepository = $responsibleRepository;
        $this->paymentServices = $paymentServices;
        $this->creditCardRepository = $creditCardRepository;
        $this->paymentRepository = $paymentRepository;
        $this->courseRepository = $courseRepository;
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

        $admin = $this->getAdminRoleId();

        $state = $this->stateRepository->all();

        //Fim Variáveis

        $church_id = $this->getUserChurch();
        /*
         * Lista de Eventos
         */


        /*$events = $this->repository->findWhere([
            'church_id' => $church_id
        ]);*/

        //dd($events);

        /*
         * Notificação, e quantidades de novas notificações
         */
        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

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
        while ($cont < $numWeek) {
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
            'leader', 'role', 'events_pag', 'admin'));
    }


    public function nextMonth($thisMonth = null, $church_id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

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

            if ($event->group_id) {
                $event->group_name = $this->groupRepository->find($event->group_id)->name;
            }

            $fullName = $this->userRepository->find($event->createdBy_id)->person;
            $event->createdBy_name = $fullName->name;
            //$event->created_at = $this->formatDateView($event->created_at);
        }

        /*
         * Notificação, e quantidades de novas notificações
         */
        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

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

        if (!$thisMonth) {
            $thisMonth = (int)date_format(date_create($today), 'm');

            $nextMonth = $thisMonth;

        } else {

            $nextMonth = $thisMonth + 1;
        }


        if ($thisMonth == 12) {
            $ano++;
            $nextMonth = 1;
        } elseif ($thisMonth == -1) {
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

        while ($x != 1) {
            // $i = 0, 1, 2, 3

            $x--; //3, 2, 1, 0

            $x *= -1; //-3, -2, -1, 0

            date_add($date, date_interval_create_from_date_string($x . "days"));

            //$days[$i] = date_create($date);

            $days[$i] = date_format($date, "Y-m-d");

            //echo "1 : " . $days[$i] . "<br>";

            date_date_set($date, $ano, $nextMonth, 1);

            $x *= -1;

            $i++;
        }

        while (!$stop) {
            $days[$i] = date_create(date_format($date, "Y-m-d"));

            $days[$i] = date_format($days[$i], "Y-m-d");

            date_add($date, date_interval_create_from_date_string("1 day"));

            $month = date_format(date_create($days[$i]), "n");

            //echo "2: " . $days[$i] . "<br>";

            //$dayNumber = date_format(date_create($days[$i]), "w");

            $i++;

            if ($month != $nextMonth) {
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


        //dd($events);

        return view("events.index", compact('countPerson', 'countGroups', 'state',
            'events', 'notify', 'qtde', 'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'next', 'ano', 'allEventsNames', 'allEventsTimes',
            'allEventsFrequencies', 'allEventsAddresses', 'church_id', 'leader',
            'role', 'admin'));
    }

    public function oldindex()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $events = $this->repository->paginate(5);


        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);

            if ($event->group_id) {
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

        for ($i = 0; $i < 7; $i++) {
            array_push($days, $nextWeek[$i]);
        }

        for ($i = 0; $i < 7; $i++) {
            array_push($days, $twoWeeks[$i]);
        }

        foreach ($days as $day) {
            array_push($prevWeek, $day);
        }

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
            'prevMonth3', 'prevMonth4', 'prevMonth5', 'prevMonth6', 'allMonths', 'allDays'));
    }

    public function create($id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $frequencies = $this->frequencyRepository->all();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $groups = $this->groupRepository->findByField('church_id', $this->getUserChurch());

        $org_name = $this->churchServices->getOrgAlias();

        $org = $this->churchRepository->findByField('id', $this->getUserChurch())->first();


        if ($id) {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles',
                'id', 'notify', 'qtde', 'groups', 'frequencies', 'leader', 'admin', 'org_name', 'org'));
        } else {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles',
                'notify', 'qtde', 'groups', 'frequencies', 'leader', 'admin', 'org_name', 'org'));
        }


    }

    public function testEventNotification()
    {
        $event = Event::find(1);

        event(new AgendaEvent($event));

        $user[] = User::find(1);

        $user[] = User::find(11);

        \Notification::send($user, new Notifications($event->name, 'events/' . $event->id . '/edit'));
    }


    public function store(Request $request)
    {
        try{

            $data = $request->all();

            $data['createdBy_id'] = \Auth::user()->id;

            $data['eventDate'] = $this->formatDateBD($data['eventDate']);

            if (!$data['eventDate']) {
                $request->session()->flash('invalidDate', 'Insira a data do primeiro encontro');

                return redirect()->back()->withInput();
            }

            $verifyFields = $this->verifyRequiredFields($data, 'event');

            if ($verifyFields) {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                return redirect()->route("event.create")->withInput();
            }

            $endEventDate = $request->get('endEventDate');

            if ($endEventDate == "") {
                $data['endEventDate'] = $data['eventDate'];
            } else {
                $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
            }


            if ($data["frequency"] == $this->biweekly()) {
                $firstDay = substr($data['eventDate'], 8, 2);

                if (!isset($data['day'])) {
                    $request->session()->flash('invalidDate', 'Data do Próximo evento está inválida');

                    return redirect()->back()->withInput();
                }

                if ($data['day'][0] != $firstDay) {
                    $request->session()->flash('invalidDate', 'Data do Próximo evento está inválida');

                    return redirect()->back()->withInput();
                } else {
                    $day = $data['day'][0];
                    $data['day_2'] = $data['day'][1];

                    unset($data['day']);

                    $data['day'] = $day;
                }
            }

            $data["city"] = ucwords($data["city"]);

            //Verificar url do evento
            if ($data['public_url'] != "") {
                if ($this->eventServices->checkUrlEvent($data['public_url'])) {
                    $request->session()->flash('error.msg', 'Url ja está em uso, mude o nome do evento');

                    return redirect()->back()->withInput();
                }
            }

            $data['certified_hours'] = $data['certified_hours'] ? $data['certified_hours'] : 0;

            $event = $this->repository->create($data);


            $this->eventServices->sendNotification($data, $event);

            if ($data["frequency"] != $this->unique()) {
                $this->eventServices->newEventDays($event->id, $data);
            } else {
                $show = $event->eventDate == date("Y-m-d") ? 1 : 0;

                $person_id = \Auth::user()->person_id;

                $event_date = date_create($data['eventDate'] . $data['startTime']);

                if ($data['endTime'] == "") {
                    if ($data['endEventDate'] == $data['eventDate']) {
                        $endTime = date_create();

                        date_add($endTime, date_interval_create_from_date_string("1 day"));

                        $endTime = date_format($endTime, "Y-m-d");

                        $endTime = date_create($endTime);

                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event->id,
                                'person_id' => $person_id,
                                'eventDate' => $event->eventDate,
                                'event_date' => $event_date,
                                'end_event_date' => $endTime,
                                'show' => $show
                            ]);
                    } else {

                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event->id,
                                'person_id' => $person_id,
                                'eventDate' => $event->eventDate,
                                'event_date' => $event_date,
                                'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                                'show' => $show
                            ]);
                    }

                } else {

                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event->id,
                            'person_id' => $person_id,
                            'eventDate' => $event->eventDate,
                            'event_date' => $event_date,
                            'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                            'show' => $show
                        ]);
                }

                $this->eventServices->subAllMembers($event->id, $event->eventDate, $person_id);
            }

            $this->setChurch_id($event);

            $this->eventServices->newRecentEvents($event->id, $this->getUserChurch());

            \DB::commit();

            return redirect()->route('event.index');

        }catch (\Exception $e)
        {
            \DB::rollBack();

            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = $e->getLine() . ' store() EventController.php';
            $bug->model = 'Events';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            $request->session()->flash('error.msg', 'Um erro ocorreu, entre em contato pelo contato@beconnect.com.br');

            return redirect()->back();
        }



        /*}catch(\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.db', 'Não foi possível criar o evento, tente novamente mais tarde');

            return redirect()->back();
        }*/

    }

    public function setChurch_id($event)
    {
        Event::where(['id' => $event->id])
            ->update(
                ['church_id' => $this->getUserChurch()]
            );
    }


    public function edit($id, $church_id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $frequencies = $this->frequencyRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        if ($this->getUserChurch() == null) {
            $church_id = null;
        } else {
            $church_id = $this->getUserChurch();
        }

        $model = $this->repository->find($id);

        $location = $this->formatGoogleMaps($model);

        $model->eventDate = $this->formatDateView($model->eventDate);
        $model->endEventDate = $this->formatDateView($model->endEventDate);

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $eventDays = $this->eventServices->eventDays($id);

        foreach ($eventDays as $eventDay) {
            $eventDay->eventDate = $this->formatDateView($eventDay->eventDate);
        }

        $check = "check-in";

        $eventFrequency = $this->eventServices->eventFrequency($id);

        //dd($eventFrequency);

        $eventPeople = $this->eventServices->eventPeople($id);

        $arr = [];
        $vis = [];
        $people = [];

        foreach ($eventPeople as $item) {
            if (isset($item->person_id)) {
                $arr[] = $item->person_id;
            } else {
                $vis[] = $item->visitor_id;
            }


            /*$e = $this->personRepository->find($item->person_id);
            $e->frequency = $this->eventServices->userFrequency($id, $item->person_id);

            $eventPeople[] = $e;*/
        }

        $eventPeople = DB::table('people')
            ->whereIn('id', $arr)
            ->get();

        foreach ($eventPeople as $item) {
            //$item->name = $this->personRepository->find($item->person_id)->name;
            $item->frequency = $this->eventServices->userFrequency($id, $item->id);
        }

        $eventVisitor = DB::table('visitors')
            ->whereIn('id', $vis)
            ->get();

        foreach ($eventVisitor as $item) {
            $item->frequency = $this->eventServices->userFrequency($id, $item->id . "/visit");
        }

        //dd($arr);


        $eventPeople = $eventPeople->merge($eventVisitor);

        //dd($eventPeople);

        $group = $model->group or null;

        $groups = $this->groupRepository->findByField('church_id', $church_id);

        $sub = false;

        $canCheckIn = $this->eventServices->canCheckIn($id);

        if ($canCheckIn) {
            $sub = $this->eventServices->isSubscribed($id);
        }


        $createdBy_id = $this->userRepository->find($model->createdBy_id)->person_id;

        $createdBy = $this->userRepository->find($model->createdBy_id)->person;

        if ($model->frequency != $this->unique()) {
            $nextEventDate = DB::table('event_person')
                ->select('eventDate')
                ->where(
                    [
                        'event_id' => $id,
                        'show' => 0
                    ]
                )->first();

            $nextEventDate = $nextEventDate != null ? $this->formatDateView($nextEventDate->eventDate) : null;
        } else {
            $nextEventDate = $model->eventDate;
        }


        $preposicao = '';

        $weekly = $this->weekly();

        $monthly = $this->monthly();

        $biweekly = $this->biweekly();

        if ($model->frequency == $weekly) {
            if ($model->day == "Sabado" || $model->day == "Domingo") {
                $preposicao = "todo";
            } else {
                $preposicao = "toda";
            }
        } elseif ($model->frequency == $monthly || $model->frequency == $biweekly) {
            $preposicao = "todo dia";
        }

        $model->sub = count($this->eventServices->getListSubEvent($id));

        $sessions = $this->sessionRepository->findByField('event_id', $id);

        if (count($sessions) == 0) {
            $sessions = false;
        }

        $org = $this->churchRepository->findByField('id', $church_id)->first();

        $local = false;

        if ($model->street == $org->street && $model->number == $org->number) {
            $local = true;
        }

        $org_name = $this->churchServices->getOrgAlias();

        $payment = null;

        if ($payment = $this->churchRepository->findByField('id', $church_id)->first()) {
            $payment = $payment->payment;
            //$model->value_money = number_format($model->value_money, 2, ',', ' ');
            //dd($model->value_money);
        }

        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles',
            'model', 'location', 'notify', 'qtde', 'eventDays', 'eventFrequency', 'check',
            'eventPeople', 'group', 'groups', 'sub', 'canCheckIn', 'createdBy_id', 'createdBy',
            'nextEventDate', 'leader', 'preposicao', 'frequencies', 'church_id', 'leader',
            'admin', 'sessions', 'local', 'org_name', 'payment', 'org'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $event = $this->repository->findByField('id', $id)->first();

        if ($event) {
            $data['createdBy_id'] = $this->repository->findByField('id', $id)->first() ?
                $this->repository->findByField('id', $id)->first()->createdBy_id : 0;

            $data['eventDate'] = $this->formatDateBD($data['eventDate']);

            $endEventDate = $request->get('endEventDate');

            if (!$data['eventDate']) {
                $request->session()->flash('invalidDate', 'Insira a data do primeiro encontro');
                return redirect()->back()->withInput();
            }

            if ($endEventDate == "") {
                $data['endEventDate'] = $data['eventDate'];
            } else {
                $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
            }

            if (isset($data["group_id"]) && $data['group_id'] == "") {
                $data["group_id"] = null;
            }

            if ($data["frequency"] == "Quinzenal") {
                $firstDay = substr($data['eventDate'], 8, 2);

                if ($data['day'][0] != $firstDay) {
                    $request->session()->flash('invalidDate', 'Data do Próximo evento está inválida');
                    return redirect()->back()->withInput();
                } else {
                    $day = $data['day'][0];
                    $data['day_2'] = $data['day'][1];

                    unset($data['day']);

                    $data['day'] = $day;
                }
            }

            $data["city"] = ucwords($data["city"]);

            if ($data['public_url'] == "" && $event->public_url != "")
            {
                $data['public_url'] = $event->public_url;
            }

            //Verificar url do evento
            if ($this->eventServices->checkUrlEvent($data['public_url'], $id))
            {
                $request->session()->flash('error.msg', 'Url ja está em uso, mude o nome do evento');

                return redirect()->back()->withInput();
            }

            if ($data['certified_hours'] == "")
            {
                $data['certified_hours'] = 0;
            }

            if (isset($data['value_money']))
            {
                $data['value_money'] = substr($data['value_money'], 2);

                $data['value_money'] = str_replace('.', '', $data['value_money']);

                $data['value_money'] = ( float )$data['value_money'];
            }

            $this->repository->update($data, $id);

            $this->eventServices->changeEventDays($id);

            //$this->reSub_event_person($id);

            return redirect()->route('event.edit', ['event' => $id]);
        }

        $request->session()->flash('error.msg', 'O evento selecionado não existe');

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

        if ($event_person) {
            DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $user->person_id,
                    'eventDate' => date_format($date, "Y-m-d")
                ])->update(['check-in' => 0]);

            echo json_encode(['status' => false]);
        } else {
            $event->people()->attach($user->person_id, [
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 1
            ]);

            echo json_encode(['status' => true]);
        }

    }


    /*
    * @param int $id
    * $id = id do evento
    * Usado para realizar check-in do evento selecionado
     * Somente para membros
    * */
    public function checkInEvent($id)
    {
        return $this->eventServices->check($id);
    }


    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * Somente para membros
     * */
    public function checkOutEvent($id)
    {
        return $this->eventServices->checkOut($id);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * Somente para visitantes
     * */
    public function checkInEventVisitor($id)
    {
        return $this->eventServices->checkVisitor($id);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * Somente para visitantes
     * */
    public function checkOutEventVisitor($id)
    {
        return $this->eventServices->checkOutVisitor($id);
    }


    public function destroy($id)
    {
        $event = $this->repository->findByField('id', $id)->first();

        if ($event) {

            DB::table('event_person')
                ->where(['event_id' => $id])
                ->delete();

            DB::table('recent_events')->where('event_id', $id)->delete();

            DB::table('event_subscribed_lists')
                ->where(['event_id' => $id])
                ->delete();

            $event->delete();

            \Session::flash('success.msg', 'O evento ' . $event->name . ' foi excluído.');

            return json_encode([
                'status' => true,
                'name' => $event->name
            ]);
        }

        return json_encode(['status' => false, 'msg' => 'Este Evento já foi excluído']);

    }

    public function destroyMany(Request $request)
    {
        $i = 0;

        $data = $request->all();


        while ($i < count($data['input'])) {
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

        while ($i < count($events)) {
            $events[$i]->createdBy_id = $this->userRepository->find($events[$i]->createdBy_id)->person->name;

            $events[$i]->group_id = $events[$i]->group_id ? $this->groupRepository->find($events[$i]->group_id)->name : "Sem Grupo";

            $x = $i == (count($events) - 1) ? "" : ",";

            $text .= '["' . $events[$i]->name . '","' . '' . $events[$i]->frequency . '' . '","' . '' . $events[$i]->createdBy_id . '' . '","' . '' . $events[$i]->group_id . '"' . ']' . $x . '';

            $i++;
        }

        $json = '{
              "content": [
                {
                  "table": {
                    "headerRows": 1,
                    "widths": [ "*", "auto", 100, "*" ],
            
                    "body":[
                      ["' . $header[0] . '", "' . $header[1] . '", "' . $header[2] . '", "' . $header[3] . '"],
                      ' . $text . '
                    ]
                  }
                }
              ]
            }';

        if (env('APP_ENV') == "local") {
            File::put(public_path('js/print.json'), $json);
        } else {
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

        Excel::create('Eventos', function ($excel) use ($info) {

            // Set the title
            //$excel->setTitle('Our new awesome title');

            // Call them separately
            //$excel->setDescription('A demonstration to change the file properties');

            $excel->sheet('Eventos', function ($sheet) use ($info) {
                $sheet->fromArray($info);
            });

        })->export($format);

        return redirect()->route('event.index');
    }

    public function imgEvent(Request $request, $event)
    {
        $file = $request->file('file');

        $event = $this->repository->findByField('id', $event)->first();

        if ($event) {
            try {
                $imgName = 'uploads/event/' . $event->id . '-' . $event->name . '.' . $file->getClientOriginalExtension();

                $file->move('uploads/event', $imgName);

                $x['imgEvent'] = $imgName;

                $this->repository->update($x, $event->id);

                $request->session()->flash('success.msg', 'A imagem foi alterada');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();

                dd($e->getMessage());

                $request->session()->flash('error.msg', 'Um erro aconteceu, tente novamente mais tarde');
            }

            return redirect()->route('event.edit', ['event' => $event->id]);
        }

        $request->session()->flash('error.msg', 'Este Evento não existe');

        return redirect()->route('event.index');
    }

    public function imgEventBg(Request $request, $event)
    {
        $file = $request->file('file');

        $event = $this->repository->findByField('id', $event)->first();

        if ($event) {
            try {
                $imgName = 'uploads/event/' . $event->id . '-' . $event->name . '-bg' . '.' . $file->getClientOriginalExtension();

                $file->move('uploads/event', $imgName);

                $x['imgEvent_bg'] = $imgName;

                $this->repository->update($x, $event->id);

                $request->session()->flash('success.msg', 'A imagem de fundo foi alterada');

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro aconteceu, tente novamente mais tarde');
            }


            return redirect()->route('event.edit', ['event' => $event->id]);
        }

        $request->session()->flash('error.msg', 'Evento não encontrado');

        return redirect()->route('event.index');

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


        if (count($events) > 0) {
            DB::table('event_person')
                ->where(
                    [
                        'eventDate' => $today,
                        'show' => 0,
                        'deleted_at' => null
                    ]
                )->update(['show' => 1]);

            foreach ($events as $event) {
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


                if ($e->frequency == $this->daily()) {
                    $this->setDays($event, $last, '1 day');
                } elseif ($e->frequency == $this->weekly()) {
                    $todayNumber = date('w');

                    $dayNumber = $this->eventServices->getDayNumber($e->day);

                    if ($todayNumber == $dayNumber) {
                        $this->setDays($event, $last, '7 days');
                    }

                } elseif ($e->frequency == $this->monthly()) {
                    $todayNumber = date('d');

                    if ($todayNumber == $e->day) {
                        $this->setDays($event, $last);
                    }
                }
            }

        } else return 0;


    }

    public function setDays($event, $last, $days = null)
    {
        $lastEvent = date_create($last->eventDate);

        if (!$days) {
            $day = date_format($lastEvent, "d");
            $month = date_format($lastEvent, "m");
            $year = date_format($lastEvent, "Y");

            $month++;

            if ($month == 13) {
                $month = 01;
                $year++;
            }

            $nextEvent = date_create($year . "-" . $month . "-" . $day);


        } else {
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
    public function getSubEventListAjax($id)
    {
        try {
            $sub = $this->eventServices->getListSubEvent($id);

            $person_sub = [];
            $visit_sub = [];

            $arr = [];

            $vis = [];

            foreach ($sub as $item) {
                if (isset($item->person_id)) {
                    $arr[] = $item->person_id;
                } else {
                    $vis[] = $item->visitor_id;
                }

                $attendance[] = count(DB::table('event_person')
                    ->where([
                        'event_id' => $id,
                        'check-in' => 1
                    ])->get());
            }

            $person_sub = DB::table('people')
                ->whereIn('id', $arr)
                ->get()//->paginate(5)
            ;

            $visit_sub = DB::table('visitors')
                ->whereIn('id', $vis)
                ->get()//->paginate(5)
            ;

            $event = $this->repository->find($id);

            $people = DB::table('people')
                ->where(
                    [
                        'church_id' => $this->getUserChurch(),
                        'deleted_at' => null
                    ])
                ->whereNotIn('id', $arr)
                ->get();


            $visitors = $this->visitorRepository->findWhereNotIn('id', $vis);

            $merged = $people->merge($visitors);

            $person_sub = $person_sub->merge($visit_sub);

            return json_encode([
                'status' => true,
                'data' => $merged
            ]);


        } catch (\Exception $e) {
            DB::rollback();

            return json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /*
     * Usado para recuperar a lista de usuários inscritos,
     * para posteriormente realizar check-in em lote.
     */
    public function getCheckInListAjax($event)
    {
        /*$sub = $this->eventServices->getListSubEvent($event);

        $arr = [];

        $vis = [];

        foreach ($sub as $item) {
            if(isset($item->person_id))
            {
                $arr[] = $item->person_id;
            }
            else{
                $vis[] = $item->visitor_id;
            }
        }

        $person_sub = DB::table('people')
            ->whereIn('id', $arr)
            ->get();

        $visit_sub = DB::table('visitors')
            ->whereIn('id', $vis)
            ->get();

        //dd($person_sub);

        $merged = $person_sub->merge($visit_sub); //dd($merged);*/

        $data = $this->eventServices->allMembers();

        return json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    /*
     * Inscrição em lote
     */
    public function subPeople($people, $event)
    {
        $people = \GuzzleHttp\json_decode($people);

        foreach ($people as $item) {
            $item = str_replace("-", "/", $item);

            $this->eventServices->subToday($event, $item);

            $this->eventServices->subEvent($event, $item);
        }

        return json_encode(['status' => true]);
    }


    /*
     * Check-in em lote
     */
    public function checkInPeople($people, $event)
    {
        //$people = $people == 0 ? false : \GuzzleHttp\json_decode($people);

        $people = $people == 0 ? false : explode(",", $people);

        //dd($people);

        if (!$people) {
            try {
                $this->eventServices->checkInAll($event);

                $qtde = count($this->eventServices->getListSubEvent($event));

                DB::commit();

                return json_encode([
                    'status' => true,
                    'qtde' => $qtde
                ]);

            } catch (\Exception $e) {
                DB::rollback();

                return json_encode([
                    'status' => false,
                    'msg' => $e->getMessage()
                ]);
            }

        } else {
            foreach ($people as $item) {
                //$item = str_replace("-", "/", $item, $count);

                //if($count == 0){
                $isSub = $this->eventServices->isSubPeople($event, $item);

                if (!$isSub) {
                    $this->eventServices->checkInBatch($event, $item);
                }

                //}
                /*else{
                    $isSub = $this->eventServices->isSubVisitor($event, $item);

                    if(!$isSub)
                    {
                        $this->eventServices->checkInVisitorBatch($event, $item);
                    }

                }*/


            }


            return json_encode(['status' => true]);
        }


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

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        //Fim Variáveis comuns

        $sub = $this->eventServices->getListSubEvent($id);

        $person_sub = [];
        $visit_sub = [];

        $arr = [];

        $vis = [];

        foreach ($sub as $item) {
            if (isset($item->person_id)) {
                $arr[] = $item->person_id;
            } else {
                $vis[] = $item->visitor_id;
            }

            $attendance[] = count(DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'check-in' => 1
                ])->get());

            //$attendance com valor incorreto
        }

        $person_sub = DB::table('people')
            ->whereIn('id', $arr)
            //->get()
            ->orderBy('name')
            ->paginate(30);

        $visit_sub = DB::table('visitors')
            ->whereIn('id', $vis)
            ->get()//->paginate(5)
        ;

        foreach ($person_sub as $p) {
            $person = $this->personRepository->find($p->id);
            $user = isset($person->user) ? $person->user : false;

            $p->social_media = false;

            $p->check = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $p->id,
                    'check-in' => 1
                ])->first();


            if ($user) {
                if ($user->facebook_id || $user->google_id) {
                    $p->social_media = true;
                }
            }


            $p->presence = 0;

            $presence = $this->eventServices->presenceMember($id, $p->id);

            if ($presence > 0) {
                $p->presence = $presence;
            }
        }

        foreach ($visit_sub as $v) {
            $user = $this->visitorRepository->find($v->id)->users()->first();

            $v->social_media = false; //echo $v->id . "<br>";

            if ($user) {
                if ($user->facebook_id || $user->google_id) {
                    $v->social_media = true;
                }
            }

            $v->presence = 0;

            $presence = $this->eventServices->presenceVisitor($id, $v->id);

            if ($presence > 0) {
                $v->presence = $presence;
            }
        }

        $event = $this->repository->find($id);

        $people = DB::table('people')
            ->where(
                [
                    'church_id' => $this->getUserChurch(),
                    'deleted_at' => null
                ])
            ->whereNotIn('id', $arr)
            ->get();


        /*$visitors = $this->visitorRepository->findWhereNotIn('id', $vis);

        $merged = $people->merge($visitors);

        $person_sub = $person_sub->merge($visit_sub);

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;*/

        $qtde_check = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'check-in' => 1
            ])->get();

        $qtde_check = count($qtde_check);


        return view('events.subscriptions',
            compact('people', 'countPerson', 'countGroups', 'leader',
                'notify', 'qtde', 'event', 'sub', 'person_sub', 'admin', 'qtde_check'));
    }

    /*
     * Usado para inscrever um usuário no evento $event
    */
    public function eventSub(Request $request, $event_id)
    {
        $data = $request->all();

        if ($data["person_id"] != "") {
            $event = $this->repository->findByField('id', $event_id)->first();

            if ($event) {
                $role = $this->getUserRole();

                //$leader = $this->roleRepository->find($this->getLeaderRoleId())->name;

                //if((isset($event->group_id) && $role == $leader) || (!isset($event->group_id)))
                //{
                $exists = $this->eventServices->subEvent($event_id, $data["person_id"]);

                if ($exists) {
                    $request->session()->flash('success.msg', 'O usuário foi inscrito');
                } else {
                    $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');
                }
                //}
            } else {
                $request->session()->flash('error.msg', 'Evento não encontrado');
            }

        } else {
            $request->session()->flash('error.msg', 'Usuário não encontrado');
        }

        return redirect()->back();
    }

    /*
     * Usado para desinscrever um usuário no evento $event_id
     *
     * */
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


    /*
     * Usado para realizar check-in pela plataforma web
     */
    public function checkin_manual($event_id, $person_id)
    {
        return $this->eventServices->check($event_id, $person_id);
    }

    /*
     * Usado para retirar check-in pela plataforma web
     */
    public function uncheckin_manual($event_id, $person_id)
    {
        return $this->eventServices->uncheck($event_id, $person_id);
    }

    /*
     * View para inscrição via Url pública
     */
    public function subUrl($url)
    {
        $event = $this->eventServices->checkUrlEvent($url);

        if ($event) {
            $church = $this->churchRepository->findByField('id', $event->church_id)->first();

            if ($church) {
                if ($church->payment && $event->value_money) {


                    if($event->status == 'active' || $event->status === null)
                    {
                        return view('events.sub-pay', compact('event', 'church', 'split_name', 'abrv'));
                    }
                    elseif($event->status == 'canceled'){

                        return view('errors.canceled');
                    }
                    elseif($event->status == 'closed'){

                        return view('errors.canceled');
                    }

                }

                return view('events.sub', compact('event', 'church'));
            }

            return 'Nenhuma Organização Encontrada';
        }

        return 'Nenhum Evento Encontrado';

    }

    /*
     * Cadastro de Participante via Url pública com inscrição em evento gratuitos
     */
    public function subFromUrl(Request $request)
    {
        $data = $request->except(['event_id']);

        $event_id = $request->get('event_id');

        if ($data['email'] == "") {
            $errors['email'] = 'Preencha seu email';

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($data['name'] == "") {
            $errors['name'] = 'Preencha seu nome';

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($data['cel'] == "") {
            $errors['cel'] = 'Preencha seu celular';

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($data['cpf'] == "") {
            $errors['cpf'] = 'Preencha seu CPF';

            return redirect()->back()->withInput()->withErrors($errors);
        }

        if ($data['dateBirth'] == "") {
            $errors['dateBirth'] = 'Preencha sua Data de Nascimento';

            return redirect()->back()->withInput()->withErrors($errors);
        }

        $person = $this->personRepository->findByField('email', $data['email'])->first();

        if ($person) {
            if ($person->user) {
                $this->eventServices->subEvent($event_id, $person->id);

                //$this->peopleServices->send_sub_email($event_id, $person->id);

                //$this->sendWhatsApp($event_id, $person->id);

                $request->session()->flash('success.msg', 'Sucesso! Você está inscrito, um email foi enviado para ' . $data['email']);
                //$request->session()->flash('success.msg', 'Sucesso! Você está inscrito, o QR Code foi enviado para ' . $data['cel']);

                return redirect()->back()->withInput();
            }
        } else {
            $data['role_id'] = 2;

            $data['imgProfile'] = 'uploads/profile/noimage.png';

            $data['tag'] = 'adult';

            $person_id = $this->personRepository->create($data)->id;

            if ($person_id) {
                $this->qrServices->generateQrCode($person_id);

                $this->createUserLogin($person_id, 'secret', $data['email'], $data['church_id']);

                $this->eventServices->subEvent($event_id, $person_id);

                //$this->peopleServices->send_sub_email($event_id, $person_id);

                //$this->sendWhatsApp($event_id, $person_id);

                $request->session()->flash('success.msg', 'Sucesso! Você está inscrito, um email foi enviado para ' . $data['email']);
                //$request->session()->flash('success.msg', 'Sucesso! Você está inscrito, o QR Code foi enviado para ' . $data['cel']);

                return redirect()->back()->withInput();
            }

            $request->session()->flash('error.msg', 'Não foi possível fazer sua inscrição, tente novamente mais tarde!');

            return redirect()->back()->withInput();


        }

        $request->session()->flash('error.msg', 'Atenção! Um erro ocorreu');

        return redirect()->back()->withInput();


    }

    /*
     * Cadastro de Participante via Url pública com inscrição em eventos pagos
     */
    public function payment(Request $request, $event_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        $value = null;

        if ($event) {

            try {
                $data = $request->all();

                if($event_id == 101)
                {
                    $value = $data['input-total'];

                    $courses = [];

                    if(isset($data['course-1']))
                    {
                        $courses[] = 'Cirurgia Minimamente Invasiva Oncológica Gastrointestinal';
                    }

                    if(isset($data['course-2']))
                    {
                        $courses[] = 'Endometriose, Uroginecologia e Ginecologia Minimamente Invasiva';
                    }

                    if(isset($data['course-3']))
                    {
                        $courses[] = 'Medicina Esportiva';
                    }
                }


                $p['name'] = $data['name'];
                $p['email'] = $data['email'];
                $p['cel'] = $data['cel'];
                $p['cpf'] = $data['cpf'];
                $p['dateBirth'] = $data['dateBirth'];

                $person = $this->personRepository->findByField('email', $data['email'])->first();

                if ($person) {
                    $x['person_id'] = $person->id;

                    $this->personRepository->update($p, $person->id);

                    if (!$this->userRepository->findByField('email', $p['email'])->first()) {
                        $this->createUserLogin($x['person_id'], 'secret', $p['email'], $event->church_id);
                    }
                } else {
                    $p['role_id'] = 2;

                    $p['imgProfile'] = 'uploads/profile/noimage.png';

                    $p['tag'] = 'adult';

                    $x['person_id'] = $this->personRepository->create($p)->id;

                    $this->createUserLogin($x['person_id'], 'secret', $p['email'], $event->church_id);
                }

                $this->qrServices->generateQrCode($x['person_id']);

                //Verifica se o cliente ja pagou pela inscrição
                $pay_exists = $this->paymentRepository->findWhere([
                    'person_id' => $x['person_id'],
                    'event_id' => $event_id,
                    'status' => 4
                ]);

                /*
                 * Se pay_exists == 0 então o cliente
                 * não pagou pela inscrição
                 */
                if (count($pay_exists) == 0) {
                    $json_data = $this->paymentServices->prepareCard($data, $x['person_id']);

                    $response_status = json_decode($json_data)->response_status;

                    $card_nonce = json_decode($json_data)->card_nonce;

                    $brandId = json_decode($json_data)->brandId;

                    if ($response_status) {

                        $x['installments'] = (int)$data['installments'];

                        $x['card_nonce'] = $card_nonce;

                        $x['brandId'] = $brandId;

                        $x['metaId'] = $this->paymentServices->setMetaId();

                        /*
                         * Se houver um metaId repetido o código abaixo
                         * vai iterar até encontrar um metaId sem uso.
                         */
                        if ($this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                            $stop = false;

                            while (!$stop) {
                                $x['metaId'] = $this->paymentServices->setMetaId();

                                if (!$this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                                    $stop = true;
                                }
                            }
                        }

                        $li_0 = 'Estado do Pagamento: Processado (pago)';
                        $li_1 = 'Método de Pagamento: Cartão de Crédito';
                        $li_2 = 'Últimos 4 dígitos do cartão: ' . substr($data['credit_card_number'], 12, 4);
                        $li_3 = 'Valor da Transação: R$' . $value ? 'R$'.$value : $event->value_money;
                        $li_4 = 'Parcelamento: ' . $data['installments'] == 1 ? 'Á vista' :
                            $data['installments'] . 'x de R$' . $event->value_money / $data['installments'];
                        $li_5 = 'Código da Transação: ' . $x["metaId"];


                        $url = 'https://www.beconnect.com.br/';//'https://migs.med.br/2019/home/';

                        $url_img = 'http://beconnect.com.br/logo/logo-menor-header.png';//'https://migs.med.br/2019/wp-content/uploads/2019/03/MIGS2019_curva_OK.png';

                        $subject = 'Seu pagamento no evento ' . $event->name;//'Seu pagamento no MIGS 2019 foi concluído.';

                        $p1 = 'Seu pagamento foi aprovado.';

                        $p2 = '';

                        if ($event_id == 101)
                        {
                            DB::table('course_descs')
                                    ->where('person_id', $x['person_id'])
                                    ->delete();

                            foreach ($courses as $item)
                            {
                                $c['description'] = $item;
                                $c['person_id'] = $x['person_id'];

                                $this->courseRepository->create($c);
                            }

                        }

                        $this->paymentServices->createTransaction($x, $event_id, $value);

                        if(isset($courses))
                        {
                            PaymentMail::dispatch($li_0, $li_1, $li_2, $li_3, $li_4,
                                $li_5, $url, $url_img, $subject, $p1, $p2, $x, $event_id, $courses)
                                ->delay(now()->addMinutes(1));
                        }
                        else{
                            PaymentMail::dispatch($li_0, $li_1, $li_2, $li_3, $li_4,
                                $li_5, $url, $url_img, $subject, $p1, $p2, $x, $event_id)
                                ->delay(now()->addMinutes(3));
                        }


                        $request->session()->flash('success.msg', 'Um email será enviado para ' .
                            $data['email'] . ' com informações sobre o pagamento');


                        /*$x['card_token'] = $result->cardToken;
                        $x['type'] = $result->type;
                        $x['card_number'] = $data['credit_card_number'];
                        $x['expirationDate'] = $result->expirationDate;
                        $x['brandId'] = $result->brandId;
                        $x['status'] = $result->status;

                        $this->creditCardRepository->create($x);

                        DB::commit();

                        */

                        //CheckCardToken::dispatch($x, $event_id);


                    }
                } //Se já pagou
                else {

                    $request->session()->flash('error.msg', 'Este usuário já efetuou o pagamento');
                }


                return redirect()->back();

            } catch (\Exception $e) {
                \DB::rollBack();

                $bug = new Bug();

                $msg = isset($x) ? $e->getMessage() . ' id do usuário: ' . $x['person_id'] : $e->getMessage();

                $bug->description = $msg;
                $bug->platform = 'Back-end';
                $bug->location = 'line ' . $e->getLine() . ' payment() EventController.php';
                $bug->model = '4all';
                $bug->status = 'Pendente';

                $bug->save();

                $request->session()->flash('error.msg',
                    'Um erro ocorreu entre em contato pelo contato@beconnect.com.br');

                return redirect()->back();
            }

        }

        throw new NotFoundHttpException();
    }

    public function check_transaction()
    {


        $data['card_token'] = '7b71gvWwLjPNZuXRJ6WlzC6cdS2fJNGyd9CO6EEsSv0=';

        $data['person_id'] = 1535;

        $data['installments'] = 2;

        $this->paymentServices->createTransaction($data, 19);

        return true;

    }

    public function check_card_token()
    {
        $card_token = '1wYgMd6uOHBebndFQ8BcwSWAqH+ZxFhqiwT4+nTBJRs=';

        return $this->paymentServices->check_card_token($card_token);
    }

    public function teste4all()
    {
        return $this->paymentServices->requestVaultKey();
    }

    public function findSubUsers($input, $event_id)
    {
        $list = $this->listRepository
            ->findByField('event_id', $event_id);


        $arr = [];

        foreach ($list as $l) {
            $arr[] = $l->person_id;
        }


        $person_sub = DB::table('people')
            ->where(
                [
                    ['name', 'like', $input . '%'],
                    ['deleted_at', '=', null],
                    'status' => 'active'
                ]
            )
            ->whereIn('id', $arr)
            ->get();


        $check = 'check-in';

        foreach ($person_sub as $item) {

            $d = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                    'person_id' => $item->id
                ])->get();


            $item->check =
                DB::table('event_person')
                    ->where([
                        'event_id' => $event_id,
                        'person_id' => $item->id
                    ])
                    ->first()->$check;


        }

        $count = count($person_sub);


        return json_encode(['status' => true, 'person_sub' => $person_sub, 'count' => $count]);

    }

    public function subTest()
    {
        $event = $this->repository->findByField('id', 14)->first();

        $person = $this->personRepository->find(1030);

        $user = $person->user;

        //dd($user);

        //$event = DB::table('events')->where('id', 14)->first();

        $qrCode = 'https://beconnect.com.br/' . $person->qrCode;

        //dd($qrCode);

        $this->welcome_sub($user, $event, $qrCode);
    }

    public function send_sub_email_test($event_id, $person_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        $person = $this->personRepository->findByField('id', $person_id)->first();

        if ($event && $person) {
            $user = $person->user;

            //$event = DB::table('events')->where('id', 14)->first();

            $qrCode = 'https://beconnect.com.br/' . $person->qrCode;

            //dd($qrCode);

            $this->welcome_sub($user, $event, $qrCode);

            return true;
        }

        return false;
    }

    /*
     * Usado para reinscrever os usuários
     */
    public function reSub($event_id)
    {
        $people = $this->listRepository->findByField('event_id', $event_id);

        foreach ($people as $item) {
            $this->eventServices->subEvent($event_id, $item->person_id);
        }

        //return true;

    }

    public function reSub_event_person($event_id)
    {
        $people = $this->listRepository->findByField('event_id', $event_id);

        $event = $this->repository->findByField('id', $event_id)->first();

        foreach ($people as $item) {
            if ($event->frequency == $this->unique()) {
                $exists = DB::table('event_person')
                    ->where([
                        'event_id' => $event_id,
                        'person_id' => $item->person_id
                    ])->first();

                if (!$exists) {
                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event_id,
                            'person_id' => $item->person_id,
                            'eventDate' => $event->eventDate,
                            'check-in' => 0,
                            'show' => 0,
                            'event_date' => date_create($event->eventDate . $event->start_date),
                            'end_event_date' => date_create($event->eventDate . $event->endTime)
                        ]);
                }


            }
        }
    }

    public function sendWhatsApp($event_id, $person_id)
    {
        //$data['number'] = '5515997454531';//'5511993105830';

        $person = $this->personRepository->findByField('id', $person_id)->first();

        $event = $this->repository->findByField('id', $event_id)->first();

        $data['person_id'] = $person_id;

        if ($person->cel == "" && $person->tel == "") {
            return json_encode(['status' => false]);
        }

        if ($person->cel == "") {
            $data['number'] = $person->tel;
        } else {
            $data['number'] = $person->cel;
        }

        $data['number'] = $this->messageServices->formatPhoneNumber($data['number']);

        $data['person_name'] = $person->name;

        $data['event_name'] = $event->name;

        $data['event_date'] = date_format(date_create($event->eventDate . $event->startTime), 'd/m/Y H:i');

        $data['text'] = 'Parabéns ' . $data['person_name'] . '. Você foi inscrito pelo BeConnect no evento ' . $data['event_name'] . ' que acontecerá em ' . $data['event_date'] . ' Lembre-se de apresentar o QR code acima para se identificar em sua entrada. Bom evento!!';

        $this->messageServices->send_QR_Teste($data);

        return json_encode(['status' => true]);

    }

    public function sendEmailQR($event_id, $person_id)
    {
        $person = $this->personRepository->findByField('id', $person_id)->first();

        $event = $this->repository->findByField('id', $event_id)->first();

        $data['person_id'] = $person_id;

        if ($person->email == "") {
            return json_encode(['status' => false]);
        }

        $user = $person->user;

        if ($person->qrCode == null) {
            $this->qrServices->generateQrCode($person_id);
        }

        $qrCode = "https://beconnect.com.br/" . $person->qrCode;

        $this->messageServices->welcome_sub($user, $event, $qrCode);

        DB::table('msg_jobs')
            ->insert([
                'person_id' => $person_id,
                'channel' => 'email',
                'responseCode' => 200,
                'responseText' => 'OK',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        return json_encode(['status' => true]);
    }


    public function sendQREmailAll($event_id)
    {

        SendQrEmail::dispatch($event_id);

        return redirect()->route('index');
    }

    public function showCertificate($event_id, $person_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        $person = $this->personRepository->findByField('id', $person_id)->first();

        $month = date_format(date_create($event->eventDate), 'm');

        $all_months = $this->agendaServices->allMonths();

        $month = (int)$month;

        $month_name = ($all_months[$month]);

        $day = date_format(date_create($event->eventDate), 'd');

        $year = date_format(date_create($event->eventDate), 'Y');

        $string_date = $day . ' de ' . $month_name . ' de ' . $year;

        $org_id = $person->church_id;

        $org = $this->churchRepository->findByField('id', $org_id)->first();

        $resp = $this->responsibleRepository->findByField('church_id', $this->getUserChurch());

        $col_size = 12 / count($resp);

        $pdf = PDF::loadView('events.certificate', compact('event', 'person',
            'org', 'string_date', 'resp', 'col_size'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();
    }

    public function generateCertificate($event_id, $person_id = null)
    {
        $org_id = 2;//$this->getUserChurch();

        $event = $this->repository->findByField('id', $event_id)->first();

        if($event)
        {
            if ($event->certified_hours)
            {
                if ($person_id) {
                    Certificate::dispatch($event_id, $org_id, $person_id);

                    \Session::flash('success.msg', 'O certificado está sendo enviado para o participante.');
                } else {
                    Certificate::dispatch($event_id, $org_id);

                    \Session::flash('success.msg', 'O certificado está sendo enviado para os participantes, 
                    você receberá um email quando os envios tiverem terminado.');
                }


                return json_encode(['status' => true, 'msg' => 'success']);
            }

            return json_encode(['status' => false, 'msg' => 'Não é possível enviar o certificado do evento']);
        }

        return json_encode(['status' => false, 'msg' => 'Evento não encontrado']);

    }

    public function downloadCertificate($event_id, $person_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        $month = date_format(date_create($event->eventDate), 'm');

        $all_months = $this->agendaServices->allMonths();

        $month = (int)$month;

        $month_name = ($all_months[$month]);

        $day = date_format(date_create($event->eventDate), 'd');

        $year = date_format(date_create($event->eventDate), 'Y');

        $string_date = $day . ' de ' . $month_name . ' de ' . $year;

        if ($event) {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if ($person) {
                $org_id = $person->church_id;

                $org = $this->churchRepository->findByField('id', $org_id)->first();

                if ($org) {
                    echo 'Realizando Download...';

                    $pdf = PDF::loadView('events.certificate', compact('event', 'person', 'org', 'string_date'))
                        ->setPaper('a4', 'landscape');

                    return $pdf->download($person->name . '.pdf');
                } else {

                    echo 'Um erro ocorreu, mande um email para contato@beconnect.com.br informando-nos sobre o erro no download do certificado';
                }
            } else {
                echo 'Um erro ocorreu, mande um email para contato@beconnect.com.br informando-nos sobre o erro no download do certificado';
            }
        } else {
            echo 'Um erro ocorreu, mande um email para contato@beconnect.com.br informando-nos sobre o erro no download do certificado';
        }


    }

    /*
     * Usado para verificar se o campo carga horária foi preenchido antes
     * de enviar o certificado
     */
    public function certified_hours($id)
    {
        $event = $this->repository->findByField('id', $id)->first();

        if ($event) {
            if ($event->certified_hours) {
                return json_encode(['status' => true]);
            }

            return json_encode(['status' => false]);
        }

        return json_encode(['status' => false, 'msg' => 'Este Evento não existe']);
    }

    public function qtde_check($id)
    {
        if ($this->repository->findByField('id', $id)->first()) {
            $list = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'check-in' => 1
                ])->get();

            return json_encode(['status' => true, 'count' => count($list)]);
        }

        return json_encode(['status' => false, 'msg' => 'Este evento não existe']);
    }

    public function is_check($id, $person_id)
    {
        if ($this->repository->findByField('id', $id)->first()) {
            $list = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'check-in' => 1,
                    'person_id' => $person_id
                ])->first();

            $person = $this->personRepository->findByField('id', $person_id)->first();

            if ($person && $person->email) {
                return json_encode(['status' => true, 'count' => $list ? 1 : 0]);
            }

            return json_encode(['status' => false, 'Este participante não tem um email cadastrado']);
        }

        return json_encode(['status' => false, 'msg' => 'Este evento não existe']);
    }

    public function testeQueue()
    {
        Test::dispatch(100, 1);

        return redirect()->route('index');
    }

    public function testezap()
    {
        $this->messageServices->sendWA();
    }

    public function listEvent($event_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        $people = [];

        if ($event) {
            $list = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                    'check-in' => 1,
                ])->select('person_id')->get();

            foreach ($list as $l) {
                $people[] = DB::table('people')
                    ->where([
                        'id' => $l->person_id

                    ])->select('name', 'cel', 'email')->first();
            }
        }

        $presence = DB::table('event_person')
            ->where([
                'event_id' => $event_id,
                'check-in' => 1,
            ])->get();

        dd($list);
    }

    public function sendEmailMessage($event_id)
    {
        $event = $this->repository->findByField('id', $event_id)->first();

        if($event)
        {
            sendEmailMessages::dispatch($event_id);
        }
    }

    public function generateQr($person_id)
    {
        $this->qrServices->generateQrCode($person_id);
    }


}
