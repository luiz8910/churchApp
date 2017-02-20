<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Person extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'name', 'lastName', 'email', 'church_id', 'tel', 'cel', 'role_id', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'maritalStatus', 'father_id', 'mother_id','mailing',
        'hasKids', 'tag', 'specialNeeds', 'street', 'neighborhood', 'city', 'zipCode', 'state'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
