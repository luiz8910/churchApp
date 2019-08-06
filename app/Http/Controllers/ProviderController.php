<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Repositories\ProviderCategoryRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\StateRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    use ConfigTrait;

    private $categoriesRepository;

    private $repository;

    private $stateRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(ProviderCategoryRepository $categoriesRepository, ProviderRepository $repository,
                                StateRepository $stateRepository, PersonRepository $personRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->personRepository = $personRepository;
    }

    //Lista de todos os fornecedores
    public function index()
    {
        $model = $this->repository->all();

        $model_cat = $this->categoriesRepository->all();

        $th = ['Logo', 'Nome', 'Telefone', 'Email', 'Categoria', ''];

        $columns = ['id', 'logo', 'name', 'tel', 'email', 'category_name'];

        $title = "Fornecedores";

        $table = 'providers';

        $text_delete = "Deseja excluir o fornecedor selecionado?";

        $buttons = (object) [
            [
                'name' => 'Fornecedor',
                'route' => 'providers.create',
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

    //Tela de Criação de Fornecedores
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        return view('providers.create', compact('categories', 'state', 'no_zip_button', 'people'));
    }

    public function edit($id)
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $model = $this->repository->findByField('id', $id)->first();

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        $sp = DB::table('provider_person')
            ->where([
                'provider_id' => $id
            ])->first();

        if(count($sp) == 1)
        {
            $sp = $sp->person_id;
        }
        else{
            $sp = false;
        }

        return view('providers.edit', compact('categories', 'state', 'no_zip_button',
            'model', 'id', 'people', 'sp'));
    }


    //Lista de todos os Fornecedores de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $providers = $this->repository->findByField('category_id', $cat_id)->get();

        return view('providers.index', compact('providers', 'cat_id'));
    }

    //Cadastro de Fornecedores
    public function store(Request $request)
    {
        try{
            $data = $request->all();

            $verifyFields = $this->verifyRequiredFields($data, 'provider');

            if($verifyFields)
            {

                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                return redirect()->back()->withInput();

            }

            $redirect = false;

            if(isset($data['new-responsible-provider']))
            {
                $redirect = true;

                unset($data['new-responsible-provider']);
            }

            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/providers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/providers/', $imgName);

                $data['logo'] = $imgName;
            }

            $id = $this->repository->create($data)->id;

            DB::commit();

            if($redirect)
            {
                $request->session()->put('new-responsible-provider', $id);

                return redirect()->route('person.create');
            }
            else
            {
                $request->session()->flash('success.msg', 'O Fornecedor foi cadastrado com sucesso');

                return redirect()->route('providers.index');
            }

        }catch(\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->route('providers.create');
        }



    }

    //Alteração de Fornecedores
    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();

            $verifyFields = $this->verifyRequiredFields($data, 'provider');

            if($verifyFields)
            {

                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                return redirect()->back()->withInput();

            }

            if(isset($data['logo']))
            {
                $file = $request->file('logo');

                $name = $data['name'];

                $imgName = 'uploads/providers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/providers/', $imgName);

                $data['logo'] = $imgName;
            }

            $redirect = false;

            if(isset($data['new-responsible-provider']))
            {
                $redirect = true;

                unset($data['new-responsible-provider']);
            }

            $this->repository->update($data, $id);

            DB::commit();

            if($data['responsible'] != "")
            {
                $sp = DB::table('provider_person')
                    ->where('provider_id', $id)
                    ->first();

                //dd($data['responsible']);

                if(count($sp) == 1)
                {
                    if($sp->person_id != $data['responsible'])
                    {
                        DB::table('provider_person')
                            ->where('provider_id', $id)
                            ->delete();

                        DB::table('provider_person')
                            ->insert([
                                'provider_id' => $id,
                                'person_id' => $data['responsible'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'deleted_at' => null
                            ]);

                    }
                }else{
                    DB::table('provider_person')
                        ->insert([
                            'provider_id' => $id,
                            'person_id' => $data['responsible'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'deleted_at' => null
                        ]);
                }



            }
            else{

                DB::table('provider_person')
                    ->where('provider_id', $id)
                    ->delete();

            }



            if($redirect)
            {
                $request->session()->put('new-responsible-provider', $id);

                return redirect()->route('person.create');
            }
            else
            {
                $request->session()->flash('success.msg', 'O Fornecedor foi atualizado com sucesso');

                return redirect()->route('providers.index');
            }

        }catch (\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->route('providers.index');
        }



    }

    //Exclusão de Fornecedores
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
            //$ex = new providers();

            //$ex->where(['category' => $id])->update(['category' => null]);

            $this->repository->findWhere(['category' => $id])->update([['category' => null]]);

            \Session::flash('success.msg', 'A categoria foi excluida com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }
}
