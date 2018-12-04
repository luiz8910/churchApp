<?php

namespace App\Http\Controllers;

use App\Repositories\SponsorCategoryRepository;
use App\Repositories\SponsorRepository;
use App\Repositories\StateRepository;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    
    private $categoriesRepository;
    
    private $repository;
   
    private $stateRepository;

    public function __construct(SponsorCategoryRepository $categoriesRepository, SponsorRepository $repository,
                                StateRepository $stateRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
    }

    //Lista de todos os patrocinadores
    public function index()
    {
        $model = $this->repository->all();

        $model_cat = $this->categoriesRepository->all();

        $th = ['Logo', 'Nome', 'Telefone', 'Email', 'Categoria', ''];

        $columns = ['id', 'logo', 'name', 'tel', 'email', 'category_name'];

        $title = "Patrocinadores";

        $table = 'sponsors';

        $text_delete = "Deseja excluir o patrocinador selecionado?";

        $buttons = (object) [
            [
                'name' => 'Patrocinador',
                'route' => 'sponsors.create',
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
            $item->category_name = $this->categoriesRepository->findByField('id', $item->category_id)->first()
                ? $this->categoriesRepository->findByField('id', $item->category_id)->first()->name : "Sem Categoria";
        }



        return view('custom.index', compact('model', 'model_cat', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete'));
    }

    //Tela de Criação de Patrocinadores
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        return view('sponsors.create', compact('categories', 'state', 'no_zip_button'));
    }

    public function edit($id)
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $model = $this->repository->findByField('id', $id)->first();

        return view('sponsors.edit', compact('categories', 'state', 'no_zip_button', 'model', 'id'));
    }


    //Lista de todos os Patrocinadores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $sponsors = $this->repository->findByField('category_id', $cat_id)->get();

        return view('sponsors.index', compact('sponsors', 'cat_id'));
    }

    //Cadastro de Patrocinadores
    public function store(Request $request)
    {
        $data = $request->all();

        if(isset($data['logo']))
        {
            $file = $request->file('logo');

            $name = $data['name'];

            $imgName = 'uploads/sponsors/' . $name .'.' . $file->getClientOriginalExtension();

            $file->move('uploads/sponsors/', $imgName);

            $data['logo'] = $imgName;
        }

        if($this->repository->create($data))
        {
            $request->session()->flash('success.msg', 'O Patrocinador foi cadastrado com sucesso');

            return redirect()->route('sponsors.index');
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->route('sponsors.index');
    }

    //Alteração de Patrocinadores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if(isset($data['logo']))
        {
            $file = $request->file('logo');

            $name = $data['name'];

            $imgName = 'uploads/sponsors/' . $name .'.' . $file->getClientOriginalExtension();

            $file->move('uploads/sponsors/', $imgName);

            $data['logo'] = $imgName;
        }

        if($this->repository->update($data, $id))
        {
            $request->session()->flash('success.msg', 'O Patrocinador foi atualizado com sucesso');

            return redirect()->route('sponsors.index');
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->route('sponsors.index');
    }

    //Exclusão de Patrocinadores
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
            //$ex = new sponsors();

            //$ex->where(['category' => $id])->update(['category' => null]);

            $this->repository->findWhere(['category' => $id])->update([['category' => null]]);

            \Session::flash('success.msg', 'A categoria foi excluida com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }
}
