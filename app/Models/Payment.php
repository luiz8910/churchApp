<?php

namespace App\Models;

use App\Traits\ConfigTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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


    public function __construct()
    {

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

    public function planStore($arr)
    {
        $login = $this->login();

        $api = $this->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan_url = $this->plan();

        $stop = false;

        while(!$stop)
        {
            $planCode = $this->genPayuCode();

            $result = DB::table('plans')->where('payu_code', $planCode)->first();

            if(count($result) == 0)
            {
                $stop = true;
            }
        }

        $trial = $this->trialDays();

        $data = (object) $arr;

        try {
            $response = $client->request('POST', $env . $plan_url,
                [
                    'json' => [

                        "accountId" => $this->merchantExample(),
                        "planCode" => $planCode,
                        "description" => $data->description,
                        "interval" => $data->type_id == 1 ? "MONTH" : "YEAR",
                        "intervalCount" => "1",
                        "maxPaymentsAllowed" => $data->type_id == 1 ? "12" : "1",
                        "paymentAttemptsDelay" => "1",
                        "maxPaymentAttempts" => "3",
                        "maxPendingPayments" => 1,
                        "trialDays" => $trial,
                        "additionalValues" => [
                            [
                                "name" => "PLAN_VALUE",
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
        $login = $this->login();

        $api = $this->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan = $this->plan();

        try {

            $response = $client->request('GET', $env . $plan . $code);

            $result = json_decode($response->getBody());

            return $result;

        } catch (GuzzleException $e) {
            dd($e);
        }
    }

    public function planUpdate($arr, $planCode)
    {
        $login = $this->login();

        $api = $this->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan_url = $this->plan();

        $data = (object) $arr;

        try {
            $response = $client->request('PUT', $env . $plan_url . $planCode,
                [
                    'json' => [

                        "description" => $data->description,
                        "maxPaymentAttempts" => "3",
                        "maxPendingPayments" => 1,
                        "paymentAttemptsDelay" => "1",
                        "additionalValues" => [
                            [
                                "name" => "PLAN_VALUE",
                                "value" => $data->price,
                                "currency" => "BRL"
                            ]
                        ]

                    ]
                ]);

            if($response->getStatusCode() == 200)
            {
                return true;
            }



        } catch (GuzzleException $e) {
            dd($e);
        }
    }

    public function planDelete($code)
    {
        $login = $this->login();

        $api = $this->api();

        $credentials = base64_encode($login . ":" . $api);

        $env = $this->prod();

        if(env('APP_ENV') == 'local'){
            $env = $this->sandbox();
        }

        $client = new Client(['headers' => [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Accept-language' => 'pt',
            //'Content-Length' => 'length',
            'Authorization' => "Basic " . $credentials,
            'HOST' => $env,

        ]]);

        $plan = $this->plan();

        try {

            $response = $client->request('DELETE', $env . $plan . $code);

            return true;

            /*$result = json_decode($response->getBody());

            return $result;*/

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
