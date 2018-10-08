<?php

namespace App\Models;

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
    use TransformableTrait, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $dates = ['deleted_at'];

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
        

}
