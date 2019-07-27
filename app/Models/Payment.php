<?php

namespace App\Models;

use App\Traits\ConfigTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Payment.
 *
 * @package namespace App\Models;
 */
class Payment extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, ConfigTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['transactionId', 'metaId', 'status', 'antiFraude_success',
        'antiFraude_validator', 'antiFraude_score', 'antiFraude_recommendation',
        'person_id', 'event_id', 'church_id'];

    protected $dates = ['deleted_at'];


}
