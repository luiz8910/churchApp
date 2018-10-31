<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Repositories\PaymentRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var PaymentRepository
     */
    private $repository;
    private $pay;


    //Controller Apenas de Teste
    public function __construct(PaymentRepository $repository)
    {

        $this->repository = $repository;

        $this->pay = new Payment();

        $plan_url = $this->pay->plan();
    }

    public function cardDelete($customer_id, $token)
    {
        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = $this->pay->customers();

        try{

            $response = $client->request('DELETE', $env . $customer . $customer_id . '/creditCards/' . $token);

            echo $response->getBody();

        }catch (GuzzleException $e){
            dd($e);
        }
    }

    public function cardUpdate($token)
    {
        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $card = $this->pay->card();

        try{

            $response = $client->request('PUT', $env . $card . $token,
                [

                    'json' => [

                        "name" => "Luiz Francisco Giovanni Pinto",
                        "document" => "1020304050",
                        "expMonth" => "01",
                        "expYear" => "2019",
                        "address" => [
                            "line1" => "Endereço",
                            "line2" => "17 25",
                            "line3" => "Of 301",
                            "postalCode" => "00000",
                            "city" => "Sorocaba",
                            "state" => "SP",
                            "country" => "BR",
                            "phone" => "300300300"
                        ]
                    ]
                ]);

            echo $response->getBody();

        }catch (GuzzleException $e){
            dd($e);
        }
    }

    public function cardGet($token)
    {
        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $card = $this->pay->card();

        try{

            $response = $client->request('GET', $env . $card . $token);

            echo $response->getBody();

        }catch (GuzzleException $e){
            dd($e);
        }
    }

    public function cardStore($customer_id)
    {
        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = $this->pay->customers();

        try {

            $response = $client->request('POST', $env . $customer . $customer_id . '/creditCards',
                [
                    'json' => [

                       "name" => "Nome Teste",
                       "document" => "1020304051",
                       "number" => "4716609311469873",
                       "expMonth" => "12",
                       "expYear" => "2022",
                       "type" => "VISA",
                       "address" => [
                          "line1" => "Address Name",
                          "line2" => "17 25",
                          "line3" => "Of 301",
                          "postalCode" => "00000",
                          "city" => "City Name",
                          "state" => "State Name",
                          "country" => "BR",
                          "phone" => "300300300"
                        ]

                    ]
                ]);

            echo $response->getBody();

        } catch (GuzzleException $e) {
            dd($e);
        }
    }

    public function customerDelete($id)
    {

        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = $this->pay->customers();

        try{

            $response = $client->request('DELETE', $env . $customer . $id);

            echo $response->getBody();

        }catch (GuzzleException $e){
            dd($e);
        }
    }


    public function customerStore()
    {
        $pay = new Payment();

        $env = $pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $pay->sandbox();
        }

        $login = "pRRXKOl8ikMmt9u";

        $api = "4Vj8eK4rloUd272L48hsrarnUA";

        $string = $login . ':' . $api;

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = 'rest/v4.3/customers/';


        try {
            $response = $client->request('POST', $env . $customer,

                ['json' => [

                    "fullName" => "Carla Andreia Francisca Farias",
                    "email" => "carlaandreiafranciscafarias-86@gmail.com"

                ]

                ]);

        } catch (GuzzleException $e) {
            dd($e);
        }

        echo "<br><br>";

        echo ( $response->getBody());


    }

    /*
     * Exemplo de retorno
     *
     * +"id": "57a19317-65c2-4f9f-ab2d-862868797583"
      +"planCode": "teste-plan-004"
      +"description": "Sample Plan 004"
      +"accountId": "512327"
      +"intervalCount": 1
      +"interval": "MONTH"
      +"maxPaymentsAllowed": 12
      +"maxPaymentAttempts": 0
      +"paymentAttemptsDelay": 1
      +"maxPendingPayments": 0
      +"trialDays": 0
      +"additionalValues": array:3 [▼
         0 => {#775 ▼
          +"name": "PLAN_TAX_RETURN_BASE"
          +"value": 0
          +"currency": "BRL"
        }
         1 => {#762 ▼
          +"name": "PLAN_VALUE"
          +"value": 500
          +"currency": "BRL"
        }
         2 => {#771 ▼
          +"name": "PLAN_TAX"
          +"value": 0
          +"currency": "BRL"
        }
      ]
}
     */
    public function planGet($code)
    {
        $login = $this->pay->login();

        $api = $this->pay->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->pay->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->pay->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan = $this->pay->plan();

        try {

            $response = $client->request('GET', $env . $plan . $code);

            $result = json_decode($response->getBody());

            dd ($result);

            echo '<br><br>';


        } catch (GuzzleException $e) {
            dd($e);
        }
    }

    public function planStore()
    {
        $login = $this->pay->login();

        $api = $this->pay->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->pay->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->pay->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan = $this->pay->plan();

        try {

            $response = $client->request('POST', $env . $plan,
                [
                    'json' => [

                        "accountId" => $this->pay->merchantExample(),
                        "planCode" => "teste-plan-004",
                        "description" => "Sample Plan 004",
                        "interval" => "MONTH",
                        "intervalCount" => "1",
                        "maxPaymentsAllowed" => "12",
                        "paymentAttemptsDelay" => "1",
                        "additionalValues" => [
                            [
                                "name" => "PLAN_VALUE",
                                "value" => "500",
                                "currency" => "BRL"
                            ],
                            [
                                "name" => "PLAN_TAX",
                                "value" => "0",
                                "currency" => "BRL"
                            ],
                            [
                                "name" => "PLAN_TAX_RETURN_BASE",
                                "value" => "0",
                                "currency" => "BRL"
                            ]
                        ]

                    ]
                ]);

            echo $response->getStatusCode();

            echo '<br><br>';

            echo $response->getBody();

            } catch (GuzzleException $e) {
                dd($e);
        }
    }


    public function customerUpdate($id)
    {
        $env = $this->pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $this->pay->sandbox();
        }

        $string = $this->pay->login() . ':' . $this->pay->api();

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = $this->pay->customers();

        try {
            $response = $client->request('PUT', $env . $customer . $id,

                ['json' => [

                    "fullName" => "Carla Andreia Francisca Farias",
                    "email" => "carla_farias@gmail.com.br"

                ]

                ]);

        } catch (GuzzleException $e) {
            dd($e);
        }

        echo "<br><br>";

        echo ( $response->getBody());
    }


    public function customerGet($id)
    {
        $pay = new Payment();

        $env = $pay->prod();

        if (env('APP_ENV') == 'local') {
            $env = $pay->sandbox();
        }

        $login = "pRRXKOl8ikMmt9u";

        $api = "4Vj8eK4rloUd272L48hsrarnUA";

        $string = $login . ':' . $api;

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'es',
            //'Content-Length' => '1000',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);


        $customer = $pay->customers();

        try {
            $response = $client->request('GET', $env . $customer . $id);

        } catch (GuzzleException $e) {
            dd($e);
        }



        echo ( $response->getBody());
    }


    public function teste()
    {

        $json = [
            [
                "test" => false,
                "language" => "en",
                "command" => "GET_PAYMENT_METHODS",
                "merchant" => [
                    "apiLogin" => "pRRXKOl8ikMmt9u",
                    "apiKey" => "4Vj8eK4rloUd272L48hsrarnUA"
                ]
            ],

            [
                "language" => "es",
                "command" => "SUBMIT_TRANSACTION",
                "merchant" => [
                    "apiLogin" => "pRRXKOl8ikMmt9u",
                    "apiKey" => "4Vj8eK4rloUd272L48hsrarnUA"
                ]
            ],
            [
                "transaction" => [
                    "order" => [
                        "accountId" => "512326",
                        "referenceCode" => "testPanama1",
                        "description" => "Test order Panama",
                        "language" => "en",
                        "notifyUrl" => "http ://pruebaslap.xtrweb.com/lap/pruebconf.php",
                        "signature" => "a2de78b35599986d28e9cd8d9048c45d",
                        "shippingAddress" => [
                            "country" => "PA"
                        ],
                        "buyer" => [
                            "fullName" => "APPROVED",
                            "emailAddress" => "test@payulatam.com",
                            "dniNumber" => "1155255887",
                            "shippingAddress" => [
                                "street1" => "Calle 93 B 17 – 25",
                                "city" => "Panama",
                                "state" => "Panama",
                                "country" => "PA",
                                "postalCode" => "000000",
                                "phone" => "5582254"
                            ]
                        ],
                        "additionalValues" => [
                            "TX_VALUE" => [
                                "value" => 5,
                                "currency" => "USD"
                            ]
                        ]
                    ],
                    "creditCard" => [
                        "number" => "4111111111111111",
                        "securityCode" => "123",
                        "expirationDate" => "2018/08",
                        "name" => "test"
                    ],
                    "type" => "AUTHORIZATION_AND_CAPTURE",
                    "paymentMethod" => "VISA",
                    "paymentCountry" => "PA",
                    "payer" => [
                        "fullName" => "APPROVED",
                        "emailAddress" => "test@payulatam.com"
                    ],
                    "ipAddress" => "127.0.0.1",
                    "cookie" => "cookie_52278879710130",
                    "userAgent" => "Firefox",
                    "extraParameters" => [
                        "INSTALLMENTS_NUMBER" => 1,
                        "RESPONSE_URL" => "http://www.misitioweb.com/respuesta.php"
                    ]
                ],
                "test" => true

            ]
        ];

        $array =
            [
                "test" => true,
                "language" => "es",
                "command" => "SUBMIT_TRANSACTION",
                "merchant" => [
                    "apiLogin" => "pRRXKOl8ikMmt9u",
                    "apiKey" => "4Vj8eK4rloUd272L48hsrarnUA"
                ],

                "transaction" => [
                    "order" => [
                        "accountId" => "512326",
                        "referenceCode" => "testPanama1", //Problema aqui
                        "description" => "Test order Panama",
                        "language" => "en",
                        "notifyUrl" => "http ://pruebaslap.xtrweb.com/lap/pruebconf.php",
                        "signature" => "a2de78b35599986d28e9cd8d9048c45d",
                        "shippingAddress" => [
                            "country" => "PA"
                        ],
                        "buyer" => [
                            "fullName" => "APPROVED",
                            "emailAddress" => "test@payulatam.com",
                            "dniNumber" => "1155255887",
                            "shippingAddress" => [
                                "street1" => "Calle 93 B 17 – 25",
                                "city" => "Panama",
                                "state" => "Panama",
                                "country" => "PA",
                                "postalCode" => "000000",
                                "phone" => "5582254"
                            ]
                        ],
                        "additionalValues" => [
                            "TX_VALUE" => [
                                "value" => 5,
                                "currency" => "USD"
                            ]
                        ]
                    ],
                    "creditCard" => [
                        "number" => "4111111111111111",
                        "securityCode" => "123",
                        "expirationDate" => "2019/03",
                        "name" => "test"
                    ],
                    "type" => "AUTHORIZATION_AND_CAPTURE",
                    "paymentMethod" => "VISA",
                    "paymentCountry" => "PA",
                    "payer" => [
                        "fullName" => "APPROVED",
                        "emailAddress" => "test@payulatam.com"
                    ],
                    "ipAddress" => "127.0.0.1",
                    "cookie" => "cookie_52278879710130",
                    "userAgent" => "Firefox",
                    "extraParameters" => [
                        "INSTALLMENTS_NUMBER" => 1,
                        "RESPONSE_URL" => "http://www.misitioweb.com/respuesta.php"
                    ]
                ],

            ];

        //dd($array);

        $pay = new Payment();

        $login = $pay->getLoginApi();

        $api = $pay->getApi();

        $string = $login . ':' . $api;

        $credentials = base64_encode($string);

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => "Basic " . $credentials

        ]]);

        $url = 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi';


        try {
            $response = $client->request('POST', $url, ['json' => $array]);

        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }

        //print_r( $response->getHeader('Content-Type') );

        echo($response->getBody());

    }


    public function rascunho()
    {

        $client = new Client();


        $url = 'https://api.payulatam.com/reports-api/4.0/service.cgi';


        /*$res = $client->request('GET', 'https://api.github.com/user', [
             'auth' => ['luiz.sanches8910@gmail.com', 'senha']
         ]);*/

        //echo $res->getStatusCode();

        //print_r( $res->getHeader('content-type') );
    }


}
