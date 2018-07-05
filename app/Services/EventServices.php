<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/03/2017
 * Time: 10:45
 */

namespace App\Services;


use App\Events\AgendaEvent;
use App\Models\Event;
use App\Models\EventSubscribedList;
use App\Models\Person;
use App\Models\RecentEvents;
use App\Models\User;
use App\Notifications\Notifications;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\FrequencyRepository;
use App\Repositories\GeofenceRepository;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use App\Traits\FormatGoogleMaps;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class EventServices
{

    use ConfigTrait, FormatGoogleMaps;
    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var FrequencyRepository
     */
    private $frequencyRepository;
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var GeofenceRepository
     */
    private $geofenceRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var AgendaServices
     */
    private $agendaServices;

    /**
     * EventServices constructor.
     * @param EventRepository $repository
     * @param FrequencyRepository $frequencyRepositoryTrait
     * @param EventSubscribedListRepository $listRepository
     * @param GeofenceRepository $geofenceRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(EventRepository $repository, FrequencyRepository $frequencyRepositoryTrait,
                                EventSubscribedListRepository $listRepository, GeofenceRepository $geofenceRepository,
                                PersonRepository $personRepository, GroupRepository $groupRepository,
                                AgendaServices $agendaServices)
    {
        $this->repository = $repository;
        $this->frequencyRepository = $frequencyRepositoryTrait;
        $this->listRepository = $listRepository;
        $this->geofenceRepository = $geofenceRepository;
        $this->personRepository = $personRepository;
        $this->groupRepository = $groupRepository;
        $this->agendaServices = $agendaServices;
    }

    /**
     * Retorna os dias dos ultimos 5 eventos
     * @param $id ($event_id)
     * @return \DateTime
     */
    public function eventDays($id)
    {
        $eventDate = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'show' => 1
            ])
            ->select('eventDate')
            ->distinct()
            ->orderBy('eventDate')
            ->limit(5)
            ->get();


        return $eventDate;
    }

    /**
     * Retorna a frequência do evento (Os dias em que o evento ocorreu)
     * @param $id ($event_id)
     * @param $person_id
     * @return Event
     */
    public function eventFrequency($id)
    {
        $event = DB::table('event_person')->
            where([
                'event_id' => $id,
                'show' => 1
            ])
            ->select('eventDate', 'check-in', 'person_id', 'visitor_id')
            ->distinct()
            ->orderBy('person_id', 'visitor_id')
            ->get();

        return $event;
    }

    /**
     * Retorna todas as pessoas que participam do evento
     * @param $id (event_id)
     */
    public function eventPeople($id)
    {
        $event = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'show' => 1
            ])
            ->select('person_id', 'visitor_id')
            ->distinct()
            ->orderBy('person_id')
            //->limit(5)
            ->get();

        return $event;
    }

    /*
     * Retorna quantos pessoas compareceram no dia $date
     * no evento $event
     */
    public function eventFrequencyByDate($event, $date)
    {
        return count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'eventDate' => $date,
                'check-in' => 1
            ])
            ->distinct()
            ->get());
    }

    /**
     * Retorna a frequência da pessoa no evento
     * @param $id (event_id)
     * @param $person_id
     * @return float|int
     */
    public function userFrequency($id, $person_id)
    {
        $event_qtde = count(DB::table('event_person')
            ->where([
                'event_id' => $id,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->limit(5)
            ->get());

        //$person_id .= "/visit";

        $visit = (integer) trim(strstr($person_id, '/visit', true));

        if($visit)
        {
            $frequency = count(DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'check-in' => 1,
                    'visitor_id' => $visit,
                    'show' => 1
                ])
                ->select('eventDate')
                ->orderBy('eventDate', 'desc')
                ->distinct()
                ->limit(5)
                ->get());

            return $frequency / $event_qtde;
        }


        $frequency = count(DB::table('event_person')
            ->where([
                'event_id' => $id,
                'check-in' => 1,
                'person_id' => $person_id,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->limit(5)
            ->get());

        return $frequency / $event_qtde;
    }

    /**
     * Cria datas de eventos futuros (5 datas por default)
     * @param $id (event_id)
     * @param $data['eventDate'] (data do primeiro evento)
     * @param $data['frequency'] (frequência do evento)
     */
    public function newEventDays($id, $data, $person_id = null)
    {
        $show = $data['eventDate'] == date("Y-m-d") ? 1 : 0;

        $person_id = $person_id ? $person_id : \Auth::user()->person->id;

        $event_date = date_create($data['eventDate'] . $data['startTime']);

        if(isset($data['endTime']) && ($data['endTime'] == "" || $data['endTime'] == null))
        {
            if($data['endEventDate'] == $data['eventDate'])
            {
                $endTime = date_create();

                date_add($endTime, date_interval_create_from_date_string("1 day"));

                $endTime = date_format($endTime, "Y-m-d");

                $endTime = date_create($endTime);

                DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => $data['eventDate'],
                        'event_date' => $event_date,
                        'end_event_date' => $endTime,
                        'show' => $show
                    ]);
            }
            else{
                DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => $data['eventDate'],
                        'event_date' => $event_date,
                        'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                        'show' => $show
                    ]);
            }
        }
        else{
            DB::table('event_person')
                ->insert([
                    'event_id' => $id,
                    'person_id' => $person_id,
                    'eventDate' => $data['eventDate'],
                    'event_date' => $event_date,
                    'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                    'show' => $show
                ]);
        }


        if($data['frequency'] == $this->weekly())
        {
            $this->setNextEvents($id, $data, "7 days", $person_id);
        }
        elseif($data['frequency'] == $this->monthly())
        {
            $this->setNextEvents($id, $data, "30 days", $person_id);
        }
        elseif ($data['frequency'] == $this->daily())
        {
            $this->setNextEvents($id, $data, "1 days", $person_id);
        }
        elseif ($data['frequency'] == $this->biweekly())
        {
            $this->setNextEvents($id, $data, "15 days", $person_id);
        }

        $this->subAllMembers($id, $data['eventDate'], $person_id);
    }

    public function setNextEvents($id, $data = null, $days, $person_id)
    {
        $i = 0;

        $event = Event::find($id);

        $day = date_create($event->eventDate . $event->startTime);

        $diff = $event->eventDate != $event->endEventDate ? true : false;

        $numNextEvents = $this->numNextEvents();

        while($i < ($numNextEvents - 1)) {

            if($days == "30 days")
            {
                $d = date_format($day, "d");
                $month = date_format($day, "m");
                $year = date_format($day, "Y");

                $month++;

                if($month == 13)
                {
                    $month = 01;
                    $year++;
                }

                $day = date_create($year."-".$month."-".$d.$event->startTime);

                $d = date_format($day, "Y-m-d");

                if($d == $event->endEventDate)
                {
                    $i = $this->numNextEvents();
                }
            }

            elseif ($days == "15 days")
            {
                $d = date_format($day, "d");
                $month = date_format($day, "m");
                $year = date_format($day, "Y");

                if ($i == 0)
                {
                    $day_2 = date_create($year."-".$month."-".$event->day_2.$event->startTime);
                    $this->insertNewDay($id, $person_id, $day_2);
                }

                $month++;

                if($month == 13)
                {
                    $month = 01;
                    $year++;
                }

                $day = date_create($year."-".$month."-".$d.$event->startTime);
                $day_2 = date_create($year."-".$month."-".$event->day_2.$event->startTime);


                $this->insertNewDay($id, $person_id, $day_2);

            }

            else{
                //2018-06-07 + 7 days = 2018-06-14
                date_add($day, date_interval_create_from_date_string($days));

                if($diff)
                {
                    $d = date_format($day, "Y-m-d");

                    if($d == $event->endEventDate)
                    {
                        $i = $this->numNextEvents();
                    }
                }
            }

            $this->insertNewDay($id, $person_id, $day);

            $i++;
        }

    }

    public function insertNewDay($id, $person_id, $day)
    {
        $visitor_id = trim(strstr($person_id, "/visit", true));

        $event = $this->repository->find($id);

        $endTime = date_create(date_format($day, "Y-m-d"));

        //2018-06-15
        date_add($endTime, date_interval_create_from_date_string("1 day"));

        if($visitor_id)
        {
            if($event->endTime == "" || $event->endTime == null)
            {
                if($event->eventDate == $event->endEventDate)
                {
                    return DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'visitor_id' => $visitor_id,
                            'eventDate' => date_format($day, "Y-m-d"),
                            'event_date' => $day,
                            'end_event_date' => $endTime,
                            'show' => 0
                        ]);
                }
                else{
                    return DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'visitor_id' => $visitor_id,
                            'eventDate' => date_format($day, "Y-m-d"),
                            'event_date' => $day,
                            'end_event_date' => date_create($event->endEventDate.$event->endTime),
                            'show' => 0
                        ]);
                }
            }
            else{

                if($event->eventDate == $event->endEventDate)
                {
                    $dateDay = date_format($day, "Y-m-d");

                    return DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'visitor_id' => $visitor_id,
                            'eventDate' => date_format($day, "Y-m-d"),
                            'event_date' => $day,
                            'end_event_date' => date_create($dateDay.$event->endTime),
                            'show' => 0
                        ]);
                }
                else{
                    return DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'visitor_id' => $visitor_id,
                            'eventDate' => date_format($day, "Y-m-d"),
                            'event_date' => $day,
                            'end_event_date' => date_create($event->endEventDate.$event->endTime),
                            'show' => 0
                        ]);
                }
            }
        }

        if($event->endTime == "" || $event->endTime == null)
        {
            if($event->eventDate == $event->endEventDate)
            {



                //$endTime = date_format($endTime, "Y-m-d");

                //$endTime = date_create($endTime);

                return DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($day, "Y-m-d"),
                        'event_date' => $day,
                        'end_event_date' => $endTime,
                        'show' => 0
                    ]);

            }
            else{
                $end = $event->endEventDate . ' ' .$event->endTime;

                return DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($day, "Y-m-d"),
                        'event_date' => $day,
                        'end_event_date' => date_create($end),
                        'show' => 0
                    ]);
            }
        }

        else{
            if($event->eventDate == $event->endEventDate)
            {
                $dateDay = date_format($day, "Y-m-d");

                return DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($day, "Y-m-d"),
                        'event_date' => $day,
                        'end_event_date' => date_create($dateDay . ' ' .$event->endTime),
                        'show' => 0
                    ]);
            }
            else{
                return DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($day, "Y-m-d"),
                        'event_date' => $day,
                        'end_event_date' => date_create($event->endEventDate . ' ' .$event->endTime),
                        'show' => 0
                    ]);
            }



        }


    }

    /* Inscreve todos os membros do grupo
     * ao qual o evento pertence (se aplicável)
     * $id = id do evento
     * $eventDate = data do evento
     * $createdBy_id = $id do criador do evento
    */
    public function subAllMembers($id, $eventDate, $createdBy_id)
    {
        $event = $this->repository->find($id);

        $group = $event->group;

        if($group)
        {
            $people = [];

            foreach ($group->people as $person)
            {
                if($person->id != $createdBy_id)
                {
                    $people[] = $person;
                }

            }

            //dd($people);

            $frequency = $event->frequency;

            $show = $eventDate == date("Y-m-d") ? 1 : 0;

            $i = 0;

            while ($i < count($people))
            {

                if($event->endTime == "" || $event->endTime == null)
                {
                    if($event->eventDate == $event->endEventDate)
                    {
                        $endTime = date_create();

                        date_add($endTime, date_interval_create_from_date_string("1 day"));

                        $endTime = date_format($endTime, "Y-m-d");

                        $endTime = date_create($endTime);

                        DB::table('event_person')
                            ->insert([
                                'event_id' => $id,
                                'person_id' => $people[$i]->id,
                                'eventDate' => $eventDate,
                                'event_date' => date_create($eventDate.$event->startTime),
                                'end_event_date' => $endTime,
                                'show' => $show
                            ]);
                    }
                    else{
                        DB::table('event_person')
                            ->insert([
                                'event_id' => $id,
                                'person_id' => $people[$i]->id,
                                'eventDate' => $eventDate,
                                'event_date' => date_create($eventDate.$event->startTime),
                                'end_event_date' => date_create($event->endEventDate . $event->endTime),
                                'show' => $show
                            ]);
                    }

                }
                else{
                    DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'person_id' => $people[$i]->id,
                            'eventDate' => $eventDate,
                            'event_date' => date_create($eventDate.$event->startTime),
                            'end_event_date' => date_create($event->endEventDate.$event->endTime),
                            'show' => $show
                        ]);
                }



                if($frequency == $this->weekly())
                {
                    $this->setNextEvents($id, $eventDate, "7 days", $people[$i]->id);
                }
                elseif($frequency == $this->monthly())
                {
                    $this->setNextEvents($id, $eventDate, "30 days", $people[$i]->id);
                }
                elseif ($frequency == $this->daily())
                {
                    $this->setNextEvents($id, $eventDate, "1 days", $people[$i]->id);
                }


                $this->subEvent($id, $people[$i]->id);

                $i++;
            }

            $this->subEvent($id, $createdBy_id);

        }

        $this->subEvent($id, $createdBy_id);

        return false;

    }

    /**
     * Retorna todos os eventos
     * @return Event
     */
    public function allEvents($church_id)
    {
        
        //Filtrar eventos por igreja
        return DB::table('event_person')
            ->join('events', 'events.id', '=', 'event_person.event_id')
            ->where([
                'events.church_id' => $church_id,
                'event_person.deleted_at' => null
                ])
            ->select('event_person.event_id', 'event_person.eventDate')
            ->orderBy('event_person.eventDate', 'asc')
            ->orderBy('events.startTime', 'asc')
            ->distinct()
            ->get();
    }


    /*
     * Verifica se o evento $id tem uma data para hoje.
     * Se houver uma data verifica se o usuário $person_id
     * realizou o check-in
     */
    public function isCheckApp($id, $person_id)
    {
        $today = date('Y-m-d');


        $event = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'eventDate' => $today,
                'deleted_at' => null
            ])->first();

        /*
         * Se true então existe um evento para a data atual
         */
        if(count($event) > 0)
        {
            $sub = DB::table('event_person')
                ->where(
                    [
                        'person_id' => $person_id,
                        'check-in' => 1,
                        'event_id' => $id,
                        'eventDate' => $today,
                        'deleted_at' => null
                    ])
                ->first();

            if(count($sub) > 0)
            {
                //Check-in foi realizado
                return json_encode(['status' => true, 'check-in' => true]);
            }
            else{

                //Check-in não foi realizado
                return json_encode(['status' => true, 'check-in' => false]);

            }

        }

        //Não há datas para hoje
        return json_encode(['status' => false, 'msg' => 'O Evento informado não tem uma data para hoje']);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para verificar se a pessoa ja deu check-in
     * no evento selecionado
     * @return bool
     */
    public function isSubscribed($id, $person_id = null)
    {
        $person = $person_id ? $person_id : \Auth::user()->person_id;

        $today = date("Y-m-d");

        $event = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'eventDate' => $today,
                'deleted_at' => null
            ])->first();

        /*
         * Se true então existe um evento para a data atual
         */
        if(count($event) > 0)
        {
            $sub = DB::table('event_person')
                ->where(
                    [
                        'person_id' => $person,
                        'check-in' => 1,
                        'event_id' => $id,
                        'eventDate' => $today,
                        'deleted_at' => null
                    ])
                ->first();

            if(count($sub) > 0)
            {
                return json_encode(['status' => true, 'check-in' => true]);
            }

        }


    }

    /*
     * Verifica se a pessoa ja fez o check-in
     */
    public function isSubPeople($id, $person_id)
    {
        $today = date("Y-m-d");

        $sub = DB::table('event_person')
            ->where(
                [
                    'person_id' => $person_id,
                    'check-in' => 1,
                    'event_id' => $id,
                    'eventDate' => $today,
                    'deleted_at' => null
                ])
            ->first();


        return count($sub) > 0 ? true : false;
    }

    public function isSubVisitor($id, $visitor_id)
    {
        $today = date("Y-m-d");

        $visit = trim(strstr($visitor_id, "/visit"));

        if($visit) {
            $visitor_id = trim(strstr($visitor_id, "/visit", true));
        }

        $sub = DB::table('event_person')
            ->where(
                [
                    'visitor_id' => $visitor_id,
                    'check-in' => 1,
                    'event_id' => $id,
                    'eventDate' => $today,
                    'deleted_at' => null
                ])
            ->first();


        return count($sub) > 0 ? true : false;
    }

    /*
     * Usado para realizar check-in do evento selecionado
     */
    public function checkApp($id, $person)
    {


        $date = date_create();

        /*
         * $event_person = Exibir se há alguma data para o
         * evento $id no dia de hoje e
         * que o usuário $person esteja inscrito
         */

        $event = $this->repository->find($id);

        if($event->endTime == "")
        {
            $event_person = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    //'person_id' => $person,
                    'eventDate' => date_format($date, "Y-m-d"),
                    ['event_date', '<=', $date],
                ])
                ->first();


        }else{

            $event_person = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    //'person_id' => $person,
                    'eventDate' => date_format($date, "Y-m-d"),
                    ['event_date', '<=', $date],
                    ['end_event_date', '>', $date]
                ])
                ->first();
        }

        if(count($event_person) > 0)
        {
            $this->subEvent($id, $person);

            DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $person,
                    'eventDate' => date_format($date, "Y-m-d"),
                    'check-in' => 0
                ])->update([
                    'check-in' => 1,
                    'show' => 1
                ]);

            return json_encode(['status' => true, 'check-in' => true]);
        }
        else{

            return json_encode(
                [
                    'status' => false,
                    'check-in' => false,
                    'msg' => 'Data do evento é diferente da data atual']);
        }


    }


    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-in do evento selecionado
     * */
    public function check($id, $person = null, $visitor = null)
    {
        try{

            $person = $person ? $person : \Auth::user()->person;

            $this->subEvent($id, $person->id);

            $date = date_create(date('Y-m-d'));

            if($visitor)
            {
                $event_person = DB::table('event_person')
                    ->where([
                        'event_id' => $id,
                        'visitor_id' => $person->id,
                        'eventDate' => date_format($date, "Y-m-d"),
                        'check-in' => 0
                    ])->get();

                if(count($event_person) > 0)
                {
                    DB::table('event_person')
                        ->where([
                            'event_id' => $id,
                            'visitor_id' => $person->id,
                            'eventDate' => date_format($date, "Y-m-d"),
                            'check-in' => 0
                        ])->update([
                            'check-in' => 1,
                            'show' => 1
                        ]);
                }
                else{
                    $days = $this->eventDays($id);

                    $today = date("Y-m-d");

                    for($i = 0; $i < count($days); $i++)
                    {
                        $check = $days[$i]->eventDate == $today ? 1 : 0;

                        DB::table('event_person')
                            ->insert([
                                'event_id' => $id,
                                'visitor_id' => $person->id,
                                'eventDate' => $days[$i]->eventDate,
                                'event_date' => date_create($days[$i]->eventDate),
                                'check-in' => $check,
                                'show' => 1
                            ]);
                    }


                }
            }
            else{

                /*
                 * $event_person = Exibir se há alguma data para o
                 * evento $id no dia de hoje e
                 * que o usuário $person esteja inscrito
                 */
                $event_person = DB::table('event_person')
                    ->where([
                        'event_id' => $id,
                        'person_id' => $person->id,
                        'eventDate' => date_format($date, "Y-m-d"),
                        //'check-in' => 0
                    ])->get();


                /*
                 * Se achar algum evento
                 */
                if(count($event_person) > 0)
                {
                    /*
                     * Realiza o check-in
                     */
                    DB::table('event_person')
                        ->where([
                            'event_id' => $id,
                            'person_id' => $person->id,
                            'eventDate' => date_format($date, "Y-m-d"),
                            'check-in' => 0
                        ])->update([
                            'check-in' => 1,
                            'show' => 1
                        ]);
                }
                /*
                 * Senão achar nenhum evento
                 * (Ele pode realizar o check-in mesmo se não estiver inscrito)
                 */
                else{
                    /**
                     * Retorna os dias dos ultimos 5 eventos
                     * @param $id ($event_id)
                     * @return \DateTime
                     */
                    $days = $this->eventDays($id);

                    $today = date("Y-m-d");

                    for($i = 0; $i < count($days); $i++)
                    {
                        $check = $days[$i]->eventDate == $today ? 1 : 0;

                        DB::table('event_person')
                            ->insert([
                                'event_id' => $id,
                                'person_id' => $person->id,
                                'eventDate' => $days[$i]->eventDate,
                                'event_date' => date_create($days[$i]->eventDate),
                                'check-in' => $check,
                                'show' => 1
                            ]);
                    }

                }
            }



            DB::commit();

            return json_encode(['status' => true]);
        }catch(\Exception $e){
            DB::rollback();

            return json_encode(['status' => false]);
        }



    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-in do evento selecionado
     * Somente para Visitantes
     * */
    public function checkVisitor($id)
    {
        try{

            $user = \Auth::user();

            $this->subEvent($id, $user->visitors->first()->id . "/visit");

            $date = date_create(date('Y-m-d'));

            $event_person = DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'visitor_id' => $user->visitors->first()->id,
                    'eventDate' => date_format($date, "Y-m-d"),
                    'check-in' => 0
                ])->get();

            if(count($event_person) > 0)
            {
                DB::table('event_person')
                    ->where([
                        'event_id' => $id,
                        'visitor_id' => $user->visitors->first()->id,
                        'eventDate' => date_format($date, "Y-m-d"),
                        'check-in' => 0
                    ])->update([
                        'check-in' => 1,
                        'show' => 1
                    ]);
            }
            else{
                $days = $this->eventDays($id);

                $today = date("Y-m-d");

                for($i = 0; $i < count($days); $i++)
                {
                    $check = $days[$i]->eventDate == $today ? 1 : 0;

                    DB::table('event_person')
                        ->insert([
                            'event_id' => $id,
                            'visitor_id' => $user->visitors->first()->id,
                            'eventDate' => $days[$i]->eventDate,
                            'event_date' => date_create($days[$i]->eventDate),
                            'check-in' => $check,
                            'show' => 1
                        ]);
                }


            }

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e){
            DB::rollback();

            return json_encode(['status' => false]);
        }
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * Somente para membros
     * */
    public function checkOut($id, $person_id = null)
    {
        $person = $person_id ? $person_id : \Auth::user()->person_id;

        $today = date("Y-m-d");

        try{

            DB::table('event_person')
                ->where(
                    [
                        'person_id' => $person,
                        'check-in' => 1,
                        'event_id' => $id,
                        'eventDate' => $today,
                        'deleted_at' => null
                    ]
                )
                ->update(
                    ['check-in' => 0]
                );

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e)
        {
            DB::rollback();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }



    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * Somente para visitantes
     * */
    public function checkOutVisitor($id)
    {
        $visitor = \Auth::user()->visitors->first()->id;
        $today = date("Y-m-d");

        DB::table('event_person')
            ->where(
                [
                    'visitor_id' => $visitor,
                    'check-in' => 1,
                    'event_id' => $id,
                    'eventDate' => $today,
                    'deleted_at' => null
                ]
            )
            ->update(
                ['check-in' => 0]
            );

        return json_encode(['status' => true]);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para verificar se a hora e o dia atual
     * correspondem com a data do evento selecionado
     *
     * */
    public function canCheckIn($id)
    {
        $type = Auth::user()->person ? 'person_id' : 'visitor_id';

        $user_id = $type == 'person_id' ? Auth::user()->person->id : Auth::user()->visitors->first()->id;

        $sub = DB::table('event_subscribed_lists')
            ->where([
                'event_id' => $id,
                $type => $user_id
            ])
            ->get();

        $e = $this->repository->find($id);

        /*
         * Se $sub = 0. então usuário logado
         * não está inscrito no evento, portanto
         * ele não pode realizar o check-in
         *
         * Obs: Valído somente para eventos privados
        */

        if(count($sub) == 0 && isset($e->group_id))
        {
            return false;
        }

        $today = date("Y-m-d");
        $time = date("H:i");

        $time = date_create($time);

        $event = DB::table('event_person')
            ->where(
                [
                    'eventDate' => $today,
                    'event_id' => $id,
                    'deleted_at' => null
                ])
            ->first();

        if (count($event) > 0)
        {
            $eventTime = Event::select('startTime', 'endTime')->where('id', $id)->first();

            $endTime = $eventTime->endTime == "" ? "" : date_create($eventTime->endTime);

            $startTime = date_create($eventTime->startTime);

            $diff = date_diff($time, $startTime);

            $diffInMin = $diff->format("%r%h") * 60;

            $diffInMin += $diff->format("%r%i");



            if($endTime == "")
            {

                if ($diffInMin < 0)
                {
                    //return 'check-in permitido, diff < 0';
                    return true;
                }
                else{
                    //return 'check-in bloqueado, diff > 0';
                    return false;
                }
            }
            else{
                $diffEnd = date_diff($time, $endTime);

                $diffInMinEnd = $diffEnd->format("%r%h") * 60;
                $diffInMinEnd += $diffEnd->format("%r%i");

                if($diffInMin < 0 && $diffInMinEnd >= 0){
                    //return 'check-in permitido';
                    return true;
                }
                else{
                    //return 'check-in bloqueado';
                    return false;
                }
            }
        }


        return false;

    }

    public function changeEventDays($id)
    {
        $today = date("Y-m-d");

        $event = Event::where('id' , $id)->first();

        DB::table('event_person')
            ->where(
                [
                    'event_id' => $id,
                    'show' => 0
                ]
            )
            ->delete();

        //Eventos Semanais
        if(!is_numeric($event->day))
        {
            $dayNumber = $this->getDayNumber($event->day);

            $nextDay = date_create($today);

            date_add($nextDay, date_interval_create_from_date_string("1 days"));

            while(date_format($nextDay, "w") != $dayNumber){
                date_add($nextDay, date_interval_create_from_date_string("1 days"));
            }

            $i = 0;

            while($i < 5)
            {
                DB::table('event_person')
                    ->insert(
                        [
                            'event_id' => $id,
                            'person_id' => \Auth::user()->person_id,
                            'eventDate' => date_format($nextDay, 'Y-m-d'),
                            'event_date' => $nextDay,
                            'check-in' => 0,
                            'show' => 0
                        ]
                    );

                date_add($nextDay, date_interval_create_from_date_string("7 days"));
                $i++;
            }

            //dd(date_format($nextDay, 'Y-m-d'));

            //dd($delete);


        }
        //Eventos Mensais
        elseif ($event->frequency == $this->monthly()){

            $year = date("Y");

            $month = date("m");

            $today = date_create($today);


            //Se o dia informado for maior ou igual a data atual
            if($event->day >= date_format($today, 'd'))
            {

                if(checkdate($month, $event->day, $year))
                {
                    $date = date_create($year."-".$month."-".$event->day);

                    DB::table('event_person')
                        ->insert(
                            [
                                'event_id' => $id,
                                'person_id' => Auth::user()->person_id,
                                'eventDate' => date_format($date, "Y-m-d"),
                                'event_date' => date_create($date),
                                'check-in' => 0,
                                'show' => 0
                            ]
                        );

                    $this->nextMonthlyEvents($event->day, $id);
                }
            }

            //Se o dia informado for menor que a data atual
            else{
                $this->nextMonthlyEvents($event->day, $id);
            }

        }

        elseif ($event->frequency == $this->biweekly())
        {
            $year = date("Y");

            $month = date("m");

            $today = date_create($today);


            //Se o dia informado for maior ou igual a data atual
            if($event->day >= date_format($today, 'd'))
            {

                if(checkdate($month, $event->day, $year))
                {
                    $date = date_create($year."-".$month."-".$event->day);

                    DB::table('event_person')
                        ->insert(
                            [
                                'event_id' => $id,
                                'person_id' => Auth::user()->person_id,
                                'eventDate' => date_format($date, "Y-m-d"),
                                'event_date' => date_create($date),
                                'check-in' => 0,
                                'show' => 0
                            ]
                        );

                    $this->nextBiWeeklyEvents($event->day, $event->day_2, $id);
                }
            }//Se o dia informado for menor que a data atual
            else{
                $this->nextBiWeeklyEvents($event->day, $event->day_2, $id);
            }

        }



    }

    public function getDayNumber($day)
    {

        $dayName[] = 'Domingo'; //0
        $dayName[] = 'Segunda-Feira'; //1
        $dayName[] = 'Terça-Feira'; //2
        $dayName[] = 'Quarta-Feira'; //3
        $dayName[] = 'Quinta-Feira'; //4
        $dayName[] = 'Sexta-Feira'; //5
        $dayName[] = 'Sábado'; //6

        $x = 0;

        for ($i = 0; $i < count($dayName); $i++)
        {
            if($day == $dayName[$i])
            {
                $x = $i;
                break;
            }
        }

        return $x;
    }

    public function nextMonthlyEvents($day, $id)
    {
        $i = 0;
        $year = date("Y");
        $month = date('m');

        while ($i < 5)
        {
            if($month == 12)
            {
                $month = 0;
                $year++;
            }

            if(checkdate($month + 1, $day, $year))
            {
                $month++;
                $date = date_create($year."-".$month."-".$day);

                DB::table("event_person")
                    ->insert(
                        [
                            'event_id' => $id,
                            'person_id' => Auth::user()->person_id,
                            'eventDate' => date_format($date, "Y-m-d"),
                            'event_date' => date_create($date),
                            'check-in' => 0,
                            'show' => 0
                        ]
                    );
            }

            $i++;
        }
        
    }

    public function nextBiWeeklyEvents($day, $day_2, $id)
    {
        $i = 0;
        $year = date("Y");
        $month = date('m');

        while ($i < 5)
        {
            if($month == 12)
            {
                $month = 0;
                $year++;
            }

            if(checkdate($month + 1, $day, $year))
            {
                $month++;
                $date = date_create($year."-".$month."-".$day);

                DB::table("event_person")
                    ->insert(
                        [
                            'event_id' => $id,
                            'person_id' => Auth::user()->person_id,
                            'eventDate' => date_format($date, "Y-m-d"),
                            'event_date' => date_create($date),
                            'check-in' => 0,
                            'show' => 0
                        ]
                    );
            }

            if (checkdate($month + 1, $day_2, $year))
            {
                $month++;
                $date = date_create($year."-".$month."-".$day_2);

                DB::table("event_person")
                    ->insert(
                        [
                            'event_id' => $id,
                            'person_id' => Auth::user()->person_id,
                            'eventDate' => date_format($date, "Y-m-d"),
                            'event_date' => date_create($date),
                            'check-in' => 0,
                            'show' => 0
                        ]
                    );
            }

            $i++;
        }
    }

    //Busca pelo próximo evento
    public function getNextEvent($id = null)
    {
        //Dia Atual
        $today = date_create();

        $arr = [];

        if($id)
        {
            //$dates contém todos as datas do evento selecionado que não foram excluídos
            $dates = DB::table("event_person")
                ->where([
                    ["deleted_at", '=', null],
                    ["event_id", '=', $id]
                ])
                ->get();

            $arrayDates = [];

            $arrayIds = [];


            for ($i = 0; $i < count($dates); $i++)
            {
                //Separando as datas dos eventos
                $date = date_create($dates[$i]->eventDate);

                //Obtendo a diferença entre a data atual
                // e a data do evento
                $diff = date_diff($today, $date);

                //Se a data do evento for igual o dia atual
                //ou datas futuras
                if($diff->format("%r%a") > -1)
                {
                    //Separa o id do evento
                    $arrayIds[$i] = $dates[$i]->event_id;
                    //Separa a data do evento
                    $arrayDates[$i] = $date;
                }
            }


            //Organiza os eventos de forma ascendente
            //O indice 0 é o próximo evento
            asort($arrayDates);

            $key = array_keys($arrayDates);

            $key = reset($key);

            //dd($arrayDates);

            //Separa a data do próximo Evento numa variável
            $d = date_format($arrayDates[$key], "Y-m-d");

            //Separa o id do próximo evento numa variável
            //$id = array_search($d, $arrayDates); // id 8

            /*
             * Indíce 0 corresponde a $id do próximo evento
             * Indice 1 corresponde a data do próximo evento
             * */
            $arr[] = $arrayIds[$key];
            $arr[] = $d;

            //dd($arr);

            return $arr;

        }
        else{
            //$dates contém todos os eventos que não foram excluídos

            $t = date_format($today, "Y-m-d");

            $time = date_format($today, "H:i");

            $church_id = $this->getUserChurch();

            $person_id = Auth::user()->person->id;

            $list = EventSubscribedList::where('person_id', $person_id)->orderBy('created_at', 'DESC')->get();

            $events = DB::table('event_person')->where([
                'event_person.deleted_at' => null,
                ['event_person.event_date', '>=', $today]
            ])->select('event_id', 'event_date')->distinct()->orderBy('event_person.event_date')->get();
            
            $my_event = '';
            $my_event_date = '';

            if(count($events) > 0)
            {
                foreach($events as $event)
                {
                    foreach ($list as $item) {
                       if($item->event_id == $event->event_id)
                       {
                           $my_event = $event->event_id;
                           $my_event_date = $event->event_date;

                           break 2;
                       }
                    }
                }

                $arr[] = $my_event;
                $arr[] = $my_event_date;


                return $arr;
            }
            else{

                $arr[] = null;
                $arr[] = null;

                return $arr;
            }



            /*$dates = DB::table('event_person')
                ->join('event_subscribed_lists', 'event_subscribed_lists.event_id', '=', 'event_person.event_id')
                ->where([
                        'event_person.deleted_at' => null,
                        'event_subscribed_lists.deleted_at' => null,
                        'event_subscribed_lists.person_id' => $person_id,
                        ['event_person.event_date', '<', $today]
                    ]
                )
                ->distinct()
                ->limit(1)
                ->orderBy('event_person.event_date', 'DESC')
                ->get();*/


            /*$dates = DB::select("SELECT ep.eventDate, e.id, e.name, e.startTime FROM event_person ep, events e, event_subscribed_lists evl
                  WHERE ep.eventDate = '$t' AND STR_TO_DATE(e.startTime, '%H:%i') >= '$time' AND ep.deleted_at is null AND
                  e.deleted_at is null AND e.church_id = '$church_id' AND evl.event_id = e.id AND evl.person_id = '$person_id' limit 1");*/

            /*if (count($dates) == 0)
            {
                $t = date_create();
                date_add($t, date_interval_create_from_date_string("1 day"));
                $t = date_format($t, "Y-m-d");

                $dates = DB::select("SELECT ep.eventDate, e.id, e.name, e.startTime FROM event_person ep, events e, event_subscribed_lists evl
                              WHERE STR_TO_DATE(ep.eventDate, '%Y-%m-%d') > '$t' AND STR_TO_DATE(e.startTime, '%H:%i') >= '00:00' AND ep.deleted_at is null AND 
                              e.deleted_at is null AND e.church_id = '$church_id' AND evl.event_id = e.id AND evl.person_id = '$person_id' ORDER BY e.startTime limit 1");
                */

                /*while(count($dates) == 0 || $stop)
                {
                    $stop = $i == 5 ?: false;

                    $t = date_create();
                    date_add($t, date_interval_create_from_date_string($i . " days"));
                    $t = date_format($t, "Y-m-d");

                    $dates = DB::select("SELECT ep.eventDate, e.id, e.name, e.startTime FROM event_person ep, events e, event_subscribed_lists evl
                              WHERE ep.eventDate = '$t' AND STR_TO_DATE(e.startTime, '%H:%i') >= '$time' AND ep.deleted_at is null AND 
                              e.deleted_at is null AND e.church_id = '$church_id' AND evl.event_id = e.id AND evl.person_id = '$person_id' limit 1");

                    $i++;

                }

                if(count($dates) > 0)
                {
                    $arr[] = $dates[0]->event_id;
                    $arr[] = $dates[0]->eventDate;


                }else{

                }
                $arr[] = null;
                $arr[] = null;

                return $arr;
            }
            else{
                $arr[] = $dates[0]->event_id;
                $arr[] = $dates[0]->event_date;

                return $arr;
            }*/



            /*$dates = DB::table("event_person")
                ->join('events', 'events.id', '=', 'event_person.event_id')
                ->where([
                    "events.church_id" => $this->getUserChurch(),
                    [DB::raw(STR_TO_DATE('event_person.eventDate', '%Y-%m-%d'))]
                ])->whereNull("event_person.deleted_at")
                ->get();*/
        }


        //dd($dates);


    }

    /*
     * Usado para inserir um evento na
     * tabela de eventos recentes
     */
    public function newRecentEvents($id, $church_id)
    {
        RecentEvents::insert([
            'event_id' => $id,
            'church_id' => $church_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /*
     * Usado para inscrever um usuário
    /**
     * @param $event_id
     * @param $person_id
     * @return bool
     */
    public function subEvent($event_id, $person_id)
    {

        try{

            $visit = trim(strstr($person_id, "/visit"));
            $visitor_id = 0;

            if($visit)
            {
                $visitor_id = trim(strstr($person_id, "/visit", true));

                $exists = $this->listRepository->findWhere([
                    'event_id' => $event_id,
                    'visitor_id' => $visitor_id
                ]);
            }
            else{
                $exists = $this->listRepository->findWhere([
                    'event_id' => $event_id,
                    'person_id' => $person_id
                ]);
            }



            if(count($exists) == 0)
            {
                $nextEvent = $this->getNextEvent($event_id);

                $event = $this->repository->find($event_id);

                $frequency = $event->frequency;

                $data['eventDate'] = $nextEvent[1];

                $data['startTime'] = $event->startTime;

                if($frequency == $this->weekly())
                {
                    $this->setNextEvents($event_id, $data, "7 days", $person_id);
                }
                elseif($frequency == $this->monthly())
                {
                    $this->setNextEvents($event_id, $data, "30 days", $person_id);
                }
                elseif ($frequency == $this->daily())
                {
                    $this->setNextEvents($event_id, $data, "1 days", $person_id);
                }
                elseif ($frequency == $this->biweekly())
                {
                    $this->setNextEvents($event_id, $data, "15 days", $person_id);
                }

                if($visitor_id != 0)
                {
                    $data["visitor_id"] = $visitor_id;
                }
                else{
                    $data["person_id"] = $person_id;
                }

                $data["event_id"] = $event_id;

                $data["sub_by"] = isset(Auth::user()->person) ? Auth::user()->person->id : 0;

                $this->listRepository->create($data);

                //$this->addGeofence($event_id, $person_id);

                DB::commit();

                return true;
            }

            return false;

        }catch(\Exception $e){

            DB::rollback();

            return false;
        }

    }

    public function addGeofence($event_id, $person_id)
    {
        $event = $this->repository->find($event_id);

        $location = $this->formatGoogleMaps($event);

        $string = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$location.'&key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A';

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $json = file_get_contents($string, false, stream_context_create($arrContextOptions));
        $obj = json_decode($json);

        $geolocation = $obj->results[0]->geometry->location;

        $user = $this->personRepository->find($person_id);

        $data["event_id"] = $event_id;
        $data["user_id"] = $user->user->id;
        $data["lat"] = $geolocation->lat;
        $data["long"] = $geolocation->lng;
        $data["active"] = 1;

        $this->geofenceRepository->create($data);
    }

    /*
     * Recupera a lista de usuários inscritos
     * no evento com id = $id
     */
    public function getListSubEvent($id)
    {
        return $this->listRepository->findWhere([
            'event_id' => $id,
        ]);
    }

    /*
     * Recupera a lista de usuários inscritos
     * no evento com id = $id
     */
    public function getListSubEventAPP($id)
    {
        return $this->listRepository->findWhere([
            'event_id' => $id,
        ]);
    }

    /*
     * Remove inscrição do membro no evento selecionado
     */
    public function UnsubUser($person_id, $event_id)
    {
        $list = $this->listRepository->findWhere([
            'person_id' => $person_id,
            'event_id' => $event_id
        ])->first();

        if(count($list) > 0)
        {
            $this->listRepository->delete($list->id);

            return true;
        }


        return false;

    }

    /*
     * Desinscreve o visitante do evento selecionado
     */
    public function UnsubVisitor($visitor_id, $event_id)
    {
        $list = $this->listRepository->findWhere([
            'visitor_id' => $visitor_id,
            'event_id' => $event_id
        ])->first();

        $this->listRepository->delete($list->id);
    }

    /*
     * Desinscreve o visitante de todos os eventos
     * em que o mesmo participa
     */
    public function UnsubVisitorAll($visitor_id)
    {
        $list = $this->listRepository->findWhere([
            'visitor_id' => $visitor_id,
        ])->first();

        $this->listRepository->delete($list->id);
    }

    /*
     * Recupera a lista de eventos em que o membro
     * está inscrito
     * */
    public function getListSubPerson($person_id)
    {
        return $this->listRepository->findWhere([
            'person_id' => $person_id
        ]);
    }

    /*
     * Recupera a lista de eventos em que o visitante
     * está inscrito
     * */
    public function getListSubVisitor($visitor_id)
    {
        return $this->listRepository->findWhere([
            'visitor_id' => $visitor_id
        ]);
    }

    /*
     * Check-in em lote
     */
    public function checkInBatch($event_id, $person_id)
    {
        try{

            $this->subEvent($event_id, $person_id);

            $date = date_create();

            $event_person = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                    'person_id' => $person_id,
                    'eventDate' => date_format($date, "Y-m-d"),
                    'check-in' => 0
                ])->get();


            if(count($event_person) > 0)
            {
                DB::table('event_person')
                    ->where([
                        'event_id' => $event_id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($date, "Y-m-d"),
                        'check-in' => 0
                    ])->update([
                        'check-in' => 1,
                        'show' => 1
                    ]);
            }
            else{

                //Descobrir a frequência do evento

                $event = $this->repository->find($event_id);

                $today = date("Y-m-d");

                //Se frequencia for semanal
                if($event->frequency == $this->weekly())
                {
                    $day = $this->agendaServices->thisDay();

                    $week = $this->agendaServices->allDaysName();

                    //O dia está correto, realiza o check-in

                    if($week[$day] == $event->day)
                    {
                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event_id,
                                'person_id' => $person_id,
                                'eventDate' => $today,
                                'event_date' => date_create($today . $event->startTime),
                                'check-in' => 1,
                                'show' => 1
                            ]);


                        $this->setNextEvents($event_id, null, "7 days", $person_id);

                    }
                    else{

                        return json_encode(
                            [
                                'status' => false,
                                'check-in' => false,
                                'msg' => 'Data do evento é diferente da data atual']);
                    }
                }

                //Se frequencia for mensal
                elseif($event->frequency == $this->monthly())
                {
                    $day = $this->agendaServices->thisDayNumber();

                    if($day == $event->day)
                    {
                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event_id,
                                'person_id' => $person_id,
                                'eventDate' => $today,
                                'event_date' => date_create($today . $event->startTime),
                                'check-in' => 1,
                                'show' => 1
                            ]);

                        $this->setNextEvents($event_id, null, "30 days", $person_id);
                    }
                    else{

                        return json_encode(
                            [
                                'status' => false,
                                'check-in' => false,
                                'msg' => 'Data do evento é diferente da data atual']);
                    }
                }

                //Se frequencia for quinzenal
                if($event->frequency == $this->biweekly())
                {
                    $day = $this->agendaServices->thisDayNumber();

                    if($day == $event->day)
                    {
                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event_id,
                                'person_id' => $person_id,
                                'eventDate' => $today,
                                'event_date' => date_create($today . $event->startTime),
                                'check-in' => 1,
                                'show' => 1
                            ]);

                        $this->setNextEvents($event_id, null, "15 days", $person_id);
                    }
                    elseif($day == $event->day_2)
                    {
                        DB::table('event_person')
                            ->insert([
                                'event_id' => $event_id,
                                'person_id' => $person_id,
                                'eventDate' => $today,
                                'event_date' => date_create($today . $event->startTime),
                                'check-in' => 1,
                                'show' => 1
                            ]);

                        $this->setNextEvents($event_id, null, "15 days", $person_id);
                    }
                    else{

                        return json_encode(
                            [
                                'status' => false,
                                'check-in' => false,
                                'msg' => 'Data do evento é diferente da data atual']);
                    }
                }
                elseif($event->frequency == $this->daily())
                {
                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event_id,
                            'person_id' => $person_id,
                            'eventDate' => $today,
                            'event_date' => date_create($today . $event->startTime),
                            'check-in' => 1,
                            'show' => 1
                        ]);

                    $this->setNextEvents($event_id, null, "1 days", $person_id);
                }

                elseif($event->frequency == $this->unique())
                {
                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event_id,
                            'person_id' => $person_id,
                            'eventDate' => $today,
                            'event_date' => date_create($today . $event->startTime),
                            'check-in' => 1,
                            'show' => 1
                        ]);
                }




                /*$days = $this->eventDays($event_id);



                for($i = 0; $i < count($days); $i++)
                {
                    $check = $days[$i]->eventDate == $today ? 1 : 0;

                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event_id,
                            'person_id' => $person_id,
                            'eventDate' => $days[$i]->eventDate,
                            'event_date' => date_create($days[$i]->eventDate . $event->startTime),
                            'check-in' => $check,
                            'show' => 1
                        ]);
                }*/


            }

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e){
            DB::rollback();

            return json_encode(['status' => false]);
        }
    }

    /*
     * Check-in de visitantes em lote
     */
    public function checkInVisitorBatch($event_id, $visitor_id)
    {

        try{

            $this->subEvent($event_id, $visitor_id);

            $date = date_create(date('Y-m-d'));

            $event_person = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                    'visitor_id' => $visitor_id,
                    'eventDate' => date_format($date, "Y-m-d"),
                    'check-in' => 0
                ])->get();

            if(count($event_person) > 0)
            {
                DB::table('event_person')
                    ->where([
                        'event_id' => $event_id,
                        'visitor_id' => $visitor_id,
                        'eventDate' => date_format($date, "Y-m-d"),
                        'check-in' => 0
                    ])->update([
                        'check-in' => 1,
                        'show' => 1
                    ]);
            }
            else{
                $days = $this->eventDays($event_id);

                $today = date("Y-m-d");

                for($i = 0; $i < count($days); $i++)
                {
                    $check = $days[$i]->eventDate == $today ? 1 : 0;

                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event_id,
                            'visitor_id' => $visitor_id,
                            'eventDate' => $days[$i]->eventDate,
                            'event_date' => date_create($days[$i]->eventDate),
                            'check-in' => $check,
                            'show' => 1
                        ]);
                }


            }

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e){
            DB::rollback();

            return json_encode(['status' => false]);
        }

    }

    /*
     * Recupera quais eventos tem os check-in disponíveis
     * para a hora e dia atual
     * @return IDs dos eventos disponíveis
     * Se @return == false, então não há eventos disponíveis
     */
    public function checkInNow()
    {
        $church_id = $this->getUserChurch();

        $midnight = date_format(date_create(), 'Y-m-d');

        $midnight = date_create($midnight);

        //$now = date_create();
        $now = date_create();

        $result = DB::table('event_person')
            ->join('events', 'events.id', '=', 'event_person.event_id')
            ->where([
                'events.church_id' => $church_id,
                'event_person.deleted_at' => null,
                ['event_person.event_date', '>=', $midnight],
                ['event_person.event_date', '<=', $now],
                ['event_person.end_event_date', '>=', $now],
            ])
            ->select('events.id')
            ->distinct()
            ->get()
            ;

        //dd($result);

        if(count($result) > 0)
        {
            $collection = collect($result);

            return $collection;
        }

        return false;
    }

    /*
     * Recupera o último evento realizado
     */
    public function getLastEvent()
    {
        $church_id = $this->getUserChurch();

        $today = date_create();

        $today = date_format($today, 'Y-m-d H:i:s');

        $lastEvent = DB::table('event_person')
            ->join('events', 'events.id', '=', 'event_person.event_id')
            ->where(
                [
                    'events.church_id' => $church_id,
                    ['event_person.event_date', '<=', $today],
                    'event_person.deleted_at' => null
                ]
            )->select('events.id')->orderBy('event_date', 'desc')->limit(1)->get();

        return $lastEvent;
    }

    /*
     * Realiza o check-in de todos os membros inscritos
     * no evento = $event
     */
    public function checkInAll($event)
    {
        $today = date_create();

        $today = date_format($today, 'Y-m-d');

        return DB::table('event_person')
            ->where([
                'event_id' => $event,
                'eventDate' => $today
            ])->update(['check-in' => 1]);
    }

    /*
     * Quando é usado a inscrição em lote, este método
     * insere todos os usuários relacionados com o dia atual
     */
    public function subToday($event, $person_id)
    {
        $e = $this->repository->find($event);

        if($e->eventDate == $e->endEventDate)
        {
            if($e->endTime == null || $e->endTime == "")
            {
                $t = date_create();

                date_add($t, date_interval_create_from_date_string("1 day"));
            }
            else{
                $t = date_create();

                $t = date_format($t, "Y-m-d");

                $t = date_create($t . $e->endTime);

                date_add($t, date_interval_create_from_date_string("1 day"));
            }
        }
        else{
            if($e->endTime == null || $e->endTime == "")
            {
                $t = date_create($e->endEventDate . '00:00:00');

                date_add($t, date_interval_create_from_date_string("1 day"));
            }
            else{
                $t = date_create($e->endEventDate . $e->endTime);
            }
        }

        $today = date_create();

        $today = date_format($today, 'Y-m-d');

        $visit = trim(strstr($person_id, "/visit"));
        $visitor_id = 0;

        if($visit) {
            $visitor_id = trim(strstr($person_id, "/visit", true));

            DB::table('event_person')
                ->insert([
                    'event_id' => $event,
                    'visitor_id' => $visitor_id,
                    'eventDate' => $today,
                    'check-in' => 0,
                    'show' => 1,
                    'event_date' => date_create($today.$e->startTime),
                    'end_event_date' => $t
                ]);
        }
        else{
            DB::table('event_person')
                ->insert([
                    'event_id' => $event,
                    'person_id' => $person_id,
                    'eventDate' => $today,
                    'check-in' => 0,
                    'show' => 1,
                    'event_date' => date_create($today.$e->startTime),
                    'end_event_date' => $t
                ]);
        }

    }

    /*
     * Retorna a qtde de vezes em que um membro($person_id)
     * participou de um evento $event
     */
    public function presenceMember($event, $person_id)
    {
        return count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'person_id' => $person_id,
                'check-in' => 1
            ])->distinct()->get());
    }

    /*
     * Retorna a qtde de vezes em que um visitante($visitor_id)
     * participou de um evento $event
     */
    public function presenceVisitor($event, $visitor_id)
    {
        return count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'visitor_id' => $visitor_id
            ])->get());
    }

    /*
     * Retorna a porcentagem de presenças de um membro($person_id)
     * em um evento $event
     */
    public function memberFrequencyPercentage($person_id, $event)
    {
        $event_qtde = count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->get());

        $frequency = count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'check-in' => 1,
                'person_id' => $person_id,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->get());

        return $frequency > 0 ? $frequency / $event_qtde : 0;
    }

    /*
     * Retorna a qtde de presenças de um membro($person_id)
     * em um evento $event
     */
    public function memberFrequencyQtde($person_id, $event)
    {
        $frequency = count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'check-in' => 1,
                'person_id' => $person_id,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->get());

        return $frequency;
    }

    /*
     * Retorna a qtde de presenças de um visitante($visitor_id)
     * em um evento $event
     */
    public function visitorFrequencyQtde($visitor_id, $event)
    {
        $frequency = count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'check-in' => 1,
                'visitor_id' => $visitor_id,
                'show' => 1
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->get());

        return $frequency;
    }

    /*
     * Retorna a qtde de vezes em que um
     * evento $event foi realizado
     */
    public function getEventTimes($event)
    {
        return count(DB::table('event_person')
            ->where([
                'event_id' => $event,
                'show' => 1
            ])
            ->select('eventDate')
            ->distinct()
            ->get());
    }


    public function sendNotification($data, $event, $church_id = null)
    {
        try{
            $church = $church_id ? $church_id : $this->getUserChurch();

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
                        'users.church_id' => $church,
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

    public function allMembers($church_id = null)
    {

        $church = $church_id ? $church_id : $this->getUserChurch();

        $people = Person::select('id', 'name', 'lastName')
            ->where('church_id', $church)
            ->whereNull('deleted_at')
            ->get();


        if(count($people) > 0)
        {

            foreach ($people as $person)
            {

                $person->name = $person->name . ' ' . $person->lastName;

                unset($person->lastName);

            }

            return $people;
        }
        else{

            return false;
        }
    }
}


