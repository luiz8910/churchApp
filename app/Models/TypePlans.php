<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TypePlans extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['type', 'selected_text', 'adjective', 'save_money'];

}
