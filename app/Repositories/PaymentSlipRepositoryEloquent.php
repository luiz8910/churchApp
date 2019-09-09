<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PaymentSlipRepository;
use App\Models\PaymentSlip;
use App\Validators\PaymentSlipValidator;

/**
 * Class PaymentSlipRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentSlipRepositoryEloquent extends BaseRepository implements PaymentSlipRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentSlip::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
