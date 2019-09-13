<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\course_descRepository;
use App\Models\CourseDesc;
use App\Validators\CourseDescValidator;

/**
 * Class CourseDescRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CourseDescRepositoryEloquent extends BaseRepository implements CourseDescRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseDesc::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
