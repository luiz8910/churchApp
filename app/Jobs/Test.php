<?php

namespace App\Jobs;

use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Test implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ConfigTrait, PeopleTrait, UserLoginRepository;

    private $stop_number;
    private $church_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stop_number, $church_id)
    {
        //
        $this->stop_number = $stop_number;
        $this->church_id = $church_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PersonRepository $personRepository)
    {

        $person = $personRepository->findByField('email', 'luiz.sanches8910@gmail.com')->first();

        if($person)
        {
            $user = $person->user;

            \Notification::send($user, new \App\Notifications\Test(10));
        }

        $person = $personRepository->findByField('email', 'luiz.sanches89@yahoo.com')->first();

        if($person)
        {
            $user = $person->user;

            \Notification::send($user, new \App\Notifications\Test(10));
        }


        $person = $personRepository->findByField('email', 'luiz.sanches89@hotmail.com')->first();

        if($person)
        {
            $user = $person->user;

            \Notification::send($user, new \App\Notifications\Test(10));
        }
    }
}


/*
 * $i = 0;

        $users_count = 0;

        while ($users_count < $this->stop_number)
        {
            $verif_name = 'Teste ' . $i;

            $verif_email =  'teste_'.$i.'@teste.com';

            $name = $personRepository->findByField('name', $verif_name)->first();

            $email = $personRepository->findByField('email', $verif_email)->first();

            if(!$name && !$email)
            {
                $data['name'] = $verif_name;

                $data['email'] = $verif_email;

                $data['cel'] = '15999999999';

                $data['church_id'] = $this->church_id;

                $data['tag'] = 'adult';

                $data['role_id'] = 2;

                $data['imgProfile'] = 'uploads/profile/noimage.png';

                $data['status'] = 'test';

                $id = $personRepository->create($data)->id;

                //$password = $this->randomPassword();

                //$this->createUserLoginTest($id, $password, $data['email'], $this->getUserChurch());

                $users_count++;
            }

            $i++;
        }


        $person = Person::where(['id' => 21])->first();

        $user = $person->user;

        \Notification::send($user, new \App\Notifications\Test($users_count));
 */
