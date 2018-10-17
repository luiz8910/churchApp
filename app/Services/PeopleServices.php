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
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PeopleServices{

    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(PersonRepository $personRepository, UserRepository $userRepository)
    {

        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
    }

    public function sendPassword($email, $password = null)
    {
        $user = $this->userRepository->findByField('email', $email)->first();

        $url = env('APP_URL');

        $today = date("d/m/Y");

        $time = date("H:i");

        if (count($user) > 0) {

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

        if (count($user) > 0) {

            DB::table('users')
                ->where('email', $email)
                ->update(['password' => bcrypt($password)]);

            return true;
        }

        return false;
    }

}