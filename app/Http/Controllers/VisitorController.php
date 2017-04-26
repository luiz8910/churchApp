<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonCreateRequest;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\VisitorRepository;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    use DateRepository, CountRepository, NotifyRepository, PeopleTrait, UserLoginRepository, FormatGoogleMaps;
    /**
     * @var VisitorRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * VisitorController constructor.
     * @param VisitorRepository $repository
     */
    public function __construct(VisitorRepository $repository, RoleRepository $roleRepository, StateRepository $stateRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = $this->repository->paginate(5);

        foreach ($visitors as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);

        return view('people.visitors', compact('visitors', 'countPerson', 'countGroups', 'notify', 'qtde'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $adults = $this->repository->findWhere(['tag' => 'adult']);

        $notify = $this->notify();

        $qtde = count($notify);

        return view('people.create-visitors', compact('state', 'countPerson', 'countGroups', 'adults', 'notify', 'qtde'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonCreateRequest $request)
    {
        $file = $request->file('img');

        $data = $request->except(['img', '_token']);

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $id = DB::table('visitors')->insertGetId($data);

        $this->updateTag($this->tag($data['dateBirth']), $id, 'visitors');

        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'visitors');
        }

        $church = $request->user()->church_id;

        $visitor = $this->repository->find($id);

        $visitor->churches()->attach($church);

        $this->createUserLogin($id, null, $data['email'], true);

        return redirect()->route('visitors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitors = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $visitors->dateBirth = $this->formatDateView($visitors->dateBirth);

        $location = $this->formatGoogleMaps($visitors);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $gender = $visitors->gender == 'M' ? 'F' : 'M';

        $adults = $this->repository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        $notify = $this->notify();

        $qtde = count($notify);

        return view('visitors.edit', compact('visitors', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'adults', 'notify', 'qtde'));
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
        $data = $request->all();

        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'visitors');
        }

        $this->repository->update($data, $id);

        return redirect()->route('visitors.index');
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

    public function login()
    {
        return view('auth.visitor');
    }
}
