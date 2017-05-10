<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Church extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name', 'responsible_id', 'email', 'telefone', 'cnpj',
        'street', 'neighborhood', 'city', 'zipCode', 'state'
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
