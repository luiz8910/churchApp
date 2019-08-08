<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SessionLikesRepository;
use App\Models\SessionLikes;
use App\Validators\SessionLikesValidator;

/**
 * Class SessionLikesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SessionLikesRepositoryEloquent extends BaseRepository implements SessionLikesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SessionLikes::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
