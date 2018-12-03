<?php

namespace App\Http\Controllers;

use App\Models\Exhibitors;
use App\Repositories\ExhibitorsCategoriesRepository;
use App\Repositories\ExhibitorsRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;

class ExhibitorsController extends Controller
{
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

    public function __construct(ExhibitorsCategoriesRepository $categoriesRepository, ExhibitorsRepository $repository,
                                StateRepository $stateRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
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
                'modal' => null
            ],
            [
                'name' => 'Categoria',
                'route' => null,
                'modal' => 'modal_NewCat'
            ],
            [
                'name' => 'Lista',
                'route' => null,
                'modal' => 'modal_list_cat'
            ]
        ];

        foreach ($model as $item)
        {
            $item->category_name = $this->categoriesRepository->findByField('id', $item->category)->first()
                ? $this->categoriesRepository->findByField('id', $item->category)->first()->name : "Sem Categoria";
        }



        return view('exhibitors.index', compact('model', 'model_cat', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete'));
    }

    //Tela de Criação de Expositores
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        return view('exhibitors.create', compact('categories', 'state', 'no_zip_button'));
    }


    //Lista de todos os expositores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $exhbit = $this->repository->findByField('category', $cat_id)->get();

        return view('exhibitors.index', compact('exhbit', 'cat_id'));
    }

    //Cadastro de Expositores
    public function store(Request $request)
    {
        $data = $request->all();

        if(isset($data['logo']))
        {
            $file = $request->file('logo');

            $name = $data['name'];

            $imgName = 'uploads/exhibitors/' . $name .'.' . $file->getClientOriginalExtension();

            $file->move('uploads/exhibitors/', $imgName);

            $data['logo'] = $imgName;
        }

        if($this->repository->create($data))
        {
            $request->session()->flash('success.msg', 'O Expositor foi cadastrado com sucesso');

            return redirect()->route('exhibitors.index');
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->route('exhibitors.index');
    }

    //Alteração de Expositores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($this->repository->update($data, $id))
        {
            $request->session()->flash('success.msg', 'O Expositor foi atualizado com sucesso');

            return redirect()->route('exhibitors.index');
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->route('exhibitors.index');
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

            $this->repository->findWhere(['category' => $id])->update([['category' => null]]);

            \Session::flash('success.msg', 'A categoria foi excluida com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }
}

