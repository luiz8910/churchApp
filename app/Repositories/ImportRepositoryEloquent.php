<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\importRepository;
use App\Models\Import;
use App\Validators\ImportValidator;

/**
 * Class ImportRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ImportRepositoryEloquent extends BaseRepository implements ImportRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Import::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
