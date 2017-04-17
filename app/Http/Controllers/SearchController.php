<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Group;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Scout\Engines\AlgoliaEngine;

class SearchController extends Controller
{
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
}
