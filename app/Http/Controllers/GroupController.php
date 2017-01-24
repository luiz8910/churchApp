<?php

namespace App\Http\Controllers;

use App\Repositories\CountPersonRepository;
use App\Repositories\DateRepository;
use App\Repositories\GroupRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use DateRepository, CountPersonRepository;
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

        $countPerson[] = $this->countPerson();

        return view('groups.index', compact('groups', 'countPerson'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countPerson[] = $this->countPerson();

        $state = $this->stateRepository->all();

        $roles = $this->repository->all();

        return view('groups.create', compact('countPerson', 'state', 'roles'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
