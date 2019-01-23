<?php

namespace App\Http\Controllers;

use App\Models\Exhibitors;
use App\Repositories\ExhibitorsCategoriesRepository;
use App\Repositories\ExhibitorsRepository;
use App\Repositories\PersonRepository;
use App\Repositories\StateRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExhibitorsController extends Controller
{
    use ConfigTrait;
    /**
     * @var ExhibitorsCategoriesRepository
     */
    private $categoriesRepository;
    /**
     * @var ExhibitorsCategoriesRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(ExhibitorsCategoriesRepository $categoriesRepository, ExhibitorsRepository $repository,
                                StateRepository $stateRepository, PersonRepository $personRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->personRepository = $personRepository;
    }

    //Lista de todos os expositores
    public function index()
    {
        $model = $this->repository->all();

        $model_cat = $this->categoriesRepository->all();

        $th = ['Logo', 'Nome', 'Telefone', 'Email', 'Categoria', ''];

        $columns = ['id', 'logo', 'name', 'tel', 'email', 'category_name'];

        $title = "Expositores";

        $table = 'exhibitors';

        $text_delete = "Deseja excluir o expositor selecionado?";

        $buttons = (object) [
            [
                'name' => 'Expositor',
                'route' => 'exhibitors.create',
                'modal' => null,
                'icon' => 'fa fa-plus'
            ],
            [
                'name' => 'Categoria',
                'route' => null,
                'modal' => 'modal_NewCat',
                'icon' => 'fa fa-plus'
            ],
            [
                'name' => 'Lista',
                'route' => null,
                'modal' => 'modal_list_cat',
                'icon' => 'fa fa-list'
            ]
        ];

        foreach ($model as $item)
        {
            $item->category_name = $this->categoriesRepository->findByField('id', $item->category_id)->first()
                ? $this->categoriesRepository->findByField('id', $item->category_id)->first()->name : "Sem Categoria";
        }



        return view('custom.index', compact('model', 'model_cat', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete'));
    }

    //Tela de Criação de Expositores
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        return view('exhibitors.create', compact('categories', 'state', 'no_zip_button', 'people'));
    }

    public function edit($id)
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $model = $this->repository->findByField('id', $id)->first();

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        $resp = DB::table('exhibitor_person')
            ->where(['exhibitor_id' => $id])
            ->first()
            ->person_id;


        return view('exhibitors.edit', compact('categories', 'state', 'no_zip_button',
            'model', 'id', 'resp', 'people'));
    }


    //Lista de todos os expositores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $exhbit = $this->repository->findByField('category_id', $cat_id)->get();

        return view('exhibitors.index', compact('exhbit', 'cat_id'));
    }

    //Cadastro de Expositores
    public function store(Request $request)
    {
        try{

            $data = $request->all();

            $data['church_id'] = $this->getUserChurch();

            $redirect = false;

            if(isset($data['new-responsible']))
            {
                $redirect = true;

                unset($data['new-responsible']);
            }

            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/exhibitors/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/exhibitors/', $imgName);

                $data['logo'] = $imgName;
            }

            $id = $this->repository->create($data)->id;

            if($redirect)
            {
                $request->session()->put('new-responsible-exhibitors', $id);

                return redirect()->route('person.create');
            }
            else{

                $request->session()->flash('success.msg', 'O Expositor foi cadastrado com sucesso');

                return redirect()->route('exhibitors.index');
            }

        }catch (\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->route('exhibitors.index');
        }





    }

    //Alteração de Expositores
    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();

            $redirect = false;

            if(isset($data['new-responsible']))
            {
                $redirect = true;

                unset($data['new-responsible']);
            }

            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/exhibitors/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/exhibitors/', $imgName);

                $data['logo'] = $imgName;
            }

            $resp = DB::table('exhibitor_person')
                ->where(['exhibitor_id' => $id])
                ->first()
                ->person_id;

            if(isset($data['responsible']) && !$redirect)
            {
                if($data['responsible'] != $resp)
                {
                    DB::table('exhibitor_person')
                        ->where(['exhibitor_id' => $id])
                        ->delete();

                    DB::table('exhibitor_person')
                        ->insert([
                            'exhibitor_id' => $id,
                            'person_id' => $data['responsible'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'deleted_at' => null
                        ]);
                }

            }

            unset($data['responsible']);

            $this->repository->update($data, $id);

            DB::commit();

            if($redirect)
            {
                $request->session()->put('new-responsible-exhibitors', $id);

                return redirect()->route('person.create');
            }

            $request->session()->flash('success.msg', 'O Expositor foi atualizado com sucesso');

            return redirect()->route('exhibitors.index');

        }catch (\Exception $e){
            DB::rollback();

            $request->session()->flash('error.msg', $e->getMessage());

            return redirect()->route('exhibitors.index');
        }



    }

    //Exclusão de Expositores
    public function delete($id)
    {
        if($this->repository->delete($id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    //Lista de Categorias
    public function index_cat()
    {
        $categories = $this->categoriesRepository->all();

        return json_encode(
            [
                'status' => true,
                'qtde' => count($categories),
                'categories' => $categories
            ]);
    }

    //Cadastro de categorias
    public function store_cat(Request $request)
    {
        $data = $request->all();

        if(isset($data['name']))
        {
            if($this->categoriesRepository->create($data))
            {
                $request->session()->flash('success.msg', 'A categoria foi cadastrada com sucesso');

                return redirect()->back();
            }
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }

    //Alteração de Categorias
    public function update_cat(Request $request, $id)
    {
        $data = $request->all();

        if(isset($data['name']))
        {
            if($this->categoriesRepository->update($data, $id))
            {
                return json_encode(['status' => true]);
            }
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }

    //Exclusão de Categoria
    public function delete_cat($id)
    {
        if($this->categoriesRepository->delete($id))
        {
            //$ex = new Exhibitors();

            //$ex->where(['category' => $id])->update(['category' => null]);

            $this->repository->findWhere(['category_id' => $id])->update([['category_id' => null]]);

            \Session::flash('success.msg', 'A categoria foi excluida com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }
}

