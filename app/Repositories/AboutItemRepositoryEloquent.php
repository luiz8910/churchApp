<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\About_ItemRepository;
use App\Models\AboutItem;
use App\Validators\AboutItemValidator;

/**
 * Class AboutItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AboutItemRepositoryEloquent extends BaseRepository implements AboutItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AboutItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
