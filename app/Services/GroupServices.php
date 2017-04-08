<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 06/04/2017
 * Time: 18:20
 */

namespace App\Services;


use App\Repositories\DateRepository;
use Illuminate\Support\Facades\DB;

class GroupServices
{
    use DateRepository;

    public function listGroupEvents($group)
    {
        $events = DB::table("events")
            ->where([
                "group_id" => $group["id"],
            ])
            ->join("event_person", "event_id", "=", "events.id")
            ->orderBy('event_person.eventDate', 'asc')
            ->get();



        //dd($events);

        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);

        }

        return $events;
    }
}