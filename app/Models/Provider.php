<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Provider.
 *
 * @package namespace App\Models;
 */
class Provider extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo', 'description', 'category_id', 'site', 'tel', 'email', 'zipCode',
        'street', 'number', 'neighborhood', 'city', 'state', 'event_id'];

}
