<?php

namespace App\Http\Controllers;

use App\Jobs\Payment_Mail_Url;
use App\Jobs\PaymentMail;
use App\Models\Bug;
use App\Repositories\CourseDescRepository;
use App\Repositories\EventRepository;
use App\Repositories\PaymentMethodsRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentSlipRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UrlItensRepository;
use App\Repositories\UrlRepository;
use App\Repositories\UserRepository;
use App\Services\EventServices;
use App\Services\PaymentServices;
use App\Services\qrServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use App\Traits\UserLoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UrlController extends Controller
{
    use CountRepository, ConfigTrait, NotifyRepository, UserLoginRepository;

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
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CourseDescRepository
     */
    private $courseRepository;
    /**
     * @var PaymentServices
     */
    private $paymentServices;
    /**
     * @var qrServices
     */
    private $qrServices;
    /**
     * @var PaymentSlipRepository
     */
    private $paymentSlipRepository;

    public function __construct(UrlRepository $repository, UrlItensRepository $itensRepository,
                                EventRepository $eventRepository, PaymentRepository $paymentRepository,
                                EventServices $eventServices, PaymentMethodsRepository $paymentMethodsRepository,
                                PersonRepository $personRepository, UserRepository $userRepository,
                                CourseDescRepository $courseRepository, PaymentServices $paymentServices,
                                qrServices $qrServices, PaymentSlipRepository $paymentSlipRepository)
    {

        $this->repository = $repository;
        $this->itensRepository = $itensRepository;
        $this->eventRepository = $eventRepository;
        $this->paymentRepository = $paymentRepository;
        $this->eventServices = $eventServices;
        $this->paymentMethodsRepository = $paymentMethodsRepository;
        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
        $this->paymentServices = $paymentServices;
        $this->qrServices = $qrServices;
        $this->paymentSlipRepository = $paymentSlipRepository;
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

    public function edit_url($id)
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $url = $this->repository->findByField('id', $id)->first();

        if($url)
        {
            $url->expires_in = !$url->expires_in ?: date_format(date_create($url->expires_in), 'd/m/Y');

            $itens = $this->itensRepository->findByField('url_id', $id);

            return view('payments.new-url', compact('events', 'countPerson', 'countGroups',
                'leader', 'admin', 'qtde', 'id', 'itens', 'url'));
        }


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

            $data['pay_method'] = isset($data['dueDate']) ? 1 : 2;

            if($data['expires_in'])
            {
                $data['expires_in'] .= ' 23:59';

                $data['expires_in'] = date_create_from_format('d/m/Y H:i', $data['expires_in']);
            }

            $data['value_money'] = isset($data['value_money']) ? $data['value_money'] : 0.00;

            $data['church_id'] = $this->getUserChurch();

            $id = $this->repository->create($data)->id;

            foreach ($data['events'] as $event)
            {
                $x['event_id'] = $event;
                $x['url_id'] = $id;

                $this->itensRepository->create($x);
            }

            if(isset($data['dueDate']))
            {
                $boleto['due_date'] = date_create_from_format('d/m/Y', $data['dueDate']);
                $boleto['daysToExpire'] = $data['daysToExpire'] ? $data['daysToExpire'] : 0;
                $boleto['url_id'] = $id;

                $this->paymentSlipRepository->create($boleto);
            }

            $request->session()->flash('success.msg', 'O link foi cadastrado com sucesso');

            return redirect()->route('url.list');

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

            return redirect()->back()->withInput();
        }
    }


    public function update(Request $request, $id)
    {
        try{
            $data = $request->all(); dd($data);

            $url = $this->repository->findByField('id', $id)->first();

            if($url)
            {
                $data['pay_method'] = isset($data['dueDate']) ? 1 : 2;

                if($data['expires_in'])
                {
                    $data['expires_in'] .= ' 23:59';

                    $data['expires_in'] = date_create_from_format('d/m/Y H:i', $data['expires_in']);
                }

                $data['value_money'] = isset($data['value_money']) ? $data['value_money'] : 0.00;

                $data['church_id'] = $this->getUserChurch();

                $this->repository->update($data, $id);

                $itens = $this->itensRepository->findByField('url_id', $id);

                foreach ($itens as $item)
                {
                    $this->itensRepository->delete($item->id);
                }

                foreach ($data['events'] as $event)
                {
                    $x['event_id'] = $event;
                    $x['url_id'] = $id;

                    $this->itensRepository->create($x);
                }

                if(isset($data['dueDate']) && isset($data['payment_slip']))
                {
                    $boleto['due_date'] = date_create_from_format('d/m/Y', $data['dueDate']);
                    $boleto['daysToExpire'] = $data['daysToExpire'] ? $data['daysToExpire'] : 0;
                    $boleto['url_id'] = $id;

                    $payment_slip = $this->paymentSlipRepository->findByField('url_id', $id)->first();

                    if($payment_slip)
                    {
                        $this->paymentSlipRepository->update($boleto, $payment_slip->id);
                    }
                }
                elseif(!isset($data['payment_slip']))
                {
                    $payment_slip = $this->paymentSlipRepository->findByField('url_id', $id)->first();

                    if($payment_slip)
                    {
                        $this->paymentSlipRepository->delete($payment_slip->id);
                    }

                }

                $request->session()->flash('success.msg', 'O link foi alterado com sucesso');
            }


            return redirect()->route('url.list');

        }catch (\Exception $e)
        {
            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'Line: ' .$e->getLine(). ' update() UrlController.php';
            $bug->model = 'Url';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->back()->withInput();
        }
    }


    public function delete($id)
    {
        try{
            \DB::beginTransaction();

            $url = $this->repository->findByField('id', $id)->first();

            if($url)
            {
                $this->repository->delete($id);

                \DB::commit();

                return json_encode(['status' => true]);
            }


            return json_encode(['status' => false, 'msg' => 'Esta url não foi encontrada']);

        }catch (\Exception $e)
        {
           \DB::rollBack();

            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'Line: ' .$e->getLine(). ' delete() UrlController.php';
            $bug->model = 'Url';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

           return json_encode(['status' => false]);
        }

    }

    public function payment(Request $request, $url_id)
    {
        $url_model = $this->repository->findByField('id', $url_id)->first();

        $value = null;

        if ($url_model) {

            try {
                $data = $request->all();

                $value = $data['input-total'];

                $courses = [];

                $itens = $this->itensRepository->findByField('url_id', $url_id);

                foreach ($itens as $item)
                {
                    $ev = $this->eventRepository->findByField('id', $item->event_id)->first();

                    if($ev)
                    {
                        if(isset($data['course-'.$ev->id]))
                        {
                            $courses[] = $ev->name;
                        }
                    }
                }

                $p['name'] = $data['name'];
                $p['email'] = $data['email'];
                $p['cel'] = $data['cel'];
                $p['cpf'] = $data['cpf'];
                $p['dateBirth'] = $data['dateBirth'];

                $person = $this->personRepository->findByField('email', $data['email'])->first();

                if ($person) {
                    $x['person_id'] = $person->id;

                    $this->personRepository->update($p, $person->id);

                    if (!$this->userRepository->findByField('email', $p['email'])->first()) {
                        $this->createUserLogin($x['person_id'], 'secret', $p['email'], $url_model->church_id);
                    }
                } else {
                    $p['role_id'] = 2;

                    $p['imgProfile'] = 'uploads/profile/noimage.png';

                    $p['tag'] = 'adult';

                    $x['person_id'] = $this->personRepository->create($p)->id;

                    $this->createUserLogin($x['person_id'], 'secret', $p['email'], $url_model->church_id);
                }

                $this->qrServices->generateQrCode($x['person_id']);

                //Verifica se o cliente ja pagou pela inscrição
                $pay_exists = $this->paymentRepository->findWhere([
                    'person_id' => $x['person_id'],
                    'url_id' => $url_model->id,
                    'status' => 4
                ]);


                /*
                 * Se pay_exists == 0 então o cliente
                 * não pagou pela inscrição
                 */
                if (count($pay_exists) == 0) {

                    if($data['pay_method'] == 1)
                    {

                        $x['metaId'] = $this->paymentServices->setMetaId();

                        /*
                         * Se houver um metaId repetido o código abaixo
                         * vai iterar até encontrar um metaId sem uso.
                         */
                        if ($this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                            $stop = false;

                            while (!$stop) {
                                $x['metaId'] = $this->paymentServices->setMetaId();

                                if (!$this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                                    $stop = true;
                                }
                            }
                        }

                        $li_0 = 'Estado do Pagamento: Processado (pago)';
                        $li_1 = 'Método de Pagamento: Cartão de Crédito';
                        $li_2 = 'Últimos 4 dígitos do cartão: ' . substr($data['credit_card_number'], 12, 4);
                        $li_3 = 'Valor da Transação: R$' . $value;
                        $li_4 = 'Parcelamento: ' . $data['installments'] == 1 ? 'Á vista' :
                            $data['installments'] . 'x de R$' . $value / $data['installments'];
                        $li_5 = 'Código da Transação: ' . $x["metaId"];


                        $url = 'https://www.beconnect.com.br/';//'https://migs.med.br/2019/home/';

                        $url_img = 'http://beconnect.com.br/logo/logo-menor-header.png';//'https://migs.med.br/2019/wp-content/uploads/2019/03/MIGS2019_curva_OK.png';

                        $subject = 'Seu pagamento do link ' . $url_model->name;//'Seu pagamento no MIGS 2019 foi concluído.';

                        $p1 = 'Seu pagamento foi aprovado.';

                        $p2 = '';

                        DB::table('course_descs')
                            ->where('person_id', $x['person_id'])
                            ->delete();

                        foreach ($courses as $item)
                        {
                            $c['description'] = $item;
                            $c['person_id'] = $x['person_id'];

                            $this->courseRepository->create($c);
                        }

                        $this->paymentServices->create_payment_slip($x, null, $value, $url_id);


                        Payment_Mail_Url::dispatch($li_0, $li_1, $li_2, $li_3, $li_4,
                            $li_5, $url, $url_img, $subject, $p1, $p2, $x, $url_id, $courses)
                            ->delay(now()->addMinutes(1));



                        $request->session()->flash('success.msg', 'Um email será enviado para ' .
                            $data['email'] . ' com informações sobre o pagamento');

                    }
                    elseif($data['pay_method'] == 2)
                    {
                        $json_data = $this->paymentServices->prepareCard($data, $x['person_id']);

                        $response_status = json_decode($json_data)->response_status;

                        $card_nonce = json_decode($json_data)->card_nonce;

                        $brandId = json_decode($json_data)->brandId;

                        if ($response_status) {

                            $x['installments'] = (int)$data['installments'];

                            $x['card_nonce'] = $card_nonce;

                            $x['brandId'] = $brandId;

                            $x['metaId'] = $this->paymentServices->setMetaId();

                            /*
                             * Se houver um metaId repetido o código abaixo
                             * vai iterar até encontrar um metaId sem uso.
                             */
                            if ($this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                                $stop = false;

                                while (!$stop) {
                                    $x['metaId'] = $this->paymentServices->setMetaId();

                                    if (!$this->paymentRepository->findByField('metaId', $x['metaId'])->first()) {
                                        $stop = true;
                                    }
                                }
                            }

                            $li_0 = 'Estado do Pagamento: Processado (pago)';
                            $li_1 = 'Método de Pagamento: Cartão de Crédito';
                            $li_2 = 'Últimos 4 dígitos do cartão: ' . substr($data['credit_card_number'], 12, 4);
                            $li_3 = 'Valor da Transação: R$' . $value;
                            $li_4 = 'Parcelamento: ' . $data['installments'] == 1 ? 'Á vista' :
                                $data['installments'] . 'x de R$' . $value / $data['installments'];
                            $li_5 = 'Código da Transação: ' . $x["metaId"];


                            $url = 'https://www.beconnect.com.br/';//'https://migs.med.br/2019/home/';

                            $url_img = 'http://beconnect.com.br/logo/logo-menor-header.png';//'https://migs.med.br/2019/wp-content/uploads/2019/03/MIGS2019_curva_OK.png';

                            $subject = 'Seu pagamento do link ' . $url_model->name;//'Seu pagamento no MIGS 2019 foi concluído.';

                            $p1 = 'Seu pagamento foi aprovado.';

                            $p2 = '';

                            DB::table('course_descs')
                                ->where('person_id', $x['person_id'])
                                ->delete();

                            foreach ($courses as $item)
                            {
                                $c['description'] = $item;
                                $c['person_id'] = $x['person_id'];

                                $this->courseRepository->create($c);
                            }

                            $this->paymentServices->createTransaction($x, null, $value, $url_id);


                            Payment_Mail_Url::dispatch($li_0, $li_1, $li_2, $li_3, $li_4,
                                $li_5, $url, $url_img, $subject, $p1, $p2, $x, $url_id, $courses)
                                ->delay(now()->addMinutes(1));



                            $request->session()->flash('success.msg', 'Um email será enviado para ' .
                                $data['email'] . ' com informações sobre o pagamento');


                            /*$x['card_token'] = $result->cardToken;
                            $x['type'] = $result->type;
                            $x['card_number'] = $data['credit_card_number'];
                            $x['expirationDate'] = $result->expirationDate;
                            $x['brandId'] = $result->brandId;
                            $x['status'] = $result->status;

                            $this->creditCardRepository->create($x);

                            DB::commit();

                            */

                            //CheckCardToken::dispatch($x, $event_id);


                        }
                    }

                } //Se já pagou
                else {

                    $request->session()->flash('error.msg', 'Este usuário já efetuou o pagamento');
                }


                return redirect()->back();

            } catch (\Exception $e) {

                \DB::rollBack();

                $bug = new Bug();

                $msg = isset($x) ? $e->getMessage() . ' id do usuário: ' . $x['person_id'] : $e->getMessage();

                $bug->description = $msg;
                $bug->platform = 'Back-end';
                $bug->location = 'line ' . $e->getLine() . ' payment() UrlController.php';
                $bug->model = '4all';
                $bug->status = 'Pendente';

                $bug->save();

                $request->session()->flash('error.msg',
                    'Um erro ocorreu entre em contato pelo contato@beconnect.com.br');

                return redirect()->back();
            }

        }

        throw new NotFoundHttpException();
    }

    public function getItens($id)
    {
        $url = $this->repository->findByField('id', $id)->first();

        if($url)
        {
            $itens = $this->itensRepository->findByField('url_id', $id);

            foreach ($itens as $item)
            {
                $event_name = $this->eventRepository->findByField('id', $item->event_id)->first();

                $item->event_name = !$event_name ?: $event_name->name;
            }

            return json_encode(['status' => true, 'itens' => $itens]);
        }

        $bug = new Bug();

        $bug->description = 'Nenhuma url encontrada com id: ' . $id;
        $bug->platform = 'Back-end';
        $bug->location = 'getItens() UrlController.php';
        $bug->model = '4all';
        $bug->status = 'Pendente';

        $bug->save();

        return json_encode(['status' => false]);
    }


    public function getPaymentMethods()
    {
        return $this->paymentServices->getPaymentMethods();
    }
}
