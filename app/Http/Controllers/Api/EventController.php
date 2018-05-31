<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Repositories\FrequencyRepository;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Services\AgendaServices;
use App\Services\ApiServices;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\FormatGoogleMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{


    use ConfigTrait, FormatGoogleMaps;

    /**
     * @var EventRepository
     */
    private $repository;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var FrequencyRepository
     */
    private $frequencyRepository;
    /**
     * @var AgendaServices
     */
    private $agendaServices;
    /**
     * @var ApiServices
     */
    private $apiServices;

    public function __construct(EventRepository $repository, EventServices $eventServices,
                                PersonRepository $personRepository, UserRepository $userRepository,
                                VisitorRepository $visitorRepository, GroupRepository $groupRepository,
                                FrequencyRepository $frequencyRepository, AgendaServices $agendaServices,
                                ApiServices $apiServices)
    {

        $this->repository = $repository;
        $this->eventServices = $eventServices;
        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
        $this->visitorRepository = $visitorRepository;
        $this->groupRepository = $groupRepository;
        $this->frequencyRepository = $frequencyRepository;
        $this->agendaServices = $agendaServices;
        $this->apiServices = $apiServices;
    }



    public function getEventsApi($qtde, $church)
    {
        $today = date_create();

        $events = DB::table('event_person')
            ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                'events.description', 'events.imgEvent',
                'events.endTime', 'events.street', 'events.number', 'events.city', 'events.frequency', 'event_person.deleted_at')
            ->join('events', 'event_person.event_id', '=', 'events.id')
            ->where('events.church_id', $church)
            ->whereDate('event_date', '>', $today)
            ->whereNull('events.deleted_at')
            ->orderBy('event_person.event_date')
            ->distinct()
            ->limit($qtde)
            ->get();

        /*$events = $events->keyBy('id');

        $events->forget(103);*/
        //dd($events);
        $events = $events->unique('id');

        $events = $events->values()->all();

        foreach ($events as $event)
        {
            $person = $this->userRepository->find($event->createdBy_id)->person;

            $event->img_user = $person->imgProfile;

            $event->createdBy_id = $person->name . " " . $person->lastName;

            $event->eventDate = date_format(date_create($event->event_date), 'd-m-Y');//$this->formatDateView($event->eventDate);

            $event->sub = count($this->eventServices->getListSubEvent($event->id));

        }

        //dd($events);

        return json_encode($events);
    }

    public function getNextWeekEvents($church)
    {
        $nextMonday = $this->agendaServices->nextWeek();

        $endWeek = date_add($nextMonday, date_interval_create_from_date_string('7 days'));

        $nextMonday = $this->agendaServices->nextWeek();

        $events = DB::table('event_person')

            ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                'events.description', 'events.imgEvent', 'events.endTime', 'events.street', 'events.number',
                'events.city', 'events.frequency', 'event_person.deleted_at')

            ->join('events', 'events.id', 'event_person.event_id')

            ->whereBetween('event_person.event_date', [$nextMonday, $endWeek])

            ->where(
                [
                    'events.church_id' => $church,
                    'event_person.deleted_at' => null
                ])

            ->distinct()
            ->get();
        //}

        foreach ($events as $event)
        {

            $person = $this->userRepository->find($event->createdBy_id)->person;

            $event->img_user = $person->imgProfile;

            $event->createdBy_id = $person->name . " " . $person->lastName;

            $event->eventDate = date_format(date_create($event->event_date), 'd-m-Y');//$this->formatDateView($event->eventDate);

            $event->sub = count($this->eventServices->getListSubEvent($event->id));

        }

        return json_encode($events);
    }

    public function recentEventsApp($church)
    {
        $events = DB::table('recent_events')
            ->select('event_id')
            ->where('church_id', $church)
            ->get();

        if(count($events) > 0)
        {
            foreach($events as $event)
            {
                $model = $this->repository->find($event->event_id);

                $event->name = $model->name;

                $event->imgEvent = $model->imgEvent;
            }

            return json_encode([
                'status' => true,
                'events' => $events
            ]);
        }

        return json_encode(['status' => false]);
    }



    public function eventsToday($id, $visitor = null)
    {
        /*
         * $id
         * $visitor = true se o usuário for visitante, false para o resto
         */


        $today = date_format(date_create(), 'Y-m-d');


        if($visitor)
        {

            $events = DB::table('event_person')
                ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                    'events.description', 'events.imgEvent', 'events.startTime',
                    'events.endTime', 'events.street', 'events.number', 'events.city', 'events.state', 'events.frequency', 'event_person.deleted_at')
                ->join('events', 'event_person.event_id', '=', 'events.id')
                ->join('event_subscribed_lists', 'event_subscribed_lists.event_id', '=', 'events.id')
                ->where('event_subscribed_lists.visitor_id', $id)
                ->whereDate('event_person.eventDate', '=', $today)
                ->whereNull('events.deleted_at')
                ->orderBy('event_person.event_date')
                ->distinct()
                ->get();

        }

        else
        {
            $events = DB::table('event_person')
                ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                    'events.description', 'events.imgEvent', 'events.startTime',
                    'events.endTime', 'events.street', 'events.number', 'events.city', 'events.state', 'events.frequency', 'event_person.deleted_at')
                ->join('events', 'event_person.event_id', '=', 'events.id')
                ->join('event_subscribed_lists', 'event_subscribed_lists.event_id', '=', 'events.id')
                ->where('event_subscribed_lists.person_id', $id)
                ->whereDate('event_person.eventDate', '=', $today)
                ->whereNull('events.deleted_at')
                ->orderBy('event_person.event_date')
                ->distinct()
                ->get();
        }


        $i = 0;

        $coords = [];

        if(count($events) > 0)
        {
            foreach($events as $event)
            {

                if($this->apiServices->getCoords($event))
                {
                    $coords[] = $this->apiServices->getCoords($event);
                }


                $i++;

            }


            return json_encode(['status' => true, 'coords' => $coords]);
        }


        return json_encode(['status' => false]);


    }


    /*
     * $id = id do evento
     * $person_id = id da pessoa
     * $visitor = se for visitante = true,
     * Utilizado para verificar se o membro ou visitante deu check-in no evento selecionado
     */
    public function isCheckedApp($id, $person_id, $visitor = null)
    {

        if($visitor)
        {

            $visitor_id = $person_id . '/visit';

            if($this->eventServices->isSubVisitor($id, $visitor_id))
            {
                return json_encode(['status' => true, 'check-in' => true]);
            }

            return json_encode(['status' => true, 'check-in' => false]);
        }
        else
        {

            if($this->eventServices->isSubscribed($id, $person_id))
            {

                return json_encode(['status' => true, 'check-in' => true]);

            }

            return json_encode(['status' => true, 'check-in' => false]);
        }


    }


    /*
     * $id = id do evento
     * $person_id = id do membro
     */
    public function checkInAPP($id, $person_id, $visitor = null)
    {
        if($visitor)
        {
            $model = $this->visitorRepository->find($person_id);
        }
        else{

            $model = $this->personRepository->find($person_id);
        }

        return $this->eventServices->check($id, $model, $visitor = null);
    }


    /*
     * Check-in em lote (app)
     */
    public function checkInPeopleAPP(Request $request, $event)
    {

        $data = $request->all();

        if(count($data) > 0)
        {
            foreach($data["people_check"] as $item)
            {
                echo $item . '<br>';
            }
        }
        else{
            echo 'igual a 0';
        }
    }


    /*
     * Informação do evento $id
     */

    public function getEventInfo($id)
    {
        try{

            $event = $this->repository->find($id);

            $coords = $this->apiServices->getCoords($event);

            $event->lat = $coords->lat;

            $event->lng = $coords->lng;

            return json_encode(['status' => true, 'event' => $event]);

        }catch(\Exception $e)
        {

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }



    }
}
