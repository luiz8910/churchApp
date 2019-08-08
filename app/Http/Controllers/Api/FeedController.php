<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Services\FeedServices;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    
    private $repository;
    private $eventRepository;
    private $personRepository;
    private $feedServices;

    public function __construct(FeedRepository $repository, EventRepository $eventRepository,
                                PersonRepository $personRepository, FeedServices $feedServices)
    {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
        $this->feedServices = $feedServices;
    }

    public function eventFeeds($event_id)
    {
        $feed = $this->feedServices->eventFeed($event_id);

        if($feed)
        {
            return json_encode(['status' => true, 'feeds' => $feed]);
        }

        return json_encode(['status' => false, 'count' => 0]);
    }

    public function sessionFeeds($session_id)
    {
        $feed = $this->feedServices->sessionFeed($session_id);

        if($feed)
        {
            return json_encode(['status' => true, 'feeds' => $feed]);
        }

        return json_encode(['status' => false, 'count' => 0]);
    }

    public function add_sessionFeed(Request $request)
    {
        $data = $request->all();

        /*$data['model'] = 'session';
        $data['model_id'] = $session_id;
        $data['text'] = $text;*/

        try{
            $data['model'] = 'session';
            $data['model_id'] = $data['session_id'];

            unset($data['session_id']);

            $this->repository->create($data);

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    public function add_eventFeed(Request $request)
    {
        $data = $request->all();

        try{
            $data['model'] = 'event';
            $data['model_id'] = $data['event_id'];

            unset($data['event_id']);

            $this->repository->create($data);

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }
}
