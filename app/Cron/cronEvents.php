<?php

namespace App\Cron;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class CronEvents{

    public function setNextEvents()
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


            if($e->frequency == "Diário")
            {
                $this->setDays($event, $last, '1 day');
            }
            elseif ($e->frequency == "Semanal")
            {
                $todayNumber = date('w');

                $dayNumber = $this->getDayNumber($e->day);

                if($todayNumber == $dayNumber)
                {
                    $this->setDays($event, $last, '7 days');
                }

            }
            elseif($e->frequency == "Mensal")
            {
                $todayNumber = date('d');

                if($todayNumber == $e->day)
                {
                    $this->setDays($event, $last);
                }
            }
        }

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


}