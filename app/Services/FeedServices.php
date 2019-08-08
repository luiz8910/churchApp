<?php
/**
 * Created by PhpStorm.
 * User: luizfernandosanches
 * Date: 03/01/18
 * Time: 01:15
 */

namespace App\Services;


use App\Repositories\EventRepository;
use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Repositories\SessionRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FeedServices
{
    use ConfigTrait;
    /**
     * @var FeedRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;

    public function __construct(FeedRepository $repository, PersonRepository $personRepository,
                                EventRepository $eventRepository, SessionRepository $sessionRepository)
    {
        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->eventRepository = $eventRepository;
        $this->sessionRepository = $sessionRepository;
    }

    public function newFeed($notif_range, $text, $link = null, $expires_in = null, $model = null,
                            $model_id = null, $feed_type = null, $people = null,
                            $event = null, $group = null)
    {
        try {
            $dt = Carbon::now();
            $dt = $dt->addWeek();

            $feed_type = $feed_type ? $feed_type : 1;
            $expires_in = $expires_in ? $expires_in : $dt;

            $data['church_id'] = $this->getUserChurch();
            $data['notification_range'] = $notif_range;
            $data['model'] = $model;
            $data['model_id'] = $model_id;
            $data['text'] = $text;
            $data['show'] = 1;
            $data['feed_type'] = $feed_type;
            $data['expires_in'] = $expires_in;
            $data['link'] = $link;

            $id = $this->repository->create($data)->id;

            switch ($notif_range) {
                case 1:
                    $this->publicFeed($id);
                    break;

                case 2:
                    $this->eventFeed($event, $id);
                    break;

                case 3:
                    $this->groupFeed($group, $id);
                    break;

                case 4:
                    $this->people($people, $id);
                    break;

                case 5:
                    $this->leaderFeed($id);
                    break;

                case 6:
                    $this->exhibitorFeed($id, $event);
                    break;
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }

    }

    public function publicFeed($id)
    {
        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        if (count($people) > 0) {
            foreach ($people as $item) {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $item->id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

    }

    public function groupFeed($group, $id)
    {

    }


    public function people($people, $id)
    {

    }

    public function leaderFeed($id)
    {
        $church_id = $this->getUserChurch();

        $role_leader = $this->getLeaderRoleId();

        $leaders = $this->personRepository->findWhere([
            'church_id' => $church_id,
            'role_id' => $role_leader
        ]);

        if (count($leaders) > 0) {
            foreach ($leaders as $leader) {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $leader->id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }


        $this->adminFeed($id);
    }

    public function adminFeed($id)
    {
        $church_id = $this->getUserChurch();

        $role_admin = $this->getAdminRoleId();

        $admins = $this->personRepository->findWhere([
            'church_id' => $church_id,
            'role_id' => $role_admin
        ]);

        if (count($admins) > 0) {
            foreach ($admins as $admin) {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $admin->id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

    }

    public function feeds()
    {
        $church_id = $this->getUserChurch();

        $feeds = DB::table('feeds')->where([
            'church_id' => $church_id,
            'show' => 1,
            ['expires_in', '>', Carbon::now()]
        ])->get();



        //dd($feeds->get());

        foreach ($feeds as $feed) {
            $dt = date_create($feed->created_at);

            $feed->data = date_format($dt, "d/m/Y");

            if ($feed->model == 'person') {
                $person = $this->personRepository->find($feed->model_id);

                $feed->model = 'Pessoas';
                $feed->link = 'person/' . $feed->model_id . '/edit';
                $feed->text .= " - " . $person->name . " " . $person->lastName;
            }
        }

        //dd($feeds);

        return $feeds;
    }

    public function myFeeds()
    {
        $church_id = $this->getUserChurch();

        if(\Auth::user()->person)
        {
            $feeds = DB::table('feeds')
                ->join('feeds_user', 'feeds.id', 'feeds_user.feed_id')
                ->where([
                    'feeds.church_id' => $church_id,
                    'feeds_user.person_id' => \Auth::user()->person->id,
                    ['expires_in', '>', Carbon::now()]
                ])->orderBy('feeds.created_at', 'desc')->get();
        }
        else{
            $feeds = DB::table('feeds')
                ->join('feeds_user', 'feeds.id', 'feeds_user.feed_id')
                ->where([
                    'feeds.church_id' => $church_id,
                    'feeds_user.visitor_id' => \Auth::user()->visitors->first()->id,
                    ['expires_in', '>', Carbon::now()]
                ])->orderBy('feeds.created_at', 'desc')->get();
        }


        /*$feeds = $this->repository->findWhere(
            [
                'church_id' => $church_id,
                ['expires_in', '>', Carbon::now()]
            ]
        );*/

        foreach ($feeds as $feed) {
            $dt = date_create($feed->created_at);
            $feed->data = $dt->format("d/m/Y");

            if ($feed->model == 'person') {
                $person = $this->personRepository->find($feed->model_id);

                $feed->model = 'Pessoas';
                $feed->link = 'person/' . $feed->model_id . '/edit';
                $feed->text .= " - " . $person->name . " " . $person->lastName;
            }
        }

        return $feeds;
    }


    /*
     * $id = id do feed
     */
    public function exhibitorFeed($id, $event)
    {
        $event = $this->eventRepository->findByField('id', $event)->first();

        $church_id = $event->church_id;

        $exs = DB::table('exhibitors')
            ->where([
                'church_id' => $church_id
            ])->get();


        foreach ($exs as $item)
        {
            $ep = DB::table('exhibitor_person')->where(['exhibitor_id' => $item->id])->first();

            if(count($ep) == 1)
            {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $ep->person_id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }

        }


    }

    public function eventFeed($event_id)
    {
        $event = $this->repository->findWhere([
            'model' => 'session',
            'model_id' => $event_id,
        ]);

        if(count($event) > 0)
        {
            return $event;
        }

        return false;
    }

    public function sessionFeed($session_id)
    {
        $feed = $this->repository->findWhere([
            'model' => 'session',
            'model_id' => $session_id,
        ]);

        if(count($feed) > 0)
        {
            return $feed;
        }

        return false;
    }
}
