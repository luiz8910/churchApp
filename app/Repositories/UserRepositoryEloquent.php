<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserRepository;
use App\Models\User;

/**
 * Class UserRepositoryEloquent
 * @package namespace App\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function changePassword($request)
    {
        $pass = \Auth::user()->password;

        $id = \Auth::user()->id;

        if (\Hash::check($request->old, $pass))
        {
            $new = bcrypt($request->new);

            DB::table('users')->
                where('id', $id)->
                update(['password' => $new]);

            return true;
        }

        return false;
    }
}
