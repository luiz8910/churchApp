<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PollRepository;
use App\Models\Poll;
use App\Validators\PollValidator;

/**
 * Class PollRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PollRepositoryEloquent extends BaseRepository implements PollRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Poll::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
