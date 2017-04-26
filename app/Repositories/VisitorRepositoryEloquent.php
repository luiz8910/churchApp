<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VisitorRepository;
use App\Models\Visitor;
use App\Validators\VisitorValidator;

/**
 * Class VisitorRepositoryEloquent
 * @package namespace App\Repositories;
 */
class VisitorRepositoryEloquent extends BaseRepository implements VisitorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Visitor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
