<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Person extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name', 'lastName', 'email', 'tel', 'cel', 'role', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'fatherName', 'motherName','mailing',
        'hasKids', 'street', 'neighborhood', 'city', 'zipCode', 'state'
    ];

}
