<?php

namespace App\Http\Controllers\Api;

use App\Models\Sponsor;
use App\Repositories\SponsorCategoryRepository;
use App\Repositories\SponsorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SponsorController extends Controller
{

    private $categoriesRepository;

    private $repository;

    public function __construct(SponsorRepository $repository, SponsorCategoryRepository $categoriesRepository)
    {

        $this->repository = $repository;
        $this->categoriesRepository = $categoriesRepository;
    }


    //Lista de todos os patrocinadores
    public function index()
    {
        $sponsor = $this->repository->all();

        foreach ($sponsor as $item)
        {
            $item->category_name = $this->categoriesRepository->findByField('id', $item->category_id)->first()
                ? $this->categoriesRepository->findByField('id', $item->category_id)->first()->name : null;
        }

        return json_encode([
            'status' => true,
            'count' => count($sponsor),
            'sponsors' => $sponsor
        ]);
    }

    //Lista de todos os patrocinadores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('id', $category)->first();


        if($cat_id)
        {
            $sponsors = $this->repository->findByField('category_id', $category);


            return json_encode([
                'status' => true,
                'count' => count($sponsors),
                'sponsors' => $sponsors
            ]);
        }

        return json_encode(['status' => false, 'msg' => 'Categoria não existe']);


    }

    //Cadastro de patrocinadores
    public function store(Request $request)
    {
        $data = $request->all();

        if(!isset($data['name']))
        {
            return json_encode(['status' => false, 'msg' => "Insira o nome do patrocinador"]);

        }

        else{
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

                return json_encode(['status' => true]);
            }
        }


        return json_encode(['status' => false]);
    }

    //Alteração de patrocinadores
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if(!isset($data['name']))
        {
            return json_encode(['status' => false, 'msg' => "Insira o nome do patrocinador"]);

        }


        else{
            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/sponsor/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/sponsor/', $imgName);

                $data['logo'] = $imgName;
            }

            if($this->repository->update($data, $id))
            {

                return json_encode(['status' => true]);
            }
        }

        return json_encode(['status' => false, "msg" => "Este Patrocinador não existe"]);
    }

    //Exclusão de patrocinadores
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
            $sponsors = new Sponsor();

            $sponsors->where('category_id', $id)->update(['category_id' => null]);

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }
}
