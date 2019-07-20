<?php

namespace App\Services;

use App\Models\Bug;
use App\Repositories\CreditCardRepository;
use App\Repositories\EventRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
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
    private $api_token;
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

    public function __construct(CreditCardRepository $creditCardRepository, EventRepository $eventRepository,
                                PersonRepository $personRepository, PaymentRepository $paymentRepository)
    {

        $this->creditCardRepository = $creditCardRepository;
        $this->client = new Client();
        $this->api_token = 'API_TOKEN';
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
        $this->paymentRepository = $paymentRepository;
    }


    public function payment_url()
    {
        //https://gateway.api.4all.com;
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


    //1ª Função no fluxo de pagamentos
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

    //2ª Função no fluxo de pagamentos
    public function prepareCard($data)
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
                        $card_nonce = json_decode($response->getBody()->read(2048))->cardNonce;

                        return $this->createCardToken($card_nonce);
                    }

                }catch (\Exception $e)
                {
                    $bug = new Bug();

                    $bug->description = $e->getMessage();
                    $bug->platform = 'Back-end';
                    $bug->location = 'prepareCard() PaymentServices.php';
                    $bug->model = '4all';
                    $bug->status = 'Pendente';

                    $bug->save();

                    return json_encode(['status' => false, 'card' => false]);
                }

            }
        }


        return json_encode(['status' => false, 'card' => true]);


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
                return $response->getBody()->read(2048) . json_encode(['status' => true]);
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


        return json_encode(['status' => false, 'card' => false]);
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

        return false;

    }

    //5ª Função no fluxo de pagamentos
    public function createTransaction($data, $event_id)
    {
        $url = "/createTransaction";

        $event = $this->eventRepository->findByField('id', $event_id)->first();

        $person = $this->personRepository->findByField('id', $data['person_id'])->first();

        $metaId = $this->randomPassword(10);

        if($event && $person)
        {
            $response = $this->client->request('POST', $this->payment_url() . $url, ['json' => [

                    "headers" => [
                        "Content-Type" => "application/json",
                        "Accept" => "application/json",
                    ],

                    "merchantKey" => $this->getMerchantKey(),
                    "amount" => $event->value_money * 100,
                    "metaId" => $metaId,
                    "softDescriptor" => "MIGS",

                    "interestRules" => [
                        "min" => 1,
                        "max" => $event->installments,
                        "percentual" => 0
                    ],

                    "paymentMethod" => [

                        "cardToken" => $data['card_token'],
                        "paymentMode" => 1,
                        "installmentType" => $data['installments'] > 1 ? 2 : 1,
                        "installments" => $data['installments'],
                        "amount" => $event->value_money * 100,
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
                $pay['transactionId'] = json_decode($response->getBody()->read(2048))->transactionId;
                $pay['status'] = json_decode($response->getBody()->read(2048))->status;
                $pay['metaId'] = $metaId;
                $pay['antiFraude_success'] = json_decode($response->getBody()->read(2048))->antiFraude->success;
                $pay['antiFraude_validator'] = json_decode($response->getBody()->read(2048))->antiFraude->validator;
                $pay['antiFraude_score'] = json_decode($response->getBody()->read(2048))->antiFraude->score;
                $pay['antiFraude_recommendation'] = json_decode($response->getBody()->read(2048))->antiFraude->recommendation;

                $this->paymentRepository->create($pay);
            }
        }


    }
}



