<?php

namespace App\Services;

use App\Traits\FormatGoogleMaps;

class ApiServices
{

    use FormatGoogleMaps;


    public function __construct()
    {

    }


    public function getCoords($event)
    {


        $local = $this->formatAPI($event);


        $location = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$local.'&key=AIzaSyCjTs0nbQbEecUygnKpThLfzRKES8nKS0A';


        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );


        $json = file_get_contents($location, false, stream_context_create($arrContextOptions));


        $obj = json_decode($json);


        if($obj->status == 'OK')
        {
            $obj->results[0]->geometry->location->event_id = $event->id;

            $obj->results[0]->geometry->location->startTime = $event->startTime;

            $obj->results[0]->geometry->location->endTime = $event->endTime;

            $lat = $obj->results[0]->geometry->location->lat;

            $lng = $obj->results[0]->geometry->location->lng;

            $lat = number_format($lat, 3, '.', ',');

            $lng = number_format($lng, 3, '.', ',');

            $obj->results[0]->geometry->location->lat = $lat;

            $obj->results[0]->geometry->location->lng = $lng;

            return $obj->results[0]->geometry->location;

        }

        return false;
    }
}