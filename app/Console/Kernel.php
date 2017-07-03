<?php

namespace App\Console;

use App\Console\Commands\SendEmails;
use App\Mail\resetPassword;
use App\Models\Event;
use App\Models\User;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Mail;

class Kernel extends ConsoleKernel
{
    use ConfigTrait;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmails::class
    ];
    /**
     * @var EventServices
     */
    private $eventServices;

    public function __construct(EventServices $eventServices)
    {

        $this->eventServices = $eventServices;
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call($this->Cron());

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

    //Função de teste somente, não tem uso em produção
    public function Cron()
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


            if($e->frequency == $this->daily())
            {
                $this->setDays($event, $last, '1 day');
            }
            elseif ($e->frequency == $this->weekly())
            {
                $todayNumber = date('w');

                $dayNumber = $this->eventServices->getDayNumber($e->day);

                if($todayNumber == $dayNumber)
                {
                    $this->setDays($event, $last, '7 days');
                }

            }
            elseif($e->frequency == $this->monthly())
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
}
