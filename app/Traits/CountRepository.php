<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/01/2017
 * Time: 17:21
 */

namespace App\Traits;


use App\Models\Group;
use Illuminate\Support\Facades\DB;

trait CountRepository
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

        $countVisitors = count(DB::table('visitors')
            ->where('deleted_at', null)
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

    public function countGroups()
    {
        $all = count(Group::withTrashed()->get());

        $active = count(DB::table('groups')
            ->where('deleted_at', null)->get());


        $inactive = count(DB::table('groups')
            ->where('deleted_at', '<>', null)->get());

        $qtde[] = $all;
        $qtde[] = $active;
        $qtde[] = $inactive;


        return $qtde;
    }
}