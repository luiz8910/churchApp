<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SponsorRepository;
use App\Models\Sponsor;
use App\Validators\SponsorValidator;

/**
 * Class SponsorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SponsorRepositoryEloquent extends BaseRepository implements SponsorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Sponsor::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
