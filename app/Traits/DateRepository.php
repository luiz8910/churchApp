<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/12/2016
 * Time: 13:03
 */

namespace App\Traits;


trait DateRepository
{
    public function formatDateBD($date)
    {
        $day = substr($date, 0, 2);

        $month = substr($date, 3, 2);

        $year = substr($date, 6);

        if(checkdate($month, $day, $year))
        {
            return $year.'-'.$month.'-'.$day;
        }

        return null;
    }

    public function formatDateView($date)
    {
        // 2005-10-5

        $year = substr($date, 0, 4);

        $month = substr($date, 5, 2);

        $day = substr($date, 8, 2);

        return $day.'/'.$month.'/'.$year;
    }

    public function formatReport($date)
    {
        $month = substr($date, 5, 2);

        $day = substr($date, 8, 2);

        return $day.'/'.$month;
    }
}