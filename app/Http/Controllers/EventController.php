<?php

namespace App\Http\Controllers;

use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\EventRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;


class EventController extends Controller
{
    use CountRepository, DateRepository, FormatGoogleMaps;
    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct(EventRepository $repository, StateRepository $stateRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
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

        return view('events.index', compact('countPerson', 'countGroups', 'state', 'roles', 'events'));
    }

    public function create($id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        if($id)
        {
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles', 'id'));
        }
        else{
            return view('events.create', compact('countPerson', 'countGroups', 'state', 'roles'));
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

        $this->repository->create($data);

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

        return view('events.edit', compact('countPerson', 'countGroups', 'state', 'roles', 'event', 'location'));
    }


}
