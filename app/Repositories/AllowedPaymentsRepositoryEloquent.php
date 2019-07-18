<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AllowedPaymentsRepository;
use App\Models\AllowedPayments;
use App\Validators\AllowedPaymentsValidator;

/**
 * Class AllowedPaymentsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AllowedPaymentsRepositoryEloquent extends BaseRepository implements AllowedPaymentsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AllowedPayments::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
