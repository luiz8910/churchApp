<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ContactSiteRepository;
use App\Models\ContactSite;
use App\Validators\ContactSiteValidator;

/**
 * Class ContactSiteRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContactSiteRepositoryEloquent extends BaseRepository implements ContactSiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactSite::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
