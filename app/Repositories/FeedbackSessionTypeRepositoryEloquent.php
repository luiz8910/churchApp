<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FeedbackSessionTypeRepository;
use App\Models\FeedbackSessionType;
use App\Validators\FeedbackSessionTypeValidator;

/**
 * Class FeedbackSessionTypeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FeedbackSessionTypeRepositoryEloquent extends BaseRepository implements FeedbackSessionTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FeedbackSessionType::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
