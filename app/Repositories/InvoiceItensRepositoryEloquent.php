<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InvoiceItensRepository;
use App\Models\InvoiceItens;
use App\Validators\InvoiceItensValidator;

/**
 * Class InvoiceItensRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InvoiceItensRepositoryEloquent extends BaseRepository implements InvoiceItensRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InvoiceItens::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
