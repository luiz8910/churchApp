<?php

namespace App\Http\Controllers;

use App\Repositories\PersonRepository;
use App\Repositories\SpeakerCategoryRepository;
use App\Repositories\SpeakerRepository;
use App\Repositories\StateRepository;
use App\Traits\ConfigTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpeakerController extends Controller
{
    use ConfigTrait;

    private $categoriesRepository;

    private $repository;

    private $stateRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(SpeakerCategoryRepository $categoriesRepository, SpeakerRepository $repository,
                                StateRepository $stateRepository, PersonRepository $personRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->personRepository = $personRepository;
    }

    //Lista de todos os palestrantes
    public function index()
    {
        $model = $this->repository->all();

        $model_cat = $this->categoriesRepository->all();

        $th = ['Foto', 'Nome', 'Empresa', ''];

        $columns = ['id', 'foto', 'name', 'company'];

        $title = "Palestrantes";

        $table = 'speakers';

        $text_delete = "Deseja excluir o palestrante selecionado?";

        $buttons = (object) [
            [
                'name' => 'Palestrante',
                'route' => 'speakers.create',
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

    //Tela de Criação de Palestrantes
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        return view('speakers.create', compact('categories', 'state', 'no_zip_button', 'people'));
    }

    public function edit($id)
    {
        $categories = $this->categoriesRepository->all();

        $state = $this->stateRepository->all();

        //Variável para retirar o botão de "Inserir CEP da organização"
        $no_zip_button = true;

        $model = $this->repository->findByField('id', $id)->first();

        $people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        $sp = DB::table('speaker_person')
            ->where([
                'speaker_id' => $id
            ])->first();

        if(count($sp) == 1)
        {
            $sp = $sp->person_id;
        }
        else{
            $sp = false;
        }

        return view('speakers.edit', compact('categories', 'state', 'no_zip_button',
            'model', 'id', 'people', 'sp'));
    }


    //Lista de todos os Palestrantes de determinada categoria
    public function listByCategory($category)
    {
        $cat_id = $this->categoriesRepository->findByField('name', $category)->id;

        $speakers = $this->repository->findByField('category_id', $cat_id)->get();

        return view('speakers.index', compact('speakers', 'cat_id'));
    }

    //Cadastro de Palestrantes
    public function store(Request $request)
    {
        try{
            $data = $request->all();

            $verifyFields = $this->verifyRequiredFields($data, 'speaker');

            if($verifyFields)
            {

                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                return redirect()->back()->withInput();

            }

            $redirect = false;

            if(isset($data['new-responsible-speaker']))
            {
                $redirect = true;

                unset($data['new-responsible-speaker']);
            }

            if(isset($data['foto']))
            {
                $file = $request->file('foto');

                $name = $data['name'];

                $imgName = 'uploads/speakers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/speakers/', $imgName);

                $data['foto'] = $imgName;
            }

            $id = $this->repository->create($data)->id;

            DB::commit();

            if($redirect)
            {
                $request->session()->put('new-responsible-speaker', $id);

                return redirect()->route('person.create');
            }
            else
            {
                $request->session()->flash('success.msg', 'O Palestrante foi cadastrado com sucesso');

                return redirect()->route('speakers.index');
            }

        }catch(\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->route('speakers.create');
        }



    }

    //Alteração de Palestrantes
    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();

            $verifyFields = $this->verifyRequiredFields($data, 'speaker');

            if($verifyFields)
            {

                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                return redirect()->back()->withInput();

            }

            if(isset($data['foto']))
            {
                $file = $request->file('foto');

                $name = $data['name'];

                $imgName = 'uploads/speakers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/speakers/', $imgName);

                $data['foto'] = $imgName;
            }

            $redirect = false;

            if(isset($data['new-responsible-speaker']))
            {
                $redirect = true;

                unset($data['new-responsible-speaker']);
            }

            $this->repository->update($data, $id);

            DB::commit();

            if($data['responsible'] != "")
            {
                $sp = DB::table('speaker_person')
                    ->where('speaker_id', $id)
                    ->first();

                //dd($data['responsible']);

                if(count($sp) == 1)
                {
                    if($sp->person_id != $data['responsible'])
                    {
                        DB::table('speaker_person')
                            ->where('speaker_id', $id)
                            ->delete();

                        DB::table('speaker_person')
                            ->insert([
                                'speaker_id' => $id,
                                'person_id' => $data['responsible'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                                'deleted_at' => null
                            ]);

                    }
                }else{
                    DB::table('speaker_person')
                        ->insert([
                            'speaker_id' => $id,
                            'person_id' => $data['responsible'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'deleted_at' => null
                        ]);
                }



            }
            else{

                DB::table('speaker_person')
                    ->where('speaker_id', $id)
                    ->delete();

            }



            if($redirect)
            {
                $request->session()->put('new-responsible-speaker', $id);

                return redirect()->route('person.create');
            }
            else
            {
                $request->session()->flash('success.msg', 'O Palestrante foi atualizado com sucesso');

                return redirect()->route('speakers.index');
            }

        }catch (\Exception $e)
        {
            DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            return redirect()->route('speakers.index');
        }



    }

    //Exclusão de Palestrantes
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
            //$ex = new speakers();

            //$ex->where(['category' => $id])->update(['category' => null]);

            $this->repository->findWhere(['category' => $id])->update([['category' => null]]);

            \Session::flash('success.msg', 'A categoria foi excluida com sucesso');

            return redirect()->back();
        }

        \Session::flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

        return redirect()->back();
    }
}
