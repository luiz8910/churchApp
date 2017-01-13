<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PersonRepository;
use App\Models\Person;
use App\Validators\PersonValidator;

/**
 * Class PersonRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PersonRepositoryEloquent extends BaseRepository implements PersonRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Person::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
