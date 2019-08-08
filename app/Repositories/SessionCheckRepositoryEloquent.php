<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SessionCheckRepository;
use App\Models\SessionCheck;
use App\Validators\SessionCheckValidator;

/**
 * Class SessionCheckRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SessionCheckRepositoryEloquent extends BaseRepository implements SessionCheckRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SessionCheck::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
