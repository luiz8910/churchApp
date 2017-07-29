<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RegisterModelsRepository;
use App\Models\RegisterModels;
use App\Validators\RegisterModelsValidator;

/**
 * Class RegisterModelsRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RegisterModelsRepositoryEloquent extends BaseRepository implements RegisterModelsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RegisterModels::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
