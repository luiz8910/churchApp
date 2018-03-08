<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\typePlansRepository;
use App\Models\TypePlans;
use App\Validators\TypePlansValidator;

/**
 * Class TypePlansRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TypePlansRepositoryEloquent extends BaseRepository implements TypePlansRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TypePlans::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
