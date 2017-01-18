<?php

namespace App\Http\Controllers;

use App\Repositories\DateRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    use DateRepository;
    /**
     * @var PersonRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct(PersonRepository $repository, StateRepository $stateRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $person = $this->repository->all();

        $adults = $this->repository->legalAge($person);

        return view('people.index', compact('adults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        return view('people.create', compact('state'));
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

        //dd($file);

        //unset($data['img']);

        $id = $this->repository->create($data)->id;

        $this->imgProfile($file, $id, $data['name']);

        $children = $request->get('group-a');

        $this->children($children, $id, $data['gender']);

        return redirect()->route('person.index');
    }

    /**
     * Atribui pais aos filhos
     *
     * @param $children
     * @param $id
     * @param $gender
     */
    public function children($children, $id, $gender)
    {
        foreach ($children as $child)
        {
            if($gender == 'M')
            {
                $father = $this->repository->find($id);

                $data['name'] = $child['childName'];

                $data['lastName'] = $child['childLastName'];

                $data['dateBirth'] = $this->formatDateBD($child['childDateBirth']);

                $data['fatherName'] = $father->name . ' ' . $father->lastName;

                $this->repository->create($data);
            }
            else{
                $mother = $this->repository->find($id);

                $data['name'] = $child['childName'];

                $data['lastName'] = $child['childLastName'];

                $data['dateBirth'] = $this->formatDateBD($child['childDateBirth']);

                $data['motherName'] = $mother->name . ' ' . $mother->lastName;

                $this->repository->create($data);
            }
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
