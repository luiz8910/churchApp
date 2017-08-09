<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Traits\ConfigTrait;
use App\Traits\PeopleTrait;
use Carbon\Carbon;

class VisitorServices{

    use PeopleTrait, ConfigTrait;

    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * VisitorServices constructor.
     * @param PersonRepository $personRepository
     * @param VisitorRepository $visitorRepository
     * @param UserRepository $userRepository
     */
    public function __construct(PersonRepository $personRepository, VisitorRepository $visitorRepository,
                                UserRepository $userRepository)
    {
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
        $this->userRepository = $userRepository;
    }
    /*
     * Usado para alterar o status de visitante
     * para membro da igreja do user logado
     * @param $data = array com os dados do novo membro
     */
    public function changeRole($data)
    {
        $visitor = $this->visitorRepository->findByField("email", $data["email"])->first();
        $user = $this->userRepository->findByField("email", $data["email"])->first();

        $password = $data["password"];

        unset($data["email"]);
        unset($data["confirm-password"]);
        unset($data["password"]);

        $data["imgProfile"] = $visitor->imgProfile;
        $data["church_id"] = $this->getUserChurch();

        //dd($visitor);

        $visitor->churches()->detach();

        $visitor->users()->detach();

        $visitor->delete();

        $person = $this->personRepository->create($data);

        $tag = $this->tag($data["dateBirth"]);
        $this->updateTag($tag, $person->id, 'people');

        User::where('id', $user->id)
            ->update([
                "person_id" => $person->id,
                "church_id" => $data["church_id"],
                "password" => bcrypt($password),
                "updated_at" => Carbon::now()
            ]);


    }
}