<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\FormatGoogleMaps;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserLoginRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository;
    /**
     * @var PersonRepository
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

    public function __construct(PersonRepository $repository, StateRepository $stateRepository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adults = $this->repository->findWhere(['tag' => 'adult']);

        foreach ($adults as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();

        return view('people.index', compact('adults', 'countPerson', 'countGroups'));
    }

    public function teenagers()
    {
        $teen = $this->repository->findWhereNotIn('tag', ['adult']);

        foreach ($teen as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();

        return view('people.teenagers', compact('teen', 'countPerson', 'countGroups'));
    }

    public function visitors()
    {
        $visitors = $this->repository->findWhere(['role_id' => '3']);

        foreach ($visitors as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();

        return view('people.visitors', compact('visitors', 'countPerson', 'countGroups'));
    }

    public function inactive()
    {
        $inactive = Person::onlyTrashed()->get();

        foreach ($inactive as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();

        return view('people.inactive', compact('inactive', 'countPerson', 'countGroups'));
    }

    public function turnActive($id)
    {
        DB::table('people')->
                where('id', $id)->
                update(['deleted_at' => null]);

        return redirect()->route('person.inactive');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $adults = $this->repository->findWhere(['tag' => 'adult']);

        return view('people.create', compact('state', 'roles', 'countPerson', 'countGroups', 'adults'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->get('group-a'));

        $file = $request->file('img');

        $email = $request->only('email');

        $email = implode('=>', $email);

        $data = $request->except(['img', 'email']);

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $children = $request->get('group-a');

        $id = $this->repository->create($data)->id;

        if($this->repository->isAdult($data['dateBirth']))
        {
            $this->createUserLogin($id, $email);

            if($children){
                $this->children($children, $id, $data['gender']);
            }

        }
        else{
            $this->createUserLogin($id);
        }

        $this->tag($this->repository->tag($data['dateBirth']), $id);

        if($file){
            $this->imgProfile($file, $id, $data['name']);
        }


        return redirect()->route('person.index');
    }


    /**
     * Atribui pais aos filhos
     *
     * @param $children
     * @param $id (do pai ou mãe)
     * @param $gender
     */
    public function children($children, $id, $gender)
    {
        foreach ($children as $child)
        {
            //$resp = $this->repository->find($id);

            $data['name'] = $child['childName'];

            $data['lastName'] = $child['childLastName'];

            $data['dateBirth'] = $this->formatDateBD($child['childDateBirth']);

            $data['imgProfile'] = 'uploads/profile/noimage.png';

            if($gender == 'M')
            {
                $data['father_id'] = $id;
            }
            else{
                $data['mother_id'] = $id;
            }

            $data['role_id'] = 2;

            $data['maritalStatus'] = 'Solteiro';

            $idChild = $this->repository->create($data)->id;

            $this->tag($this->repository->tag($data['dateBirth']), $idChild);
        }

        DB::table("people")
            ->where('id', $id)
            ->update(['hasKids' => 'on']);
    }


    /**
     * Insere a imagem de perfil do membro cadastrado
     *
     * @param $file
     * @param $id
     * @param $name
     */
    public function imgProfile($file, $id, $name)
    {
        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        //$request->session()->flash('updateUser', 'Alterações realizadas com sucesso');
    }

    public function imgEditProfile(Request $request, $id)
    {
        $name = $this->repository->find($id)->name;

        $file = $request->file('img');

        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
        where('id', $id)->
        update(['imgProfile' => $imgName]);

        return redirect()->back();
    }

    public function tag($tag, $id)
    {
        DB::table('people')->
            where('id', $id)->
            update(['tag' => $tag]);
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
        $person = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $person->dateBirth = $this->formatDateView($person->dateBirth);

        $location = $this->formatGoogleMaps($person);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $adults = $this->repository->findWhere(['tag' => 'adult']);

        return view('people.edit', compact('person', 'state', 'location', 'roles', 'countPerson', 'countGroups', 'adults'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, UserRepository $user)
    {
        $data = $request->except(['email']);

        $email = $request->only('email');

        //Formatação correta do email
        $email = implode('=>', $email);

        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         *
        */
        if($data['maritalStatus'] != 'Casado')
        {
            $data['partner'] = null;
        }


        $myEmail = $user->findByField('person_id', $id);

        //Verifica se o email mudou, se sim chama função para alterar
        if($myEmail[0]->email != $email)
        {
            $this->updateEmail($email, $id);
        }

        $this->repository->update($data, $id);

        return redirect()->route('person.index');
    }

    public function updateEmail($email, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['email' => $email]);
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

        return redirect()->route('person.index');
    }
}
