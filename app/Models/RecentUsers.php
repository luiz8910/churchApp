<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RecentUsers extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'person_id', 'church_id'
    ];

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function church()
    {
        return $this->hasOne(Church::class);
    }

}
