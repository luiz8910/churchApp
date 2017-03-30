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
        return DB::table('event_person')
            ->select('event_id', 'eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->get();
    }
}


