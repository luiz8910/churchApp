<?php

namespace App\Services;

use App\Models\Bug;
use App\Repositories\CreditCardRepository;
use App\Repositories\EventRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UrlItensRepository;
use App\Repositories\UrlRepository;
use App\Traits\PeopleTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;


class PaymentServices
{
    use PeopleTrait;

    /**
     * @var CreditCardRepository
     */
    private $creditCardRepository;
    private $client;

    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var PaymentRepository
     */
    private $paymentRepository;
    /**
     * @var UrlRepository
     */
    private $urlRepository;
    /**
     * @var UrlItensRepository
     */
    private $urlItensRepository;

    public function __construct(CreditCardRepository $creditCardRepository, EventRepository $eventRepository,
                                PersonRepository $personRepository, PaymentRepository $paymentRepository,
                                UrlRepository $urlRepository, UrlItensRepository $urlItensRepository)
    {

        $this->creditCardRepository = $creditCardRepository;
        $this->client = new Client();
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
        $this->paymentRepository = $paymentRepository;
        $this->urlRepository = $urlRepository;
        $this->urlItensRepository = $urlItensRepository;
    }


    public function payment_url()
    {

        if(env('APP_ENV') == 'prod')
        {
            return 'https://gateway.api.4all.com';
        }

        return 'https://gateway.homolog-interna.4all.com';

    }

    public function getMerchantKey()
    {
        return env('MERCHANT_KEY');
    }

    public function getPublicKey()
    {
        return env('PUBLIC_API_KEY');
    }


    //2ª Função no fluxo de pagamentos
    public function requestVaultKey()
    {
        $url = '/requestVaultKey';

        try{
            $response = $this->client->request('post', $this->payment_url() . $url, ['json' => [

                "headers" => [
                    "Content-Type" => "application/json",
                    //"Content-Type" => "application/x-www-form-urlencoded",
                    "Accept" => "application/json",
                ],


                "merchantKey" => $this->getMerchantKey(),
            ]

            ]);

            if ($response->getStatusCode() == 200) {

                $access_key = json_decode($response->getBody()->read(1024))->accessKey;

                return $access_key;
            }

        }catch (\Exception $e)
        {
            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'requestVaultKey() PaymentServices.php';
            $bug->model = '4all';
            $bug->status = 'Pendente';

            $bug->save();
        }


        return false;

    }

    //1ª Função no fluxo de pagamentos
    public function prepareCard($data, $person_id = null)
    {
        $card = $this->creditCardRepository->findByField('card_number', $data['credit_card_number'])->first();

        if(!$card)
        {
            $access_key = $this->requestVaultKey();

            if($access_key)
            {
                try{

                    $url = '/prepareCard';

                    $response = $this->client->request('post', $this->payment_url() . $url, ['json' => [

                        "headers" => [
                            "Content-Type" => "application/json",
                            //"Content-Type" => "application/x-www-form-urlencoded",
                            "Accept" => "application/json",
                        ],

                        "accessKey" => $access_key,
                        "cardData" => [
                            "type" => 1,
                            "cardholderName" => $data['holder_name'],
                            "cardNumber" => $data['credit_card_number'],
                            "expirationDate" => str_replace('/', '', $data['expires_in']),
                            "securityCode" => $data['cvc']
                        ]

                    ]

                    ]);


                    if ($response->getStatusCode() == 200)
                    {

                        $json = $response->getBody()->read(2048);

                        $card_nonce = json_decode($json)->cardNonce;

                        $brandId = json_decode($json)->brandId;


                        return json_encode([
                            'response_status'=> true,
                            'card_nonce' => $card_nonce,
                            'brandId' => $brandId
                        ]);

                        //return $this->createCardToken($card_nonce);
                    }

                }catch (\Exception $e)
                {
                    $bug = new Bug();

                    $bug->description = $e->getMessage() . ' id da pessoa: ' . $person_id;
                    $bug->platform = 'Back-end';
                    $bug->location = 'prepareCard() PaymentServices.php';
                    $bug->model = '4all';
                    $bug->status = 'Pendente';

                    $bug->save();

                    return json_encode(['response_status' => false, 'card' => false]);
                }

            }
        }


        return json_encode(['response_status' => false, 'card' => true]);


    }

    //3ª Função no fluxo de pagamentos
    public function createCardToken($card_nonce)
    {
        try{

            $url = '/createCardToken';

            $response = $this->client->request('post', $this->payment_url() . $url, ['json' =>

                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'merchantKey' => $this->getMerchantKey(),
                    'cardNonce' => $card_nonce
                ]
            ]);

            if($response->getStatusCode() == 200)
            {
                return $response->getBody()->read(2048);
            }

        }catch (\Exception $e){
            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'createCardToken() PaymentServices.php';
            $bug->model = '4all';
            $bug->status = 'Pendente';

            $bug->save();

        }


        return json_encode(['response_status' => false, 'card' => false]);
    }


    //4ª Função no fluxo de pagamentos
    public function check_card_token($card_token)
    {

        try{

            $url = '/checkCardToken';

            $response = $this->client->request('post', $this->payment_url() . $url, ['json' =>
                [
                    "headers" => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'merchantKey' => $this->getMerchantKey(),
                    'cardToken' => $card_token
                ]
            ]);

            if($response->getStatusCode() == 200)
            {
                return json_decode($response->getBody()->read(1024))->status;

            }

        }catch (\Exception $e)
        {
            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->location = 'check_card_token() PaymentServices.php';
            $bug->model = '4all';
            $bug->status = 'Pendente';

            $bug->save();
        }

        return json_encode(['response_status' => false]);

    }


    public function check_card($data, $event_id)
    {

        $card = $this->creditCardRepository->findByField('card_token', $data['card_token'])->first();

        if($card)
        {
            try{

                $status = $this->check_card_token($data['card_token']);

                $result = json_decode($status);

                if(!isset($result->response_status))
                {
                    if($status == 1)
                    {
                        $x['status'] = $status;

                        $this->creditCardRepository->update($x, $card->id);

                        $this->createTransaction($data, $event_id);

                        \DB::commit();

                        return $status;
                    }
                }
                else{
                    return -1;
                }


            }catch (\Exception $e)
            {
                \DB::rollBack();

                $bug = new Bug();

                $bug->description = $e->getMessage();
                $bug->platform = 'Back-end';
                $bug->location = 'line ' . $e->getLine() . ' check_card_token() PaymentServices.php';
                $bug->model = '4all';
                $bug->status = 'Pendente';

                $bug->save();
            }

        }else{

            $bug = new Bug();

            $bug->description = 'Não existe com o card_token informado: ' . $data['card_token'];
            $bug->platform = 'Back-end';
            $bug->location = 'check_card PaymentServices.php';
            $bug->model = '4all';
            $bug->status = 'Pendente';

            $bug->save();
        }
    }

    //5ª Função no fluxo de pagamentos
    public function createTransaction($data, $event_id = null, $total = null, $url_id = null)
    {
        $url = "/createTransaction";

        $person = $this->personRepository->findByField('id', $data['person_id'])->first();

        if($event_id)
        {
            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event && $person)
            {
                if($total)
                {
                    $value = $total * 100;
                }
                else{
                    $value = $event->value_money * 100;
                }

                $response = $this->client->request('POST', $this->payment_url() . $url, ['json' => [

                    "headers" => [
                        "Content-Type" => "application/json",
                        "Accept" => "application/json",
                    ],

                    "merchantKey" => $this->getMerchantKey(),
                    "amount" => $value,
                    "metaId" => $data['metaId'],


                    /*"interestRules" => [
                        "min" => 1,
                        "max" => $event->installments,
                        "percentual" => 0
                    ],*/

                    "paymentMethod" => [
                        "softDescriptor" => "BRICKS",
                        "cardNonce" => $data['card_nonce'],
                        "cardBrandId" => $data['brandId'],
                        "paymentMode" => 1,
                        "installmentType" => $data['installments'] > 1 ? 2 : 1,
                        "installments" => $data['installments'],
                        "amount" => $value,
                    ],

                    "customerInfo" => [
                        "fullName" => $person->name,
                        "cpf" => $person->cpf,
                        "phoneNumber" => $person->cel,
                        "birthday" => date_format(date_create($person->dateBirth), 'Y-m-d'),
                        "emailAddress" => $person->email,
                    ],


                ]
                ]);

                if($response->getStatusCode() == 200)
                {
                    try{
                        $json = $response->getBody()->read(2048);


                        $pay['transactionId'] = json_decode($json)->transactionId;
                        $pay['status'] = json_decode($json)->status;
                        $pay['metaId'] = $data['metaId'];
                        $pay['person_id'] = $person->id;
                        $pay['event_id'] = $event_id;
                        $pay['church_id'] = $event->church_id;
                        /*$pay['antiFraude_success'] = json_decode($json)->antifraude->success;
                        $pay['antiFraude_validator'] = json_decode($json)->antifraude->validator;
                        $pay['antiFraude_score'] = json_decode($json)->antifraude->score;
                        $pay['antiFraude_recommendation'] = json_decode($json)->antifraude->recommendation;*/

                        $exists = $this->paymentRepository->findWhere([
                            'person_id' => $pay['person_id'],
                            'event_id' => $pay['event_id']
                        ])->first();

                        if($exists)
                        {
                            $this->paymentRepository->update($pay, $exists->id);
                        }
                        else{
                            $this->paymentRepository->create($pay);
                        }


                        \DB::commit();

                        return true;

                    }catch (\Exception $e)
                    {
                        \DB::rollBack();

                        $bug = new Bug();

                        $bug->description = $e->getMessage() . ' id da pessoa: ' . $person->id;
                        $bug->platform = 'Back-end';
                        $bug->location = 'line ' . $e->getLine() . ' createTransaction() PaymentServices.php';
                        $bug->model = '4all';
                        $bug->status = 'Pendente';

                        $bug->save();
                    }

                }
                else{
                    $bug = new Bug();

                    $bug->description = $response->getReasonPhrase() . ' Código: ' . $response->getStatusCode();
                    $bug->platform = 'Back-end';
                    $bug->location = 'createTransaction() PaymentServices.php';
                    $bug->model = '4all';
                    $bug->status = 'Pendente';

                    $bug->save();

                }
            }
        }



        if($url_id)
        {
            $url_model = $this->urlRepository->findByField('id', $url_id)->first();


            if($url_model && $person)
            {
                if($total)
                {
                    $value = $total * 100;
                }

                $response = $this->client->request('POST', $this->payment_url() . $url, ['json' => [

                    "headers" => [
                        "Content-Type" => "application/json",
                        "Accept" => "application/json",
                    ],

                    "merchantKey" => $this->getMerchantKey(),
                    "amount" => $value,
                    "metaId" => $data['metaId'],


                    /*"interestRules" => [
                        "min" => 1,
                        "max" => $event->installments,
                        "percentual" => 0
                    ],*/

                    "paymentMethod" => [
                        "softDescriptor" => "BRICKS",
                        "cardNonce" => $data['card_nonce'],
                        "cardBrandId" => $data['brandId'],
                        "paymentMode" => 1,
                        "installmentType" => $data['installments'] > 1 ? 2 : 1,
                        "installments" => $data['installments'],
                        "amount" => $value,
                    ],

                    "customerInfo" => [
                        "fullName" => $person->name,
                        "cpf" => $person->cpf,
                        "phoneNumber" => $person->cel,
                        "birthday" => date_format(date_create($person->dateBirth), 'Y-m-d'),
                        "emailAddress" => $person->email,
                    ],


                ]
                ]);

                if($response->getStatusCode() == 200)
                {
                    try{
                        $json = $response->getBody()->read(2048);


                        $pay['transactionId'] = json_decode($json)->transactionId;
                        $pay['status'] = json_decode($json)->status;
                        $pay['metaId'] = $data['metaId'];
                        $pay['person_id'] = $person->id;
                        $pay['url_id'] = $url_id;
                        $pay['church_id'] = $url_model->church_id;
                        /*$pay['antiFraude_success'] = json_decode($json)->antifraude->success;
                        $pay['antiFraude_validator'] = json_decode($json)->antifraude->validator;
                        $pay['antiFraude_score'] = json_decode($json)->antifraude->score;
                        $pay['antiFraude_recommendation'] = json_decode($json)->antifraude->recommendation;*/

                        $exists = $this->paymentRepository->findWhere([
                            'person_id' => $pay['person_id'],
                            'url_id' => $pay['url_id']
                        ])->first();

                        if($exists)
                        {
                            $this->paymentRepository->update($pay, $exists->id);
                        }
                        else{
                            $this->paymentRepository->create($pay);
                        }


                        \DB::commit();

                        return true;

                    }catch (\Exception $e)
                    {
                        \DB::rollBack();

                        $bug = new Bug();

                        $bug->description = $e->getMessage() . ' id da pessoa: ' . $person->id;
                        $bug->platform = 'Back-end';
                        $bug->location = 'line ' . $e->getLine() . ' createTransaction() PaymentServices.php';
                        $bug->model = '4all';
                        $bug->status = 'Pendente';
                        $bug->church_id = 0;

                        $bug->save();
                    }

                }
                else{
                    $bug = new Bug();

                    $bug->description = $response->getReasonPhrase() . ' Código: ' . $response->getStatusCode();
                    $bug->platform = 'Back-end';
                    $bug->location = 'createTransaction() PaymentServices.php';
                    $bug->model = '4all';
                    $bug->status = 'Pendente';
                    $bug->church_id = 0;

                    $bug->save();

                }
        }
        }

        return false;


    }


    public function setMetaId()
    {
        $alphabet = '1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}



