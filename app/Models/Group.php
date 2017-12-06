<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Group extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, Searchable;

    protected $fillable = [
        'name', 'sinceOf', 'imgProfile', 'active', 'owner_id',
        'street', 'neighborhood', 'city', 'zipCode', 'state', 'church_id', 'number'
    ];

    protected $dates = ['deleted_at'];

    public function people()
    {
        return $this->belongsToMany(Person::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function recent_group()
    {
        return $this->hasOne(RecentGroups::class);
    }

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class);
    }

}
