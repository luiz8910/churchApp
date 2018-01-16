<?php
/**
 * Created by PhpStorm.
 * User: Luiz
 * Date: 06/04/2017
 * Time: 18:20
 */

namespace App\Services;


use App\Models\Event;
use App\Models\RecentGroups;
use App\Repositories\GroupRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupServices
{
    /**
     * @var GroupRepository
     */
    private $repository;

    public function __construct(GroupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listGroupEvents($group, $church_id)
    {
        $events = Event::select('id', 'name')
            ->where(
            [
                'group_id' => $group,
                'church_id' => $church_id
            ]
        )->get();


        return $events;
    }

    public function newRecentGroup($id, $church_id)
    {
        RecentGroups::insert([
            'group_id' => $id,
            'church_id' => $church_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function getListSubGroup($group)
    {
        return DB::table('group_person')
            ->where([
                'group_id' => $group,
                'deleted_at' => null
            ])
            ->get();
    }
}