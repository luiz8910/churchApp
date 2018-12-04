<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $item->category_name = $this->categoriesRepository->findByField('id', $item->category_id)->first()
                 ? $this->categoriesRepository->findByField('id', $item->category_id)->first()->name : null;
        }

        return json_encode([
            'status' => true,
            'count' => count($exhbit),
            'exhibitors' => $exhbit
        ]);
    }

    //Lista de todos os expositores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('id', $category)->first();


        if($cat_id)
        {
            $exhbit = $this->repository->findByField('category_id', $category);


            return json_encode([
                'status' => true,
                'count' => count($exhbit),
                'exhibitors' => $exhbit
            ]);
        }

        return json_encode(['status' => false, 'msg' => 'Categoria não existe']);


    }

    //Cadastro de Expositores
    public function store(Request $request)
    {
        $data = $request->all();

        if(!isset($data['name']))
        {
            return json_encode(['status' => false, 'msg' => "Insira o nome do expositor"]);

        }
        elseif (!isset($data['description']))
        {
            return json_encode(['status' => false, 'msg' => "Insira uma descrição para o expositor"]);
        }

        else{
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

                return json_encode(['status' => true]);
            }
        }


        return json_encode(['status' => false]);
    }

    //Alteração de Expositores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if(!isset($data['name']))
        {
            return json_encode(['status' => false, 'msg' => "Insira o nome do expositor"]);

        }
        elseif (!isset($data['description']))
        {
            return json_encode(['status' => false, 'msg' => "Insira uma descrição para o expositor"]);
        }

        else{
            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/exhibitors/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/exhibitors/', $imgName);

                $data['logo'] = $imgName;
            }

            if($this->repository->update($data, $id))
            {

                return json_encode(['status' => true]);
            }
        }

        return json_encode(['status' => false, "msg" => "Este Expositor não existe"]);
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
                'count' => count($categories),
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

        return json_encode(['status' => false, "msg" => 'Insira o nome da Categoria']);
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
            else{

                return json_encode(['status' => false, "msg" => "Esta Categoria não existe"]);
            }
        }

        return json_encode(['status' => false, "msg" => "Insira o novo nome da Categoria"]);
    }

    //Exclusão de Categoria
    public function delete_cat($id)
    {
        if($this->categoriesRepository->delete($id))
        {
            $exhibitors = new Exhibitors();

            $exhibitors->where('category_id', $id)->update(['category_id' => null]);

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }
}
