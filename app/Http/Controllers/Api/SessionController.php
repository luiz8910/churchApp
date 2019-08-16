<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\SessionCheckRepository;
use App\Repositories\SessionRepository;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{

    use ConfigTrait;

    private $repository;
    private $eventRepository;
    private $check_in;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository,
                                SessionCheckRepository $check_in, PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->check_in = $check_in;
        $this->personRepository = $personRepository;
    }

    /*
     * Lista todos as sessões do evento escolhido
     */
    public function list($event_id, $person_id = null)
    {
        $sessions = $this->repository->findByField('event_id', $event_id);

        if(count($sessions) > 0)
        {
            foreach ($sessions as $s)
            {
                $qtde = $this->check_in->findByField('session_id', $s->id);

                $s->check_in = count($qtde);

                if($person_id)
                {
                    $person = $this->personRepository->findByField('id', $person_id)->first();

                    if($person)
                    {
                        $exists = DB::table('session_checks')
                            ->where([
                                'session_id' => $data['session_id'],
                                'person_id' => $data['person_id']
                            ])->first();

                        if($exists)
                        {
                            $s->person_check = 1;
                        }
                        else{
                            $s->person_check = 0;
                        }

                    }
                }

            }

            return json_encode(['status' => true, 'sessions' => $sessions]);
        }

        return json_encode(['status' => false, 'msg' => 'Não há sessões para o evento selecionado']);

    }

    /*
     * Usado para verificar se o código existe e
     * qual sessão correspondente.
     */
    public function getCode($code)
    {
        $session = $this->repository->findByField('code', $code)->first();

        if($session)
        {
            return json_encode(['status' => true, 'session' => $session]);
        }

        return json_encode(['status' => false, 'msg' => 'O código está incorreto ou não existe']);
    }

    public function add_check_in(Request $request)
    {
        $data = $request->all();

        $data['check-in'] = 1;

        try{

            $exists = DB::table('session_checks')
                ->where([
                    'session_id' => $data['session_id'],
                    'person_id' => $data['person_id']
                ])->first();

            if($exists)
            {
                $this->check_in->update($data, $exists->id);

            }else{

                $this->check_in->create($data);

            }

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }


    }

    public function remove_check_in(Request $request)
    {
        $data = $request->all();

        $data['check-in'] = 0;

        try{

            $exists = DB::table('session_checks')
                ->where([
                    'session_id' => $data['session_id'],
                    'person_id' => $data['person_id']
                ])->first();

            if($exists)
            {
                $this->check_in->update($data, $exists->id);

            }else{

                $this->check_in->create($data);

            }

            \DB::commit();

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }


    }


    /*
     * Detalhes de uma sessão
     */
    public function show($id, $person_id)
    {
        $session = $this->repository->findByField('id', $id)->first();

        if($session)
        {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person)
            {
                $exists = DB::table('session_checks')
                    ->where([
                        'session_id' => $data['session_id'],
                        'person_id' => $data['person_id']
                    ])->first();

                if($exists)
                {
                    return json_encode(['status' => true, 'session' => $session, 'person_check' => 1]);
                }

                return json_encode(['status' => true, 'session' => $session, 'person_check' => 0]);
            }

            return $this->returnFalse('Esta pessoa não existe');
        }

        return $this->returnFalse('Esta sessão não existe');
    }



}
