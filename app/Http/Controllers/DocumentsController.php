<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Repositories\DocumentRepository;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
    use ConfigTrait;
    /**
     * @var DocumentRepository
     */
    private $repository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;

    public function __construct(DocumentRepository $repository, EventRepository $eventRepository, PersonRepository $personRepository)
    {

        $this->repository = $repository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
    }


    /*
     * $id = id do evento
     */
    public function index(Request $request)
    {
        $th = ['Nome', 'Tipo', 'Criado Por', 'Evento'];

        $columns = ['id', 'name', 'type', 'created_by', 'event_id', ''];

        $title = "Documentos";

        $title_modal = 'Lista de Eventos';

        $table = 'documents';

        $text_delete = "Deseja excluir o documento selecionado?";

        $model_list = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $buttons = (object) [
            [
                'name' => 'Filtrar por evento',
                'route' => null,
                'modal' => 'list',
                'icon' => 'fa fa-list'
            ],
            [
                'name' => 'Docs Excluídos',
                'route' => 'documents.deleted',
                'modal' => null,
                'icon' => 'fa fa-trash-o'
            ]


        ];


        $id = null !== $request->get('list') ? $request->get('list') : null;

        if ($id != 0) {
            $model = $this->repository->findByField('event_id', $id);

        }else{

            $model = $this->repository->all();
        }

        foreach ($model as $item)
        {
            $item->created_by = $this->personRepository->findByField('id', $item->created_by)->first()->name;

            $item->event_id = null !== $item->event_id ?
                $this->eventRepository->findByField('id', $item->event_id)->first()->name : 'Sem evento';
        }

        $person_id = \Auth::getUser()->person->id;

        $search_not_ready = $doc = true;

        return view('custom.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete',
            'title_modal', 'model_list', 'search_not_ready', 'doc', 'person_id'));

    }

    public function upload(Request $request)
    {
        $data = $request->all();

        if (isset($data['file'])) {

            $data['created_by'] = \Auth::getUser()->person->id;

            $data['church_id'] = \Auth::getUser()->person->church_id;

            $data['event_id'] = $data['event_id'] == "" ? null : $data['event_id'];

            $file = $request->file('file');

            unset($data['file']);

            $data['name'] = $file->getClientOriginalName();

            $data['type'] = $file->getClientOriginalExtension();

            $id = $this->repository->create($data)->id;

            $fileName = $id . '-' . $file->getClientOriginalName();

            $file->move('uploads/documents/', $fileName);

            $d['path'] = 'uploads/documents/'. $fileName;

            $this->repository->update($d, $id);

            $request->session()->flash('success.msg', 'O arquivo ' . $data['name'] . ' foi armazenado com sucesso');

            return redirect()->back();

        } else {
            $request->session()->flash('error.msg', 'Nenhum arquivo foi enviado');

            return redirect()->back();
        }
    }

    public function deleted()
    {
        $org = $this->getUserChurch();

        $th = ['Nome', 'Tipo', 'Criado Por', 'Evento'];

        $columns = ['id', 'name', 'type', 'created_by', 'event_id', ''];

        $title = "Documentos";

        $title_modal = 'Lista de Eventos';

        $table = 'documents';

        $text_delete = "Deseja excluir o documento selecionado?";

        $model_list = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $buttons = (object) [
            [
                'name' => 'Filtrar por evento',
                'route' => null,
                'modal' => 'list',
                'icon' => 'fa fa-list'
            ],
            [
                'name' => 'Documentos',
                'route' => 'documents.index',
                'modal' => null,
                'icon' => 'fa fa-list'
            ]


        ];

        $docs = new Document();

        $model = $docs->onlyTrashed()->where('church_id', $org)->get();

        foreach ($model as $item)
        {
            $item->created_by = $this->personRepository->findByField('id', $item->created_by)->first()->name;

            $item->event_id = null !== $item->event_id ?
                $this->eventRepository->findByField('id', $item->event_id)->first()->name : 'Sem evento';
        }

        $person_id = \Auth::getUser()->person->id;

        $search_not_ready = $doc = $deleted = true;

        return view('custom.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete',
            'title_modal', 'model_list', 'search_not_ready', 'doc', 'person_id', 'deleted'));
    }


    public function activate($id)
    {
        DB::table('documents')->where('id', $id)->update(['deleted_at' => null]);

        return json_encode(['status' => true]);

    }

    public function redirectDownload($id)
    {
        return view('custom.download', compact('id'));
    }

    public function download($id)
    {
        $doc = $this->repository->findByField('id', $id)->first();

        return response()->download($doc->path);
    }

}
