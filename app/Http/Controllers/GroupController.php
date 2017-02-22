<?php

namespace App\Http\Controllers;


use App\Models\Group;
use App\Models\User;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\GroupRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserLoginRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository;
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

    /**
     * GroupController constructor.
     * @param GroupRepository $repository
     * @param StateRepository $stateRepository
     * @param RoleRepository $roleRepository
     * @param PersonRepository $personRepository
     */
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

        //Endereço do grupo formatado para api do google maps
        $location = $this->formatGoogleMaps($group);

        //Listagem de todos os membros do grupo
        $members = $group->people->all();

        $address = [];

        $arr = [];

        foreach ($members as $item)
        {
            //Separando a id de cada membro do grupo num array
            $arr[] = $item->id;

            //Separando o endereço formatado para a api do google maps
            //de cada membro do grupo num array
            $address[] = $this->formatGoogleMaps($item);
        }

        $quantitySingleMother = '';
        $quantitySingleFather = '';
        $quantitySingleWomen = '';
        $quantitySingleMen = '';
        $quantityMarriedWomenNoKids = '';
        $quantityMarriedMenNoKids = '';

        //Quantidade de todas as mulheres solteiras com filhos que pertencem ao grupo
        $quantitySingleMother = $this->quantitySingleMother($arr);

        //Quantidade de todos os homens solteiros com filhos que pertencem ao grupo
        $quantitySingleFather = $this->quantitySingleMen($arr);

        //Quantidade de todas as mulheres solteiras e adultas
        $quantitySingleWomen = $this->quantitySingleWomen($arr);

        //Quantidade de todos os homens solteiros e adultos
        $quantitySingleMen = $this->quantitySingleMen($arr);

        //Quantidade de mulheres casadas sem filhos
        $quantityMarriedWomenNoKids = $this->quantityMarriedWomenNoKids($arr);

        //Quantidade de homens casados sem filhos
        $quantityMarriedMenNoKids = $this->quantityMarriedMenNoKids($arr);

        //Quantidade de homens com parceira fora da igreja
        $quantityMarriedWomenOutsideChurch = $this->quantityMarriedWomenOutsideChurch($arr);

        //Quantidade de mulheres com parceiro fora da igreja
        $quantityMarriedMenOutsideChurch = $this->quantityMarriedMenOutsideChurch($arr);

        //Listagem de todas as pessoas que não pertencem ao grupo
        $people = $this->personRepository->findWhereNotIn('id', $arr);

        $roles = $this->roleRepository->all();

        $state = $this->stateRepository->all();

        $group->sinceOf = $this->formatDateView($group->sinceOf);

        return view('groups.edit', compact('group', 'countPerson', 'countGroups', 'address', 'location',
            'people', 'roles', 'state', 'members', 'quantitySingleMother', 'quantitySingleFather', 'quantitySingleWomen',
            'quantitySingleMen', 'quantityMarriedWomenNoKids', 'quantityMarriedMenNoKids',
            'quantityMarriedWomenOutsideChurch', 'quantityMarriedMenOutsideChurch'));
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

    public function newMemberToGroup(Request $request, $group)
    {
        $user = $this->personRepository->create($request->except('email'));

        $user->groups()->attach($group);

        $email = $request->only('email');

        $email = implode('=>', $email);

        $this->createUserLogin($user->id, $email);

        \Session::flash('group.deleteMember', 'Usuário criado com sucesso');

        return redirect()->route('group.edit', ['id' => $group]);
    }

    /**
     * Quantidade de todas as mulheres solteiras com filhos que pertencem ao grupo
     * @param $members
     * @return int
     */
    public function quantitySingleMother($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && $person->hasKids && $person->maritalStatus == 'Solteiro')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleWomen($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && !$person->hasKids &&
                $person->maritalStatus == 'Solteiro' && $person->tag == 'adult')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleMen($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && !$person->hasKids &&
                $person->maritalStatus == 'Solteiro' && $person->tag == 'adult')
            {
                $qty++;
            }
        }

        return $qty;
    }

    /**
     * @param $members
     * @return int
     */
    public function quantitySingleFather($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && $person->hasKids && $person->maritalStatus == 'Solteiro')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedWomenNoKids($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && !$person->hasKids && $person->maritalStatus == 'Casado')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedMenNoKids($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && !$person->hasKids && $person->maritalStatus == 'Casado')
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedMenOutsideChurch($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'M' && $person->maritalStatus == 'Casado' && $person->partner == 0)
            {
                $qty++;
            }
        }

        return $qty;
    }

    public function quantityMarriedWomenOutsideChurch($members)
    {
        $qty = 0;

        foreach ($members as $member)
        {
            $person = $this->personRepository->find($member);

            if($person->gender == 'F' && $person->maritalStatus == 'Casado' && $person->partner == 0)
            {
                $qty++;
            }
        }

        return $qty;
    }
}
