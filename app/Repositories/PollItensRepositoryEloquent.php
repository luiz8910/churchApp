<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Poll_ItensRepository;
use App\Models\PollItens;
use App\Validators\PollItensValidator;

/**
 * Class PollItensRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PollItensRepositoryEloquent extends BaseRepository implements PollItensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PollItens::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
