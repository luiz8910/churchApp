<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RecentGroups extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'group_id', 'church_id'
    ];

    public function group()
    {
        return $this->hasOne(Group::class);
    }

    public function church()
    {
        return $this->hasOne(Church::class);
    }

}
