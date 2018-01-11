<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Models\Visitor;
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

    //public function removeInactive($array)
    public function removeInactive($code)
    {

        $people = Person::onlyTrashed()
            ->where('import_code', $code)
            ->get();

        //dd($people);

        if(count($people) > 0)
        {
            foreach ($people as $item)
            {
                $user = User::onlyTrashed()->where('person_id', $item->id)->first();

                if($user != null)
                {
                    $user->forceDelete();
                }

                $item->forceDelete();
            }
        }

        /*foreach ($array as $item) {

            $person = Person::onlyTrashed()
                ->where('id', $item->id)
                ->first();

            $user = User::onlyTrashed()->where('person_id', $item->id)->first();

            if($user)
            {
                $user->forceDelete();
            }

            $person->forceDelete();
        }*/
    }

    public function rollbackLastVisitors($code)
    {
        $people = Person::onlyTrashed()
            ->where('import_code', $code)
            ->get();

        //dd($people);

        foreach ($people as $item)
        {
            $user = User::onlyTrashed()->where('person_id', $item->id)->first();

            if($user != null)
            {
                $user->forceDelete();
            }

            $item->forceDelete();
        }
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

    //public function removeInactiveVisitor($array)
    public function removeInactiveVisitor($code)
    {
        $visitors = Visitor::onlyTrashed()->where('import_code', $code)->get();

        if(count($visitors) > 0){
            foreach($visitors as $item)
            {
                $user = $item->users()->onlyTrashed()->first();

                //dd($user);

                if($user != null){
                    $user->forceDelete();
                }

                $item->forceDelete();
            }
        }


    }

    public function rollback($code)
    {
        try{
            $members = $this->personRepository->findByField('import_code', $code);

            if(count($members) > 0) {
                foreach ($members as $member)
                {
                    $user = $member->user;

                    if ($user) {
                        $member->user->delete();
                    }

                    $member->delete();
                }

                $this->removeInactive($code);
            }


            $visitors = $this->visitorRepository->findByField('import_code', $code);

            if(count($visitors) > 0) {
                foreach ($visitors as $visitor)
                {
                    $user = $visitor->users->first();

                    if ($user) {
                        $user->delete();
                    }

                    $visitor->delete();
                }

                $this->removeInactiveVisitor($code);
            }

            $total = count($members) + count($visitors);

            DB::commit();

            \Session::flash('rollback.message', ' ' .  $total . ' usuários foram removidos');

            return json_encode(['status' => true]);

        }catch(\Exception $e){
            DB::rollback();

            return json_encode([
                'status' => false,
                'error' => $e->getMessage() . ' ' . $e->getTrace()
            ]);
        }

    }
}
