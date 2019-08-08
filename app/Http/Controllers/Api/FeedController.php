<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Services\FeedServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function eventFeeds($event_id, $page = null)
    {
        if($page && $page > 1)
        {
            $offset = $page - 1;

            $offset = ($offset * 10) + 1;

            $feeds = DB::table('feeds')
                ->where([
                    'model_id' => $event_id,
                    'model' => 'event'

                ])->orderBy('created_at', 'desc')->offset($offset)->limit(10)->get();
        }
        else{

            $feeds = DB::table('feeds')
                ->where([
                    'model_id' => $event_id,
                    'model' => 'event'

                ])->orderBy('created_at', 'desc')->limit(10)->get();
        }


        if(count($feeds) > 0)
        {
            return json_encode(['status' => true, 'feeds' => $feeds]);
        }

        return json_encode(['status' => true, 'count' => 0]);
    }

    public function sessionFeeds($session_id, $page = null)
    {
        if($page && $page > 1)
        {
            $offset = $page - 1;

            $offset = ($offset * 10) + 1;

            $feeds = DB::table('feeds')
                ->where([
                    'model_id' => $session_id,
                    'model' => 'session'

                ])->orderBy('created_at', 'desc')->offset($offset)->limit(10)->get();
        }
        else{

            $feeds = DB::table('feeds')
                ->where([
                    'model_id' => $session_id,
                    'model' => 'session'

                ])->orderBy('created_at', 'desc')->limit(10)->get();
        }


        if(count($feeds) > 0)
        {
            return json_encode(['status' => true, 'feeds' => $feeds]);
        }

        return json_encode(['status' => true, 'count' => 0]);
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
