<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Plans extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'type_id', 'most_popular', 'payu_code'];

    protected $dates = ['deleted_at'];
}
