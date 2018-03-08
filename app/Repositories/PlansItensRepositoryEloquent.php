<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\plansItensRepository;
use App\Models\PlansItens;
use App\Validators\PlansItensValidator;

/**
 * Class PlansItensRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PlansItensRepositoryEloquent extends BaseRepository implements PlansItensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlansItens::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
