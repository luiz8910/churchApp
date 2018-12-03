<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Sponsor.
 *
 * @package namespace App\Models;
 */
class Sponsor extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo', 'description', 'category_id', 'site', 'tel', 'email', 'zipCode',
        'street', 'number', 'neighborhood', 'city', 'state'];

    protected $dates = ['deleted_at'];
}
