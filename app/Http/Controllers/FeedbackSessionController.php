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


    /*
     * Lista por avaliações por sessão
     */
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
                $feedback_session = $this->repository->findByField('session_id', $session_id);

                if(count($feedback_session) > 0)
                {
                    foreach ($feedback_session as $item)
                    {
                        $type = $this->typeRepository->findByField('id', $item->type_feedback)->first();

                        if($type)
                        {
                            $item->type = $type->type;
                        }

                        $person = $this->personRepository->findByField('id', $item->person_id)->first();

                        if($person)
                        {
                            $item->person = $person->name;
                        }
                    }
                }

                return view('sessions.list_rates',
                    compact('session', 'roles', 'leader', 'admin',
                        'notify', 'qtde', 'event', 'feedback_session'));
            }
        }
    }

    /*
     * Lista tipos de avaliação por sessão
     */
    public function list_types_rates($session_id)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $session = $this->sessionRepository->findByField('id', $session_id)->first();

        if($session)
        {
            $event = $this->eventRepository->findByField('id', $session->event_id)->first();

            if($event)
            {
                $types = $this->typeRepository->findByField('session_id', $session_id);

                return view('sessions.list_types_rates',
                    compact('session', 'roles', 'leader', 'admin',
                        'notify', 'qtde', 'event', 'types'));
            }
        }
    }

    public function create_type($session_id)
    {
        return view('sessions.new_type_rate', compact('session_id'));
    }

    public function edit_type($id)
    {
        $type = $this->typeRepository->findByField('id', $id)->first();

        return view('sessions.edit_type_rate', compact('type'));
    }


    public function store_type(Request $request)
    {
        $data = $request->all();

        $this->typeRepository->create($data);

        $request->session()->flash('success.msg', 'Avaliação criada com sucesso');

        return redirect()->route('event.session.list_types_rates', ['id' => $data['session_id']]);
    }

    public function update_type(Request $request, $id)
    {
        $data = $request->all();

        $data['session_id'] = $this->typeRepository->findByField('id', $id)->first()->session_id;

        $this->typeRepository->update($data, $id);

        $request->session()->flash('success.msg', 'Avaliação editada com sucesso');

        return redirect()->route('event.session.list_types_rates', ['id' => $data['session_id']]);
    }
}
