<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Traits\DateRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Group;


class GroupController extends Controller
{

    use DateRepository;


    /**
     * @var GroupRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(GroupRepository $repository, PersonRepository $personRepository)
    {

        $this->repository = $repository;
        $this->personRepository = $personRepository;
    }


    public function groupListApp($church)
    {
        //$groups = Group::withTrashed()->get();

        $groups = Group::select('id', 'name', 'sinceOf')->where('church_id', $church)->get();

        if(count($groups) > 0)
        {
            foreach ($groups as $group)
            {
                $group->sinceOf = $this->formatDateView($group->sinceOf);

                $people = DB::table('group_person')->where('group_id', $group->id)->get();

                $group->members = count($people);
            }

            return json_encode($groups);
        }

        return json_encode(false);

    }


    public function myGroupsApp($person_id)
    {
        $person = $this->personRepository->find($person_id);

        if(count($person->groups) > 0)
        {
            return json_encode([
                'status' => true,
                'groups' => $person->groups
            ]);
        }

        return json_encode(['status' => false]);


    }


    public function groupPeopleApp($group_id)
    {
        $group = $this->repository->find($group_id);

        if(count($group->people) > 0)
        {
            $people = [];

            foreach ($group->people as $item)
            {
                $people[] = $this->personRepository->find($item->id, ['id', 'name', 'lastName', 'imgProfile']);
            }

            return json_encode([
                'status' => true,
                'people' => $people
            ]);
        }

        return json_encode(['status' => false]);
    }

    public function recentGroupsApp($church)
    {
        $groups = DB::table('recent_groups')
            ->select('group_id')
            ->where('church_id', $church)
            ->get();

        if(count($groups) > 0)
        {
            foreach($groups as $group)
            {
                $model = $this->repository->find($group->group_id);

                $group->name = $model->name;

                $group->imgProfile = $model->imgProfile;
            }

            return json_encode([
                'status' => true,
                'groups' => $groups
            ]);
        }

        return json_encode(['status' => false]);

    }


    /*
     * Informações de um grupo específico
     * $id do grupo
     */
    public function getGroupInfo($id)
    {

        try{

            $group = $this->repository->find($id);

            $group->sinceOf = $this->formatDateView($group->sinceOf);

            $people = DB::table('group_person')->where('group_id', $group->id)->get();

            $group->members = count($people);

            return json_encode(['status' => true, 'group' => $group]);


        }
        catch(\Exception $e)
        {
            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

}