<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FeaturesItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['text', 'feature_id', 'icon_id'];

}
