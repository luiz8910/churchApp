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



