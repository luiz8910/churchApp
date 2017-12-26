<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Person;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\RoleRepository;
use App\Traits\ConfigTrait;
use App\Traits\DateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Scout\Engines\AlgoliaEngine;

class SearchController extends Controller
{
    use ConfigTrait, DateRepository;


    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {

        $this->roleRepository = $roleRepository;
    }

    public function findNewPeople($input)
    {
        $church_id = $this->getUserChurch();

        $people = DB::table('people')
                    ->where(
                        [
                            ['name', 'like', $input.'%'],
                            ['church_id', '=', $church_id],
                            ['deleted_at', '=', null]
                        ]
                    )
                    ->get();


        if(count($people) > 0)
        {
            $arr = [];

            foreach ($people as $person)
            {
                $arr[] = $person->imgProfile;
                $arr[] = $person->name . " " . $person->lastName;
                $arr[] = $person->id;
            }

            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }

    /**
     * @param $input
     * @param $status
     * @return string
     */
    public function searchPerson($input, $status)
    {
        $church_id = $this->getUserChurch();

        $symbol = $status == 'inactive' ? '<>' : '=';

        $fullName = explode(" ", $input);

        $table = $status == 'visitor' ? 'visitors' : 'people';

        $url = env('APP_URL');

        $route = str_replace($url, "", url()->previous());

        $tag = $route == 'teen' ? '<>' : '=';

        if(count($fullName) > 1)
        {

            if($table == 'visitors')
            {
                $people = DB::table($table)
                    ->where(
                        [
                            ['name', 'like', '%'.$fullName[0].'%'],
                            ['lastName', 'like', $fullName[1].'%'],
                            ['deleted_at', $symbol, null]
                        ]
                    )
                    ->limit(5)
                    ->orderBy('name', 'desc')
                    ->get();
            }else{
                if($status == 'inactive')
                {
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$fullName[0].'%'],
                                ['lastName', 'like', $fullName[1].'%'],
                                ['church_id', '=', $church_id],
                                ['deleted_at', $symbol, null]
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }else{
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$fullName[0].'%'],
                                ['lastName', 'like', $fullName[1].'%'],
                                ['church_id', '=', $church_id],
                                ['tag', $tag, 'adult'],
                                ['deleted_at', $symbol, null]
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }

            }

        }
        else{

            if($table == "visitors")
            {
                $people = DB::table($table)
                    ->where(
                        [
                            ['name', 'like', '%'.$input.'%'],
                            ['deleted_at', $symbol, null]
                        ]
                    )
                    ->limit(5)
                    ->orderBy('name', 'desc')
                    ->get();
            }
            else{
                if($status == "inactive")
                {
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$input.'%'],
                                ['church_id', '=', $church_id],
                                ['deleted_at', $symbol, null]
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }
                else{
                    $people = DB::table($table)
                        ->where(
                            [
                                ['name', 'like', '%'.$input.'%'],
                                ['church_id', '=', $church_id],
                                ['tag', $tag, 'adult'],
                                ['deleted_at', $symbol, null]
                            ]
                        )
                        ->limit(5)
                        ->orderBy('name', 'desc')
                        ->get();
                }

            }

        }



        if(count($people) > 0)
        {
            $arr = [];

            if($status == "inactive")
            {
                foreach ($people as $person)
                {
                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->id;
                }
            }
            elseif($status == "people")
            {
                foreach ($people as $person)
                {
                    $person->role = $this->roleRepository->find($person->role_id)->name;
                    $person->dateBirth = $this->formatDateView($person->dateBirth);
                    $person->cpf = $person->cpf ? $person->cpf : '';

                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->cpf;
                    $arr[] = $person->role;
                    $arr[] = $person->dateBirth;
                    $arr[] = $person->id;

                }
            }
            else{

                foreach($people as $person)
                {
                    $person->dateBirth = $this->formatDateView($person->dateBirth);
                    $person->cpf = $person->cpf ? $person->cpf : '';

                    $arr[] = $person->imgProfile;
                    $arr[] = $person->name . " " . $person->lastName;
                    $arr[] = $person->cpf;
                    $arr[] = $person->dateBirth;
                    $arr[] = $person->id;
                }
            }


            return json_encode([
                'status' => true,
                'data' => $arr
            ]);
        }

        return json_encode(['status' => false]);
    }
}
