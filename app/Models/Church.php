<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Church extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name', 'responsible_id', 'email', 'tel', 'cnpj',
        'street', 'neighborhood', 'city', 'zipCode', 'state',
        'number', 'alias', 'plan_id'
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
