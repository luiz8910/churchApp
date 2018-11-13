<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\exhibitorsRepository;
use App\Models\Exhibitors;
use App\Validators\ExhibitorsValidator;

/**
 * Class ExhibitorsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExhibitorsRepositoryEloquent extends BaseRepository implements ExhibitorsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Exhibitors::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
