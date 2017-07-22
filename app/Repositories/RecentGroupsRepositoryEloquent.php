<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\recent_groupsRepository;
use App\Models\RecentGroups;
use App\Validators\RecentGroupsValidator;

/**
 * Class RecentGroupsRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RecentGroupsRepositoryEloquent extends BaseRepository implements RecentGroupsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RecentGroups::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
