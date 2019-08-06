<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProviderCategoryRepository;
use App\Models\ProviderCategory;
use App\Validators\ProviderCategoryValidator;

/**
 * Class ProviderCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProviderCategoryRepositoryEloquent extends BaseRepository implements ProviderCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProviderCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
