<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SessionRepository;
use App\Models\Session;
use App\Validators\SessionValidator;

/**
 * Class SessionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SessionRepositoryEloquent extends BaseRepository implements SessionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Session::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
