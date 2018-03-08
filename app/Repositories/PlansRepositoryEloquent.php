<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PlansRepository;
use App\Models\Plans;
use App\Validators\PlansValidator;

/**
 * Class PlansRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlansRepositoryEloquent extends BaseRepository implements PlansRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plans::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
