<?php

namespace App\Http\Controllers;

use App\Models\Exhibitors;
use App\Repositories\ExhibitorsCategoriesRepository;
use App\Repositories\ExhibitorsRepository;
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

    public function __construct(ExhibitorsCategoriesRepository $categoriesRepository, ExhibitorsRepository $repository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
    }

    //Lista de todos os expositores
    public function index()
    {
        $exhbit = $this->repository->all();

        foreach ($exhbit as $item)
        {
            $item->category_name = $this->categoriesRepository->find($item->category)->name;
        }

        return view('exhibitors.index', compact('exhbit'));
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

        if($this->repository->create($data))
        {
            $request->session()->flash('success.msg', 'O Expositor foi cadastrado com sucesso');

            return redirect()->back();
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }

    //Alteração de Expositores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($this->repository->update($data, $id))
        {
            $request->session()->flash('success.msg', 'O Expositor foi atualizado com sucesso');

            return redirect()->back();
        }

        $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }

    //Exclusão de Expositores
    public function delete($id)
    {
        if($this->repository->delete($id))
        {
            \Session::flash('success.msg', 'O Expositor foi excluído com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
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
                $request->session()->flash('success.msg', 'O Expositor foi cadastrado com sucesso');

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

