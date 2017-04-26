<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ChurchRepository;
use App\Models\Church;
use App\Validators\ChurchValidator;

/**
 * Class ChurchRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ChurchRepositoryEloquent extends BaseRepository implements ChurchRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Church::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
