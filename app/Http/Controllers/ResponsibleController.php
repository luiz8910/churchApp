<?php

namespace App\Http\Controllers;

use App\Repositories\ChurchRepository;
use App\Repositories\PersonRepository;
use App\Repositories\ResponsibleRepository;
use App\Repositories\RoleRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\NotifyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Traits\CacheableRepository;

class ResponsibleController extends Controller
{

    use ConfigTrait, NotifyRepository, CountRepository;


    /**
     * @var ResponsibleRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;

    public function __construct(ResponsibleRepository $repository, RoleRepository $roleRepository,
                                PersonRepository $personRepository, ChurchRepository $churchRepository)
    {

        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->churchRepository = $churchRepository;
    }

    public function index()
    {
        $resp = DB::table("responsibles")
            ->where([
                'deleted_at' => null,
                'church_id' => $this->getUserChurch(),
            ])->orderBy('name')->paginate(5);


        foreach ($resp as $item) {
            if($item->dateBirth)
            {
                $item->dateBirth = date_format(date_create($item->dateBirth), 'd/m/Y');
            }


            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $roles = $this->roleRepository->findWhereNotIn('id', [6]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        return view('responsibles.index', compact('resp', 'countPerson', 'countGroups', 'notify', 'qtde',
            'leader', 'admin', 'visitor_id', 'roles'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try{

            $data['church_id'] = $this->getUserChurch();

            $this->repository->create($data);

            DB::commit();

            $request->session()->flash('success.msg', 'Usuário criado com sucesso');

        }catch (\Exception $e)
        {
            DB::rollBack();

            $request->session()->flash('error.msg', 'Um erro ocorreu');
        }

        return redirect()->back();
    }

    /**
     * @param $id
     * @return false|string
     */
    public function getRespData($id)
    {
        $resp = $this->repository->findByField('id', $id)->first();

        if($resp)
        {
            return json_encode([
                'status' => true,
                'abbreviation' => $resp->abbreviation,
                'name' => $resp->name,
                'special_role' => $resp->special_role,
                'role_id' => $resp->role_id
            ]);
        }

        return json_encode(['status' => false, 'msg' => 'Responsável não encontrado']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $resp = $this->repository->findByField('id', $id)->first();

        if($resp)
        {
            try{

                $this->repository->update($data, $id);

                $d['name'] = $data['name'];

                if($resp->person_id)
                {
                    $d['role_id'] = $data['role_id'];

                    $this->personRepository->update($d, $resp->person_id);
                }

                DB::commit();

                $request->session()->flash('success.msg', 'Usuário alterado com sucesso');

                return redirect()->back();

            }catch (\Exception $e)
            {
                DB::rollBack();

                $request->session()->flash('error.msg', 'Um erro ocorreu');

                return redirect()->back();
            }
        }

        $request->session()->flash('error.msg', 'O responsável não existe');

        return redirect()->back();
    }

    public function delete($id)
    {
        $resp = $this->repository->findByField('id', $id)->first();

        if($resp)
        {
            $church = $this->churchRepository->findByField('id', $this->getUserChurch())->first();

            if ($church)
            {
                if($church->responsible_id == $id)
                {
                    return $this->returnFalse('Não é possivel remover o responsável da organização');
                }

                else{

                    try{


                        if(!$resp->person_id)
                        {
                            $this->repository->delete($id);

                            DB::commit();

                            return json_encode(['status' => true]);
                        }


                        return $this->returnFalse('Não é possivel remover o responsável da organização');

                    }catch (\Exception $exception){
                        DB::rollBack();

                        return $this->returnFalse();
                    }

                }
            }
        }

        return $this->returnFalse('Este Responsável não existe');
    }
}
