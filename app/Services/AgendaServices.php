<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 23/03/2017
 * Time: 14:09
 */

namespace App\Services;


class AgendaServices
{
    public function findWeek($week = null)
    {
        $i = 1;

        $today = date_create(date("Y-m-d"));

        $today_number = date('N');

        $days = [];

        if($week == "next")
        {
            date_add($today, date_interval_create_from_date_string("7 days"));
        }
        elseif($week == "prev"){
            date_add($today, date_interval_create_from_date_string("-7 days"));
        }
        elseif ($week == "2"){
            date_add($today, date_interval_create_from_date_string("14 days"));
        }
        elseif ($week){
            $x = $week * 7;
            date_add($today, date_interval_create_from_date_string($x . " days"));
        }


        if($today_number > 1)
        {
            while ($i <= $today_number)
            {
                $num = $today_number - $i;
                $days[] = date_format(date_add($today, date_interval_create_from_date_string("-".$num. " days")), "Y-m-d");
                $i++;
                $today = date_create(date("Y-m-d"));
                if($week == "next")
                {
                    date_add($today, date_interval_create_from_date_string("7 days"));
                }
                elseif($week == "prev"){
                    date_add($today, date_interval_create_from_date_string("-7 days"));
                }
                elseif ($week == "2"){
                    date_add($today, date_interval_create_from_date_string("14 days"));
                }
                elseif ($week){
                    $x = $week * 7;
                    date_add($today, date_interval_create_from_date_string($x . " days"));
                }
            }
        }
        else{
            $days[] = date_format($today, "Y-m-d");
        }


        if($today_number < 7)
        {
            $i = $today_number;

            while ($i < 7)
            {
                $i++;
                $num = $i - $today_number;
                $days[] = date_format(date_add($today, date_interval_create_from_date_string($num . " days")), "Y-m-d");
                $today = date_create(date("Y-m-d"));

                if($week == "next")
                {
                    date_add($today, date_interval_create_from_date_string("7 days"));
                }
                elseif($week == "prev"){
                    date_add($today, date_interval_create_from_date_string("-7 days"));
                }
                elseif ($week == "2"){
                    date_add($today, date_interval_create_from_date_string("14 days"));
                }
                elseif ($week){
                    $x = $week * 7;
                    date_add($today, date_interval_create_from_date_string($x . " days"));
                }
            }
        }


        return $days;
    }

    public function findMonth($month, $week = null)
    {
        $i = 1;

        $today = date_create(date("Y-m-d"));

        $today_number = date('N');

        $days = [];

        if($month == 1)
        {
            $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("21 days"));
        }
        else{
            $x = 21 * $month;

            $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string($x . " days"));
        }

        if($week == "next")
        {
            date_add($today, date_interval_create_from_date_string("7 days"));
        }
        elseif($week == "prev"){
            date_add($today, date_interval_create_from_date_string("-7 days"));
        }
        elseif ($week == "2 weeks"){
            date_add($today, date_interval_create_from_date_string("14 days"));
        }



        if($today_number > 1)
        {
            while ($i <= $today_number)
            {
                $num = $today_number - $i;
                $days[] = date_format(date_add($today, date_interval_create_from_date_string("-".$num. " days")), "Y-m-d");
                $i++;

                if($month == 1)
                {
                    $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("21 days"));
                }
                else{
                    $x = 21 * $month;
                    $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string($x . " days"));
                }

                if($week == "next")
                {
                    date_add($today, date_interval_create_from_date_string("7 days"));
                }
                elseif($week == "prev"){
                    date_add($today, date_interval_create_from_date_string("-7 days"));
                }
                elseif ($week == "2 weeks"){
                    date_add($today, date_interval_create_from_date_string("14 days"));
                }
            }
        }
        else{
            $days[] = date_format($today, "Y-m-d");
        }

        if($today_number < 7)
        {
            $i = $today_number;

            while ($i < 7)
            {
                $i++;
                $num = $i - $today_number;
                $days[] = date_format(date_add($today, date_interval_create_from_date_string($num . " days")), "Y-m-d");

                if($month == 1)
                {
                    $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string("21 days"));
                }
                else{
                    $x = 21 * $month;
                    $today = date_add(date_create(date("Y-m-d")), date_interval_create_from_date_string($x . " days"));
                }

                if($week == "next")
                {
                    date_add($today, date_interval_create_from_date_string("7 days"));
                }
                elseif($week == "prev"){
                    date_add($today, date_interval_create_from_date_string("-7 days"));
                }
                elseif ($week == "2 weeks"){
                    date_add($today, date_interval_create_from_date_string("14 days"));
                }
            }
        }


        return $days;

    }

    public function thisMonth()
    {
        return date("n");
    }

    public function allMonths()
    {
        $month[] = "";
        $month[] = "Janeiro";
        $month[] = "Fevereiro";
        $month[] = "Março";
        $month[] = "Abril";
        $month[] = "Maio";
        $month[] = "Junho";
        $month[] = "Julho";
        $month[] = "Agosto";
        $month[] = "Setembro";
        $month[] = "Outubro";
        $month[] = "Novembro";
        $month[] = "Dezembro";
        $month[] = "Janeiro";

        return $month;
    }

    public function allDaysName()
    {
        $days[] = '';
        $days[] = "Segunda-Feira";
        $days[] = "Terça-Feira";
        $days[] = "Quarta-Feira";
        $days[] = "Quinta-Feira";
        $days[] = "Sexta-Feira";
        $days[] = "Sábado";
        $days[] = "Domingo";

        return $days;
    }

    public function nextWeek()
    {
        $today = date_create();

        $add = 8 - date('N');

        date_add($today, date_interval_create_from_date_string($add . ' days'));

        return $today;

    }
}