<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CreditCard extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'person_id', 'card_token', 'status', 'type', 'lastDigits', 'expirationDate', 'brandId'
    ];

    protected $dates = ['deleted_at'];

}
