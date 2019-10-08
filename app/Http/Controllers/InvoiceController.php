<?php

namespace App\Http\Controllers;

use App\Repositories\ChurchRepository;
use App\Repositories\EmailInvoiceRepository;
use App\Repositories\EventRepository;
use App\Repositories\InvoiceItensRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    private $repository;
    private $eventRepository;
    private $churchRepository;
    private $personRepository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var InvoiceItensRepository
     */
    private $itensRepository;
    /**
     * @var EmailInvoiceRepository
     */
    private $emailInvoiceRepository;

    public function __construct(InvoiceRepository $repository, EventRepository $eventRepository,
                                ChurchRepository $churchRepository, PersonRepository $personRepository,
                                StateRepository $stateRepository, InvoiceItensRepository $itensRepository,
                                EmailInvoiceRepository $emailInvoiceRepository)
    {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->churchRepository = $churchRepository;
        $this->personRepository = $personRepository;
        $this->stateRepository = $stateRepository;
        $this->itensRepository = $itensRepository;
        $this->emailInvoiceRepository = $emailInvoiceRepository;
    }

    public function index($org_id = null)
    {
        $name = 'Admin';

        if($org_id)
        {
            $orgs = $this->churchRepository->orderBy('name')
                ->findWhere([
                    'status' => 'active',
                    ['id', '<>', $org_id]
                ]);

            $invoices = $this->repository->findByField('customer_id', $org_id);

        }else{
            $orgs = $this->churchRepository->orderBy('name')->findByField('status', 'active');

            $invoices = $this->repository->all();
        }

        $price = 0;

        foreach ($invoices as $invoice)
        {
            $invoice->org_name = $this->churchRepository->findByField('id', $invoice->customer_id)->first() ?
                $this->churchRepository->findByField('id', $invoice->customer_id)->first()->name : 'Esta Org não existe';

            if($invoice->event_id)
            {
                $invoice->event_name = $this->eventRepository->findByField('id', $invoice->event_id)->first() ?
                    $this->eventRepository->findByField('id', $invoice->event_id)->first()->name : 'Este evento não existe';
            }

            $itens = $this->itensRepository->findByField('invoice_id', $invoice->id);

            foreach ($itens as $item)
            {
                $price += $item->price;
            }

            $invoice->total_price = $price;

            $price = 0;

            $invoice->date = date_format(date_create($invoice->date), 'm/Y');
        }

        return view('invoices.index', compact('name', 'orgs', 'invoices', 'org_id'));
    }

    public function create()
    {
        $name = 'Admin';

        $orgs = $this->churchRepository->orderBy('name')->findByField('status', 'active');

        $route = 'create';

        return view('invoices.create', compact('name', 'orgs', 'route'));
    }

    public function edit($id)
    {
        $name = 'Admin';

        $orgs = $this->churchRepository->orderBy('name')->findByField('status', 'active');

        $invoice = $this->repository->findByField('id', $id)->first();

        $route = 'edit';

        if($invoice)
        {
            $events = $this->eventRepository->findByField('church_id', $invoice->customer_id);

            $invoice->date = date_format(date_create($invoice->date), 'd/m/Y');

            return view('invoices.create', compact('name', 'orgs', 'invoice', 'events', 'route'));
        }

        \Session::flash('error.msg', 'Este invoice não existe');

        return redirect()->route('invoice.index');
    }

    public function get_info_org($id)
    {
        $org = $this->churchRepository->findByField('id', $id)->first();

        if($org)
        {
            $events = $this->eventRepository->findByField('church_id', $id);

            if(count($events) > 0)
            {
                return json_encode([
                    'status' => true, 'events' => $events,
                    'org' => $org
                ]);
            }
        }

        return json_encode(['status' => false]);

    }

    public function store(Request $request)
    {

        $invoice = $request->only(['customer_id', 'event_id', 'date']);

        $itens = $request->except(['customer_id', 'event_id', 'date', '_token', 'print']);

        $invoice['date'] = date_create_from_format('d/m/Y', $invoice['date']);

        if(!$invoice['event_id'])
        {
            unset($invoice['event_id']);
        }

        $invoice_id = $this->repository->create($invoice)->id;

        $stop = false;
        $i = 1;

        while(!$stop)
        {
            if(isset($itens['td_title_'.$i]))
            {
                $x['invoice_id'] = $invoice_id;

                $x['title'] = $itens['td_title_'.$i];

                $x['description'] = $itens['td_description_'.$i];

                $x['price'] = substr($itens['td_price_'.$i], 2);

                $x['price'] = (float) $x['price'];

                $x['qtde'] = $itens['td_qtde_'.$i] ? (float) $itens['td_qtde_'.$i] : 0.00;

                $this->itensRepository->create($x);

                unset($x);

                $i++;
            }
            else{
                $stop = true;
            }

        }

        $stop_email = false;
        $e = 1;

        while (!$stop_email)
        {
            if(isset($itens['email_'.$e]))
            {
                $em['email'] = $itens['email_'.$e];
                $em['invoice_id'] = $invoice_id;

                $this->emailInvoiceRepository->create($em);

                unset($em);

                $e++;
            }
            else{
                $stop_email = true;
            }
        }

        $request->session()->flash('success.msg', 'O Invoice foi criado');

        if($request->has('print'))
        {
            return redirect()->route('invoice.print', ['id' => $invoice_id]);
        }

        return redirect()->route('invoice.index');

    }

    public function update(Request $request, $id)
    {
        $invoice = $request->only(['customer_id', 'event_id', 'date']);

        $itens = $request->except(['customer_id', 'event_id', 'date', '_token', 'print']);

        $invoice['date'] = date_create_from_format('d/m/Y', $invoice['date']);

        if(!$invoice['event_id'])
        {
            unset($invoice['event_id']);
        }

        $this->repository->update($invoice, $id);

        $itens_exist = $this->itensRepository->findByField('invoice_id', $id);

        foreach ($itens_exist as $item)
        {
            $this->itensRepository->delete($item->id);
        }

        $stop = false;
        $i = 1;



        while(!$stop)
        {
            if(isset($itens['td_title_'.$i]))
            {
                $x['invoice_id'] = $id;

                $x['title'] = $itens['td_title_' . $i];

                $x['description'] = $itens['td_description_' . $i];

                //$x['price'] = substr($itens['td_price_' . $i], 2);

                //$x['price'] = (float) $x['price'];

                $x['price'] = (float) $itens['td_price_'.$i];

                $x['qtde'] = $itens['td_qtde_'.$i] ? (float) $itens['td_qtde_'.$i] : 0.00;

                $this->itensRepository->create($x);

                $i++;
            }
            else{
                $stop = true;
            }
        }

        $emails_exist = $this->emailInvoiceRepository->findByField('invoice_id', $id);

        foreach ($emails_exist as $item)
        {
            $this->emailInvoiceRepository->delete($item->id);
        }

        $stop_email = false;
        $e = 1;

        while (!$stop_email)
        {
            if(isset($itens['email_'.$e]))
            {
                $em['email'] = $itens['email_'.$e];
                $em['invoice_id'] = $id;

                $this->emailInvoiceRepository->create($em);

                $e++;
            }
            else{
                $stop_email = true;
            }
        }

        $request->session()->flash('success.msg', 'O Invoice foi alterado');

        if($request->has('print'))
        {
            return redirect()->route('invoice.print', ['id' => $id]);
        }

        return redirect()->route('invoice.index');
    }

    public function delete($id)
    {
        $invoice = $this->repository->findByField('id', $id)->first();

        try{
            \DB::beginTransaction();

            if($invoice)
            {
                $itens = $this->itensRepository->findByField('invoice_id', $id);

                foreach ($itens as $item)
                {
                    $this->itensRepository->delete($item->id);
                }

                $emails = $this->emailInvoiceRepository->findByField('invoice_id', $id);

                foreach ($emails as $email)
                {
                    $this->emailInvoiceRepository->delete($email->id);
                }

                $this->repository->delete($id);

                \DB::commit();

                return json_encode(['status' => true]);
            }
            else{
                \DB::rollBack();

                return json_encode(['status' => false]);
            }

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false]);
        }

    }

    public function print($id)
    {
        $name = 'Admin';

        $invoice = $this->repository->findByField('id', $id)->first();

        if($invoice)
        {
            $org = $this->churchRepository->findByField('id', $invoice->customer_id)->first();

            $invoice->date = date_format(date_create($invoice->date), 'm/Y');

            if($org)
            {
                $itens = $this->itensRepository->findByField('invoice_id', $invoice->id);

                $total_price = 0;

                foreach ($itens as $item)
                {
                    $total_price += $item->price;
                }

                $emails = $this->emailInvoiceRepository->findByField('invoice_id', $invoice->id);



                return view('invoices.invoice', compact('name', 'invoice', 'org', 'total_price', 'itens', 'emails'));
            }
        }

    }


    public function get_itens($id)
    {
        $invoice = $this->repository->findByField('id', $id)->first();

        if($invoice)
        {
            $itens = $this->itensRepository->findByField('invoice_id', $id);

            return json_encode(['status' => true, 'itens' => $itens]);
        }

        return json_encode(['status' => false, 'msg' => 'Este invoice não existe', 'statusCode' => 404]);
    }

    public function get_emails($id)
    {
        $invoice = $this->repository->findByField('id', $id)->first();

        if($invoice)
        {
            $emails = $this->emailInvoiceRepository->findByField('invoice_id', $id);

            return json_encode(['status' => true, 'emails' => $emails]);
        }

        return json_encode(['status' => false, 'msg' => 'Este invoice não existe', 'statusCode' => 404]);
    }
}










