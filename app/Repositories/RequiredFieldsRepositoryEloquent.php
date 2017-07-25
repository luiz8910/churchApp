<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RequiredFieldsRepository;
use App\Models\RequiredFields;
use App\Validators\RequiredFieldsValidator;

/**
 * Class RequiredFieldsRepositoryEloquent
 * @package namespace App\Repositories;
 */
class RequiredFieldsRepositoryEloquent extends BaseRepository implements RequiredFieldsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RequiredFields::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
