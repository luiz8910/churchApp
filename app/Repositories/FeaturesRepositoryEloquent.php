<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\featuresRepository;
use App\Models\Features;
use App\Validators\FeaturesValidator;

/**
 * Class FeaturesRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FeaturesRepositoryEloquent extends BaseRepository implements FeaturesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Features::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
