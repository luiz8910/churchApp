<?php 

namespace App\Http\Controllers\Api;

use App\Repositories\PollItensRepository;
use App\Repositories\PollAnswerRepository;
use App\Http\Controllers\Controller;

/**
 * 
 */
class PollController extends Controller
{
	private $answerRepository;
	private $itensRepository;

	function __construct(PollItensRepository $itensRepository, PollAnswerRepository $answerRepository)
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

        $item = $this->itensRepository->findByField('id', $id)->first();

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
