<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Poll.
 *
 * @package namespace App\Models;
 */
class Poll extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'event_id', 'church_id', 'created_by', 'deleted_by', 'expires_in',
        'expires_in_time', 'status', 'session_id', 'content', 'order', 'deleted_at'];


    protected $dates = ['deleted_at'];



}
