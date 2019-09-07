<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Speaker.
 *
 * @package namespace App\Models;
 */
class Speaker extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'photo', 'description', 'category_id', 'site', 'tel', 'email', 'zipCode',
        'street', 'number', 'neighborhood', 'city', 'state', 'event_id', 'company', 'country'];

}
