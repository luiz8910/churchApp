<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EventSubscribedListRepository;
use App\Models\EventSubscribedList;
use App\Validators\EventSubscribedListValidator;

/**
 * Class EventSubscribedListRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EventSubscribedListRepositoryEloquent extends BaseRepository implements EventSubscribedListRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EventSubscribedList::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
