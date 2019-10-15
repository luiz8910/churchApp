<?php

namespace App\Http\Controllers;

use App\Repositories\ChurchRepository;
use App\Repositories\EmailInvoiceRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\InvoiceItensRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    use ConfigTrait;

    private $repository;
    private $eventRepository;
    private $churchRepository;
    private $personRepository;
    private $stateRepository;
    private $itensRepository;
    private $emailInvoiceRepository;
    private $eventServices;
    private $listRepository;

    public function __construct(InvoiceRepository $repository, EventRepository $eventRepository,
                                ChurchRepository $churchRepository, PersonRepository $personRepository,
                                StateRepository $stateRepository, InvoiceItensRepository $itensRepository,
                                EmailInvoiceRepository $emailInvoiceRepository, EventServices $eventServices,
                                EventSubscribedListRepository $listRepository)
    {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->churchRepository = $churchRepository;
        $this->personRepository = $personRepository;
        $this->stateRepository = $stateRepository;
        $this->itensRepository = $itensRepository;
        $this->emailInvoiceRepository = $emailInvoiceRepository;
        $this->eventServices = $eventServices;
        $this->listRepository = $listRepository;
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

            return view('invoices.create', compact('name', 'orgs', 'invoice', 'events', 'route', 'id'));
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
        set_time_limit(60);

        $invoice = $request->only(['customer_id', 'event_id', 'date']);

        $itens = $request->except(['customer_id', 'event_id', 'date', '_token', 'print']);

        $invoice['date'] = date_create_from_format('d/m/Y', $invoice['date']);

        if(!$invoice['event_id'])
        {
            unset($invoice['event_id']);
        }

        $chargeback = false;

        if(isset($itens['chargeback']))
        {
            $chargeback = true;

            unset($itens['chargeback']);
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

                $itens['td_price_'.$i] = str_replace(',', '.',$itens['td_price_'.$i]);

                $x['price'] = (float) $itens['td_price_'.$i];

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

        if($chargeback)
        {
            $list = $this->eventServices->money_back_list($invoice['event_id']);

            //How many users we have in a particular event
            $sub = $this->listRepository->findByField('event_id', $invoice['event_id']);

            //$ql means qtde_list
            $ql['title'] = 'Quantidade de Reembolsos';
            $ql['price'] = 0;
            $ql['qtde'] = count($list);
            $ql['description'] = 'Quantidade de Reembolsos pedidos: ' . count($list);
            $ql['invoice_id'] = $invoice_id;

            $this->itensRepository->create($ql);

            //$qs means qtde_sub
            $qs['title'] = 'Quantidade de Pagamentos';
            $qs['price'] = 0;
            $qs['qtde'] = count($sub);
            $qs['description'] = 'Quantidade de Pagamento Efetuados: ' . count($sub);
            $qs['invoice_id'] = $invoice_id;

            $this->itensRepository->create($qs);

            foreach ($list as $item)
            {
                $person = $this->personRepository->findByField('id', $item->person_id)->first();

                $event = $this->eventRepository->findByField('id', $invoice['event_id'])->first();

                if($person)
                {

                    $x['title'] = $person->name;

                    $x['price'] = $event->value_money * -1;

                    $x['invoice_id'] = $invoice_id;

                    $x['qtde'] = -1;

                    $x['description'] = '<p>Reembolso feito dia '. date_format(date_create($item->deleted_at), 'd/m/Y') .'</p>';
                    $x['description'] .= '<p>Email: ' .$person->email .'</p>';
                    $x['description'] .= '<p>Telefone: ' .$this->formatPhoneInvoice($person->cel).'</p>';

                    $this->itensRepository->create($x);

                }
            }



            foreach ($sub as $item)
            {
                $person = $this->personRepository->findByField('id', $item->person_id)->first();

                $event = $this->eventRepository->findByField('id', $invoice['event_id'])->first();

                if($person)
                {

                    $x['title'] = $person->name;

                    $x['price'] = $event->value_money;

                    $x['invoice_id'] = $invoice_id;

                    $x['qtde'] = -1;

                    $x['description'] = '<p>Pagamento feito dia '. date_format(date_create($item->created_at), 'd/m/Y') .'</p>';
                    $x['description'] .= '<p>Email: ' .$person->email .'</p>';
                    $x['description'] .= '<p>Telefone: ' .$this->formatPhoneInvoice($person->cel) .'</p>';

                    $this->itensRepository->create($x);



                }
            }
        }


        /*unset($invoice);

        $invoice = $this->repository->findByField('id', $invoice_id)->first();

        $folder_name = $this->churchRepository->findByField('id', $invoice->customer_id)->first()->alias ?
            $this->churchRepository->findByField('id', $invoice->customer_id)->first()->alias : $invoice->customer_id;

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
        }

        $name = 'Admin';

        PDF::loadView('invoices.invoice',
            compact('name', 'invoice', 'org', 'total_price', 'itens', 'emails'))->save('uploads/invoices.'.$folder_name.'.'.$invoice->id);*/

        $request->session()->flash('success.msg', 'O Invoice foi criado');

        if($request->has('print'))
        {
            return redirect()->route('invoice.print', ['id' => $invoice_id]);
        }

        return redirect()->route('invoice.index');

    }

    public function update(Request $request, $id)
    {
        set_time_limit(120);

        $invoice = $request->only(['customer_id', 'event_id', 'date']);

        $itens = $request->except(['customer_id', 'event_id', 'date', '_token', 'print']);

        $invoice['date'] = date_create_from_format('d/m/Y', $invoice['date']);

        if(!$invoice['event_id'])
        {
            unset($invoice['event_id']);
        }

        $chargeback = false;

        if(isset($itens['chargeback']))
        {
            $chargeback = true;

            unset($itens['chargeback']);
        }

        $this->repository->update($invoice, $id);


        DB::table('invoice_itens')
            ->where(['invoice_id' => $id])
            ->update(['deleted_at' => Carbon::now()]);


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

                $itens['td_price_'.$i] = str_replace(',', '.',$itens['td_price_'.$i]);

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

        if($chargeback)
        {
            $list = $this->eventServices->money_back_list($invoice['event_id']);

            $sub = $this->listRepository->findByField('event_id', $invoice['event_id']);

            $qtde_list = $this->itensRepository->findWhere(['title' => 'Quantidade de Reembolsos', 'invoice_id' => $id])->first();

            if($qtde_list)
            {
                $this->itensRepository->delete($qtde_list->id);
            }

            $qtde_sub = $this->itensRepository->findWhere(['title' => 'Quantidade de Pagamentos', 'invoice_id' => $id])->first();

            if($qtde_sub)
            {
                $this->itensRepository->delete($qtde_sub->id);
            }

            //$ql means qtde_list
            $ql['title'] = 'Quantidade de Reembolsos';
            $ql['price'] = 0;
            $ql['qtde'] = count($list);
            $ql['description'] = 'Quantidade de Reembolsos pedidos: ' . count($list);
            $ql['invoice_id'] = $id;

            $this->itensRepository->create($ql);

            //$qs means qtde_sub
            $qs['title'] = 'Quantidade de Pagamentos';
            $qs['price'] = 0;
            $qs['qtde'] = count($sub);
            $qs['description'] = 'Quantidade de Pagamento Efetuados: ' . count($sub);
            $qs['invoice_id'] = $id;

            $this->itensRepository->create($qs);

            foreach ($list as $item)
            {
                 $person = $this->personRepository->findByField('id', $item->person_id)->first();

                 $event = $this->eventRepository->findByField('id', $invoice['event_id'])->first();

                 if($person)
                 {
                     $exist = $this->itensRepository->findWhere(
                         [
                             'title' => $person->name,
                             'invoice_id' => $id
                         ])->first();

                     if(!$exist)
                     {
                         $x['title'] = $person->name;

                         $x['price'] = $event->value_money * -1;

                         $x['invoice_id'] = $id;

                         $x['qtde'] = -1;

                         $x['description'] = '<p>Reembolso feito dia '. date_format(date_create($item->deleted_at), 'd/m/Y') .'</p>';
                         $x['description'] .= '<p>Email: ' .$person->email .'</p>';
                         $x['description'] .= '<p>Telefone: ' .$this->formatPhoneInvoice($person->cel).'</p>';

                         $this->itensRepository->create($x);
                     }


                 }
            }


            foreach ($sub as $item)
            {
                $person = $this->personRepository->findByField('id', $item->person_id)->first();

                $event = $this->eventRepository->findByField('id', $invoice['event_id'])->first();

                if($person)
                {
                    $exist = $this->itensRepository->findWhere(
                        [
                            'title' => $person->name,
                            'invoice_id' => $id
                        ])->first();

                    if(!$exist)
                    {
                        $x['title'] = $person->name;

                        $x['price'] = $event->value_money;

                        $x['invoice_id'] = $id;

                        $x['qtde'] = -1;

                        $x['description'] = '<p>Pagamento feito dia '. date_format(date_create($item->created_at), 'd/m/Y') .'</p>';
                        $x['description'] .= '<p>Email: ' .$person->email .'</p>';
                        $x['description'] .= '<p>Telefone: ' .$this->formatPhoneInvoice($person->cel) .'</p>';

                        $this->itensRepository->create($x);
                    }


                }
            }
        }

        unset($invoice);

        $invoice = $this->repository->findByField('id', $id)->first();

        $folder_name = $this->churchRepository->findByField('id', $invoice->customer_id)->first()->alias ?
            $this->churchRepository->findByField('id', $invoice->customer_id)->first()->alias : $invoice->customer_id;

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
        }

        $name = 'Admin';

        if(!file_exists('uploads/invoices/'.$folder_name))
        {
            mkdir('uploads/invoices/'.$folder_name);
        }

        PDF::loadView('invoices.pdf',
            compact('name', 'invoice', 'org', 'total_price', 'itens', 'emails'))->save('uploads/invoices/'.$folder_name.'/'.$invoice->id.'.pdf');

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

    /*
     * $id = invoice_id
     */
    public function sendMail($id)
    {
        $invoice = $this->repository->findByField('id', $id)->first();

        if($invoice)
        {
            $subject = 'Sua fatura Beconnect';

            $text = '<p>Sua fatura Beconnect chegou e aqui está anexada.</p>
                    <br><br><p>Em caso de dúvidas responda este email.</p>';


        }
    }
}










