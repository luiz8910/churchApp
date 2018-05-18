<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 25/01/2017
 * Time: 02:25
 */

namespace App\Traits;


trait FormatGoogleMaps
{
    public function formatGoogleMaps($location)
    {
        if ($location->street)
        {
            $place = str_replace(' ', '+', $location->street);

            $place .= '+' . $location->number . '+' . $location->city . '+' . $location->state;

            return $place;
        }
        else{
            return false;
        }
    }


    public function formatAPI($location)
    {

        if($location->street)
        {
            $place = $location->number . '+';

            $place .= str_replace(' ', '+', $location->street);

            $place .= ',+' . $location->city . '+,' . '+' . $location->state;

            return $place;
        }
        else{

            return false;
        }
    }
}