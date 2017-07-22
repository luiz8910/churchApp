<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\recent_usersRepository;
use App\Models\RecentUsers;
use App\Validators\RecentUsersValidator;

/**
 * Class RecentUsersRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RecentUsersRepositoryEloquent extends BaseRepository implements RecentUsersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RecentUsers::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
