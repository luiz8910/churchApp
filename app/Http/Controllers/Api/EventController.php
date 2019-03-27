<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\FrequencyRepository;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Services\AgendaServices;
use App\Services\ApiServices;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use Event;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{


    use ConfigTrait, FormatGoogleMaps, DateRepository, NotifyRepository;

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
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;

    public function __construct(EventRepository $repository, EventServices $eventServices,
                                PersonRepository $personRepository, UserRepository $userRepository,
                                VisitorRepository $visitorRepository, GroupRepository $groupRepository,
                                FrequencyRepository $frequencyRepository, AgendaServices $agendaServices,
                                ApiServices $apiServices, EventSubscribedListRepository $listRepository,
                                ChurchRepository $churchRepository)
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
        $this->listRepository = $listRepository;
        $this->churchRepository = $churchRepository;
    }



    public function getEventsApi($qtde, $church)
    {
        $today = date_create();

        $day = date_format($today, 'Y-m-d');

        $events = DB::table('event_person')
            ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                'events.description', 'events.imgEvent',
                'events.endTime', 'events.street', 'events.number', 'events.city', 'events.frequency', 'event_person.deleted_at')
            ->join('events', 'event_person.event_id', '=', 'events.id')
            ->where([
                'events.church_id' => $church,
                ['event_person.eventDate', '>=', $day]
            ])
            //->whereDate('event_date', '>', $today)
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

        $aux = date('Y-m-d 00:00:00');

        $today = $aux;

        $endWeek = date_add(date_create($aux), date_interval_create_from_date_string('7 days'));


        $events = DB::table('event_person')

            ->select('events.name', 'events.id', 'events.createdBy_id', 'event_person.event_date', 'events.group_id',
                'events.description', 'events.imgEvent', 'events.endTime', 'events.street', 'events.number',
                'events.city', 'events.frequency', 'event_person.deleted_at')

            ->join('events', 'events.id', 'event_person.event_id')

            ->whereBetween('event_person.event_date', [$today, $endWeek])

            ->where(
                [
                    'events.church_id' => $church,
                    'event_person.deleted_at' => null
                ])

            ->distinct()
            ->orderBy('event_person.event_date', 'asc')
            ->get();



        if(count($events) > 0)
        {
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

        return json_encode(['status' => false]);

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

        return $this->eventServices->isCheckApp($id, $person_id);

    }


    /*
     * $id = id do evento
     * $person_id = id do membro
     * Check-in Manual API
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

        return $this->eventServices->checkApp($id, $person_id);
    }


    /*
     * Check-in em lote (app)
     */
    public function checkInPeopleAPP(Request $request)
    {

        $people = $request->get('people');

        $event = $request->get('id');


        if($people == 0)
        {
            try{
                $this->eventServices->checkInAll($event);

                $qtde = count($this->eventServices->getListSubEvent($event));

                DB::commit();

                return json_encode([
                    'status' => true,
                    'qtde' => $qtde
                ]);

            }catch(\Exception $e)
            {
                DB::rollback();

                return json_encode([
                    'status' => false,
                    'msg' => $e->getMessage()
                ]);
            }

        }

        else{

            foreach ($people as $item)
            {
                $isSub = $this->eventServices->isSubPeople($event, $item);

                if(!$isSub)
                {
                    $this->eventServices->checkInBatch($event, $item);
                }

            }



            return json_encode(['status' => true]);
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

    /*
     * Check-out de usuário $person_id no evento $id selecionado (app)
     */
    public function checkout($id, $person_id)
    {

        return $this->eventServices->checkOut($id, $person_id);

    }

    /*
     * Lista de checkins num evento $id
     */
    public function getCheckinList($id)
    {
        //$data = $this->eventServices->getListSubEvent($id);

        try{

            $church = $this->repository->find($id)->church_id;

            $data = $this->eventServices->allMembers($church);

            if($data)
            {
                return json_encode(['status' => true, 'data' => $data]);
            }

            return json_encode(['status' => false, 'msg' => 'Não há nenhum usuário cadastrado no momento']);


        }catch(\Exception $e)
        {
            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }


    public function store(Request $request, $person_id)
    {
        //try{

        $data = $request->all();

        $church = $data['church_id'];

        $data['createdBy_id'] = $this->personRepository->find($person_id)->user->id;

        //$data['eventDate'] = $this->formatDateBD($data['eventDate']);

        if(!$data['eventDate'])
        {

            return json_encode(['status' => false, 'msg' => 'Insira a data do primeiro encontro']);

        }

        $verifyFields = $this->verifyRequiredFields($data, 'event', $church);

        if($verifyFields)
        {

            return json_encode(['status' => false, 'msg' => "Preencha o campo " . $verifyFields]);
        }

        $endEventDate = $request->get('endEventDate');

        if ($endEventDate == "")
        {
            $data['endEventDate'] = $data['eventDate'];
        }
        /*else{
            $data['endEventDate'] = $this->formatDateBD($data['endEventDate']);
        }*/

        if($data["group_id"] == "")
        {
            $data["group_id"] = null;
        }

        if($data["frequency"] == $this->biweekly())
        {
            $firstDay = substr($data['eventDate'], 8, 2);

            if($data['day'][0] != $firstDay)
            {
                return json_encode(['status' => false, 'msg' => 'Data do Próximo evento está inválida']);
            }
            else{
                $day = $data['day'][0];
                $data['day_2'] = $data['day'][1];

                unset($data['day']);

                $data['day'] = $day;
            }
        }

        $data["city"] = ucwords($data["city"]);

        $event = $this->repository->create($data);

        if($data["group_id"] == null)
        {
            unset($data['group_id']);
        }

        $this->eventServices->sendNotification($data, $event, $church);

        if($data["frequency"] != $this->unique())
        {
            $this->eventServices->newEventDays($event->id, $data, $person_id);
        }
        else{
            $show = $event->eventDate == date("Y-m-d") ? 1 : 0;

            $event_date = date_create($data['eventDate'] . $data['startTime']);

            if($data['endTime'] == "")
            {
                if($data['endEventDate'] == $data['eventDate'])
                {
                    $endTime = date_create();

                    date_add($endTime, date_interval_create_from_date_string("1 day"));

                    $endTime = date_format($endTime, "Y-m-d");

                    $endTime = date_create($endTime);

                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event->id,
                            'person_id' => $person_id,
                            'eventDate' => $event->eventDate,
                            'event_date' => $event_date,
                            'end_event_date' => $endTime,
                            'show' => $show
                        ]);
                }
                else{
                    DB::table('event_person')
                        ->insert([
                            'event_id' => $event->id,
                            'person_id' => $person_id,
                            'eventDate' => $event->eventDate,
                            'event_date' => $event_date,
                            'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                            'show' => $show
                        ]);
                }

            }
            else{
                DB::table('event_person')
                    ->insert([
                        'event_id' => $event->id,
                        'person_id' => $person_id,
                        'eventDate' => $event->eventDate,
                        'event_date' => $event_date,
                        'end_event_date' => date_create($data['endEventDate'] . $data['endTime']),
                        'show' => $show
                    ]);
            }



            $this->eventServices->subAllMembers($event->id, $event->eventDate, $person_id);
        }

        /*Event::where(['id' => $event->id])
            ->update(
                ['church_id' => $this->getUserChurch()]
            );*/

        $this->eventServices->newRecentEvents($event->id, $church);

        //DB::commit();


        return json_encode(['status' => true]);

        /*}catch(\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.db', 'Não foi possível criar o evento, tente novamente mais tarde');

            return redirect()->back();
        }*/

    }

    /*
     * Lista de Inscrito no evento $id e check-ins
     */
    public function getListSubEvent($id)
    {
        //$result = $this->eventServices->getListSubEventAPP($id);

        $event = $this->repository->findByField('id', $id)->first();

        if($event)
        {
            //$result = $this->personRepository->findWhere(['status' => 'active']);

            $result = $this->listRepository->findByField('event_id', $id);

            if($result)
            {
                foreach ($result as $item)
                {
                    $person = $this->personRepository->find($item->person_id);

                    $item->name = $person->name . ' ' . $person->lastName;

                    $sub = json_decode($this->eventServices->isSubscribed($id, $item->person_id)) or null;

                    $check = 'check-in';

                    $item->check = false;

                    if($sub && $sub->status && $sub->$check)
                    {
                        $item->check = true;
                    }

                    //echo $item->person_id;

                }


                return json_encode(['status' => true, 'people' => $result]);
            }

            return json_encode(['status' => true, 'people' => 0]);
        }

        return $this->returnFalse('Erro ao buscar evento');

    }

    /*
     * Remove a inscrição do usuário $person_id no evento $id
     */
    public function unsubUser($id, $person_id)
    {
        $result = $this->eventServices->UnsubUser($person_id, $id);

        if($result)
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    /*
     * Inscreve o usuário $person_id no evento $id
     */
    public function sub($id, $person_id)
    {
        $result = $this->eventServices->subEvent($id, $person_id);

        if($result)
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }


    public function searchEvents($input)
    {
        $events = DB::table('events')
            ->where(
                [
                    ['name', 'like', '%'.$input.'%'],
                    ['deleted_at', '=', null]
                ]
            )
            ->limit(5)
            ->orderBy('name', 'desc')
            ->get();

        foreach ($events as $event)
        {
            $event->eventDate = date_format(date_create($event->eventDate), "d/m/Y");

            $event->endEventDate = date_format(date_create($event->endEventDate), "d/m/Y");
        }

        return $events;
    }


    public function oldEvents($church_id = null)
    {
        $today = date_create();

        if($church_id)
        {
            $events = DB::table('events')
                ->where([
                    'church_id' => $church_id,
                    ['endEventDate', '<', $today]
                ])->get();
        }
        else{

            $events = DB::table('events')
                ->where([
                    ['endEventDate', '<', $today]
                ])->get();
        }


        return $events;
    }

    public function personSubs($person_id, $church_id = null)
    {
        if($this->personRepository->findByField('id', $person_id))
        {
            $list = $this->listRepository->findByField('person_id', $person_id);

            //$collection = collect([]);

            $arr = [];

            if(count($list) > 0)
            {
                if(is_numeric($church_id) && $this->churchRepository->findByField('id', $church_id)->first())
                {
                    foreach ($list as $item)
                    {
                        /*$collection = collect([
                            ['account_id' => 1, 'product' => 'Desk'],
                            ['account_id' => 2, 'product' => 'Chair'],
                        ]);*/

                        /*$collection[] = [
                            'event_id' => $item->event_id,
                            'church_id' => $this->repository->findByField('id', $item->event_id)->first()->church_id
                        ];*/

                        $event = $this->repository->findByField('id', $item->event_id)->first();

                        if($event->church_id == $church_id)
                        {
                            $arr[] = $event;
                        }

                    }
                }
                else{

                    foreach ($list as $item)
                    {
                        //$collection[] = ['event_id' => $item->event_id];

                        $arr[] = $this->repository->findByField('id', $item->event_id)->first();
                    }
                }

                return json_encode(['status' => true, 'events' => $arr]);
            }

            return json_encode(['status' => false, 'events' => 0]);
        }


        return json_encode(['status' => false, 'events' => 0, 'msg' => 'Usuário não encontrado']);
    }


    public function changeNotifyActivity(Request $request)
    {
        $data = $request->only(['person_id', 'event_id', 'value']);

        if(!isset($data['person_id']) || $data['person_id'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo person_id é nulo ou não existe']);
        }

        if(!isset($data['event_id']) || $data['event_id'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo event_id é nulo ou não existe']);
        }

        if(!isset($data['value']) || $data['value'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo value é nulo ou não existe']);
        }

        if($data['value'] != 0 && $data['value'] != 1)
        {
            return json_encode(['status' => false, 'msg' => 'Campo value pode ser 0 ou 1']);
        }
        else{

            $person = $this->personRepository->findByField('id', $data['person_id'])->first();

            if($person)
            {
                $event = $this->repository->findByField('id', $data['event_id'])->first();

                if($event)
                {
                    $data['notification_activity'] = $data['value'];

                    unset($data['value']);

                    $id = $this->listRepository->findWhere(
                        [
                            'person_id' => $data['person_id'],
                            'event_id' => $data['event_id']
                        ])->first()->id;

                    try{

                        DB::beginTransaction();

                        if($this->listRepository->update($data, $id))
                        {
                            DB::commit();

                            return json_encode(['status' => true]);
                        }

                    }catch (\Exception $e)
                    {
                        DB::rollBack();

                        return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                    }


                }

                return json_encode(['status' => false, 'msg' => 'Este evento não existe ou foi excluído']);
            }


            return json_encode(['status' => false, 'msg' => 'Este usuário não existe ou foi excluído']);

        }
    }

    public function changeNotifyUpdates(Request $request)
    {
        $data = $request->only(['person_id', 'event_id', 'value']);

        if(!isset($data['person_id']) || $data['person_id'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo person_id é nulo ou não existe']);
        }

        if(!isset($data['event_id']) || $data['event_id'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo event_id é nulo ou não existe']);
        }

        if(!isset($data['value']) || $data['value'] == '')
        {
            return json_encode(['status' => false, 'msg' => 'Campo value é nulo ou não existe']);
        }

        if($data['value'] != 0 && $data['value'] != 1)
        {
            return json_encode(['status' => false, 'msg' => 'Campo value pode ser 0 ou 1']);
        }
        else{

            $person = $this->personRepository->findByField('id', $data['person_id'])->first();

            if($person)
            {
                $event = $this->repository->findByField('id', $data['event_id'])->first();

                if($event)
                {
                    $data['notification_updates'] = $data['value'];

                    unset($data['value']);

                    $id = $this->listRepository->findWhere(
                        [
                            'person_id' => $data['person_id'],
                            'event_id' => $data['event_id']
                        ])->first()->id;

                    try{

                        DB::beginTransaction();

                        if($this->listRepository->update($data, $id))
                        {
                            DB::commit();

                            return json_encode(['status' => true]);
                        }

                    }catch (\Exception $e)
                    {
                        DB::rollBack();

                        return json_encode(['status' => false, 'msg' => $e->getMessage()]);
                    }


                }

                return json_encode(['status' => false, 'msg' => 'Este evento não existe ou foi excluído']);
            }


            return json_encode(['status' => false, 'msg' => 'Este usuário não existe ou foi excluído']);

        }
    }

    public function getNotifyActivity($person_id, $event_id)
    {
        $value = $this->listRepository->findWhere(
            [
                'person_id' => $person_id,
                'event_id' => $event_id
            ])->first()->notification_activity;

        return json_encode(['status' => true, 'value' => $value]);

    }

    public function getNotifyUpdates($person_id, $event_id)
    {
        $value = $this->listRepository->findWhere(
            [
                'person_id' => $person_id,
                'event_id' => $event_id
            ])->first()->notification_updates;

        return json_encode(['status' => true, 'value' => $value]);

    }

    public function isSub($person_id, $event_id)
    {
        $list = $this->listRepository->findWhere(
            [
                'person_id' => $person_id,
                'event_id' => $event_id

            ])->first();

        if ($list)
        {
            return $this->eventServices->checkApp($event_id, $person_id);
        }


        return json_encode(['status' => false, 'msg' => 'Este usuário não está inscrito']);

    }

}
