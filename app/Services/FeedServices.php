<?php
/**
 * Created by PhpStorm.
 * User: luizfernandosanches
 * Date: 03/01/18
 * Time: 01:15
 */

namespace App\Services;


use App\Repositories\FeedRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FeedServices
{
    use ConfigTrait;
    /**
     * @var FeedRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(FeedRepository $repository, PersonRepository $personRepositoryTrait)
    {
        $this->repository = $repository;
        $this->personRepository = $personRepositoryTrait;
    }

    public function newFeed($notif_range, $model, $model_id, $text)
    {
        $data['church_id'] = $this->getUserChurch();
        $data['notification_range'] = $notif_range;
        $data['model'] = $model;
        $data['model_id'] = $model_id;
        $data['text'] = $text;
        $data['show'] = 1;

        $id = $this->repository->create($data)->id;

        switch ($notif_range){
            case 1: $this->publicFeed($id); break;

            case 2: $this->groupFeed($id); break;

            case 3: $this->leaderFeed($id); break;

            case 4: $this->adminFeed($id); break;
        }
    }

    public function publicFeed($id)
    {

    }

    public function groupFeed($id)
    {

    }

    public function leaderFeed($id)
    {
        $church_id = $this->getUserChurch();

        $role_leader = $this->getLeaderRoleId();

        $leaders = $this->personRepository->findWhere([
            'church_id' => $church_id,
            'role_id' => $role_leader
        ]);

        if(count($leaders) > 0){
            foreach ($leaders as $leader) {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $leader->id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }


        $this->adminFeed($id);
    }

    public function adminFeed($id)
    {
        $church_id = $this->getUserChurch();

        $role_admin = $this->getAdminRoleId();

        $admins = $this->personRepository->findWhere([
            'church_id' => $church_id,
            'role_id' => $role_admin
        ]);

        if(count($admins) > 0){
            foreach ($admins as $admin) {
                DB::table('feeds_user')
                    ->insert([
                        'person_id' => $admin->id,
                        'feed_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
            }
        }

    }
}