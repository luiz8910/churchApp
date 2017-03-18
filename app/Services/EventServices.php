<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/03/2017
 * Time: 10:45
 */

namespace App\Services;


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
     * @param $id ($event_id)
     */
    public static function eventDays($id)
    {
        $eventDate = DB::table('event_person')
            ->where([
                'event_id' => $id
            ])
            ->select('eventDate')
            ->distinct()
            ->orderBy('eventDate')
            ->limit(5)
            ->get();



        return $eventDate;
    }

    /**
     * @param $id ($event_id)
     * @param $person_id
     */
    public static function eventFrequency($id)
    {
        $event = DB::table('event_person')->
            where([
                'event_id' => $id
            ])
            ->select('eventDate', 'check-in', 'person_id')
            ->distinct()
            ->orderBy('person_id')
            ->get();

        return $event;
    }

    /**
     * @param $id (event_id)
     */
    public static function eventPeople($id)
    {
        $event = DB::table('event_person')
            ->where('event_id', $id)
            ->select('person_id')
            ->distinct()
            ->orderBy('person_id')
            ->limit(5)
            ->get();

        return $event;
    }

    public static function userFrequency($id, $person_id)
    {
        $event_qtde = count(DB::table('event_person')
            ->where('event_id', $id)
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->limit(5)
            ->get());


        $frequency = count(DB::table('event_person')
            ->where([
                'event_id' => $id,
                'check-in' => 1,
                'person_id' => $person_id
            ])
            ->select('eventDate')
            ->orderBy('eventDate', 'desc')
            ->distinct()
            ->limit(5)
            ->get());

        return $frequency / $event_qtde;
    }
}


