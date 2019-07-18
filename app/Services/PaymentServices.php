<?php

namespace App\Services;

use App\Repositories\CreditCardRepository;
use GuzzleHttp\Client;

class PaymentServices{

    /**
     * @var CreditCardRepository
     */
    private $creditCardRepository;
    private $client;
    private $api_token;

    public function __construct(CreditCardRepository $creditCardRepository)
    {

        $this->creditCardRepository = $creditCardRepository;
        $this->client = new Client();
        $this->api_token = 'API_TOKEN';
    }


    public function payment_url()
    {
        //https://gateway.api.4all.com;
        return 'https://gateway.homolog-interna.4all.com';
    }

    public function vault()
    {
        return 'https://vault.test.4all.com';
        //return 'https://vault.api.4all.com';
    }

    public function getMerchantKey()
    {
        return env('MERCHANT_KEY');
    }

    public function getPublicKey()
    {
        return env('PUBLIC_API_KEY');
    }

    public function requestVaultKey()
    {
        $url = '/requestVaultKey';

        $response = $this->client->request('post', $this->payment_url() . $url,
            //['verify' => false],

            ['json' => [

                "headers" => [
                    "Content-Type" => "application/json",
                    //"Content-Type" => "application/x-www-form-urlencoded",
                    "Accept" => "application/json",
            ],


                "merchantKey" => $this->getMerchantKey(),
            ]

        ]);

        if($response->getStatusCode() == 200)
        {
            $access_key = json_decode($response->getBody()->read(1024))->accessKey;

            $this->prepareCard($access_key);
        }

    }

    public function prepareCard($access_key)
    {
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
                    "cardholderName" => "John Smith",
                    "cardNumber" => "4574849552718601",
                    "expirationDate" => "0120",
                    "securityCode" => "123"
                ]

            ]

        ]);


        if($response->getStatusCode() == 200)
        {
            dd($response->getBody()->read(2048));
        }
    }


    public function sendCustomerData()
    {
        $url = '/authenticateCard';

        //4574849552718601
        $response = $this->client->request('post', $this->payment_url() . $url, ['json' => [

                "headers" => [
                    "Content-Type" => "application/json",
                    //"Content-Type" => "application/x-www-form-urlencoded",
                    "Accept" => "application/json",
                ],


                    "merchantKey" => $this->getMerchantKey(),
                    "metaId" => "ANDBB476FB",
                    "softDescriptor" => "Descrição teste",

                    "cardData" => [
                        "type" => 1,
                        "cardholderName" => "John Smith",
                        "cardNumber" => "4574849552718601",
                        "expiration_date" => "0120",
                        "security_code" => "123"
                    ]


            ]
        ]);

        return $response;
    }

    public function cardStatus()
    {

        $url = '/getBrands';

        $response = $this->client->request('POST', $this->payment_url() . $url, ['json' => [
                "headers" => [
                    "ContentType" => "application/json",
                    "Accept" => "application/json",
                ],

                "merchantKey" => $this->getMerchantKey()
            ]

        ]);

        if($response->getStatusCode() == 200)
        {
            dd($response->getBody());
        }
    }

    public function newBuyer()
    {
        $marketplace_id = 1;


        $url = "https://api.zoop.ws/v1/marketplaces/$marketplace_id/buyers";

        $response = $this->client->request('POST', $url, [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->api_token
            ],

            "first_name" => "Fabiano",
            "last_name" => "Cruz",
            "taxpayer_id" => "63488360024",
            "description" => "Customer for jack@example.com",
            "email" => "fabiano@example.com"

        ]);

        return $response;
    }

    public function newCardToken()
    {
        $url = "https://api.zoop.ws/v1/marketplaces/3249465a7753536b62545a6a684b0000/cards/tokens";

        $response = $this->client->request('POST', $url, [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->api_token
            ],

            "holder_name" => "João Silva",
            "expiration_month" => "03",
            "expiration_year" => "2018",
            "security_code" => "123",
            "card_number" => "5201561050024014"


        ]);

        return $response;

    }

    public function newCard($token)
    {
        $url = "https://api.zoop.ws/v1/marketplaces/3249465a7753536b62545a6a684b0000/transactions";

        $response = $this->client->request('POST', $url, [

            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => $this->api_token
            ],

            "amount" => 100,
            "currency" => "BRL",
            "description" => "venda",
            "on_behalf_of" => "5715c67929994f919a21f1323e407e11",
            "token" => "d2b6a1c55d32473b904d9c287e1cafc5",
            "payment_type" => "credit",
            "installment_plan" => [
                "mode" => "interest_free",
                "number_installments" => 6
            ]
        ]);

        return $response;



    }


    public function newCreditCard($data)
    {
        $cardExists = $this->cardExists($data['number']);

        if(!$cardExists)
        {
            if($this->creditCardRepository->create($data))
            {
                return true;
            }
        }

        return false;
    }

    /*
     * Verifica se o cartão de crédito já existe
     */
    public function cardExists($number)
    {
        $card = $this->creditCardRepository->findByField('number', $number);

        if(count($card) > 0)
        {
            return true;
        }

        return false;
    }
}



