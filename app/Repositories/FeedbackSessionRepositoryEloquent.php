<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FeedbackSessionRepository;
use App\Models\FeedbackSession;
use App\Validators\FeedbackSessionValidator;

/**
 * Class FeedbackSessionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FeedbackSessionRepositoryEloquent extends BaseRepository implements FeedbackSessionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FeedbackSession::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
