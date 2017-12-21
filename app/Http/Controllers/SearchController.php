<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Person;
use App\Models\User;
use App\Models\Visitor;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Engines\AlgoliaEngine;

class SearchController extends Controller
{
    use ConfigTrait;
    /**
     * @var Event
     */
    private $event;
    /**
     * @var Person
     */
    private $person;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Group
     */
    private $group;

    public function __construct(Event $event, Person $person, User $user, Group $group)
    {
        $this->event = $event;
        $this->person = $person;
        $this->user = $user;
        $this->group = $group;
    }

    public function search($text)
    {
        $event = $this->event->search($text)->get();

        if(count($event) > 0)
        {
            return $event;
        }

        else{
            $person = $this->person->search($text)->get();

            if (count($person) > 0)
            {
                return $person;
            }

            else{
                $group = $this->group->search($text)->get();

                if(count($group) > 0)
                {
                    return $group;
                }
            }
        }

        return false;
    }

    public function searchEvents($text)
    {
        return $this->event->search($text)->get();
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

    public function searchPerson($input, $status)
    {
        $church_id = $this->getUserChurch();

        $symbol = $status == 'inactive' ? '<>' : '=';

        $fullName = explode(" ", $input);

        if(count($fullName) > 1)
        {

            $people = DB::table('people')
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
        }
        else{
            $people = DB::table('people')
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
}
