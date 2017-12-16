<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Visitor extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'facebook_id', 'google_id', 'linkedin_id',
        'name', 'lastName', 'email', 'import_code', 'tel', 'cel', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'maritalStatus', 'partner', 'father_id', 'mother_id','mailing',
        'hasKids', 'tag', 'specialNeeds', 'street', 'neighborhood', 'city', 'zipCode', 'state', 'number'
    ];

    protected $dates = ['deleted_at'];

    public function churches()
    {
        return $this->belongsToMany(Church::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

}
