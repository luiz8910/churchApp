<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UploadStatusRepository;
use App\Models\UploadStatus;
use App\Validators\UploadStatusValidator;

/**
 * Class UploadStatusRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UploadStatusRepositoryEloquent extends BaseRepository implements UploadStatusRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UploadStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
