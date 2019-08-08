<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FeedbackSessionRepository;
use App\Repositories\FeedbackSessionTypeRepository;
use App\Repositories\PersonRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;


class FeedbackSessionController extends Controller
{
    private $repository;
    private $sessionRepository;
    private $personRepository;
    private $typeRepository;

    public function __construct(FeedbackSessionRepository $repository, FeedbackSessionTypeRepository $typeRepository,
                                SessionRepository $sessionRepository, PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->sessionRepository = $sessionRepository;
        $this->personRepository = $personRepository;
        $this->typeRepository = $typeRepository;
    }

    public function index()
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();

        try{

            $this->repository->create($data);

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

    }


    public function listTypes($session_id)
    {
        $type = $this->typeRepository->findByField('session_id', $session_id);

        return count($type) > 0 ? json_encode(['status' => true, 'count' => count($type), 'type' => $type])
            : json_encode(['status' => true, 'count' => 0]);
    }

    public function rating_person($person_id, $session_id)
    {
        $exists = $this->repository->findWhere([
            'session_id' => $session_id,
            'person_id' => $person_id
        ]);

        if(count($exists) > 0)
        {
            return json_encode(['status' => true, 'rating' => 1]);
        }

        return json_encode(['status' => true, 'rating' => 0]);
    }
}
