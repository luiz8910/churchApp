<?php

namespace App\Jobs;

use App\Mail\welcome_sub_migs;
use App\Models\Person;
use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\ImportRepository;
use App\Repositories\PersonRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Import implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ConfigTrait, PeopleTrait, UserLoginRepository;

    private $row;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {

        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EventServices $eventServices, EventRepository $eventRepository, PersonRepository $personRepository)
    {
        if($this->row[3] == 'Inscrito')
        {
            $password = false;

            $user_exists = $personRepository->findByField('email', $this->row[1])->first();


            //Se o email não for encontrado então o usuário não existe
            if(!$user_exists)
            {

                $person = Person::create([
                    'name' => $this->row[0],
                    'email' => $this->row[1],
                    'cel' => $this->row[2] == "" ? null : $this->formatPhoneNumber($this->row[2]),
                    'church_id' => $this->row[4],
                    'imgProfile' => 'uploads/profile/noimage.png',
                    'role_id' => 2,
                    'tag' => 'adult',
                ]);

                $password = $this->randomPassword(6);

                $user = $this->createUserLogin($person->id, $password, $this->row[1], $this->row[4]);

                $id = $person->id;

            }
            else{
                $id = $user_exists->id;

                $user = $user_exists->user;
            }

            /*$path = 'qrcodes/'.$id.'.png';

            DB::table('people')
                ->where('id', $id)
                ->update(['qrCode' => $path]);

            QrCode::format('png')->size(1000)->generate($id, $path);*/

            $url = 'https://migs.med.br/2019';

            $event = $eventRepository->findByField('id', $this->row[5])->first();

            if($event)
            {
                Mail::to($user)
                    ->send(new welcome_sub_migs(
                        $user, $url, $event, $password
                    ));


                $eventServices->subEvent($this->row[5], $id);
            }


        }
    }
}
