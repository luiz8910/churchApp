<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/01/2017
 * Time: 17:21
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

trait CountPersonRepository
{
    public function countPerson()
    {
        $countAdults = count(DB::table('people')
            ->where('tag', 'adult')
            ->where('deleted_at', null)
            ->get());

        $countTeens = count(DB::table('people')
            ->where('tag', '<>', 'adult')
            ->where('deleted_at', null)
            ->get());

        $countVisitors = count(DB::table('people')
            ->where('role_id', '3')
            ->get());

        $countInactive = count(DB::table('people')
            ->where('deleted_at', '<>', null)
            ->get());


        $qtde[] = $countAdults;
        $qtde[] = $countTeens;
        $qtde[] = $countVisitors;
        $qtde[] = $countInactive;

        return $qtde;
    }
}