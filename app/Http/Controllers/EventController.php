<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\EventRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Repositories\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;


class EventController extends Controller
{
    use CountRepository, DateRepository, FormatGoogleMaps, NotifyRepository;
    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(EventRepository $repository, StateRepository $stateRepository,
                                UserRepository $userRepository, GroupRepository $groupRepository,
                                PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->personRepository = $personRepository;
    }

    public function index()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $events = $this->repository->all();

        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);
            //$event->created_at = $this->formatDateView($event->created_at);
        }

        $user = $this->userRepository->find(\Auth::getUser()->id);

        $event_user[] = $user->person->events->all();

        $notify[] = $this->notify();

        //dd($event_user[0][1]["id"]);

        //dd(isset($event_user[0][1]));

        //dd(count($event_user[0]));

        return view('events.index', compact('countPerson', 'countGroups', 'state', 'roles', 'events', 'event_user', 'notify'));
    }

    public function create($id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $notify[] = $this->notify();

        if($id)
        {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'id', 'notify'));
        }
        else{
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'notify'));
        }


    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['createdBy_id'] = \Auth::getUser()->id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        $endEventDate = $request->get('endEventDate');

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        else{
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }

        $event = $this->repository->create($data);

        event(new AgendaEvent($event));

        /*$user = [];

        if (isset($data['group_id']))
        {
            $group = $this->groupRepository->find($data['group_id']);

            $user[] = $group->people->all();
        }

        $user[] = $this->personRepository->findWhere(['role_id' => '1']);

        foreach ($user as $item) {
            \Notification::send($item, new EventNotification($data['name'], 'events/'.$event->id.'/edit'));
        }*/

        return redirect()->route('index');
    }


    public function edit($id)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $event = $this->repository->find($id);

        $location = $this->formatGoogleMaps($event);

        $event->eventDate = $this->formatDateView($event->eventDate);
        $event->endEventDate = $this->formatDateView($event->endEventDate);

        $notify[] = $this->notify();

        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles', 'event', 'location', 'notify'));
    }

    public function joinEvent($id)
    {
        $event = $this->repository->find($id);

        $subscribed = false;

        $user = \Auth::getUser();

        foreach ($event->people as $item)
        {

            if($item->id == $user->person_id)
            {
                $event->people()->detach($user->person_id);
                $subscribed = true;
            }
        }

        if ($subscribed)
        {
            echo json_encode(['status' => false]);
        }
        else{
            $event->people()->attach($user->person_id);
            echo json_encode(['status' => true]);
        }
    }


}
