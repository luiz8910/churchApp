<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EventSubscribedList extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id', 'person_id', 'sub_by', 'church_id', 'visitor_id', 'notification_activity',
        'notification_updates'
    ];

    //protected $dates = ['deleted_at'];

}
