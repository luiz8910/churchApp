<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\email_invoiceRepository;
use App\Models\EmailInvoice;
use App\Validators\EmailInvoiceValidator;

/**
 * Class EmailInvoiceRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmailInvoiceRepositoryEloquent extends BaseRepository implements EmailInvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailInvoice::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
