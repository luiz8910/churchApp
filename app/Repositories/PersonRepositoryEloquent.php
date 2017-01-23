<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PersonRepository;
use App\Models\Person;

/**
 * Class PersonRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PersonRepositoryEloquent extends BaseRepository implements PersonRepository
{
    use DateRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Person::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    /**
     * Listagem de pessoas que possuem mais de 18 anos
     *
     * @param $person
     * @return array
     */
    public function legalAge($person)
    {
        $adults = [];

        $today = date("Y-m-d");

        foreach ($person as $item){

            $date = DB::select("SELECT DATEDIFF('$today', '$item->dateBirth')/365 AS DiffDate");

            if ((int)$date[0]->DiffDate >= 18)
            {
                $item->dateBirth = $this->formatDateView($item->dateBirth);
                array_push($adults, $item);
            }

        }

        return $adults;
    }

    public function teen($person)
    {
        $teenagers = [];

        $today = date("Y-m-d");

        foreach ($person as $item){

            $date = DB::select("SELECT DATEDIFF('$today', '$item->dateBirth')/365 AS DiffDate");

            if ((int)$date[0]->DiffDate < 18)
            {
                $item->dateBirth = $this->formatDateView($item->dateBirth);
                array_push($teenagers, $item);
            }

        }

        return $teenagers;
    }

    public function tag($dateBirth)
    {
        $today = date("Y-m-d");

        $date = DB::select("SELECT DATEDIFF('$today', '$dateBirth')/365 AS DiffDate");

        $date = (int)$date[0]->DiffDate;

        return $date < 18 ? $date < 11 ? 'kid' : 'teen' : 'adult';
    }
}
