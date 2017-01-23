<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Repositories\CountPersonRepository;
use App\Repositories\DateRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    use DateRepository, CountPersonRepository;
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


        return view('people.index', compact('adults', 'countPerson'));
    }

    public function teenagers()
    {
        $teen = $this->repository->findWhereNotIn('tag', ['adult']);

        foreach ($teen as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();

        return view('people.teenagers', compact('teen', 'countPerson'));
    }

    public function visitors()
    {
        $visitors = $this->repository->findWhere(['role_id' => '3']);

        foreach ($visitors as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();

        return view('people.visitors', compact('visitors', 'countPerson'));
    }

    public function inactive()
    {
        $inactive = Person::onlyTrashed()->get();

        foreach ($inactive as $item)
        {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();

        return view('people.inactive', compact('inactive', 'countPerson'));
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

        return view('people.create', compact('state', 'roles', 'countPerson'));
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

        $data = $request->except(['img']);

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $id = $this->repository->create($data)->id;

        $this->tag($this->repository->tag($data['dateBirth']), $id);

        $this->imgProfile($file, $id, $data['name']);

        $children = $request->get('group-a');

        $this->children($children, $id, $data['gender']);

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

            $idChild = $this->repository->create($data)->id;

            $this->tag($this->repository->tag($data['dateBirth']), $idChild);
        }
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

        if ($person->street)
        {
            $location = str_replace(' ', '+', $person->street);

            $location .= '+' . $person->city . '+' . $person->state;

            //dd($location);
        }
        else{
            $location = null;
        }

        $countPerson[] = $this->countPerson();

        return view('people.edit', compact('person', 'state', 'location', 'roles', 'countPerson'));
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

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $this->repository->update($data, $id);

        return redirect()->route('person.index');
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
