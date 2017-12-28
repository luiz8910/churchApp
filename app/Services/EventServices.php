<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/03/2017
 * Time: 10:45
 */

namespace App\Services;


use App\Models\Event;
use App\Models\RecentEvents;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\FrequencyRepository;
use App\Repositories\GeofenceRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use App\Traits\FormatGoogleMaps;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
     * EventServices constructor.
     * @param EventRepository $repository
     * @param FrequencyRepository $frequencyRepositoryTrait
     * @param EventSubscribedListRepository $listRepository
     * @param GeofenceRepository $geofenceRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(EventRepository $repository, FrequencyRepository $frequencyRepositoryTrait,
                                EventSubscribedListRepository $listRepository, GeofenceRepository $geofenceRepository,
                                PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->frequencyRepository = $frequencyRepositoryTrait;
        $this->listRepository = $listRepository;
        $this->geofenceRepository = $geofenceRepository;
        $this->personRepository = $personRepository;
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
            ->select('eventDate', 'check-in', 'person_id')
            ->distinct()
            ->orderBy('person_id')
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
            ->select('person_id')
            ->distinct()
            ->orderBy('person_id')
            //->limit(5)
            ->get();

        return $event;
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
     * @param $eventDate (data do primeiro evento)
     * @param $frequency (frequência do evento)
     */
    public function newEventDays($id, $eventDate, $frequency)
    {
        $show = $eventDate == date("Y-m-d") ? 1 : 0;

        $person_id = \Auth::user()->person_id;

        $event_date = date_create($eventDate);

        DB::table('event_person')
            ->insert([
                'event_id' => $id,
                'person_id' => $person_id,
                'eventDate' => $eventDate,
                'event_date' => $event_date,
                'show' => $show
            ]);


        if($frequency == $this->weekly())
        {
            $this->setNextEvents($id, $eventDate, "7 days", $person_id);
        }
        elseif($frequency == $this->monthly())
        {
            $this->setNextEvents($id, $eventDate, "30 days", $person_id);
        }
        elseif ($frequency == $this->daily())
        {
            $this->setNextEvents($id, $eventDate, "1 days", $person_id);
        }
        elseif ($frequency == $this->biweekly())
        {
            $this->setNextEvents($id, $eventDate, "15 days", $person_id);
        }

        $this->subAllMembers($id, $eventDate, $person_id);
    }

    public function setNextEvents($id, $eventDate, $days, $person_id)
    {
        $day = date_create($eventDate);

        $i = 0;

        $event = Event::find($id);

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

                $day = date_create($year."-".$month."-".$d);

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
                    $day_2 = date_create($year."-".$month."-".$event->day_2);
                    $this->insertNewDay($id, $person_id, $day_2);
                }

                $month++;

                if($month == 13)
                {
                    $month = 01;
                    $year++;
                }

                $day = date_create($year."-".$month."-".$d);
                $day_2 = date_create($year."-".$month."-".$event->day_2);


                $this->insertNewDay($id, $person_id, $day_2);

            }

            else{
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

        if($visitor_id)
        {
            return DB::table('event_person')
                ->insert([
                    'event_id' => $id,
                    'visitor_id' => $visitor_id,
                    'eventDate' => date_format($day, "Y-m-d"),
                    'event_date' => $day,
                    'show' => 0
                ]);
        }

        return DB::table('event_person')
            ->insert([
                'event_id' => $id,
                'person_id' => $person_id,
                'eventDate' => date_format($day, "Y-m-d"),
                'event_date' => $day,
                'show' => 0
            ]);
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

                DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $people[$i]->id,
                        'eventDate' => $eventDate,
                        'event_date' => date_create($eventDate),
                        'show' => $show
                    ]);


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
     * @param int $id
     * $id = id do evento
     * Usado para verificar se a pessoa ja deu check-in
     * no evento selecionado
     * @return bool
     */
    public function isSubscribed($id)
    {
        $person = \Auth::user()->person_id;
        $today = date("Y-m-d");

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


        return count($sub) > 0 ? true : false;
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-in do evento selecionado
     * */
    public function check($id)
    {
        $user = \Auth::user();

        $this->subEvent($id, $user->person->id);

        $date = date_create(date('Y-m-d'));

        $event_person = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'person_id' => $user->person_id,
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 0
            ])->get();

        if(count($event_person) > 0)
        {
            DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $user->person_id,
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
                        'person_id' => $user->person_id,
                        'eventDate' => $days[$i]->eventDate,
                        'event_date' => date_create($days[$i]->eventDate),
                        'check-in' => $check,
                        'show' => 1
                    ]);
            }


        }

        echo json_encode(['status' => true]);
    }

    /*
     * @param int $id
     * $id = id do evento
     * Usado para realizar check-out do evento selecionado
     * */
    public function checkOut($id)
    {
        $person = \Auth::user()->person_id;
        $today = date("Y-m-d");

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
                            'event_date' => date_create($nextDay),
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


            $dates = DB::select("SELECT ep.eventDate, e.id, e.name, e.startTime FROM event_person ep, events e, event_subscribed_lists evl
                  WHERE ep.eventDate = '$t' AND STR_TO_DATE(e.startTime, '%H:%i') >= '$time' AND ep.deleted_at is null AND 
                  e.deleted_at is null AND e.church_id = '$church_id' AND evl.event_id = e.id AND evl.person_id = '$person_id' limit 1");

            if (count($dates) == 0)
            {
                /*$t = date_create();
                date_add($t, date_interval_create_from_date_string("1 day"));
                $t = date_format($t, "Y-m-d");*/

                $dates = DB::select("SELECT ep.eventDate, e.id, e.name, e.startTime FROM event_person ep, events e, event_subscribed_lists evl
                              WHERE STR_TO_DATE(ep.eventDate, '%Y-%m-%d') > '$t' AND STR_TO_DATE(e.startTime, '%H:%i') >= '00:00' AND ep.deleted_at is null AND 
                              e.deleted_at is null AND e.church_id = '$church_id' AND evl.event_id = e.id AND evl.person_id = '$person_id' ORDER BY e.startTime limit 1");


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

                }*/

                if(count($dates) > 0)
                {
                    $arr[] = $dates[0]->id;
                    $arr[] = $dates[0]->eventDate;


                }else{
                    $arr[] = null;
                    $arr[] = null;
                }


                return $arr;
            }
            else{
                $arr[] = $dates[0]->id;
                $arr[] = $dates[0]->eventDate;

                return $arr;
            }



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

            $frequency = $this->repository->find($event_id)->frequency;

            if($frequency == $this->weekly())
            {
                $this->setNextEvents($event_id, $nextEvent[1], "7 days", $person_id);
            }
            elseif($frequency == $this->monthly())
            {
                $this->setNextEvents($event_id, $nextEvent[1], "30 days", $person_id);
            }
            elseif ($frequency == $this->daily())
            {
                $this->setNextEvents($event_id, $nextEvent[1], "1 days", $person_id);
            }
            elseif ($frequency == $this->biweekly())
            {
                $this->setNextEvents($event_id, $nextEvent[1], "15 days", $person_id);
            }

            if($visitor_id != 0)
            {
                $data["visitor_id"] = $visitor_id;
            }
            else{
                $data["person_id"] = $person_id;
            }

            $data["event_id"] = $event_id;

            $data["sub_by"] = Auth::user()->person->id;

            $this->listRepository->create($data);

            //$this->addGeofence($event_id, $person_id);

            return true;
        }

        return false;

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

    public function UnsubUser($person_id, $event_id)
    {
        $list = $this->listRepository->findWhere([
            'person_id' => $person_id,
            'event_id' => $event_id
        ])->first();

        $this->listRepository->delete($list->id);
    }

    public function UnsubVisitor($visitor_id, $event_id)
    {
        $list = $this->listRepository->findWhere([
            'visitor_id' => $visitor_id,
            'event_id' => $event_id
        ])->first();

        $this->listRepository->delete($list->id);
    }

    public function UnsubVisitorAll($visitor_id)
    {
        $list = $this->listRepository->findWhere([
            'visitor_id' => $visitor_id,
        ])->first();

        $this->listRepository->delete($list->id);
    }

    public function getListSubPerson($person_id)
    {
        return $this->listRepository->findWhere([
            'person_id' => $person_id
        ]);
    }

    public function getListSubVisitor($visitor_id)
    {
        return $this->listRepository->findWhere([
            'visitor_id' => $visitor_id
        ]);
    }
}


