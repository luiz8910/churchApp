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
     * Lista de Perguntas para a sessão escolhida
     * Se valor de $page for informado então haverá
     * paginação limitada a 10 usuários.
     * Se $person_id for informado, retornará se a pessoa
     * já deu like na questão.
     */
    public function index($session_id, $person_id = null, $page = null)
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

                if($person_id)
                {
                    $person = $this->personRepository->findByField('id', $person_id)->first();

                    if($person)
                    {
                        foreach ($questions as $q)
                        {
                            $like_exists = DB::table('like_person')
                                ->where([
                                    'person_id' => $person_id,
                                    'question_id' => $q->id,
                                ])->first();

                            if($like_exists)
                            {
                                $q->liked = $like_exists->liked;
                            }
                            else{

                                $q->liked = 0;
                            }
                        }
                    }
                }

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
                        $id = $this->repository->create($data)->id;

                        if($id)
                        {
                            $question = \DB::table('questions')->where('id', $id)->first();

                            $person_name = $this->personRepository->findByField('id', $question->person_id)->first()->name;

                            $question->person_name = $person_name;

                            event(new \App\Events\Question($question));

                            \DB::commit();

                            return json_encode(['status' => true]);
                        }

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
    public function add_like($id, $person_id)
    {
        $question = $this->repository->findByField('id', $id)->first();

        if($question)
        {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person)
            {
                $like_exists = DB::table('like_person')
                    ->where([
                        'person_id' => $person_id,
                        'question_id' => $id,
                    ])->first();

                if($like_exists)
                {
                    if($like_exists->liked == 1)
                    {
                        return json_encode(['status' => false, 'Este usuário já curtiu esta questão.']);
                    }
                }

                $x['like_count'] = $question->like_count;

                $x['like_count']++;

                try{
                    if($this->repository->update($x, $id))
                    {

                        if($like_exists)
                        {
                            DB::table('like_person')
                                ->where([
                                    'person_id' => $person_id,
                                    'question_id' => $id,
                                ])->update(['liked' => 1]);
                        }
                        else{
                            DB::table('like_person')
                                ->insert([
                                    'liked' => 1,
                                    'person_id' => $person_id,
                                    'question_id' => $id
                                ]);
                        }

                        $question = \DB::table('questions')->where('id', $id)->first();

                        $person_name = $this->personRepository->findByField('id', $question->person_id)->first()->name;

                        $question->person_name = $person_name;

                        event(new \App\Events\LikedQuestion($question));

                        \DB::commit();

                        return json_encode(['status' => true]);

                    }


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

            $bug->description = 'Person id: ' . $id . ' não existe';
            $bug->platform = 'App';
            $bug->location = 'add_like() Api\QuestionController.php';
            $bug->model = 'Question';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Essa pessoa não existe']);

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
    public function remove_like($id, $person_id)
    {
        $question = $this->repository->findByField('id', $id)->first();

        if($question)
        {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person)
            {
                $like_exists = DB::table('like_person')
                    ->where([
                        'person_id' => $person_id,
                        'question_id' => $id,
                    ])->first();

                if($like_exists)
                {
                    if ($like_exists->liked == 0)
                    {
                        return json_encode([
                            'status' => false,
                            'msg' => 'Não é possível remover uma pergunta que não foi curtida.'
                        ]);
                    }
                }

                $x['like_count'] = $question->like_count;

                if($x['like_count'] > 0)
                {
                    $x['like_count']--;

                    try{
                        if($this->repository->update($x, $id))
                        {
                            if($like_exists)
                            {
                                DB::table('like_person')
                                    ->where([
                                        'person_id' => $person_id,
                                        'question_id' => $id,
                                    ])->update(['liked' => 0]);
                            }
                            else{
                                DB::table('like_person')
                                    ->insert([
                                        'liked' => 0,
                                        'person_id' => $person_id,
                                        'question_id' => $id
                                    ]);
                            }
                        }

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
