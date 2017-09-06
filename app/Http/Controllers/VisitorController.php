<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonCreateRequest;
use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use App\Models\Visitor;
use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\GroupRepository;
use App\Repositories\RequiredFieldsRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Services\AgendaServices;
use App\Services\EventServices;
use App\Services\VisitorServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    use DateRepository, CountRepository, NotifyRepository, PeopleTrait, UserLoginRepository, FormatGoogleMaps, ConfigTrait;
    /**
     * @var VisitorRepository
     */
    private $repository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var AgendaServices
     */
    private $agendaServices;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var VisitorServices
     */
    private $visitorServices;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RequiredFieldsRepository
     */
    private $fieldsRepository;

    /**
     * VisitorController constructor.
     * @param VisitorRepository $repository
     * @param RoleRepository $roleRepositoryTrait
     * @param StateRepository $stateRepository
     * @param ChurchRepository $churchRepository
     * @param EventRepository $eventRepository
     * @param GroupRepository $groupRepository
     * @param AgendaServices $agendaServices
     * @param EventServices $eventServices
     * @param VisitorServices $visitorServices
     * @param UserRepository $userRepository
     */
    public function __construct(VisitorRepository $repository, RoleRepository $roleRepositoryTrait,
                                StateRepository $stateRepository, ChurchRepository $churchRepository,
                                EventRepository $eventRepository, GroupRepository $groupRepository,
                                AgendaServices $agendaServices, EventServices $eventServices,
                                VisitorServices $visitorServices, UserRepository $userRepository,
                                RequiredFieldsRepository $fieldsRepository)
    {
        $this->repository = $repository;
        $this->roleRepository = $roleRepositoryTrait;
        $this->stateRepository = $stateRepository;
        $this->churchRepository = $churchRepository;
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
        $this->agendaServices = $agendaServices;
        $this->eventServices = $eventServices;
        $this->visitorServices = $visitorServices;
        $this->userRepository = $userRepository;
        $this->fieldsRepository = $fieldsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::where('deleted_at' , null)->paginate(5);

        foreach ($visitors as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);
        $leader = $this->getLeaderRoleId();

        return view('people.visitors', compact('visitors', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $adults = $this->repository->findWhere(['tag' => 'adult']);

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $route = $this->getRoute();

        return view('people.create-visitors', compact('state', 'countPerson', 'countGroups', 'adults',
            'notify', 'qtde', 'leader', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('img');

        $data = $request->except(['img', '_token']);

        unset($data["role_id"]);

        $fields = $this->fieldsRepository->findWhere([
            'model' => 'visitor',
            'church_id' => $this->getUserChurch()
        ]);

        foreach ($fields as $field) {
            if($field->value == "email"){
                if($field->required == 1 && $data['email'] == ""){
                    \Session::flash("email.exists", "Insira seu email");
                    return redirect()->back()->withInput();
                }
            }
        }

        $verifyFields = $this->verifyRequiredFields($data, 'visitor');

        if($verifyFields)
        {
            \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
            return redirect()->back()->withInput();
        }

        $data['dateBirth'] = $data['dateBirth'] ? $this->formatDateBD($data['dateBirth']) : null;

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $data['created_at'] = Carbon::now();

        $data['updated_at'] = Carbon::now();

        $data["city"] = ucwords($data["city"]);

        $id = DB::table('visitors')->insertGetId($data);

        $this->updateTag($this->tag($data['dateBirth']), $id, 'visitors');

        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'visitors');
        }

        //$church = $request->user()->church_id;

        $visitor = $this->repository->find($id);

        //$visitor->churches()->attach($church);

        $password = $this->churchRepository->find($this->getUserChurch())->alias;

        $user = $this->createUserLogin(null, $password, $data['email'], null);

        $visitor->users()->attach($user);

        return redirect()->route('visitors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->findWhereNotIn('id', [3]);

        $model->dateBirth = $this->formatDateView($model->dateBirth);

        $location = $this->formatGoogleMaps($model);

        $leader = $this->getLeaderRoleId();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $gender = $model->gender == 'M' ? 'F' : 'M';

        $adults = $this->repository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        $notify = $this->notify();

        $qtde = count($notify);

        $route = $this->getRoute();

        return view('people.edit-visitors', compact('model', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'adults', 'notify', 'qtde', 'leader', 'leader', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $user = $this->userRepository->findByField('email', $data["email"])->first() or null;

        //$oldEmail = $user->email;

        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        if($data["dateBirth"] == "")
        {
            $request->session()->flash("email.exists", "Insira a data de Nascimento");
            return redirect()->back()->withInput();
        }

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'visitors');
        }


        //$user = $visitor->users->first() or null;

        /*if(isset($data["password"]))
        {
            if($data["password"] != $data["confirm-password"])
            {
                $request->session()->flash("email.exists", "As senhas não combinam");
                return redirect()->back()->withInput();
            }
        }*/


        if($user)
        {
            if ($user->church_id != null || $user->visitors->first()->id != $id) {
                \Session::flash("email.exists", "Existe uma conta associada para o email informado (" . $data["email"] . ")");

                $request->flashExcept('password');

                return redirect()->back()->withInput();
            }
        }


        if($data["role_id"] != $this->roleRepository->findByField('name', 'Visitante')->first()->id)
        {
            $this->visitorServices->changeRole($data);
        }
        else{
            $visitor = $this->repository->find($id);

            DB::table('users')
                ->where('email', $visitor->users->first()->email)
                ->update([
                    'email' => $data["email"],
                    'updated_at' => Carbon::now()
                ]);
        }

        $verifyFields = $this->verifyRequiredFields($data, 'visitor');

        if($verifyFields)
        {
            \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
            return redirect()->route("visitors.edit", ['visitor' => $id])->withInput();
        }

        $data["city"] = ucwords($data["city"]);

        $this->repository->update($data, $id);

        return redirect()->route('visitors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visitor = $this->repository->find($id);

        $visitor->churches()->detach();

        $visitor->users()->detach();

        $this->repository->delete($id);

        return redirect()->route('visitors.index');
    }

    public function login()
    {
        $churches = $this->churchRepository->orderBy('name')->all();

        return view('auth.visitor', compact('churches'));
    }


    public function visitors()
    {
        $church = $this->getUserChurch();

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $events = Event::where('church_id', $church)->paginate(5);

        //$notify = $this->notify();

        //$qtde = count($notify) or 0;

        $groups = null;

        if (count($events) == 0) {
            return view('dashboard.visitors', compact('countPerson', 'countGroups', 'events',
                'countMembers', 'street', 'groups', 'leader'));
        }

        $groups = Group::where('church_id', $church)->paginate(5);

        foreach ($groups as $group) {
            $group->sinceOf = $this->formatDateView($group->sinceOf);
            $countMembers[] = count($group->people->all());
        }


        /*
         * Inicio Agenda
         */

        //Dia Atual
        $today = date("Y-m-d");

        //Recupera todos os meses
        $allMonths = $this->agendaServices->allMonths();

        //Recuperar todos os dias da semana
        $allDays = $this->agendaServices->allDaysName();

        //Recupera a semana atual
        $days = $this->agendaServices->findWeek();

        //Contador de semanas
        $cont = 1;

        //Numero de Semanas
        $numWeek = $this->getDefaultWeeks();

        //Listagem até a 6° semana por padrão
        while ($cont < $numWeek) {
            $time = $cont == 1 ? 'next' : $cont;

            $days = array_merge($days, $this->agendaServices->findWeek($time));

            $cont++;
        }

        //Retorna todos os eventos
        $allEvents = $this->eventServices->allEvents($church);

        $allEventsNames = [];
        $allEventsTimes = [];
        $allEventsFrequencies = [];
        $allEventsAddresses = [];

        foreach ($allEvents as $allEvent) {
            $e = $this->eventRepository->find($allEvent->event_id);

            //Nome de todos os eventos
            $allEventsNames[] = $e->name;

            //Hora de inicio de todos os eventos
            $allEventsTimes[] = $e->startTime;

            //Frequência de todos os eventos
            $allEventsFrequencies[] = $e->frequency;

            //Todos os endereços
            $allEventsAddresses[] = $e->street . ", " . $e->neighborhood . "\n" . $e->city . ", " . $e->state;
        }

        //dd($allEventsNames);
        //Recupera o mês atual
        $thisMonth = $this->agendaServices->thisMonth();

        //Ano Atual
        $ano = date("Y");


        /*
         * Fim Agenda
         */

        $church_id = $church;

        return view('dashboard.visitors', compact('countPerson', 'countGroups', 'events', 'notify', 'qtde',
            'street', 'groups', 'countMembers', 'allMonths', 'days',
            'allMonths', 'allDays', 'days', 'allEvents',
            'thisMonth', 'today', 'ano', 'allEventsNames', 'allEventsTimes',
            'allEventsFrequencies', 'allEventsAddresses', 'numWeek', 'church_id'));
    }


    public function imgEditProfile(Request $request, $id)
    {
        $name = $this->repository->find($id)->name;

        $file = $request->file('img');

        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('visitors')->
        where('id', $id)->
        update(['imgProfile' => $imgName]);

        return redirect()->back();
    }

    public function getList()
    {
        $header[] = "Nome";
        $header[] = "CPF";
        $header[] = "Cargo";
        $header[] = "Data de Nasc.";

        $i = 0;

        $text = "";

        $church_id = $this->getUserChurch();

        $visitors = $this->repository->findByField('church_id', $church_id);

        while ($i < count($visitors)) {
            $visitors[$i]->dateBirth = $this->formatDateView($visitors[$i]->dateBirth);

            $visitors[$i]->role_id = "Visitante";

            $x = $i == (count($visitors) - 1) ? "" : ",";

            $text .= '["' . $visitors[$i]->name . ' ' . $visitors[$i]->lastName . '","' . '' . $visitors[$i]->cpf . '' . '","' . '' . $visitors[$i]->role_id . '' . '","' . '' . $visitors[$i]->dateBirth . '"' . ']' . $x . '';

            $i++;
        }


        $json = '{
              "content": [
                {
                  "table": {
                    "headerRows": 1,
                    "widths": [ "*", "auto", 100, "*" ],
            
                    "body":[
                      ["' . $header[0] . '", "' . $header[1] . '", "' . $header[2] . '", "' . $header[3] . '"],
                      ' . $text . '
                    ]
                  }
                }
              ]
            }';

        if (env('APP_ENV') == "local") {
            File::put(public_path('js/print.json'), $json);
        } else {
            File::put(getcwd() . '/js/print.json', $json);
        }
    }

    public function checkCPF($cpf)
    {
        return $this->traitCheckCPF($cpf)->first();
    }
}
