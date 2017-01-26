<?php

namespace App\Http\Controllers;

use App\Repositories\CountPersonRepository;
use App\Repositories\DateRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use DateRepository, CountPersonRepository, FormatGoogleMaps;
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

    public function __construct(GroupRepository $repository, StateRepository $stateRepository, RoleRepository $roleRepository)
    {

        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
    }
    /**
     * Exibe todos os grupos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = $this->repository->all();

        foreach ($groups as $group)
        {
            $group->sinceOf = $this->formatDateView($group->sinceOf);
            $countMembers[] = count($group->people->all());
        }

        $countPerson[] = $this->countPerson();

        $countGroups = $this->countGroups();

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

        $countGroups = $this->countGroups();

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

        $data['active'] = 1;

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

        $countGroups = $this->countGroups();

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

        $countGroups = $this->countGroups();

        $location = $this->formatGoogleMaps($group);

        $people = $group->people->all();

        $roles = $this->roleRepository->all();

        $state = $this->stateRepository->all();

        $group->sinceOf = $this->formatDateView($group->sinceOf);

        return view('groups.edit', compact('group', 'countPerson', 'countGroups', 'location', 'people', 'roles', 'state'));
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

        $data['active'] = 1;

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
        //
    }
}
