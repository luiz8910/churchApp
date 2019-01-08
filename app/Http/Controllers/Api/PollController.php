<?php 

namespace App\Http\Controllers\Api;

use App\Repositories\ItensRepository;
use App\Repositories\AnswerRepository;

/**
 * 
 */
class PollController extends Controller
{
	private $answerRepository;
	private $itensRepository;

	function __construct(ItensRepository $itensRepository, AnswerRepository $answerRepository)
	{
		$this->answerRepository = $answerRepository;
		$this->itensRepository = $itensRepository;
	}

	
    /*
     * Escolhe uma opção da enquete
     * $id = id da opção escolhida
     */
    public function choose($id, $person_id)
    {

        $item = $this->itensRepository->findByField('id')->first();

        $data['polls_id'] = $item->polls_id;

        $data['person_id'] = $person_id;

        $data['item_id'] = $id;

        if($this->answerRepository->create($data))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }
}