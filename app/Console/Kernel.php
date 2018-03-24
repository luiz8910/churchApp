<?php

namespace App\Console;

use App\Console\Commands\SendEmails;
use App\Cron\CronEvents;
use App\Mail\resetPassword;
use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Mail;

class Kernel extends ConsoleKernel
{

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmails::class
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function(){
            //$cron = new CronEvents();

            $this->setNextEvents();
            $this->clearRecentTables();
        });

        /*$schedule->call(function (){
            $user = User::where("email", 'luiz.sanches8910@gmail.com')->get();

            $url = env('APP_URL');

            $today = date("d/m/Y");

            $time = date("H:i");

            if (count($user) > 0) {
                $u = User::find($user->first()->id);

                Mail::to($u)
                    ->send(new resetPassword(
                        $u, $url, $today, $time
                    ));

            }
        });*/

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }


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


        if(count($events) > 0)
        {
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
                elseif($e->frequency == "Quinzenal")
                {
                    $todayNumber = date('d');

                    if($todayNumber == $e->day || $todayNumber == $e->day_2)
                    {
                        $this->setDays($event, $last, '15 days');
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

        $e = DB::table('events')
            ->where('id', $event->event_id)
            ->first();

        $event_date = date_create(date_format($nextEvent, "Y-m-d") . $e->startTime);
        $end_event_date = date_create(date_format($nextEvent, "Y-m-d") . $e->endTime);

        if($event->person_id)
        {
            DB::table('event_person')
                ->insert(
                    [
                        'event_id' => $event->event_id,
                        'person_id' => $event->person_id,
                        'eventDate' => date_format($nextEvent, "Y-m-d"),
                        'event_date' => $event_date,
                        'end_event_date' => $end_event_date,
                        'show' => 0
                    ]
                );
        }
        else{
            DB::table('event_person')
                ->insert(
                    [
                        'event_id' => $event->event_id,
                        'visitor_id' => $event->visitor_id,
                        'eventDate' => date_format($nextEvent, "Y-m-d"),
                        'event_date' => $event_date,
                        'end_event_date' => $end_event_date,
                        'show' => 0
                    ]
                );
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

    public function clearRecentTables()
    {
        $today = date_create();

        date_add($today, date_interval_create_from_date_string("-7 days"));

        DB::table('recent_users')
            ->whereDate('created_at', '<', date_format($today, "Y-m-d"))
            ->delete();

        DB::table('recent_groups')
            ->whereDate('created_at', '<', date_format($today, "Y-m-d"))
            ->delete();

        DB::table('recent_events')
            ->whereDate('created_at', '<', date_format($today, "Y-m-d"))
            ->delete();

    }
}
