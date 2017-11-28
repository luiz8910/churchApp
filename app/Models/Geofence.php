<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Geofence extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id', 'user_id', 'lat', 'long', 'time', 'active'
    ];

}
