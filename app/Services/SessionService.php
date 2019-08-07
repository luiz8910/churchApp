<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\SessionRepository;

class SessionService
{

    /**
     * @var SessionRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(SessionRepository $repository, EventRepository $eventRepository, PersonRepository $personRepository)
    {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
    }

    /*
     * Gerar código único da sessão
     */
    public function setCode()
    {
        $numbers = '1234567890';

        $code = array();

        $n_length = strlen($numbers) - 1;

        for ($i = 0; $i < 6; $i++)
        {
            $n = rand(0, $n_length);
            $code[] = $numbers[$n];
        }

        $code = implode($code);

        $exists = $this->repository->findByField('code', $code)->first();

        if($exists)
        {
            $this->setCode();
        }

        return $code;
    }
}
