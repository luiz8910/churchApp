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
        'owner_id', 'person_name', 'number', 'expires_in', 'cvc', 'company'
    ];

    protected $dates = ['deleted_at'];

}
