<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BugRepository;
use App\Models\Bug;
use App\Validators\BugValidator;

/**
 * Class BugRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BugRepositoryEloquent extends BaseRepository implements BugRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bug::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
