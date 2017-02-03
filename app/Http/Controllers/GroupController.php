<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Person;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps;
    /**
     * @var GroupRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(GroupRepository $repository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, PersonRepository $personRepository)
    {

        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
    }
    /**
     * Exibe todos os grupos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::withTrashed()->get();

        foreach ($groups as $group)
        {
            $group->sinceOf = $this->formatDateView($group->sinceOf);
            $countMembers[] = count($group->people->all());
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        return view('groups.index', compact('groups', 'countPerson', 'countMembers', 'countGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        return view('groups.create', compact('countPerson', 'countGroups', 'state', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('img');

        $data = $request->except(['img']);

        $data['sinceOf'] = $this->formatDateBD($data['sinceOf']);

        $data['owner_id'] = \Auth::getUser()->id;

        $id = $this->repository->create($data)->id;

        $this->imgProfile($file, $id, $data['name']);

        return redirect()->route('group.index');
    }

    public function imgProfile($file, $id, $name)
    {
        $imgName = 'uploads/group/' . $id . '-' . $name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/group', $imgName);

        DB::table('groups')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        //$request->session()->flash('updateUser', 'Alterações realizadas com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = $this->repository->find($id);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        //endereço formatado para api do google maps
        $location = $this->formatGoogleMaps($group);

        $people = $group->people->all();

        //dd($people[0]->user->email);

        return view('groups.show', compact('group', 'countPerson', 'countGroups', 'location', 'people'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->repository->find($id);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        //endereço formatado para api do google maps
        $location = $this->formatGoogleMaps($group);

        //listagem de todos os membros do grupo
        $members = $group->people->all();

        $arr = [];

        foreach ($members as $item)
        {
            $arr[] = $item->id;
        }

        //Listagem de todas as pessoas que não pertencem ao grupo
        $people = $this->personRepository->findWhereNotIn('id', $arr);

        $roles = $this->roleRepository->all();

        $state = $this->stateRepository->all();

        $group->sinceOf = $this->formatDateView($group->sinceOf);

        return view('groups.edit', compact('group', 'countPerson', 'countGroups', 'location', 'people', 'roles', 'state', 'members'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('img');

        $data = $request->except(['img']);

        $data['sinceOf'] = $this->formatDateBD($data['sinceOf']);

        $this->repository->update($data, $id);

        if ($file){
            $this->imgProfile($file, $id, $data['name']);
        }

        return redirect()->route('group.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return redirect()->route('group.index');
    }

    public function addMembers(Request $request, $group)
    {
        $arr = [];
        $i = 0;

        $gr = $this->repository->find($group);

        foreach ($request->all() as $item) {
            $arr[] = $item;

            if($i > 0){
                $gr->people()->attach($arr[$i]);
            }

            $i++;
        }


        return redirect()->route('group.edit', ['id' => $group]);
    }

    public function deleteMember($group, $member)
    {
        $gr = $this->repository->find($group);

        $gr->people()->detach($member);

        \Session::flash('group.deleteMember', 'Usuário excluido com sucesso');

        return redirect()->route('group.edit', ['id' => $group]);
    }
}
