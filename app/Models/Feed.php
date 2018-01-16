<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Feed extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'church_id', 'notification_range', 'model', 'model_id',
        'text', 'icon_id', 'show', 'feed_type', 'expires_in', 'link'
    ];

}
