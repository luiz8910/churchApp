<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Responsible extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name', 'lastName', 'email', 'tel', 'role_id', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'street', 'neighborhood', 'city', 'zipCode', 'state', 'number'
    ];

    public function churches()
    {
        return $this->belongsToMany(Church::class);
    }

}
