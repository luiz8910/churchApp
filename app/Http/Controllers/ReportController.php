<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\ReportRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function __construct(ReportRepository $repository, EventRepository $eventRepository, EventServices $eventServices)
    {
        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->eventServices = $eventServices;
    }

    public function index()
    {
        /*
         * Lista variáveis comuns
         */

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = count($notify);

        //Fim Variáveis comuns

        return view('reports.index', compact('countPerson', 'countGroups', 'leader', 'admin', 'notify', 'qtde'));
    }

    public function getReport()
    {
        try{

            $lastEvent = $this->eventServices->getLastEvent();

            $event = $this->eventRepository->find($lastEvent[0]->id);

            $eventDays = $this->eventServices->eventDays($event->id);

            $eventPeople = count($this->eventServices->eventPeople($event->id));

            $qtde = [];

            $eventFrequency = [];

            $i = 0;

            while($i < count($eventDays))
            {
                $eventFrequency[] = $this->eventServices->eventFrequencyByDate($event->id, $eventDays[$i]->eventDate);
                $eventDays[$i] = $this->formatReport($eventDays[$i]->eventDate);

                $i++;
            }


            /*foreach ($eventPeople as $item) {
                if($item->person_id)
                {
                    $qtde[] = count(DB::table('event_person')
                        ->where([
                            'event_id' => $event->id,
                            'person_id' => $item->person_id,
                            'check-in' => 1
                        ])
                        ->distinct()
                        ->get());
                }
                else{
                    $qtde[] = count(DB::table('event_person')
                        ->where([
                            'event_id' => $event->id,
                            'visitor_id' => $item->visitor_id,
                            'check-in' => 1
                        ])
                        ->distinct()
                        ->get());
                }

            }*/

            DB::commit();

            return json_encode([
                'status' => true,
                'days' => $eventDays,
                'qtdePeople' => $eventPeople,
                'frequency' => $eventFrequency,
                'name' => $event->name
            ]);

        }catch(\Exception $e)
        {
            DB::rollback();

            return json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }

        //dd($eventFrequency);
    }
}
