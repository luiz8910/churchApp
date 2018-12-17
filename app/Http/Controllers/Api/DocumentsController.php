<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\DocumentRepository;
use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
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

    public function index($id = null)
    {
        if ($id) {
            $documents = $this->repository->findByField('event_id', $id);

            $qtde = count($documents);

            if ($qtde > 0) {
                return json_encode([
                    'status' => true,
                    'qtde' => $qtde,
                    'documents' => $documents
                ]);
            } else {

                return json_encode([
                    'status' => false,
                    'msg' => 'Não há arquivos deste evento'
                ]);
            }
        }

        $documents = $this->repository->all();

        $qtde = count($documents);

        if ($qtde > 0) {
            return json_encode([
                'status' => true,
                'qtde' => $qtde,
                'documents' => $documents
            ]);
        } else {

            return json_encode([
                'status' => true,
                'qtde' => $qtde,
            ]);
        }
    }

    /*
     * Busca por documento pelo nome
     */
    public function find($name)
    {
        $doc = $this->repository->findByField('name', $name);

        $qtde = count($doc);

        if($qtde > 0)
        {

            return json_encode([
                'status' => true,
                'qtde' => $qtde,
                'doc' => $doc
            ]);
        }

        return json_encode([
            'status' => false,
            'qtde' => 0
        ]);

    }

    /*
     * Procura documento pelo nome, modo instant search
     */
    public function search($input)
    {
        $docs = DB::table('documents')
            ->where([
                ['name', 'like', '%'.$input.'%'],
            ])->get();

        $qtde = count($docs);

        if($qtde)
        {
            return json_encode([
                'status' => true,
                'qtde' => $qtde,
                'documents' => $docs
            ]);
        }

        return json_encode([
            'status' => true,
            'qtde' => $qtde

        ]);
    }

    public function upload(Request $request)
    {
        $data = $request->all();

        if (isset($data['file'])) {

            $data['event_id'] = isset($data['event_id']) || $data['event_id'] == "" ? $data['event_id'] : null;

            if(isset($data['person_id']))
            {
                $org = $this->personRepository->findByField('id', $data['person_id'])->first()->church_id;

                $data['church_id'] = $org;
            }

            $file = $request->file('file');

            unset($data['file']);

            $data['name'] = $file->getClientOriginalName();

            $data['type'] = $file->getClientOriginalExtension();

            $id = $this->repository->create($data)->id;

            $fileName = $id . '-' . $file->getClientOriginalName();

            $file->move('uploads/documents/', $fileName);

            $d['path'] = 'uploads/documents/'. $fileName;

            $this->repository->update($d, $id);

            return json_encode([
                'status' => true
            ]);

        } else {
            return json_encode([
                'status' => false,
                'msg' => 'Nenhum arquivo enviado.'
            ]);
        }


    }

    public function download($id)
    {
        $doc = $this->repository->findByField('id', $id)->first();

        return response()->download($doc->path);
    }

    public function delete($file_id, $person_id)
    {
        $doc = $this->repository->findByField('id', $file_id)->first()
            ? $this->repository->findByField('id', $file_id)->first() : null;

        if($doc)
        {
            $a['deleted_by'] = $person_id;

            $this->repository->update($a, $file_id);

            $this->repository->delete($file_id);

            return json_encode([
                'status' => true,
                'msg' => 'Arquivo excluido'
            ]);
        }

        return json_encode([
            'status' => false,
            'msg' => 'Arquivo não encontrado'
        ]);
    }
}
