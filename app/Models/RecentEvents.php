<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RecentEvents extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'event_id', 'church_id'
    ];

    public function group()
    {
        return $this->hasOne(Event::class);
    }

    public function church()
    {
        return $this->hasOne(Church::class);
    }

}
