<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\recent_eventsRepository;
use App\Models\RecentEvents;
use App\Validators\RecentEventsValidator;

/**
 * Class RecentEventsRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RecentEventsRepositoryEloquent extends BaseRepository implements RecentEventsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RecentEvents::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
