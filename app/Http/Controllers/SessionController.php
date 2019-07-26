<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StateRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    use ConfigTrait, CountRepository, NotifyRepository;
    /**
     * @var SessionRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository, StateRepository $stateRepository,
                                RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
    }

    /*
     * Lista todos as sessões do evento escolhido
     */
    public function list($event_id)
    {
        $sessions = $this->repository->findByField('event_id', $event_id);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $event = $this->eventRepository->findByField('id', $event_id)->first();

        if (count($sessions) > 0)
        {
            foreach ($sessions as $session)
            {

                $start_time = $session->start_time;

                $session->start_time = date_format(date_create($session->start_time), 'd/m/Y H:i');

                $session->short_start_time = date_format(date_create($start_time), 'H:i');

                $session->end_time = date_format(date_create($session->end_time), 'H:i');

                $session->session_date = date_format(date_create($session->session_date), 'd/m/Y');
            }

            return view('events.sessions-list',
                compact('sessions', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event'));
        } else {

            $sessions = false;

            return view('events.sessions-list',
                compact('sessions', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event'));
        }

    }

    public function store(Request $request, $event_id)
    {
        $data = $request->all();

        $event = $this->eventRepository->findByField('id', $event_id)->first();

        if ($event) {
            $data['event_id'] = $event_id;

            if ($data['max_capacity'] == 0 || $data['max_capacity'] == "") {
                $data['max_capacity'] = -1;
            }

            if($data['session_date'] != "")
            {
                $data['session_date'] = date_format(date_create($data['session_date']), 'd-m-Y');

                $data['start_time'] = date_create($data['session_date'] . " " . $data['start_time']);

                if ($data['end_time'] != "") {
                    $data['end_time'] = date_create($data['session_date'] . " " . $data['end_time']);
                }
            }
            else{
                $data['start_time'] = date_create($event->eventDate . " " . $data['start_time']);

                if ($data['end_time'] != "") {
                    $data['end_time'] = date_create($event->eventDate . " " . $data['end_time']);
                }
            }


            try {

                $this->repository->create($data);

                \DB::commit();

                $request->session()->flash('success.msg', 'A sessão foi incluída com sucesso');

                return redirect()->back();

            } catch (\Exception $e) {
                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'Back-end';
                $bug->location = 'line ' . $e->getLine() . ' store() SessionController.php';
                $bug->model = 'Session';
                $bug->status = 'Pendente';

                $bug->save();

                $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                return redirect()->back();

            }


        }

        $request->session()->flash('error.message', 'O evento selecionado não existe');

        return redirect()->back();

    }

    public function update(Request $request, $event_id)
    {
        $data = $request->except(['session-id']);

        $session_id = $request->get('session-id');

        $event = $this->eventRepository->findByField('id', $event_id)->first();

        if ($event) {

            if ($this->repository->findByField('id', $session_id)->first()) {
                $data['event_id'] = $event_id;

                if ($data['max_capacity'] == 0 || $data['max_capacity'] == "") {
                    $data['max_capacity'] = -1;
                }

                if($data['session_date'] != "")
                {
                    $data['session_date'] = date_format(date_create($data['session_date']), 'Y-m-d');

                    $data['start_time'] = date_create($data['session_date'] . " " . $data['start_time']);

                    if ($data['end_time'] != "") {
                        $data['end_time'] = date_create($data['session_date'] . " " . $data['end_time']);
                    }
                }
                else{
                    $data['start_time'] = date_create($event->eventDate . " " . $data['start_time']);

                    if ($data['end_time'] != "") {
                        $data['end_time'] = date_create($event->eventDate . " " . $data['end_time']);
                    }
                }

                try{
                    $this->repository->update($data, $session_id);

                    \DB::commit();

                    $request->session()->flash('success.msg', 'A sessão foi incluída com sucesso');

                    return redirect()->back();

                }catch (\Exception $e)
                {

                    \DB::rollBack();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'Back-end';
                    $bug->location = 'line ' . $e->getLine() . ' update() SessionController.php';
                    $bug->model = 'Session';
                    $bug->status = 'Pendente';

                    $bug->save();

                    $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

                    return redirect()->back();
                }

            }

            $request->session()->flash('error.message', 'O sessão selecionada não existe');

            return redirect()->back();
        }

        $request->session()->flash('error.message', 'O evento selecionado não existe');

        return redirect()->back();
    }

    public function check_in_list($id)
    {
        $session = $this->repository->findByField('id', $id)->first();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $event = $this->eventRepository->findByField('id', $session->event_id)->first();

        if ($session) {

            $session->start_time = date_format(date_create($session->start_time), 'd/m/Y H:i');

            $session->short_start_time = date_format(date_create($session->start_time), 'H:i');

            $session->end_time = date_format(date_create($session->end_time), 'H:i');

            $session->session_date = date_format(date_create($session->session_date), 'd/m/Y');


            return view('events.check_in_sessions',
                compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event'));
        } else {

            $session = false;

            return view('events.check_in_sessions',
                compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event'));
        }
    }
}
