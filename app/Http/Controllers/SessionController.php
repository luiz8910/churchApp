<?php

namespace App\Http\Controllers;

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

        }

    }
}
