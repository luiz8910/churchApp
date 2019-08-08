<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\SessionCheckRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{

    private $repository;
    private $eventRepository;
    private $check_in;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository, SessionCheckRepository $check_in)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->check_in = $check_in;
    }

    /*
     * Lista todos as sessões do evento escolhido
     */
    public function list($event_id)
    {
        $sessions = $this->repository->findByField('event_id', $event_id);

        if(count($sessions) > 0)
        {
            foreach ($sessions as $s)
            {
                $qtde = $this->check_in->findByField('session_id', $s->id);

                $s->check_in = count($qtde);
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



}
