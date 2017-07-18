<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/03/2017
 * Time: 10:45
 */

namespace App\Services;


use App\Models\Event;
use App\Repositories\EventRepository;
use App\Repositories\FrequencyRepository;
use App\Traits\ConfigTrait;
use Auth;
use Illuminate\Support\Facades\DB;

class EventServices
{

    use ConfigTrait;
    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var FrequencyRepository
     */
    private $frequencyRepository;

    public function __construct(EventRepository $repository, FrequencyRepository $frequencyRepositoryTrait)
    {
        $this->repository = $repository;
        $this->frequencyRepository = $frequencyRepositoryTrait;
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
     * Retorna a frequência do evento
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
            ->limit(5)
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
     * Cria datas de eventos futuros (10 datas por default)
     * @param $id (event_id)
     * @param $eventDate (data do primeiro evento)
     * @param $frequency (frequência do evento)
     */
    public function newEventDays($id, $eventDate, $frequency)
    {
        $show = $eventDate == date("Y-m-d") ? 1 : 0;
        $person_id = \Auth::user()->person_id;

        DB::table('event_person')
            ->insert([
                'event_id' => $id,
                'person_id' => $person_id,
                'eventDate' => $eventDate,
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

                if($diff)
                {
                    if($day == $event->eventDate)
                    {
                        $i = $this->numNextEvents();
                    }
                }
            }

            elseif ($days == "15 days")
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
                $day_2 = date_create($year."-".$month."-".$event->day_2);

                DB::table('event_person')
                    ->insert([
                        'event_id' => $id,
                        'person_id' => $person_id,
                        'eventDate' => date_format($day_2, "Y-m-d"),
                        'show' => 0
                    ]);
            }

            else{
                date_add($day, date_interval_create_from_date_string($days));

                if($diff)
                {
                    if($day == $event->eventDate)
                    {
                        $i = $this->numNextEvents();
                    }
                }
            }


            DB::table('event_person')
                ->insert([
                    'event_id' => $id,
                    'person_id' => $person_id,
                    'eventDate' => date_format($day, "Y-m-d"),
                    'show' => 0
                ]);

            $i++;
        }
    }

    /* Inscreve todos os membros do grupo
     * ao qual o evento pertence (se aplicável)
     * $id = id do evento
     * $eventDate = data do evento
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

                $i++;
            }
        }

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
                            'check-in' => 0,
                            'show' => 0
                        ]
                    );
            }

            $i++;
        }
    }   
}


