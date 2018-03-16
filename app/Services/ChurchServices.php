<?php

namespace App\Services;


class ChurchServices{

    public function __construct()
    {
        
    }

    public function setChurchAlias($name)
    {
        $array = explode(" ", $name);

        $alias = '';

        foreach ($array as $item) {

            $alias .= substr($item, 0, 1);
        }

        return $alias;
    }
}