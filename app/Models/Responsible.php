<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Responsible extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'name', 'lastName', 'email', 'tel', 'role_id', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'street', 'neighborhood', 'city', 'zipCode',
        'state', 'number', 'person_id'
    ];

    protected $dates = ['deleted_at'];

    public function churches()
    {
        return $this->belongsToMany(Church::class);
    }

}
