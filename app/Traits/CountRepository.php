<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 21/01/2017
 * Time: 17:21
 */

namespace App\Traits;


use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait CountRepository
{


    public function countPerson()
    {
        $church = session('church') ? session('church') : Auth::user()->church_id;

        $countAdults = count(DB::table('people')
            ->where(

                [
                    ['role_id', '<>', 3],
                    'tag' => 'adult',
                    'deleted_at' => null,
                    'church_id' => $church
                ])
            ->get());

        $countTeens = count(DB::table('people')
            ->where([
                ['role_id', '<>', 3],
                    ['tag', '<>', 'adult'],
                    'deleted_at' => null,
                    'church_id' => $church
                ])
            ->get());

        $countVisitors = count(DB::table('people')
            ->where(
                [
                    'deleted_at' => null,
                    'church_id' => $church,
                    'role_id' => 3
                ])
            ->get());

        $countInactive = count(DB::table('people')
            ->where([
                ['deleted_at', '<>', null],
                ['status', '<>', 'deleted'],
                'church_id' => $church
            ])
            ->get());


        $qtde[] = $countAdults;
        $qtde[] = $countTeens;
        $qtde[] = $countVisitors;
        $qtde[] = $countInactive;

        return $qtde;
    }

    public function countGroups()
    {
        $church = session('church') ? session('church') : Auth::user()->church_id;

        $all = count(Group::withTrashed()->get());

        $active = count(DB::table('groups')
            ->where([
                'deleted_at' => null,
                'church_id' => $church
            ])->get());


        $inactive = count(DB::table('groups')
            ->where('deleted_at', '<>', null)->get());

        $qtde[] = $all;
        $qtde[] = $active;
        $qtde[] = $inactive;


        return $qtde;
    }
}