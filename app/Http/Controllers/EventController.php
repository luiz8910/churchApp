<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Models\Event;
use App\Models\User;
use App\Services\EventServices;
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
use Illuminate\Support\Facades\DB;


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

        $events = $this->repository->paginate(5);


        foreach ($events as $event) {
            $event->eventDate = $this->formatDateView($event->eventDate);

            if($event->group_id)
            {
                $event['group_name'] = $this->groupRepository->find($event->group_id)->name;
            }

            //$event->created_at = $this->formatDateView($event->created_at);
        }

        $user = $this->userRepository->find(\Auth::getUser()->id);

        $event_user[] = $user->person->events->all();

        $notify = $this->notify();

        $qtde = count($notify);

        //dd($event_user[0][1]["id"]);

        //dd(isset($event_user[0][1]));

        //dd(count($event_user[0]));

        return view('events.index', compact('countPerson', 'countGroups', 'state', 'roles', 'events', 'event_user', 'notify', 'qtde'));
    }

    public function create($id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        $notify = $this->notify();

        $qtde = count($notify);

        if($id)
        {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'id', 'notify', 'qtde'));
        }
        else{
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'notify', 'qtde'));
        }


    }

    public function testEventNotification()
    {
        $event = Event::find(1);

        event(new AgendaEvent($event));

        $user[] = User::find(1);

        $user[] = User::find(11);

        \Notification::send($user, new Notifications($event->name, 'events/'.$event->id.'/edit'));
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

        $this->sendNotification($data, $event);

        return redirect()->route('events.index');
    }

    public function sendNotification($data, $event)
    {
        $user = [];

        event(new AgendaEvent($event));

        if (isset($data['group_id']))
        {
            $group = $this->groupRepository->find($data['group_id']);

            $people = $group->people->all();

            $i = 0;

            while ($i < count($people))
            {
                $user[] = $people[$i]->user;
                $i++;
            }
        }

        $i = 0;

        $join = DB::table('people')
            ->crossJoin('users', 'users.person_id', '=', 'people.id')
            ->where('role_id', 1)
            ->select('users.id')
            ->get();

        while ($i < count($join))
        {
            $user[] = User::find($join[$i]->id);
            $i++;
        }

        \Notification::send($user, new Notifications($data['name'], 'events/'.$event->id.'/edit'));
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

        $notify = $this->notify();

        $qtde = count($notify);

        $eventDays = EventServices::eventDays($id);

        foreach ($eventDays as $eventDay) {
            $eventDay->eventDate = $this->formatDateView($eventDay->eventDate);
        }

        $check = "check-in";

        $eventFrequency = EventServices::eventFrequency($id);

        $eventPeople = EventServices::eventPeople($id);

        foreach ($eventPeople as $item)
        {
            $item->name = $this->personRepository->find($item->person_id)->name;
            $item->frequency = EventServices::userFrequency($id, $item->person_id);
        }


        //dd($userFrequency);


        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles', 'event', 'location',
            'notify', 'qtde', 'eventDays', 'eventFrequency', 'check', 'eventPeople'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $data['createdBy_id'] = $this->repository->find($id)->createdBy_id;

        $data['eventDate'] = $this->formatDateBD($data['eventDate']);

        $endEventDate = $request->get('endEventDate');

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        else{
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }

        $this->repository->update($data, $id);

        return redirect()->route('event.index');
    }
    

    public function joinEvent($id)
    {
        $event = $this->repository->find($id);

        $user = \Auth::getUser();

        $date = date_create(date('Y-m-d'));

        $event_person = DB::table('event_person')
            ->where([
                'event_id' => $id,
                'person_id' => $user->person_id,
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 1
            ])->get();

        if(count($event_person) > 0)
        {
            DB::table('event_person')
                ->where([
                    'event_id' => $id,
                    'person_id' => $user->person_id,
                    'eventDate' => date_format($date, "Y-m-d")
                ])->update(['check-in' => 0]);

            echo json_encode(['status' => false]);
        }else{
            $event->people()->attach($user->person_id, [
                'eventDate' => date_format($date, "Y-m-d"),
                'check-in' => 1
            ]);

            echo json_encode(['status' => true]);
        }

        //date_add($date, date_interval_create_from_date_string("2 days"));


    }



    public function destroy($id)
    {
        $event = $this->repository->find($id);

        $name = $event->name;

        $event->people()->detach();

        $this->repository->delete($id);

        \Session::flash('event.deleted', 'O evento '.$name.' foi excluido');

        return redirect()->route('event.index');
    }

    public function destroyMany(Request $request)
    {
        $i = 0;

        $data = $request->all();

        while($i < count($data['input']))
        {
            $this->repository->delete($data['input'][$i]);
            $i++;
        }

        \Session::flash('event.deleted', 'Os eventos selecionados foram excluidos');

        return redirect()->route('event.index');
    }


}
