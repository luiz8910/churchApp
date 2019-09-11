<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Repositories\EventRepository;
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
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(SpeakerCategoryRepository $categoriesRepository, SpeakerRepository $repository,
                                StateRepository $stateRepository, PersonRepository $personRepository, EventRepository $eventRepository)
    {

        $this->categoriesRepository = $categoriesRepository;
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->personRepository = $personRepository;
        $this->eventRepository = $eventRepository;
    }

    //Lista de todos os palestrantes
    public function index($event_id = null)
    {
        if($event_id)
        {

            $event = $this->eventRepository->findByField('id', $event_id)->first();

            if($event)
            {

                $model = $this->repository->orderBy('name')->findByField('event_id', $event_id);
            }
            else{
                $bug = new Bug();

                $bug->description = 'Não existe o evento com id: ' . $event_id;
                $bug->platform = 'Back-end';
                $bug->location = 'index() SpeakerController.php';
                $bug->model = 'Speaker';
                $bug->status = 'Pendente';
                $bug->church_id = $this->getUserChurch();

                $bug->save();

                \Session::flash('error.msg', 'O Evento que este palestrante pertence não existe');

                return redirect()->back();
            }


        }
        else{

            /*$model = DB::table('speakers')
                            ->where(['deleted_at' => null])
                            ->orderBy('name')
                            ->get();*/

            $model = $this->repository->orderBy('name')->all();

        }

        $model_cat = $this->categoriesRepository->all();

        if(count($model) > 0)
        {
            /*$model->map(function ($m){
                $m->category_name = $this->categoriesRepository->findByField('id', $m->category_id)->first()
                    ? $this->categoriesRepository->findByField('id', $m->category_id)->first()->name : "Sem Categoria";

                $m->event_name = $m->event_id ? $this->eventRepository->findByField('id', $m->event_id)->first()->name : '';

                return $m;
            });*/

            foreach ($model as $item)
            {

                $item->category_name = $this->categoriesRepository->findByField('id', $item->category_id)->first()
                    ? $this->categoriesRepository->findByField('id', $item->category_id)->first()->name : "Sem Categoria";

                $item->event_name = $item->event_id ? $this->eventRepository->findByField('id', $item->event_id)->first()->name : '';
            }
        }

        //dd($model);

        $th = ['Foto', 'Nome', 'País', 'Evento', ''];

        $columns = ['id', 'photo', 'name', 'country', 'event_name'];

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

        return view('custom.index', compact('model', 'model_cat', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete'));


    }

    //Tela de Criação de Palestrantes
    public function create()
    {
        $categories = $this->categoriesRepository->all();

        //$people = $this->personRepository->findByField('church_id', $this->getUserChurch());

        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        return view('speakers.create', compact('categories', 'events'));
    }

    public function edit($id)
    {
        $categories = $this->categoriesRepository->all();

        $model = $this->repository->findByField('id', $id)->first();

        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        return view('speakers.edit', compact('categories', 'model', 'id', 'events'));
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


            if(isset($data['photo']))
            {
                $file = $request->file('photo');

                $name = $data['name'];

                $imgName = 'uploads/speakers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/speakers/', $imgName);

                $data['photo'] = $imgName;
            }
            else{
                $data['photo'] = 'uploads/profile/noimage.png';
            }

            $this->repository->create($data);

            \DB::commit();

            $request->session()->flash('success.msg', 'O Palestrante foi cadastrado com sucesso');

            return redirect()->route('speakers.index');


        }catch(\Exception $e)
        {
            \DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->model = 'Speaker';
            $bug->location = 'Line: ' .$e->getLine() . ' store() SpeakerController.php';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

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

            if(isset($data['photo']))
            {
                $file = $request->file('photo');

                $name = $data['name'];

                $imgName = 'uploads/speakers/' . $name .'.' . $file->getClientOriginalExtension();

                $file->move('uploads/speakers/', $imgName);

                $data['photo'] = $imgName;
            }else{

                $img_exists = $this->repository->findWhere([
                                                    ['photo', '<>', 'uploads/profile/noimage.png'],
                                                    'id' => $id
                                                        ])->first();

                if(!$img_exists)
                {
                    $data['photo'] = 'uploads/profile/noimage.png';
                }

            }

            $this->repository->update($data, $id);

            \DB::commit();

            $request->session()->flash('success.msg', 'O Palestrante foi atualizado com sucesso');

            return redirect()->route('speakers.index');

        }catch (\Exception $e)
        {
            \DB::rollback();

            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');

            $bug = new Bug();

            $bug->description = $e->getMessage();
            $bug->platform = 'Back-end';
            $bug->model = 'Speaker';
            $bug->location = 'Line: ' .$e->getLine() . ' update() SpeakerController.php';
            $bug->status = 'Pendente';
            $bug->church_id = $this->getUserChurch();

            $bug->save();

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
