<?php

namespace App\Models;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Transformable
{
    use TransformableTrait, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'church_id', 'facebook_id',
        'linkedin_id', 'google_id', 'twitter_id', 'person_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function routeNotificationForSlack()
    {
        //return $this->slack_webhook;
        return "https://hooks.slack.com/services/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";
    }


}
