<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Event extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'createdBy_id', 'eventDate', 'group_id', 'description',
        'endEventDate', 'startTime', 'endTime', 'frequency', 'day', 'allDay',
        'street', 'neighborhood', 'city', 'zipCode', 'state'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

}
