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
use Auth;
use Illuminate\Support\Facades\DB;

class EventServices
{

    /**
     * @var EventRepository
     */
    private $repository;

    public function __construct(EventRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retorna os dias dos ultimos 5 eventos
     * @param $id ($event_id)
     * @return \DateTime
     */
    public static function eventDays($id)
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
    public static function eventFrequency($id)
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
    public static function eventPeople($id)
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
    public static function userFrequency($id, $person_id)
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
     * Cria 5 datas de eventos futuros
     * @param $id (event_id)
     * @param $eventDate (data do primeiro evento)
     * @param $frequency (frequência do evento)
     */
    public static function newEventDays($id, $eventDate, $frequency)
    {
        $show = $eventDate == date("Y-m-d") ? 1 : 0;

        DB::table('event_person')
            ->insert([
                'event_id' => $id,
                'person_id' => \Auth::getUser()->person_id,
                'eventDate' => $eventDate,
                'show' => $show
            ]);

        $i = 0;

        $day = date_create($eventDate);

        while ($i < 4)
        {
            if($frequency == "Semanal")
            {
                date_add($day, date_interval_create_from_date_string("7 days"));
            }
            elseif($frequency == "Mensal")
            {
                date_add($day, date_interval_create_from_date_string("30 days"));
            }
            elseif ($frequency == "Diario")
            {
                date_add($day, date_interval_create_from_date_string("1 day"));
            }

            DB::table('event_person')
                ->insert([
                    'event_id' => $id,
                    'person_id' => \Auth::getUser()->person_id,
                    'eventDate' => date_format($day, "Y-m-d"),
                    'show' => 0
                ]);

            $i++;
        }
    }

    /**
     * Retorna todos os eventos
     * @return Event
     */
    public static function allEvents()
    {
        $church_id = \Auth::getUser()->church_id;
        
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
    public static function isSubscribed($id)
    {
        $person = \Auth::getUser()->person_id;
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
    public static function check($id)
    {
        $user = \Auth::getUser();

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
            $days = EventServices::eventDays($id);

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
    public static function checkOut($id)
    {
        $person = \Auth::getUser()->person_id;
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
    public static function canCheckIn($id)
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



            if($endTime == "")
            {

                if ($diff->format('%h:%i') > 0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                $diffEnd = date_diff($time, $endTime);

                if($diff->format('%h:%i') > 0 && $diffEnd->format('%h:%i') <= 0){
                    return true;
                }
                else{
                    return false;
                }
            }
        }


        return false;

    }

    public function changeEventDays($id)
    {
        $today = date("Y-m-d");

        $day = Event::where('id' , $id)
            ->first()
            ->day;


        //Eventos Semanais
        if(!is_numeric($day))
        {
            $dayNumber = $this->getDayNumber($day);


            DB::table('event_person')
                ->where(
                    [
                        'event_id' => $id,
                        'show' => 0
                    ]
                )
                ->delete();

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
        else{
            DB::table("event_person")
                ->where(
                    [
                        'event_id' => $id,
                        'show' => 0
                    ]
                )
                ->delete();


            $year = date("Y");

            $month = date("m");

            $today = date_create($today);



            //Se o dia informado for maior ou igual a data atual
            if($day >= date_format($today, 'd'))
            {

                if(checkdate($month, $day, $year))
                {
                    $date = date_create($year."-".$month."-".$day);

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

                    $this->nextMonthlyEvents($day, $id);
                }
                else{
                    dd("else");
                }
            }

            //Se o dia informado for menor que a data atual
            else{
                $this->nextMonthlyEvents($day, $id);
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
}


