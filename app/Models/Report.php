<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Report extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [];

    protected $dates = ['deleted_at'];

}
