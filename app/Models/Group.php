<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Group extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'name', 'frequency', 'sinceOf', 'imgProfile', 'active', 'owner_id',
        'street', 'neighborhood', 'city', 'zipCode', 'state'
    ];

    protected $dates = ['deleted_at'];

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

}
