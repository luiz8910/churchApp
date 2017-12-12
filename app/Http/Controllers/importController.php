<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Repositories\ImportRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class importController extends Controller
{
    use ConfigTrait;
    /**
     * @var ImportRepository
     */
    private $repository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(ImportRepository $repository, PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->personRepository = $personRepository;
    }

    public function rollbackLast($table)
    {
        $church = $this->getUserChurch();

        $last = DB::table('imports')->where(
            [
                'church_id' => $church,
                'table' => $table

            ])->orderBy('created_at', 'desc')->first();


        if($table == 'people')
        {
            $people = Person::withTrashed()->where('import_code', $last->code)->get();

            if(count($people) > 0)
            {
                foreach($people as $person)
                {
                    if($person->user)
                    {
                        $person->user->delete();
                    }

                    $person->delete();
                }
                
                $this->removeInactive($people);
                
                \Session::flash('rollback.message', ' ' . count($people) . ' usuários foram removidos');
            }else{

                \Session::flash('rollback.message', ' Não há usuários para remover');
            }

        }

        return redirect()->back();
    }

    public function removeInactive($array)
    {

        foreach ($array as $item) {

            $person = Person::onlyTrashed()
                ->where('id', $item->id)
                ->first();

            $user = User::onlyTrashed()->where('person_id', $item->id)->first();

            if($user)
            {
                $user->forceDelete();
            }

            $person->forceDelete();
        }
    }
}
