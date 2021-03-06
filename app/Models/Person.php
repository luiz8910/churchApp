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
        'name', 'email', 'church_id', 'tel', 'cel', 'role_id', 'imgProfile', 'gender',
        'dateBirth', 'cpf', 'rg', 'maritalStatus', 'partner', 'father_id', 'mother_id','mailing',
        'hasKids', 'tag', 'description', 'street', 'neighborhood', 'city', 'zipCode', 'state', 'number',
        'import_code', 'deleted_at', 'status', 'terms', 'visibility', 'qrCode'
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

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function recent_user()
    {
        return $this->belongsTo(RecentUsers::class);
    }
}
