<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Church extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'name', 'responsible_id', 'email', 'tel', 'cnpj',
        'street', 'neighborhood', 'city', 'zipCode', 'state',
        'number', 'alias', 'plan_id', 'status', 'password'
    ];

    protected $dates = ['deleted_at'];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class);
    }

    public function responsibles()
    {
        return $this->belongsToMany(Responsible::class);
    }

}
