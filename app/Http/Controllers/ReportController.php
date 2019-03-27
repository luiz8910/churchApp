<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\PersonRepository;
use App\Repositories\ReportRepository;
use App\Repositories\VisitorRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp;

class ReportController extends Controller
{
    use ConfigTrait, CountRepository, NotifyRepository, DateRepository;
    /**
     * @var ReportRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;

    public function __construct(ReportRepository $repository, EventRepository $eventRepository,
                                EventServices $eventServices, EventSubscribedListRepository $listRepository,
                                PersonRepository $personRepository, VisitorRepository $visitorRepository)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->eventServices = $eventServices;
        $this->listRepository = $listRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
    }

    public function index($event = null)
    {
        /*
         * Lista variáveis comuns
         */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        //Fim Variáveis comuns

        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $members = $this->personRepository->findByField('church_id', $this->getUserChurch());

        $visitors = $this->visitorRepository->all();

        if ($event) {

            return view('reports.index-id', compact('countPerson', 'countGroups', 'leader',
                'admin', 'notify', 'qtde', 'events', 'members', 'visitors'));
        }


        return view('reports.index', compact('countPerson', 'countGroups', 'leader',
            'admin', 'notify', 'qtde', 'events', 'members', 'visitors'));
    }

    /*
     * Frequencia do último evento
     */
    public function getReport()
    {
        try {

            $lastEvent = $this->eventServices->getLastEvent();

            if(count($lastEvent) > 0)
            {
                $event = $this->eventRepository->find($lastEvent[0]->id);

                $eventDays = $this->eventServices->eventDays($event->id);

                $eventPeople = count($this->eventServices->eventPeople($event->id));

                $eventFrequency = [];

                $i = 0;

                while ($i < count($eventDays)) {
                    $eventFrequency[] = $this->eventServices->eventFrequencyByDate($event->id, $eventDays[$i]->eventDate);
                    $eventDays[$i] = $this->formatReport($eventDays[$i]->eventDate);

                    $i++;
                }

                DB::commit();

                return json_encode([
                    'status' => true,
                    'days' => $eventDays,
                    'qtdePeople' => $eventPeople,
                    'frequency' => $eventFrequency,
                    'name' => $event->name,
                    'noEvent' => false
                ]);
            }


            DB::commit();

            return json_encode([
                'status' => true,
                'noEvent' => true
            ]);


        } catch (\Exception $e) {
            DB::rollback();

            return json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /*
     * Faixa etária do último evento
     */
    public function ageRange($event = null)
    {
        $kids = 0;
        $teens = 0;
        $adults = 0;

        if (!$event) {

            $event = $this->eventServices->getLastEvent();

            if(count($event) > 0)
            {
                $event = $this->eventRepository->find($event[0]->id);


                $list = $this->listRepository->findByField('event_id', $event->id);


                foreach ($list as $l) {

                    if ($l->person_id) {
                        $person = $this->personRepository->find($l->person_id);

                        if ($person->tag == 'kid') {
                            $kids += 1;
                        } elseif ($person->tag == 'teen') {
                            $teens += 1;
                        } else {
                            $adults += 1;
                        }
                    } elseif ($l->visitor_id) {
                        $visitor = $this->visitorRepository->find($l->visitor_id);

                        if ($visitor->tag == 'kid') {
                            $kids += 1;
                        } elseif ($visitor->tag == 'teen') {
                            $teens += 1;
                        } else {
                            $adults += 1;
                        }
                    }
                }

                $data = new \stdClass();

                $data->kids = $kids;
                $data->teens = $teens;
                $data->adults = $adults;
                $data->name = $event->name;
                $data->qtdePeople = count($list);


                return json_encode([
                    'status' => true,
                    'data' => $data,
                    'noEvent' => false
                ]);
            }
            else{
                return json_encode([
                    'status' => true,
                    'noEvent' => true
                ]);
            }


        }
    }

    /*
     * Relacão membro por visitante do último evento
     */
    public function member_visitor($event = null)
    {
        $member = 0;
        $visitor = 0;

        if (!$event) {

            $event = $this->eventServices->getLastEvent();

            if(count($event) > 0)
            {
                $event = $this->eventRepository->find($event[0]->id);


                $list = $this->listRepository->findByField('event_id', $event->id);

                foreach ($list as $l) {

                    if ($l->person_id) {
                        $member += 1;
                    } else {
                        $visitor += 1;
                    }
                }

                $data = new \stdClass();

                $data->members = $member;
                $data->visitors = $visitor;
                $data->name = $event->name;
                $data->qtdePeople = count($list);


                return json_encode([
                    'status' => true,
                    'data' => $data,
                    'noEvent' => false
                ]);
            }
            else{
                return json_encode([
                    'status' => true,
                    'noEvent' => true
                ]);
            }

        }
    }


    /*
     * Frequência do membro para cada evento em que o mesmo
     * está inscrito
     */
    public function memberFrequency($person_id)
    {
        $eventFrequencyPercentage = [];

        $eventNames = [];

        $eventQtde = [];

        $eventTimes = [];
        
        $events = $this->eventServices->getListSubPerson($person_id);

        $person = $this->personRepository->find($person_id);

        foreach ($events as $event) {

            $qtde = $this->eventServices->memberFrequencyQtde($person_id, $event->event_id);

            $times = $this->eventServices->getEventTimes($event->event_id);

            $eventQtde[] = $qtde;

            $eventTimes[] = $times;

            $eventNames[] = $this->eventRepository->find($event->event_id)->name . "(" . $times . ")";

            if($times > 0)
            {
                $number = ($qtde / $times) * 100;
                $number = number_format($number, 2, ",", ".");
            }
            else{
                $number = 0;
            }

            $eventFrequencyPercentage[] = $number;
        }

        //Quantidade de todas as datas de todos os eventos em que o usuário está inscrito
        $totalEvents = 0;

        //Quantidade de todas as datas de todos os eventos em que o usuário compareceu
        $totalQtde = 0;

        $i = 0;

        while($i < count($eventTimes))
        {
            $totalEvents += $eventTimes[$i];

            $totalQtde += $eventQtde[$i];

            $i++;
        }

        //$average = média de presença de todos os eventos
        $average = $totalEvents > 0 ? ($totalQtde / $totalEvents) * 100 : 0;

        $average = number_format($average, 2, ',', '.');

        $data = new \stdClass();

        $data->names = $eventNames;
        $data->qtdePresence = $eventQtde;
        $data->frequencyPercentage = $eventFrequencyPercentage;
        $data->average = $average;
        $data->personName = $person->name . " " . $person->lastName;
        $data->qtdeEvents = count($events);
        $data->type = 'person';

        return json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    /*
     * Frequência do visitante para cada evento em que o mesmo
     * está inscrito
     */
    public function visitorFrequency($visitor_id)
    {
        $eventFrequencyPercentage = [];

        $eventNames = [];

        $eventQtde = [];

        $eventTimes = [];

        $events = $this->eventServices->getListSubVisitor($visitor_id);

        $visitor = $this->visitorRepository->find($visitor_id);

        foreach ($events as $event) {

            $eventNames[] = $this->eventRepository->find($event->event_id)->name;

            $qtde = $this->eventServices->visitorFrequencyQtde($visitor_id, $event->event_id);

            $times = $this->eventServices->getEventTimes($event->event_id);

            $eventQtde[] = $qtde;

            $eventTimes[] = $times;

            if($times > 0)
            {
                $number = ($qtde / $times) * 100;
                $number = number_format($number, 2, ",", ".");
            }
            else{
                $number = 0;
            }

            $eventFrequencyPercentage[] = $number;
        }

        //Quantidade de todas as datas de todos os eventos em que o usuário está inscrito
        $totalEvents = 0;

        //Quantidade de todas as datas de todos os eventos em que o usuário compareceu
        $totalQtde = 0;

        $i = 0;

        while($i < count($eventTimes))
        {
            $totalEvents += $eventTimes[$i];

            $totalQtde += $eventQtde[$i];

            $i++;
        }

        $average = $totalEvents > 0 ? ($totalQtde / $totalEvents) * 100 : 0;

        $average = number_format($average, 2, ',', '.');

        $data = new \stdClass();

        $data->names = $eventNames;
        $data->qtdePresence = $eventQtde;
        $data->qtdeTimes = $eventTimes;
        $data->frequencyPercentage = $eventFrequencyPercentage;
        $data->average = $average;
        $data->personName = $visitor->name . " " . $visitor->lastName;
        $data->qtdeEvents = count($events);
        $data->type = 'visitor';

        return json_encode([
            'status' => true,
            'data' => $data
        ]);
    }


    public function exportExcel($event = null)
    {

        if(!$event)
        {
            $event = $this->eventServices->getLastEvent();

            //Frequência

            $data = json_decode($this->getReport());

            $i = 0;

            //dd(count($data->days));

            $d = array();


            while($i < count($data->days)) {

                array_push($d, array($data->days[$i], $data->frequency[$i]));

                $i++;
            }

            $ageRange = json_decode($this->ageRange());

            $age = array(
                array($ageRange->data->kids, $ageRange->data->teens, $ageRange->data->adults)
            );

            $memVis = json_decode($this->member_visitor());

            $m = array(
                array($memVis->data->members, $memVis->data->visitors)
            );


            /*$d = array(
                array($days[0], $frequency[0]),
                array('data 1', 'data 2')
            );*/

            //dd($d);

            Excel::create('ultimo-evento', function($excel) use ($d, $data, $age, $m){

                $excel->sheet($data->name, function($sheet) use ($d, $data) {

                    $sheet->row(1, array($data->name))
                        ->row(2, array(
                        'Data', 'Frequencia'
                    ))->rows($d)->freezeFirstRow();

                });

                $excel->sheet('Faixa Etária', function($sheet) use ($age){

                    $sheet->row(1, array('Faixa Etária'))
                        ->row(2, array(
                            'Crianças', 'Adolescentes', 'Adultos'
                        ))->rows($age)->freezeFirstRow();
                });

                $excel->sheet('Membros e Visitantes', function($sheet) use ($m){

                    $sheet->row(1, array('Membros x Visitantes'))
                        ->row(2, array(
                            'Membros', 'Visitantes'
                        ))->rows($m)->freezeFirstRow();
                });
            })->download('xlsx');

        }



    }
}
