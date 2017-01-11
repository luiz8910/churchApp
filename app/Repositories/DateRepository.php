<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/12/2016
 * Time: 13:03
 */

namespace App\Repositories;


trait DateRepository
{
    public function formatDateBD($date)
    {
        $dia = substr($date, 0, 2);

        $mes = substr($date, 3, 2);

        $ano = substr($date, 6);

        return $ano.'-'.$mes.'-'.$dia;
    }

    public function formatDateView($date)
    {
        // 2005-10-5

        $ano = substr($date, 0, 4);

        $mes = substr($date, 5, 2);

        $dia = substr($date, 8);

        return $dia.'/'.$mes.'/'.$ano;
    }
}