<?php

namespace App\Console;

use App\Console\Commands\SendEmails;
use App\Mail\resetPassword;
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
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function (){
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
        })->everyMinute();



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
}
