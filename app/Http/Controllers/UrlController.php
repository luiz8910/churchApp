<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Repositories\EventRepository;
use App\Repositories\PaymentMethodsRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UrlItensRepository;
use App\Repositories\UrlRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;


class UrlController extends Controller
{
    use CountRepository, ConfigTrait, NotifyRepository;

    private $repository;
    private $itensRepository;
    private $eventRepository;
    private $paymentRepository;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var PaymentMethodsRepository
     */
    private $paymentMethodsRepository;

    public function __construct(UrlRepository $repository, UrlItensRepository $itensRepository,
                                EventRepository $eventRepository, PaymentRepository $paymentRepository,
                                EventServices $eventServices, PaymentMethodsRepository $paymentMethodsRepository)
    {

        $this->repository = $repository;
        $this->itensRepository = $itensRepository;
        $this->eventRepository = $eventRepository;
        $this->paymentRepository = $paymentRepository;
        $this->eventServices = $eventServices;
        $this->paymentMethodsRepository = $paymentMethodsRepository;
    }

    public function index()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $urls = $this->repository->all();

        foreach ($urls as $url) {

            $url->expires_in = $url->expires_in ? date_format(date_create($url->expires_in), 'd/m/Y') : '-';

            $url->payment_method = $this->paymentMethodsRepository->findByField('id', $url->pay_method)->first() ?
                $this->paymentMethodsRepository->findByField('id', $url->pay_method)->first()->name : null;

        }

        return view('payments.list-url', compact('urls', 'countPerson', 'countGroups',
            'leader', 'admin', 'qtde'));
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

    public function store(Request $request)
    {

        try{
            $data = $request->all();

            $url = $data['url'] ? $data['url'] : null;

            if($url)
            {
                if($this->eventServices->checkUrlEvent($url))
                {
                    $request->session()->flash('error.msg', 'Esta url já existe');

                    return redirect()->back()->withInput();
                }
                else{

                    if($this->repository->findByField('url', $url)->first())
                    {
                        $request->session()->flash('error.msg', 'Esta url já existe');

                        return redirect()->back()->withInput();
                    }
                }
            }

            $data['pay_method'] = isset($data['payment-slip']) ? $data['pay_method'] = 1 : $data['pay_method'] = 2;

            if($data['expires_in'])
            {
                $data['expires_in'] .= ' 23:59';

                $data['expires_in'] = date_create_from_format('d/m/Y H:i', $data['expires_in']);
            }

            $data['value_money'] = $data['value_money'] ? $data['value_money'] : 0.00;

            $id = $this->repository->create($data)->id;

            foreach ($data['events'] as $event)
            {
                $x['event_id'] = $event;
                $x['url_id'] = $id;

                $this->itensRepository->create($x);
            }

            return redirect()->back();

        }catch (\Exception $e)
        {
            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'Line: ' .$e->getLine(). ' store() UrlController.php';
            $bug->model = 'Url';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {

    }


    public function delete($id)
    {

    }



}
