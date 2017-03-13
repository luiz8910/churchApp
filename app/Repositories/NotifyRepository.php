<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 13/03/2017
 * Time: 17:41
 */

namespace App\Repositories;


trait NotifyRepository
{
    public function notify()
    {
        $user = \Auth::getUser();

        $notify = [];

        foreach($user->notifications as $notification)
        {
            $notify[] = $notification->data;
        }

        return $notify;
    }
}