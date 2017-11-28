<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\geofenceRepository;
use App\Models\Geofence;
use App\Validators\GeofenceValidator;

/**
 * Class GeofenceRepositoryEloquent
 * @package namespace App\Repositories;
 */
class GeofenceRepositoryEloquent extends BaseRepository implements GeofenceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Geofence::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
