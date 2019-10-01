<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\url_itensRepository;
use App\Models\UrlItens;
use App\Validators\UrlItensValidator;

/**
 * Class UrlItensRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UrlItensRepositoryEloquent extends BaseRepository implements UrlItensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UrlItens::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
