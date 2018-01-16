<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\FeedRepository;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Services\EventServices;
use App\Services\FeedServices;
use App\Services\GroupServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller
{
    use CountRepository, NotifyRepository, ConfigTrait;
    /**
     * @var FeedRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var FeedServices
     */
    private $feedServices;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var GroupServices
     */
    private $groupServices;

    public function __construct(FeedRepository $repository, PersonRepository $personRepository,
                                FeedServices $feedServices, EventServices $eventServices,
                                EventRepository $eventRepository, GroupRepository $groupRepository,
                                GroupServices $groupServices)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->feedServices = $feedServices;
        $this->eventServices = $eventServices;
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
        $this->groupServices = $groupServices;
    }

    public function index()
    {
        $church_id = $this->getUserChurch();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $role = $this->getUserRole();

        $feeds = $this->feedServices->feeds();

        $events = $this->eventRepository->findByField('church_id', $church_id);

        $groups = $this->groupRepository->findByField('church_id', $church_id);

        $people = $this->personRepository->findByField('church_id', $church_id);

        return view('feeds.index', compact('groups', 'countPerson', 'countMembers',
            'countGroups', 'notify', 'qtde', 'leader', 'role', 'church_id', 'feeds',
            'events', 'groups', 'people'));
    }

    public function newFeed($feed_notif, $text, $link = null, $expires_in = null)
    {
        //echo $link;

        $result = $this->feedServices->newFeed($feed_notif, $text, $link, $expires_in);

        return json_encode($result);
    }

    public function eventFeed($event, $text, $link = null, $expires_in = null, $feed_type = null)
    {
        try {
            $dt = Carbon::now();
            $dt = $dt->addWeek();

            $feed_type = $feed_type ? $feed_type : 1;
            $expires_in = $expires_in ? $expires_in : $dt;

            $data['church_id'] = $this->getUserChurch();

            //notif = 2 (Evento)
            $data['notification_range'] = 2;

            $data['model'] = "events";
            $data['model_id'] = null;
            $data['text'] = $text;
            $data['show'] = 1;
            $data['feed_type'] = $feed_type;
            $data['expires_in'] = $expires_in;
            $data['link'] = $link;

            $id = $this->repository->create($data)->id;

            $people = $this->eventServices->getListSubEvent($event);

            foreach ($people as $item) {
                if ($item->person_id) {
                    DB::table('feeds_user')
                        ->insert([
                            'person_id' => $item->person_id,
                            'feed_id' => $id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('feeds_user')
                        ->insert([
                            'visitor_id' => $item->visitor_id,
                            'feed_id' => $id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                }


            }

            DB::commit();

            return json_encode(['status' => true]);
        } catch (\Exception $e) {
            DB::rollback();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    public function groupFeed($group, $text, $link = null, $expires_in = null, $feed_type = null)
    {
        try {
            $dt = Carbon::now();
            $dt = $dt->addWeek();

            $feed_type = $feed_type ? $feed_type : 1;
            $expires_in = $expires_in ? $expires_in : $dt;

            $data['church_id'] = $this->getUserChurch();

            //notif = 2 (Evento)
            $data['notification_range'] = 2;

            $data['model'] = "events";
            $data['model_id'] = null;
            $data['text'] = $text;
            $data['show'] = 1;
            $data['feed_type'] = $feed_type;
            $data['expires_in'] = $expires_in;
            $data['link'] = $link;

            $id = $this->repository->create($data)->id;

            $list = $this->groupServices->getListSubGroup($group);

            foreach($list as $item)
            {
                if ($item->person_id) {
                    DB::table('feeds_user')
                        ->insert([
                            'person_id' => $item->person_id,
                            'feed_id' => $id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                } else {
                    DB::table('feeds_user')
                        ->insert([
                            'visitor_id' => $item->visitor_id,
                            'feed_id' => $id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                }
            }

            DB::commit();

            return json_encode(['status' => true]);
        } catch (\Exception $e) {
            DB::rollback();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function personFeed($person, $text, $link = null, $expires_in = null, $feed_type = null)
    {
        try{

            $dt = Carbon::now();
            $dt = $dt->addWeek();

            $feed_type = $feed_type ? $feed_type : 1;
            $expires_in = $expires_in ? $expires_in : $dt;

            $data['church_id'] = $this->getUserChurch();

            //notif = 2 (Evento)
            $data['notification_range'] = 2;

            $data['model'] = "events";
            $data['model_id'] = null;
            $data['text'] = $text;
            $data['show'] = 1;
            $data['feed_type'] = $feed_type;
            $data['expires_in'] = $expires_in;
            $data['link'] = $link;

            $id = $this->repository->create($data)->id;

            DB::table('feeds_user')
                ->insert([
                    'person_id' => $person,
                    'feed_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();

            return json_encode(['status' => true]);
        }catch(\Exception $e){
            DB::rollback();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }


    }
}