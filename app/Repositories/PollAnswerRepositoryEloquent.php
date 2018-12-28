<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PollAnswerRepository;
use App\Models\PollAnswer;
use App\Validators\PollAnswerValidator;

/**
 * Class PollAnswerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PollAnswerRepositoryEloquent extends BaseRepository implements PollAnswerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PollAnswer::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
