<?php

namespace App\Console\Commands;

use App\Mail\resetPassword;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * The drip e-mail service.
     *
     * @var DripEmailer
     */
    protected $drip;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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
    }
}
