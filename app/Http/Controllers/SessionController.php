<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StateRepository;
use App\Services\SessionService;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    /**
     * @var SessionService
     */
    private $service;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, SessionService $service, QuestionRepository $questionRepository,
                                PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->service = $service;
        $this->questionRepository = $questionRepository;
        $this->personRepository = $personRepository;
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


        if($event)
        {

            $days = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                ])
                ->select('eventDate')
                ->distinct()
                ->get();

            $eventDate = null;

            /*
             * Se houver uma data apenas para o evento,
             * então o campo Data em criação de sessão
             * vai se autocompletar com a data do evento
             */
            if(count($days) == 1)
            {
                $eventDate = date_format(date_create($days[0]->eventDate), 'd/m/Y');
            }


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
                    compact('sessions', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'eventDate'));


            }else {

                $sessions = false;

                return view('events.sessions-list',
                    compact('sessions', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'eventDate'));
            }

        }

        else{

            $bug = new Bug();

            $bug->description = 'Evento ' . $event_id . ' não encontrado';
            $bug->platform = 'Back-end';
            $bug->location = 'list() SessionController.php';
            $bug->model = 'Session';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            throw new ModelNotFoundException();

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

            if ($data['session_date'] != "") {
                $data['session_date'] = DateTime::createFromFormat('d/m/Y', trim($data['session_date']))->format('Y-m-d');

                $data['start_time'] = date_create($data['session_date'] . " " . $data['start_time']);

                if ($data['end_time'] != "") {
                    $data['end_time'] = date_create($data['session_date'] . " " . $data['end_time']);
                }
            } else {
                $data['start_time'] = date_create($event->eventDate . " " . $data['start_time']);

                if ($data['end_time'] != "") {
                    $data['end_time'] = date_create($event->eventDate . " " . $data['end_time']);
                }
            }

            $data['code'] = $this->service->setCode();

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

            if ($this->repository->findByField('id', $session_id)->first())
            {

                $data['event_id'] = $event_id;

                if ($data['max_capacity'] == 0 || $data['max_capacity'] == "") {
                    $data['max_capacity'] = -1;
                }


                if($data['session_date'] != "")
                {
                    $data['start_time'] = date_create($data['session_date'] . " " . $data['start_time']);

                    if ($data['end_time'] != "") {
                        $data['end_time'] = date_create($data['session_date'] . " " . $data['end_time']);
                    }

                    $data['session_date'] = date_create($data['session_date']);

                }else {

                    $data['start_time'] = date_create($event->eventDate . " " . $data['start_time']);

                    if ($data['end_time'] != "") {
                        $data['end_time'] = date_create($event->eventDate . " " . $data['end_time']);
                    }
                }

                try {
                    $this->repository->update($data, $session_id);

                    \DB::commit();

                    $request->session()->flash('success.msg', 'A sessão foi incluída com sucesso');

                    return redirect()->back();

                } catch (\Exception $e) {

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


    /*
     * $id da sessão
     */
    public function delete($id)
    {

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

    /*
     * Usado para verificar quantos dias o evento ocorre
     */
    public function event_days($event_id)
    {
        $event = $this->eventRepository->findByField('id', $event_id)->first();

        if($event)
        {
            $days = DB::table('event_person')
                ->where([
                    'event_id' => $event_id,
                ])
                ->select('eventDate')
                ->distinct()
                ->get();


            /*
             * Se houver mais datas no evento
             */
            if(count($days) > 1)
            {
                return json_encode(['status' => true, 'days' => $days]);
            }

            //Apenas um evento
            return json_encode(['status' => false, 'msg' => 1]);
        }

        return json_encode(['status' => false, 'msg' => 'Evento não existe']);
    }


    public function modal_code($id)
    {
        $session = $this->repository->findByField('id', $id)->first();
        return view('events.session_modal_code', compact('session'));
    }

    /*
     * Id da sessão
     */
    public function list_questions($id)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $session = $this->repository->findByField('id', $id)->first();

        if($session)
        {
            $event = $this->eventRepository->findByField('id', $session->event_id)->first();

            if($event)
            {
                $questions = $this->repository->findByField('session_id', $id);

                if(count($questions) > 0)
                {
                    foreach ($questions as $q)
                    {
                        $person = $this->personRepository->findByField('id', $q->person_id)->first();

                        if($person)
                        {
                            $q->person_name = $person->name;
                        }
                        else{
                            $bug = new Bug();

                            $bug->description = 'Person com id: ' . $q->person_id . ' não existe';
                            $bug->platform = 'Back-end';
                            $bug->location = 'list question SessionController.php';
                            $bug->model = 'Question';
                            $bug->status = 'Pendente';
                            $bug->church_id = $this->getUserChurch();

                            $bug->save();

                            $q->person_name = 'Desconhecido';
                        }
                    }

                    dd($questions);

                    return view('sessions.session-list-questions', compact('questions', 'event', 'session'));
                }
            }

            return view('sessions.session_list_questions',
                compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'questions'));
        }


    }

    public function view_question($id)
    {
        // TODO
    }

    public function list_quizz($id)
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

        $quizzes = json_decode(json_encode([
            [
                'id' => 1,
                'order' => 1,
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                'alternatives' => [
                    [
                        'id' => 1,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 2,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 3,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                ]
            ],
            [
                'id' => 2,
                'order' => 2,
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                'alternatives' => [
                    [
                        'id' => 4,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 5,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 6,
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                ]
            ],
        ])); // TODO

        return view('events.session_list_quizz',
            compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'quizzes'));
    }

    public function view_quizz_question($id)
    {
        // TODO
        $question = json_decode(json_encode([
            'id' => 1,
            'order' => 1,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
            'alternatives' => [
                [
                    'id' => 1,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 10
                ],
                [
                    'id' => 2,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 50
                ],
                [
                    'id' => 3,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 40
                ],
            ]
        ]));

        return view('events.session_modal_quizz_question', compact('question'));
    }

    public function quizz_store()
    {
        // TODO
    }

    public function new_quizz()
    {
        return view('events.session_new_quizz');
    }

    public function delete_quizz($id)
    {
        // TODO
    }

    public function approve_question($id)
    {
        // TODO
    }

    public function unapprove_question($id)
    {
        // TODO
    }

    public function list_types_rates($id)
    {
        // TODO
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

        $types_rates = json_decode(json_encode([
            [
                'id' => 1,
                'title' => 'Lorem Ipsum'
            ],
        ]));

        return view('events.session_list_types_rates',
            compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'types_rates'));
    }

    public function new_type_rate($session_id)
    {
        return view('events.session_new_type_rate', compact('session_id'));
    }

    public function edit_type_rate($id)
    {
        // TODO
        $type_rate = json_decode(json_encode(
            [
                'id' => 1,
                'title' => 'Lorem Ipsum'
            ]
        ));

        return view('events.session_edit_type_rate', compact('type_rate'));
    }

    public function delete_typer_rate($id)
    {
        // TODO
    }

    public function list_rates($id)
    {
        // TODO
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

        $rates = json_decode(json_encode([
            [
                'user' => ['name' => 'Joãozinho', 'id' => 1],
                'average' => 4,
                'user_rates' => [
                    [
                        'id' => 1,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 3,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 2,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 5,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ]
                ]
            ],
            [
                'user' => ['name' => 'Mariazinha', 'id' => 2],
                'average' => 3,
                'user_rates' => [
                    [
                        'id' => 3,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 1,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 4,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 5,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ]
                ]
            ],
        ]));

        return view('events.session_list_rates',
            compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde', 'event', 'rates'));
    }

    public function view_rate($user_id, $session_id)
    {
        $session = $this->repository->findByField('id', $session_id)->first();

        // TODO
        $question = json_decode(json_encode([
            'id' => 1,
            'order' => 1,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
            'alternatives' => [
                [
                    'id' => 1,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 10
                ],
                [
                    'id' => 2,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 50
                ],
                [
                    'id' => 3,
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!',
                    'choice_rate' => 40
                ],
            ]
        ]));

        $rate = json_decode(json_encode(
            [
                'user' => ['name' => 'Joãozinho', 'id' => 1],
                'average' => 4,
                'user_rates' => [
                    [
                        'id' => 1,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 3,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ],
                    [
                        'id' => 2,
                        'type_rate' => ['id' => 1, 'title' => 'Lorem Ipsum'],
                        'star_count' => 5,
                        'comment' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, architecto dolores eaque, eos est impedit itaque maxime minima nostrum nulla quam totam voluptas voluptatem? Aliquid atque blanditiis quaerat velit veritatis!'
                    ]
                ]
            ]
        ));

        return view('events.session_modal_view_rate', compact('rate', 'question', 'session'));
    }
}
