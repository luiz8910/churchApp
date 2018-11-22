<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return json_encode([
            'status' => true,
            'exhibitors' => $exhbit
        ]);
    }

    //Lista de todos os expositores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $exhbit = $this->repository->findByField('category', $cat_id)->get();

        return json_encode([
            'status' => true,
            'count' => count($exhbit),
            'exhibitors' => $exhbit
        ]);
    }

    //Cadastro de Expositores
    public function store(Request $request)
    {
        $data = $request->all();

        if($this->repository->create($data))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    //Alteração de Expositores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($this->repository->update($data, $id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
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
                return json_encode(['status' => true]);
            }
        }

        return json_encode(['status' => false]);
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

        return json_encode(['status' => false]);
    }

    //Exclusão de Categoria
    public function delete_cat($id)
    {
        if($this->categoriesRepository->delete($id))
        {
            $this->repository->findWhere(['category' => $id])->update([['category' => null]]);

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }
}
