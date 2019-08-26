<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Question;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Repositories\StateRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use CountRepository, NotifyRepository, ConfigTrait;
    /**
     * @var QuestionRepository
     */
    private $repository;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(QuestionRepository $repository, SessionRepository $sessionRepository,
                                EventRepository $eventRepository, PersonRepository $personRepository,
                                RoleRepository $roleRepository)
    {

        $this->repository = $repository;
        $this->sessionRepository = $sessionRepository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
        $this->roleRepository = $roleRepository;
    }

    public function testEvent()
    {
        //$question = Question::find(3);

        try{
            event(new \App\Events\Question('teste'));

        }catch (\Exception $e)
        {
            dd($e);
        }


        return 'evento foi disparado';
    }

    public function index($session_id)
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
                $pending = $this->repository->findWhere([
                                                'status' => 'pending',
                                                'session_id' => $session_id
                                    ]);

                if(count($pending) > 0)
                {
                    foreach ($pending as $item)
                    {
                        $person = $this->personRepository->findByField('id', $item->person_id)->first();

                        if($person)
                        {
                            $item->person_name = $person->name;
                        }
                    }
                }

                $approved = $this->repository->findWhere([
                    'status' => 'approved',
                    'session_id' => $session_id]);

                if(count($approved) > 0)
                {
                    foreach ($approved as $item)
                    {
                        $person = $this->personRepository->findByField('id', $item->person_id)->first();

                        if($person)
                        {
                            $item->person_name = $person->name;
                        }
                    }
                }

                $denied = $this->repository->findWhere([
                    'status' => 'denied',
                    'session_id' => $session_id]);

                if(count($denied) > 0)
                {
                    foreach ($denied as $item)
                    {
                        $person = $this->personRepository->findByField('id', $item->person_id)->first();

                        if($person)
                        {
                            $item->person_name = $person->name;
                        }
                    }
                }

                return view('sessions.session_list_questions', compact('countGroups', 'countGroups', 'roles', 'leader',
                    'admin', 'qtde', 'session', 'pending', 'approved', 'denied', 'event'
                ));
            }

            $bug = new Bug();

            $bug->description = 'O Evento com id: ' . $session->event_id . ' não existe';
            $bug->platform = 'Back-end';
            $bug->location = 'index() QuestionController.php';
            $bug->model = 'Question';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            \Session::flash('error.msg', 'Este evento não existe');

            return redirect()->back();



        }else{

            $bug = new Bug();

            $bug->description = 'A sessão com id: ' .$session_id . ' não existe';
            $bug->platform = 'Back-end';
            $bug->location = 'index() QuestionController.php';
            $bug->model = 'Question';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            \Session::flash('error.msg', 'Esta sessão não existe');

            return redirect()->back();

        }

    }

    /*
     * Usado para aprovar uma questão.
     * $id = question id
     */
    public function approve($id)
    {
        $question = $this->repository->findByField('id', $id)->first();

        if ($question)
        {

            try{

                $q['status'] = 'approved';

                $this->repository->update($q, $id);

                \DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){

                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'Back-end';
                $bug->location = 'approve QuestionController()';
                $bug->model = 'Question';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }

        return json_encode(['status' => false, 'msg' => 'Esta questão não existe']);
    }

    /*
     * Usado para reprovar uma questão.
     * $id = question id
     */
    public function deny($id)
    {

        $question = $this->repository->findByField('id', $id)->first();

        if ($question)
        {
            try{

                $q['status'] = 'denied';

                $this->repository->update($q, $id);

                \DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e){

                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'Back-end';
                $bug->location = 'deny QuestionController()';
                $bug->model = 'Question';
                $bug->status = 'Pendente';
                $bug->church_id = 0;

                $bug->save();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Esta questão não existe']);
    }
}
