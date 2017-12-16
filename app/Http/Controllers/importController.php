<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Repositories\ImportRepository;
use App\Repositories\PersonRepository;
use App\Repositories\VisitorRepository;
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
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;

    public function __construct(ImportRepository $repository, PersonRepository $personRepository, VisitorRepository $visitorRepository)
    {
        $this->repository = $repository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
    }

    public function rollbackLast($table)
    {
        $church = $this->getUserChurch();

        $last = DB::table('imports')->where(
            [
                'church_id' => $church,
                'table' => $table

            ])->orderBy('created_at', 'desc')->first();

        $visitors = $this->visitorRepository->findByField('import_code', $last->code);

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

                $qtdeVis = $this->rollbackLastVisitors($visitors);

                $total = count($people) + $qtdeVis;
                
                \Session::flash('rollback.message', ' ' .  $total . ' usuários foram removidos');
            }else{

                if(count($visitors) > 0)
                {
                    $qtdeVis = $this->rollbackLastVisitors($visitors);

                    \Session::flash('rollback.message', ' ' .  $qtdeVis . ' usuários foram removidos');
                }
                else{
                    \Session::flash('rollback.message', ' Não há usuários para remover');
                }

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

    public function rollbackLastVisitors($visitors)
    {
        if(count($visitors) > 0)
        {
            foreach ($visitors as $visitor)
            {
                if($visitor->user)
                {
                    $visitor->users->delete();
                }

                $visitor->delete();
            }

            $this->removeInactiveVisitor($visitors);

        }

        return count($visitors);
    }

    public function removeInactiveVisitor($array)
    {
        foreach($array as $item)
        {
            $visitor = $this->visitorRepository->find($item->id);

            $user = $visitor->users->first();

            if($user){
                $user->forceDelete();
            }

            $visitor->forceDelete();
        }

    }
}
