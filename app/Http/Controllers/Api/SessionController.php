<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\SessionRepository;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * @var SessionRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
    }

    /*
     * Lista todos as sessões do evento escolhido
     */
    public function list($event_id)
    {
        $sessions = $this->repository->findByField('event_id', $event_id);

        if(count($sessions) > 0)
        {
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
}
