<?php

namespace App\Http\Controllers;

use App\Repositories\DocumentRepository;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Traits\ConfigTrait;
use Illuminate\Http\Request;

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
            ]

        ];


        $id = null !== $request->get('list') ? $request->get('list') : null;

        if ($id) {
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

        $search_not_ready = $doc = true;

        return view('custom.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete',
            'title_modal', 'model_list', 'search_not_ready', 'doc'));

    }

    public function upload(Request $request)
    {
        $data = $request->all();

        if (isset($data['file'])) {

            $data['created_by'] = \Auth::getUser()->person->id;

            $data['event_id'] = isset($data['event_id']) || $data['event_id'] == "" ? $data['event_id'] : null;

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
}
