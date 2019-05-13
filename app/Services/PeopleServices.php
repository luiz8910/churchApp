<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 17/10/2018
 * Time: 00:05
 */

namespace App\Services;

use App\Mail\resetPassword;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PeopleServices{

    use EmailTrait;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(PersonRepository $personRepository, UserRepository $userRepository, EventRepository $eventRepository)
    {

        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
        $this->eventRepository = $eventRepository;
    }

    public function sendPassword($email, $password = null)
    {
        $user = $this->userRepository->findByField('email', $email)->first();

        $url = env('APP_URL');

        $today = date("d/m/Y");

        $time = date("H:i");

        if ($user) {

            if($password)
            {
                Mail::to($user)
                    ->send(new resetPassword(
                        $user, $url, $today, $time, $password
                    ));
            }
            else{
                Mail::to($user)
                    ->send(new resetPassword(
                        $user, $url, $today, $time
                    ));
            }


            return true;
        }

        return false;
    }

    public function changePassword($email, $password)
    {
        $user = $this->userRepository->findByField('email', $email)->first();

        if ($user) {

            DB::table('users')
                ->where('email', $email)
                ->update(['password' => bcrypt($password)]);

            return true;
        }

        return false;
    }

    public function send_sub_email($event_id, $person_id)
    {
        $event = $this->eventRepository->findByField('id', $event_id)->first();

        $person = $this->personRepository->findByField('id', $person_id)->first();

        if($event && $person)
        {
            $user = $person->user;

            //$event = DB::table('events')->where('id', 14)->first();

            $qrCode = 'https://beconnect.com.br/' . $person->qrCode;

            //dd($qrCode);

            $this->welcome_sub($user, $event, $qrCode);

            return true;
        }

        return false;
    }

}
