<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\FeedbackSessionRepository;
use App\Repositories\FeedbackSessionTypeRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;

class FeedbackSessionController extends Controller
{
    use CountRepository, ConfigTrait, NotifyRepository;
    private $repository;
    private $typeRepository;
    private $sessionRepository;
    private $personRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;


    public function __construct(FeedbackSessionRepository $repository, FeedbackSessionTypeRepository $typeRepository,
                                SessionRepository $sessionRepository, PersonRepository $personRepository,
                                EventRepository $eventRepository, RoleRepository $roleRepository)
    {

        $this->repository = $repository;
        $this->typeRepository = $typeRepository;
        $this->sessionRepository = $sessionRepository;
        $this->personRepository = $personRepository;
        $this->eventRepository = $eventRepository;
        $this->roleRepository = $roleRepository;
    }


    public function index($session_id)
    {
        $session = $this->sessionRepository->findByField('id', $session_id)->first();

        if($session)
        {

            $countPerson[] = $this->countPerson();

            $countGroups[] = $this->countGroups();

            $roles = $this->roleRepository->all();

            $leader = $this->getLeaderRoleId();

            $admin = $this->getAdminRoleId();

            $notify = $this->notify();

            $qtde = $notify ? count($notify) : null;

            $event = $this->eventRepository->findByField('id', $session->event_id)->first();

            if($event)
            {
                return view('session.list_types_rates',
                    compact('session', 'state', 'roles', 'leader', 'admin',
                        'notify', 'qtde', 'event', 'feedback_session'));
            }
        }
    }
}
