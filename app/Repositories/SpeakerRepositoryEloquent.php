<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SpeakerRepository;
use App\Models\Speaker;
use App\Validators\SpeakerValidator;

/**
 * Class SpeakerRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SpeakerRepositoryEloquent extends BaseRepository implements SpeakerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Speaker::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
