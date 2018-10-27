<?php

namespace App\Models;

use App\Repositories\PlansRepository;
use App\Traits\ConfigTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Payment.
 *
 * @package namespace App\Models;
 */
class Payment extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, ConfigTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $dates = ['deleted_at'];
    /**
     * @var PlansRepository
     */
    private $plansRepository;


    public function __construct()
    {
        $this->plansRepository = PlansRepository::class;
    }

    public function plan()
    {
        return 'rest/v4.3/plans/';
    }

    public function customers()
    {
        return 'rest/v4.3/customers/';
    }

    public function sandbox()
    {
        return 'https://sandbox.api.payulatam.com/payments-api/';
    }

    public function prod()
    {
        return 'https://api.payulatam.com/payments-api/';
    }

    public function getApi()
    {
        return env('PAY_U_API_KEY');
    }

    public function getLoginApi()
    {
        return env('PAY_U_LOGIN_KEY');
    }

    public function merchantId()
    {
        return env('PAY_U_MERCHANT_ID');
    }


    public function login()
    {
        return 'pRRXKOl8ikMmt9u';
    }

    public function api()
    {
        return '4Vj8eK4rloUd272L48hsrarnUA';
    }

    public function card()
    {
        return 'rest/v4.3/creditCards/';
    }

    public function merchantExample()
    {
        return '512327';
    }

    public function planStore($data)
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

        $plan_url = $this->pay->plan();

        $stop = false;

        while(!$stop)
        {
            $planCode = $this->genPayuCode();

            $result = $this->plansRepository->findByField('payu_code', $planCode)->first();

            if(count($result) == 0)
            {
                $stop = true;
            }
        }

        $trial = $this->trialDays();

        try {

            $response = $client->request('POST', $env . $plan_url,
                [
                    'json' => [

                        "accountId" => $this->pay->merchantExample(),
                        "planCode" => $planCode,
                        "description" => $data->description,
                        "interval" => $data->frequency == 1 ? "MONTH" : "YEAR",
                        "intervalCount" => "1",
                        "maxPaymentsAllowed" => $data->frequency == 1 ? "12" : "1",
                        "paymentAttemptsDelay" => "1",
                        "maxPaymentAttempts" => "3",
                        "maxPendingPayments" => 1,
                        "trialDays" => $trial,
                        "additionalValues" => [
                            [
                                "name" => $data->name,
                                "value" => $data->price,
                                "currency" => "BRL"
                            ]
                        ]

                    ]
                ]);

            if($response->getStatusCode() == 200 || $response->getStatusCode() == 201)
            {
                $result = json_decode($response->getBody());

                return $result->planCode;
            }
            

        } catch (GuzzleException $e) {
            dd($e);
        }
    }

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

            echo $response->getBody();

        } catch (GuzzleException $e) {
            dd($e);
        }
    }


    /*
     * Geração do Código do Plano na Payu
     */
    public function genPayuCode()
    {

        return random_int(100000, 999999);

    }
        

}
