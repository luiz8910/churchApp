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
        $verify = [];

        foreach($user->notifications as $notification)
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


        return $notify;
    }
}