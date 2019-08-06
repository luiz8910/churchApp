<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SpeakerCategoryRepository;
use App\Models\SpeakerCategory;
use App\Validators\SpeakerCategoryValidator;

/**
 * Class SpeakerCategoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SpeakerCategoryRepositoryEloquent extends BaseRepository implements SpeakerCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SpeakerCategory::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
