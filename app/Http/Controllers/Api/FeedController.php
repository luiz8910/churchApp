<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Services\FeedServices;
use Berkayk\OneSignal\OneSignalFacade;
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

    public function eventFeeds($event_id, $person_id = null, $page = null)
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
            if($person_id)
            {
                $person = $this->personRepository->findByField('id', $person_id)->first();

                if($person)
                {
                    foreach ($feeds as $f)
                    {
                        $like_exists = DB::table('like_feed')
                            ->where([
                                'person_id' => $person_id,
                                'feed_id' => $f->id,
                            ])->first();

                        if($like_exists)
                        {
                            $f->liked = $like_exists->liked;
                        }
                        else{

                            $f->liked = 0;
                        }
                    }
                }
            }


            return json_encode(['status' => true, 'feeds' => $feeds]);
        }

        return json_encode(['status' => true, 'count' => 0]);
    }

    public function sessionFeeds($session_id, $person_id = null, $page = null)
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
            if($person_id)
            {
                $person = $this->personRepository->findByField('id', $person_id)->first();

                if($person)
                {
                    foreach ($feeds as $f)
                    {
                        $like_exists = DB::table('like_feed')
                            ->where([
                                'person_id' => $person_id,
                                'feed_id' => $f->id,
                            ])->first();

                        if($like_exists)
                        {
                            $f->liked = $like_exists->liked;
                        }
                        else{

                            $f->liked = 0;
                        }
                    }
                }
            }

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

            OneSignalFacade::sendNotificationUsingTags(
                $data['text'],
                array(["field" => "tag", "key" => "event_id", "relation" => "=", "value" => $data['event_id']])
            );

            unset($data['event_id']);

            $this->repository->create($data);

            return json_encode(['status' => true]);

        }catch (\Exception $e)
        {
            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    /*
     * $id = id do feed
     */
    public function add_like($id, $person_id)
    {
        $feed = $this->repository->findByField('id', $id)->first();

        if($feed)
        {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person)
            {
                $like_exists = DB::table('like_feed')
                    ->where([
                        'person_id' => $person_id,
                        'feed_id' => $id,
                    ])->first();

                if($like_exists)
                {
                    if($like_exists->liked == 1)
                    {
                        return json_encode(['status' => false, 'Este usuário já curtiu este feed.']);
                    }
                }

                $x['like_count'] = $feed->like_count;

                $x['like_count']++;

                try{
                    if($this->repository->update($x, $id))
                    {

                        if($like_exists)
                        {
                            DB::table('like_feed')
                                ->where([
                                    'person_id' => $person_id,
                                    'feed_id' => $id,
                                ])->update(['liked' => 1]);
                        }
                        else{
                            DB::table('like_feed')
                                ->insert([
                                    'liked' => 1,
                                    'person_id' => $person_id,
                                    'feed_id' => $id
                                ]);
                        }

                        /*$feed = \DB::table('questions')->where('id', $id)->first();

                        $person_name = $this->personRepository->findByField('id', $feed->person_id)->first()->name;

                        $feed->person_name = $person_name;

                        event(new \App\Events\LikedQuestion($feed));*/

                        \DB::commit();

                        return json_encode(['status' => true]);

                    }


                }catch (\Exception $e)
                {
                    \DB::rollBack();

                    $session = $this->repository->findByField('id', $feed->session_id)->first();

                    $event = $this->eventRepository->findByField('id', $session->event_id)->first();

                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'App';
                    $bug->location = 'add_like() Api\FeedController.php';
                    $bug->model = 'Feed';
                    $bug->status = 'Pendente';
                    $bug->church_id = $event->church_id;

                    $bug->save();

                    return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                }
            }


            $bug = new Bug();

            $bug->description = 'Person id: ' . $id . ' não existe';
            $bug->platform = 'App';
            $bug->location = 'add_like() Api\FeedController.php';
            $bug->model = 'Feed';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Essa pessoa não existe']);

        }

        $bug = new Bug();

        $bug->description = 'Feed id: ' . $id . ' não existe';
        $bug->platform = 'App';
        $bug->location = 'add_like() Api\FeedController.php';
        $bug->model = 'Feed';
        $bug->status = 'Pendente';
        $bug->church_id = 0;

        $bug->save();

        return json_encode(['status' => false, 'msg' => 'Este feed não existe']);

    }

    /*
     * $id = id da questão
     */
    public function remove_like($id, $person_id)
    {
        $feed = $this->repository->findByField('id', $id)->first();

        if($feed)
        {
            $person = $this->personRepository->findByField('id', $person_id)->first();

            if($person)
            {
                $like_exists = DB::table('like_feed')
                    ->where([
                        'person_id' => $person_id,
                        'feed_id' => $id,
                    ])->first();

                if($like_exists)
                {
                    if ($like_exists->liked == 0)
                    {
                        return json_encode([
                            'status' => false,
                            'msg' => 'Este usuário ainda não curtiu o feed.'
                        ]);
                    }
                }

                $x['like_count'] = $feed->like_count;

                if($x['like_count'] > 0)
                {
                    $x['like_count']--;

                    try{
                        if($this->repository->update($x, $id))
                        {
                            if($like_exists)
                            {
                                DB::table('like_feed')
                                    ->where([
                                        'person_id' => $person_id,
                                        'feed_id' => $id,
                                    ])->update(['liked' => 0]);
                            }
                            else{
                                DB::table('like_feed')
                                    ->insert([
                                        'liked' => 0,
                                        'person_id' => $person_id,
                                        'feed_id' => $id
                                    ]);
                            }
                        }

                        \DB::commit();

                        return json_encode(['status' => true]);

                    }catch (\Exception $e)
                    {
                        \DB::rollBack();

                        $session = $this->repository->findByField('id', $feed->session_id)->first();

                        $event = $this->eventRepository->findByField('id', $session->event_id)->first();

                        $bug = new Bug();

                        $bug->description = $e->getMessage();
                        $bug->platform = 'App';
                        $bug->location = 'remove_like() Api\FeedController.php';
                        $bug->model = 'Feed';
                        $bug->status = 'Pendente';
                        $bug->church_id = $event->church_id;

                        $bug->save();

                        return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                    }
                }
            }


        }
        else{
            $bug = new Bug();

            $bug->description = 'Feed id: ' . $id . ' não existe';
            $bug->platform = 'App';
            $bug->location = 'remove_like() Api\FeedController.php';
            $bug->model = 'Feed';
            $bug->status = 'Pendente';
            $bug->church_id = 0;

            $bug->save();

            return json_encode(['status' => false, 'msg' => 'Este feed não existe']);
        }
    }
}
