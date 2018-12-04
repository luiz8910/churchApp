<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ExhibitorsController.
 *
 * @package namespace App\Models;
 */
class Exhibitors extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'site', 'tel', 'email', 'zipCode',
        'street', 'number', 'neighborhood', 'city', 'state', 'logo', 'category_id'];

    protected $dates = ['deleted_at'];

}
