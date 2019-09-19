<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\invoiceRepository;
use App\Models\Invoice;
use App\Validators\InvoiceValidator;

/**
 * Class InvoiceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class InvoiceRepositoryEloquent extends BaseRepository implements InvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Invoice::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
