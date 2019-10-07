<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PaymentSlip.
 *
 * @package namespace App\Models;
 */
class PaymentSlip extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'bank', 'due_date', 'bar_code', 'typeable_line', 'our_number', 'daysToExpire', 'event_id', 'url_id'
    ];

}
