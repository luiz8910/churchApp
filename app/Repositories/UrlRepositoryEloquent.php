<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UrlRepository;
use App\Models\Url;
use App\Validators\UrlValidator;

/**
 * Class UrlRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UrlRepositoryEloquent extends BaseRepository implements UrlRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Url::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
