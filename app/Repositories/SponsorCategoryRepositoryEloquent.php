<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SponsorCategoryRepository;
use App\Models\SponsorCategory;
use App\Validators\SponsorCategoryValidator;

/**
 * Class SponsorCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SponsorCategoryRepositoryEloquent extends BaseRepository implements SponsorCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SponsorCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
