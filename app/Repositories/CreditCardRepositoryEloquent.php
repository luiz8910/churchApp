<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CreditCardRepository;
use App\Models\CreditCard;
use App\Validators\CreditCardValidator;

/**
 * Class CreditCardRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CreditCardRepositoryEloquent extends BaseRepository implements CreditCardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CreditCard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
