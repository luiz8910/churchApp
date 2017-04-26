<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ResponsibleRepository;
use App\Models\Responsible;
use App\Validators\ResponsibleValidator;

/**
 * Class ResponsibleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ResponsibleRepositoryEloquent extends BaseRepository implements ResponsibleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Responsible::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
