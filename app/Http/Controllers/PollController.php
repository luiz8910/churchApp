<?php

namespace App\Http\Controllers;

use App\Repositories\EventRepository;
use App\Repositories\PersonRepository;
use App\Repositories\PollItensRepository;
use App\Repositories\PollRepository;
use App\Repositories\PollAnswerRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SessionRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\NotifyRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollController extends Controller
{
    use ConfigTrait, DateRepository, NotifyRepository, CountRepository;


    private $repository;

    private $itensRepository;

    private $eventRepository;

    private $personRepository;

    private $answerRepository;

    private $sessionRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(PollRepository $repository, PollItensRepository $itensRepository, SessionRepository $sessionRepository,
                                EventRepository $eventRepository, PersonRepository $personRepository,
                                PollAnswerRepository $answerRepository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->itensRepository = $itensRepository;
        $this->eventRepository = $eventRepository;
        $this->personRepository = $personRepository;
        $this->answerRepository = $answerRepository;
        $this->sessionRepository = $sessionRepository;
        $this->roleRepository = $roleRepository;
    }



    /**
     * @param null $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexOld($event_id = null)
    {
        $org = $this->getUserChurch();

        $th = ['Nome', 'Evento', 'Criado Por', 'Status'];

        $columns = ['id', 'name', 'event_id', 'created_by', 'status', ''];

        $title = "Enquetes";

        $title_modal = 'Lista de Eventos';

        $table = 'polls';

        $text_delete = "Deseja excluir a enquete selecionada?";

        $model_list = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $buttons = (object) [
            [
                'name' => 'Nova Enquete',
                'route' => 'polls.create',
                'modal' => null,
                'icon' => 'fa fa-plus'
            ],
            [
                'name' => 'Filtrar por evento',
                'route' => null,
                'modal' => 'list',
                'icon' => 'fa fa-list'
            ],
            [
                'name' => 'Enquetes Expiradas',
                'route' => 'polls.expired',
                'modal' => null,
                'icon' => 'fa fa-clock-o'
            ],
            [
                'name' => 'Enquetes Excluídas',
                'route' => 'polls.deleted',
                'modal' => null,
                'icon' => 'fa fa-trash-o'
            ]


        ];


        if ($event_id) {
            $model = $this->repository->findWhere(['event_id' => $event_id, 'status' => 'active']);

        }else{

            $model = $this->repository->findWhere(['church_id' => $org, 'status' => 'active']);
        }

        foreach ($model as $item)
        {
            $item->created_by = $this->personRepository->findByField('id', $item->created_by)->first()->name;

            $item->event_name = null !== $item->event_id ?
                $this->eventRepository->findByField('id', $item->event_id)->first()->name : 'Sem evento';

            $item->status = $item->status == 'active' ? 'Coletando Respostas' : 'Desativada';
        }

        $person_id = \Auth::getUser()->person->id;

        $search_not_ready = true;

        $create = 'store';

        return view('polls.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete',
            'title_modal', 'model_list', 'search_not_ready', 'person_id', 'create'));

    }


    public function index($session_id)
    {
        $session = $this->sessionRepository->findByField('id', $session_id)->first();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        $person_id = \Auth::user()->person->id;

        if($session)
        {
            $polls = $this->repository->findByField('session_id', $session_id);

            $event = $this->eventRepository->findByField('id', $session->event_id)->first();

            return view('polls.session_list_quizz',
                compact('session', 'state', 'roles', 'leader', 'admin', 'notify', 'qtde',
                    'event', 'polls', 'person_id'));
        }
    }



    public function deleted($event_id = null)
    {
        $org = $this->getUserChurch();

        $th = ['Nome', 'Evento', 'Criado Por', 'Status'];

        $columns = ['id', 'name', 'event_id', 'created_by', 'status', ''];

        $title = "Enquetes";

        $title_modal = 'Lista de Eventos';

        $table = 'polls';

        $text_delete = "Deseja excluir a enquete selecionada?";

        $model_list = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $buttons = (object) [
            [
                'name' => 'Nova Enquete',
                'route' => 'polls.create',
                'modal' => null,
                'icon' => 'fa fa-plus'
            ],
            [
                'name' => 'Filtrar por evento',
                'route' => null,
                'modal' => 'list',
                'icon' => 'fa fa-list'
            ],
            [
                'name' => 'Enquetes',
                'route' => 'polls.index',
                'modal' => null,
                'icon' => 'fa fa-info-circle'
            ]


        ];


        if ($event_id) {

            $model = $this->repository->findWhere(['event_id' => $event_id, 'status' => 'deactivated']);

        }else{

            $model = $this->repository->findWhere(['church_id' => $org, 'status' => 'deactivated']);
        }

        foreach ($model as $item)
        {
            $item->created_by = $this->personRepository->findByField('id', $item->created_by)->first()->name;

            $item->event_name = null !== $item->event_id ?
                $this->eventRepository->findByField('id', $item->event_id)->first()->name : 'Sem evento';

            $item->status = $item->status == 'active' ? 'Coletando Respostas' : 'Desativada';
        }

        $person_id = \Auth::getUser()->person->id;

        $search_not_ready = true;

        $create = 'store';

        return view('polls.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete',
            'title_modal', 'model_list', 'search_not_ready', 'person_id', 'create'));
    }


    public function create($session_id)
    {
        $events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $session = $this->sessionRepository->findByField('id', $session_id)->first();

        if($session)
        {
            return view('polls.session_new_quizz', compact('events', 'session'));
        }

    }


    public function store(Request $request)
    {

        $data = $request->all();

        $poll['session_id'] = $data['session_id'];
        $poll['content'] = $data['content'];

        $person_id = \Auth::user()->person->id;

        $data['created_by'] = $person_id;

        $id = $this->repository->create($poll)->id;

        foreach ($data['alternative_content'] as $d)
        {
            if($d != "")
            {
                $x['description'] = $d;
                $x['polls_id'] = $id;
                $this->itensRepository->create($x);
            }
        }

        return redirect()->route('event.session.poll.index', ['id' => $data['session_id']]);
    }

    /*
     * Recupera as respostas do quiz
     */
    public function answers($id)
    {
        $answer = DB::table('poll_answers')
                        ->where(['polls_id' => $id])
                        ->distinct()
                        ->select('item_id')
                        ->get();


        $count_ans = $this->answerRepository->findByField('polls_id', $id);


        if(count($answer) > 0)
        {
            foreach ($answer as $a)
            {
                $a->text = $this->itensRepository->find($a->item_id)->description;

                $a->count = count($this->answerRepository->findByField('item_id', $a->item_id));
            }

            return json_encode(['status' => true, 'count_itens' => count($count_ans), 'answers' => $answer]);

        }


    }

    public function storeOld(Request $request)
    {
        $data = $request->only(['name', 'event_id', 'expires_in', 'expires_in_time']);

        $itens = $request->only(['opt_1', 'opt_2']);

        $opt = $request->has(['opt']) ? $request->only(['opt']) : null;

        $date = $this->formatDateBD($data['expires_in']) . $data['expires_in_time'];

        $data['expires_in'] = date_create($date);

        if($data['expires_in'] < Carbon::now())
        {
            $request->session()->flash('error.msg', 'Data Inválida');

            return redirect()->back();
        }

        $person_id = \Auth::user()->person->id;

        $data['created_by'] = $person_id;

        $data['church_id'] = $this->getUserChurch();

        unset($data['expires_in_time']);

        $id = $this->repository->create($data)->id;

        $poll = [];

        $poll['polls_id'] = $id;

        if($opt)
        {
            foreach ($opt["opt"] as $item)
            {
                $poll['description'] = $item;

                $this->itensRepository->create($poll);
            }
        }

        $i = 0;

        while($i < 2)
        {

            $poll['description'] = $i == 0 ? $itens['opt_1'] : $itens['opt_2'];

            $this->itensRepository->create($poll);

            $i++;
        }

        $request->session()->flash('success.msg', 'Enquete inserida com sucesso');

        return redirect()->route('polls.index');
    }





    public function delete($id, $person_id)
    {
        \DB::beginTransaction();

        try{

            $d['deleted_at'] = Carbon::now();

            $d['status'] = 'deactivated';

            $d['deleted_by'] = $person_id;

            $itens = DB::table('poll_itens')->where('polls_id', $id)->select('id')->get();

            $ids = [];

            foreach ($itens as $item)
            {
                $ids[] = $item->id;
            }

            DB::table('poll_answers')->whereIn('item_id', $ids)->update(['deleted_at' => Carbon::now()]);

            DB::table('poll_itens')->where('polls_id', $id)->update(['deleted_at' => Carbon::now()]);

            if($this->repository->update($d, $id))
            {
                \DB::commit();

                return json_encode([
                    'status' => true,
                ]);
            }

        }catch (\Exception $e)
        {
            \DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }


        return json_encode([
            'status' => false
        ]);
    }






    public function expire($id, $person_id)
    {
        $x['status'] = 'deactivated';

        $x['expires_in'] = Carbon::now();

        $x['deleted_by'] = $person_id;

        if($this->repository->update($x, $id))
        {
            return json_encode([
                'status' => true,
            ]);
        }

        return json_encode([
            'status' => false
        ]);
    }


    public function edit($id)
    {
        /*$events = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $model = $this->repository->findByField('id', $id)->first();

        $itens = $this->itensRepository->findByField('polls_id', $id);

        $itens = $itens->sortByDesc('id');

        if($model)
        {
            $model->expires_in_time = date_format(date_create($model->expires_in), 'H:i');

            $model->expires_in = date_format(date_create($model->expires_in), 'd/m/Y');

            return view('polls.edit', compact('model', 'events', 'itens'));
        }

        return redirect()->back();*/

        $session = $this->sessionRepository->findByField('id', $id)->first();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $roles = $this->roleRepository->all();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : null;

        if($session)
        {

        }
    }



    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'event_id', 'expires_in', 'expires_in_time']);

        $opt = $request->has(['opt']) ? $request->only(['opt']) : null;

        $date = $this->formatDateBD($data['expires_in']) . $data['expires_in_time'];

        $data['expires_in'] = date_create($date);

        if($data['expires_in'] < Carbon::now())
        {
            $request->session()->flash('error.msg', 'Data Inválida');

            return redirect()->back();
        }

        $data['church_id'] = $this->getUserChurch();

        unset($data['expires_in_time']);

        $this->repository->update($data, $id);

        $poll = [];

        $poll['polls_id'] = $id;

        if($opt)
        {
            foreach ($opt["opt"] as $item)
            {
                if(is_array($item))
                {
                    $poll['description'] = $item[key($item)];

                    $this->itensRepository->update($poll, key($item));
                }
                else{
                    $poll['description'] = $item;

                    $this->itensRepository->create($poll);
                }

            }
        }

        $request->session()->flash('success.msg', 'Enquete alterado com sucesso');

        return redirect()->route('polls.index');
    }








    public function deleteItem($id)
    {
        if($this->itensRepository->delete($id))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }







    public function expired($event_id = null)
    {
        if($event_id)
        {
            $model = $this->repository->findWhere([
                ['expires_in', '<', Carbon::now()],
                'deleted_at' => null,
                'status' => 'deactivated',
                'event_id' => $event_id
            ]);

        }
        else{

            $model = $this->repository->findWhere([
                ['expires_in', '<', Carbon::now()],
                'deleted_at' => null,
                'status' => 'deactivated'
            ]);

        }

        $th = ['Nome', 'Evento', 'Criado Por', 'Status'];

        $columns = ['id', 'name', 'event_id', 'created_by', 'status', ''];

        $title = "Enquetes";

        $title_modal = 'Lista de Eventos';

        $table = 'polls';

        $text_delete = "Deseja excluir a enquete selecionada?";

        $model_list = $this->eventRepository->findByField('church_id', $this->getUserChurch());

        $buttons = (object) [
            [
                'name' => 'Nova Enquete',
                'route' => 'polls.create',
                'modal' => null,
                'icon' => 'fa fa-plus'
            ],
            [
                'name' => 'Filtrar por evento',
                'route' => null,
                'modal' => 'list',
                'icon' => 'fa fa-list'
            ],
            [
                'name' => 'Enquetes',
                'route' => 'polls.index',
                'modal' => null,
                'icon' => 'fa fa-info-circle'
            ],
            [
                'name' => 'Enquetes Excluídas',
                'route' => 'polls.deleted',
                'modal' => null,
                'icon' => 'fa fa-trash-o'
            ]


        ];

        foreach ($model as $item)
        {
            $item->created_by = $this->personRepository->findByField('id', $item->created_by)->first()->name;

            $item->event_name = null !== $item->event_id ?
                $this->eventRepository->findByField('id', $item->event_id)->first()->name : 'Sem evento';

            $item->status = $item->status == 'active' ? 'Coletando Respostas' : 'Desativada';
        }

        $person_id = \Auth::getUser()->person->id;

        $search_not_ready = true;

        $create = 'store';

        return view('polls.index', compact('model', 'th',
            'buttons', 'title', 'table', 'columns', 'text_delete', 'expired',
            'title_modal', 'model_list', 'search_not_ready', 'person_id', 'create'));
    }


    public function report($id)
    {

        $poll = $this->repository->findByField('id', $id)->first();

        $answer = $this->answerRepository->findByField('polls_id', $id); 

        //dd($answer);
        
        $description = []; $result = []; $count = []; $ids = [];


        foreach ($answer as $key) {
            
            $ids[] = $key->item_id;
        }
        
        $itens = $this->itensRepository->findWhereIn('id', $ids);


        foreach ($itens as $key)
        {
            $description[] = $key->description;

            $result[] = count($this->answerRepository->findByField('item_id', $key->id));

        }

        //dd($result);


        if(count($poll) > 0)
        {

            return view('polls.report', compact('poll', 'description', 'result'));
        }
        else{

            return view('polls.report');
        }
    }







}
