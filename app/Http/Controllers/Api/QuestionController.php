<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
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

    public function __construct(QuestionRepository $repository, SessionRepository $sessionRepository,
                                EventRepository $eventRepository, PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->sessionRepository = $sessionRepository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
    }

    /*
     * Lista de Perguntas para a sessão escolhida (limitada ás primeiras 10 questões)
     */
    public function index($session_id, $page = null)
    {
        $session = $this->sessionRepository->findByField('id', $session_id)->first();

        if($session)
        {

            if($page && $page > 1)
            {
                $offset = $page - 1;

                $offset = ($offset * 10) + 1;

                $questions = DB::table('questions')
                    ->where([
                        'session_id' => $session_id,
                        'status' => 'approved',
                        'deleted_at' => null

                    ])->orderBy('like_count', 'desc')->offset($offset)->limit(10)->get();
            }
            else{

                $questions = DB::table('questions')
                    ->where([
                        'session_id' => $session_id,
                        'status' => 'approved',
                        'deleted_at' => null

                    ])->orderBy('like_count', 'desc')->get();
            }


            if(count($questions) == 0)
            {
                return json_encode(['status' => true, 'count' => 0]);
            }
            else{

                return json_encode(['status' => true, 'count' => count($questions), 'questions' => $questions]);
            }
        }

        return json_encode(['status' => false, 'msg' => 'Esta Sessão não existe']);

    }

    /*
     * Adicionar Perguntas
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $session = $this->sessionRepository->findByField('id', $data['session_id'])->first();

        if($session)
        {
            if(!isset($data['content']) || !$data['content'])
            {
                return json_encode(['status' => false, 'msg' => 'Campo Pergunta não pode estar branco']);
            }
            else{

                if(!isset($data['person_id']) || !$data['person_id'])
                {
                    return json_encode(['status' => false, 'Campo id da pessoa (person_id) não pode estar em branco']);
                }
                else{

                    $data['like_count'] = 0;
                    $data['status'] = 'pending';

                    try{
                        $this->repository->create($data);

                        \DB::commit();

                        return json_encode(['status' => true]);

                    }catch (\Exception $e)
                    {
                        \DB::rollBack();

                        $event = $this->eventRepository->findByField('id', $session->event_id)->first();

                        $bug = new Bug();

                        $bug->description = $e->getMessage();
                        $bug->platform = 'App';
                        $bug->location = 'store() Api/QuestionController.php';
                        $bug->model = 'Question';
                        $bug->status = 'Pendente';
                        $bug->church_id = $event->church_id;

                        $bug->save();
                    }

                }
            }
        }

        $bug = new Bug();


        $bug->description = 'Sessão com id: ' . $data['session_id'] . ' não existe';
        $bug->platform = 'App';
        $bug->model = 'Question';
        $bug->location = 'store() Api\QuestionController';
        $bug->status = 'Pendente';
        $bug->church_id = 0;

        $bug->save();

        return json_encode(['status' => false, 'msg' => 'Esta Sessão não existe']);
    }


    /*
     * $id = id da questão
     */
    public function add_like($id)
    {
        $question = $this->repository->findByField('id', $id)->first();

        if($question)
        {
            $x['like_count'] = $question->like_count;

            $x['like_count']++;

            try{
                $this->repository->update($x, $id);

                \DB::commit();

                return json_encode(['status' => true]);

            }catch (\Exception $e)
            {
                \DB::rollBack();

                $session = $this->repository->findByField('id', $question->session_id)->first();

                $event = $this->eventRepository->findByField('id', $session->event_id)->first();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'App';
                $bug->location = 'add_like() Api\QuestionController.php';
                $bug->model = 'Question';
                $bug->status = 'Pendente';
                $bug->church_id = $event->church_id;

                $bug->save();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }

        $bug = new Bug();

        $bug->description = 'Question id: ' . $id . ' não existe';
        $bug->platform = 'App';
        $bug->location = 'add_like() Api\QuestionController.php';
        $bug->model = 'Question';
        $bug->status = 'Pendente';
        $bug->church_id = 0;

        $bug->save();

        return json_encode(['status' => false, 'msg' => 'Essa questão não existe']);

    }

    /*
     * $id = id da questão
     */
    public function remove_like($id)
    {
        $question = $this->repository->findByField('id', $id)->first();

        if($question)
        {
            $x['like_count'] = $question->like_count;

            if($x['like_count'] > 0)
            {
                $x['like_count']--;

                try{
                    $this->repository->update($x, $id);

                    \DB::commit();

                    return json_encode(['status' => true]);

                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $session = $this->repository->findByField('id', $question->session_id)->first();

                    $event = $this->eventRepository->findByField('id', $session->event_id)->first();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'App';
                    $bug->location = 'remove_like() Api\QuestionController.php';
                    $bug->model = 'Question';
                    $bug->status = 'Pendente';
                    $bug->church_id = $event->church_id;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                }
            }
        }
        else{
            $bug = new Bug();

            $bug->description = 'Question id: ' . $id . ' não existe';
            $bug->platform = 'App';
            $bug->location = 'remove_like() Api\QuestionController.php';
            $bug->model = 'Question';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Essa questão não existe']);
        }



    }
}
