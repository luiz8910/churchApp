<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 06/04/2017
 * Time: 18:20
 */

namespace App\Services;


use App\Models\Event;

class GroupServices
{

    public function listGroupEvents($group, $church_id)
    {
        $events = Event::select('id', 'name')
            ->where(
            [
                'group_id' => $group,
                'church_id' => $church_id
            ]
        )->get();


        return $events;
    }
}