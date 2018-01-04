<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FeedRepository;
use App\Models\Feed;
use App\Validators\FeedValidator;

/**
 * Class FeedRepositoryEloquent
 * @package namespace App\Repositories;
 */
class FeedRepositoryEloquent extends BaseRepository implements FeedRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Feed::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
