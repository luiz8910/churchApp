<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Session.
 *
 * @package namespace App\Models;
 */
class Session extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'event_id', 'name', 'max_capacity', 'location', 'start_time',
            'end_time', 'description', 'tag', 'session_date', 'code'
        ];

    protected $dates = ['deleted_at'];

}
