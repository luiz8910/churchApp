<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FrequencyRepository;
use App\Models\Frequency;
use App\Validators\FrequencyValidator;

/**
 * Class FrequencyRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FrequencyRepositoryEloquent extends BaseRepository implements FrequencyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Frequency::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
