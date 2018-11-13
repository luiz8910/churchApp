<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\exhibitors_categoriesRepository;
use App\Models\ExhibitorsCategories;
use App\Validators\ExhibitorsCategoriesValidator;

/**
 * Class ExhibitorsCategoriesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ExhibitorsCategoriesRepositoryEloquent extends BaseRepository implements ExhibitorsCategoriesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExhibitorsCategories::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
