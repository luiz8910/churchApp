<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Repositories\EventRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use App\Services\PaymentServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ConfigTrait, NotifyRepository, CountRepository;

    /**
     * @var PaymentRepository
     */
    private $repository;
    private $pay;
    private $client;
    /**
     * @var PaymentServices
     */
    private $paymentServices;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;


    public function __construct(PaymentRepository $repository, PaymentServices $paymentServices,
                                EventRepository $eventRepository, PersonRepository $personRepository)
    {

        $this->repository = $repository;

        $this->paymentServices = $paymentServices;

        $this->eventRepository = $eventRepository;

        $this->personRepository = $personRepository;
    }


    public function index($event_id = null)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        if($event_id)
        {
            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event)
            {
                $payments = $this->repository->findWhere([
                    'church_id' => $this->getUserChurch(),
                    'event_id' => $event_id
                    ]);



                if(count($payments) == 0)
                {
                    $payments = false;
                }
                else{

                    foreach ($payments as $payment)
                    {
                        $person = $this->personRepository->findByField('id', $payment->person_id)->first();

                        if($person)
                        {
                            $payment->person_name = $person->name;
                            $payment->email = $person->email;
                        }

                        $payment->event_name = $event->name;

                        $payment->value_money = $event->value_money;

                        if($payment->status == 4)
                        {
                            $payment->status_name = 'Aprovado';
                        }
                        elseif($payment->status == 1){
                            $payment->status_name = 'Recusado';
                        }
                        else{
                            $payment->status_name = 'Outros';
                        }
                    }

                }


                return view('payments.index', compact('payments', 'event', 'countPerson', 'countGroups',
                    'leader', 'admin', 'qtde'));
            }
        }
        else{

            $payments = $this->repository->findByField('church_id', $this->getUserChurch());

            if(count($payments) == 0)
            {
                $payments = false;
            }
            else{

                foreach ($payments as $payment)
                {
                    $person = $this->personRepository->findByField('id', $payment->person_id)->first();

                    if($person)
                    {
                        $payment->person_name = $person->name;
                        $payment->email = $person->email;
                    }

                    $event = $this->eventRepository->findByField('id', $payment->event_id)->first();

                    if($event)
                    {
                        $payment->event_name = $event->name;

                        $payment->value_money = $event->value_money;

                        if($payment->status == 4)
                        {
                            $payment->status_name = 'Aprovado';
                        }
                        elseif($payment->status == 1){
                            $payment->status_name = 'Recusado';
                        }
                        else{
                            $payment->status_name = 'Outros';
                        }
                    }

                }
            }
            
            return view('payments.index', compact('payments', 'event', 'countPerson', 'countGroups',
                'leader', 'admin', 'qtde'));
        }


    }


    public function new_url()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        return view('payments.new-url', compact('events', 'countPerson', 'countGroups',
            'leader', 'admin', 'qtde'));
    }

    public function store_new_url()
    {
        
    }
}
