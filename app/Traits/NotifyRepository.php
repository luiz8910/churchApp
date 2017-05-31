<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 13/03/2017
 * Time: 17:41
 */

namespace App\Traits;


trait NotifyRepository
{
    public function notify()
    {
        $user = \Auth::getUser();

        $notify = [];
        $verify = [];

        foreach($user->unreadNotifications as $notification)
        {
            if(count($notify) > 0)
            {
                if(!in_array($notification->data, $verify))
                {
                    $notify[] = $notification;
                    $verify[] = $notification->data;
                }
            }else{
                $notify[] = $notification;
                $verify[] = $notification->data;
            }

        }

        $notify = array_key_exists(0, $notify) ? $notify : null;

        return $notify;
    }
}