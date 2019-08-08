<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FeedbackSession.
 *
 * @package namespace App\Models;
 */
class FeedbackSession extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_feedback', 'rating', 'comment', 'person_id', 'session_id'
    ];

}
