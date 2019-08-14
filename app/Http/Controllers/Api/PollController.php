<?php 

namespace App\Http\Controllers\Api;

use App\Repositories\PersonRepository;
use App\Repositories\PollItensRepository;
use App\Repositories\PollAnswerRepository;
use App\Http\Controllers\Controller;
use App\Repositories\PollRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
class PollController extends Controller
{
	private $answerRepository;
	private $itensRepository;
    private $personRepository;
    /**
     * @var PollRepository
     */
    private $repository;

    function __construct(PollRepository $repository, PollItensRepository $itensRepository,
                         PollAnswerRepository $answerRepository, PersonRepository $personRepository)
	{
		$this->answerRepository = $answerRepository;
		$this->itensRepository = $itensRepository;
        $this->repository = $repository;
        $this->personRepository = $personRepository;
    }

	
    /*
     * Escolhe uma opção do quiz
     * $id = id da opção escolhida
     */
    public function choose(Request $request, $id)
    {
        $data = $request->all();

        $item = $this->itensRepository->findByField('id', $id)->first();

        $data['polls_id'] = $item->polls_id;

        $data['item_id'] = $id;

        $exists = $this->answerRepository->findWhere([
            'polls_id' => $item->polls_id,
            'person_id' => $data['person_id']
        ])->first();

        try{

            if($exists)
            {
                $this->answerRepository->update($data, $exists->id);

                \DB::commit();

                return json_encode(['status' => true]);
            }

            $this->answerRepository->create($data);

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => 'Um erro ocorreu']);
        }

    }

    /*
     * Lista de Itens por quiz
     */
    public function list_itens($poll_id)
    {
        $poll = $this->repository->findByField('id', $poll_id)->first();

        if($poll)
        {
            $itens = $this->itensRepository->findByField('polls_id', $poll_id);

            return json_encode(['status' => true, 'itens' => $itens]);
        }

        //Crud Bug

        return json_encode(['status' => false, 'msg' => 'Este quiz não existe']);
    }

    /*
     * Lista quiz por sessão
     */
    public function index($session_id, $person_id = null)
    {
        $polls = $this->repository->findByField('session_id', $session_id);

        if($person_id) {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person) {
                foreach ($polls as $p) {
                    $vote_exists = DB::table('poll_answers')
                        ->where([
                            'person_id' => $person_id,
                            'polls_id' => $p->id,
                        ])->first();

                    if($vote_exists) {
                        $p->voted = $vote_exists->item_id;
                    } else{
                        $p->voted = 0;
                    }
                }
            }
        }

        if(count($polls) > 0)
        {
            return json_encode(['status' => true, 'quizz' => $polls]);
        }

        return json_encode(['status' => false, 'msg' => 'Não há quiz para esta sessão']);
    }
}
