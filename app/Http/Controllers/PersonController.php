<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Events\PersonEvent;
use App\Http\Requests\PersonCreateRequest;
use App\Models\Event;
use App\Models\Person;
use App\Models\RecentUsers;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EventNotification;
use App\Notifications\Notifications;
use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\GroupRepository;
use App\Repositories\ImportRepository;
use App\Repositories\RequiredFieldsRepository;
use App\Repositories\UploadStatusRepository;
use App\Services\EventServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\FormatGoogleMaps;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Traits\PeopleTrait;
use App\Traits\UserLoginRepository;
use App\Repositories\UserRepository;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Notification;
use File;

class PersonController extends Controller
{
    use DateRepository, CountRepository, FormatGoogleMaps, UserLoginRepository,
        NotifyRepository, EmailTrait, PeopleTrait, ConfigTrait;
    /**
     * @var PersonRepository
     */
    private $repository;
    /**
     * @var StateRepository
     */
    private $stateRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RequiredFieldsRepository
     */
    private $fieldsRepository;
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var UploadStatusRepository
     */
    private $uploadStatusRepository;
    /**
     * @var ImportRepository
     */
    private $importRepository;

    public function __construct(PersonRepository $repository, StateRepository $stateRepositoryTrait, RoleRepository $roleRepository,
                                UserRepository $userRepository, RequiredFieldsRepository $fieldsRepository, EventSubscribedListRepository $listRepository,
                                GroupRepository $groupRepository, ChurchRepository $churchRepository, EventRepository $eventRepository,
                                EventServices $eventServices, UploadStatusRepository $uploadStatusRepository, ImportRepository $importRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepositoryTrait;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        $this->fieldsRepository = $fieldsRepository;
        $this->listRepository = $listRepository;
        $this->groupRepository = $groupRepository;
        $this->churchRepository = $churchRepository;
        $this->eventRepository = $eventRepository;
        $this->eventServices = $eventServices;
        $this->uploadStatusRepository = $uploadStatusRepository;
        $this->importRepository = $importRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adults = DB::table("people")
            ->where([
                'tag' => 'adult',
                'deleted_at' => null,
                'church_id' => $this->getUserChurch()
            ])->paginate(5);


        foreach ($adults as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify);

        $leader = $this->getLeaderRoleId();

        return view('people.index', compact('adults', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader'));
    }

    public function teenagers()
    {
        $teen = DB::table("people")
            ->where([
                ['tag', '<>', 'adult'],
                'deleted_at' => null,
                'church_id' => $this->getUserChurch()
            ])->paginate(5);

        foreach ($teen as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);
        $leader = $this->getLeaderRoleId();

        return view('people.teenagers', compact('teen', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader'));
    }


    public function inactive()
    {
        $inactive = Person::onlyTrashed()->paginate(5);

        foreach ($inactive as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();
        $countGroups[] = $this->countGroups();
        $notify = $this->notify();
        $qtde = count($notify);
        $leader = $this->getLeaderRoleId();

        return view('people.inactive', compact('inactive', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader'));
    }

    public function reactivate($person)
    {
        $person = Person::onlyTrashed()
                    ->where('id', $person)
                    ->first();

        if(count($person) > 0)
        {
            if($person->tag == 'adult')
            {
                $user = $person->user()->withTrashed()->first();

                if($user){
                    $user->restore();
                }

            }

            $person->restore();

            if($person->maritalStatus == 'Casado' && $person->partner != 0)
            {
                $partner = $this->repository->find($person->partner);

                Person::where('id', $partner->id)->update(['partner' => $person->id]);
            }

//            if($person->hasKids)
//            {
//                $parent = $person->gender == 'M' ? Person::where('father_id', $person->id)->get()
//                    : Person::where('mother_id', $person->id)->get();
//
//
//            }

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function forceDelete($person)
    {
        $person = Person::onlyTrashed()
            ->where('id', $person)
            ->first();

        if(count($person) > 0)
        {
            if ($person->tag == 'adult') {
                $user = $person->user()->withTrashed()->first();

                if($user){
                    $user->forceDelete();
                }
            }

            $person->forceDelete();

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state = $this->stateRepository->all();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $roles = $this->roleRepository->findWhereNotIn('id', [$visitor_id]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $notify = $this->notify();

        $qtde = count($notify);

        $fields = $this->fieldsRepository->findWhere([
            'model' => 'person',
            'church_id' => $this->getUserChurch()
        ]);

        //dd($fields[0]);

        $church_id = $this->getUserChurch();

        $partner = $this->repository->findByField('partner', null);

        $adults = $this->repository->findWhere(
            [
                'tag' => 'adult',
                'church_id' => $church_id,
                ['partner', '=', 0]
            ]
        )->union($partner);


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->whereNull('people.deleted_at')
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->whereNull('people.deleted_at')
            ->get();

        $route = $this->getRoute();

        return view('people.create', compact('state', 'roles', 'countPerson', 'countGroups',
            'adults', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'fields', 'route'));
    }

    public function createTeen()
    {
        $state = $this->stateRepository->all();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $member_id = $this->roleRepository->findByField('name', 'Membro')->first()->id;

        $roles = $this->roleRepository->findWhereIn('id', [$member_id, $visitor_id]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $church_id = $this->getUserChurch();

        $notify = $this->notify();

        $qtde = count($notify);

        $route = $this->getRoute();

        $adults = $this->repository->findWhere(['tag' => 'adult', 'church_id' => $church_id]);

        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id,
                    'people.deleted_at' => null
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id,
                    'people.deleted_at' => null
                ]
            )
            ->get();



        return view('people.create-teen', compact('state', 'roles', 'countPerson', 'countGroups',
            'adults', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $this->fieldsRepository->findWhere([
            'model' => 'person',
            'church_id' => $this->getUserChurch()
        ]);

        $file = $request->file('img');

        $email = $request->only(['email']);

        /*$password = $request->only(['password']);

        $confirmPass = $request->only(['confirm-password']);

        $password = implode('=>', $password);

        $confirmPass = implode('=>', $confirmPass);*/

        $teen = $request->get('teen') or null;

        $email = $email["email"];

        /*if(!$teen)
        {
            /*if(!$password){
                \Session::flash("email.exists", "Escolha uma senha");
                return redirect()->route("person.create")->withInput();
            }
            elseif($password != $confirmPass){
                \Session::flash("email.exists", "As senhas não combinam");
                $request->flashExcept('password');

                return redirect()->route("person.create")->withInput();
            }


        }*/


        if($request->get('dateBirth') == ""){

            \Session::flash("email.exists", "Insira a data de Nascimento");

            if($teen)
            {
                return redirect()->route("teen.create")->withInput();
            }
            else{
                return redirect()->route("person.create")->withInput();
            }

        }


        $user = User::select('id')->where('email', $email)->first() or null;

        if($user)
        {
            \Session::flash("email.exists", "Existe uma conta associada para o email informado (" .$email. ")");

            $request->flashExcept('password');

            return redirect()->route("person.create")->withInput();
        }

        $data = $request->except(['img', 'password', 'confirm-password', '_token']);

        if($teen)
        {
            $data["email"] = $email;

            $verifyFields = $this->verifyRequiredFields($data, 'teen');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("teen.create")->withInput();
            }

        }else{
            unset($data["email"]);

            $verifyFields = $this->verifyRequiredFields($data, 'person');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("person.create")->withInput();
            }
        }


        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['dateBaptism'] = $data['dateBaptism'] == "" ? null :$this->formatDateBD($data['dateBaptism']);

        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $children = $request->get('group-a');

        if(isset($data['father_id_input']) || isset($data['mother_id_input'])){
            if($data['father_id_input'] || $data['mother_id_input'])
            {
                $data['father_id'] = $data['father_id_input'] or null;
                $data['mother_id'] = $data['mother_id_input'] or null;
            }
        }

        if(!isset($data["maritalStatus"])){
            $data["maritalStatus"] = "Solteiro";
        }

        if(!isset($data["role_id"])){
            $member = $this->roleRepository->findByField('name', 'Membro')->first()->id;
            $data["role_id"] = $member;
        }

        $data["church_id"] = $this->getUserChurch();

        $data["city"] = ucwords($data["city"]);

        $id = $this->repository->create($data)->id;

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'people');
        }

        $church_id = $this->getUserChurch();

        if ($this->repository->isAdult($data['dateBirth'])) {

            $password = $this->churchRepository->find($church_id)->alias;

            $user = $this->createUserLogin($id, $password, $email, $church_id);

            $this->welcome($user, $password);

            if ($children) {
                $this->children($children, $id, $data['gender'], $data["role_id"]);
            }

        }

        $this->updateTag($this->tag($data['dateBirth']), $id, 'people');

        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'people');
        }

        $this->newRecentUser($id, $church_id);

        if($teen){
            Session::flash('teen.crud', 'Usuário '. $data['name'] . ' criado com sucesso');
            return redirect()->route('person.teen');
        }

        Session::flash('person.crud', 'Usuário '. $data['name'] . ' criado com sucesso');
        return redirect()->route('person.index');
    }


    public function imgEditProfile(Request $request, $id)
    {
        $name = $this->repository->find($id)->name;

        $file = $request->file('img');

        $imgName = 'uploads/profile/' . $id . '-' . $name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        return redirect()->back();
    }




    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $user = $model->user;

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $model->dateBirth = $this->formatDateView($model->dateBirth);

        $model->dateBaptism = !$model->dateBaptism ? null : $this->formatDateView($model->dateBaptism);

        $leader = $this->getLeaderRoleId();

        $location = $this->formatGoogleMaps($model);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $route = $this->getRoute();

        $fields = $this->fieldsRepository->findWhere([
            'model' => 'person',
            'church_id' => $this->getUserChurch()
        ]);

        $gender = $model->gender == 'M' ? 'F' : 'M';

        $church_id = $this->getUserChurch();

        $partner = null;

        if($model->maritalStatus == "Casado")
        {
            $adults = DB::table('people')
                ->where([
                    'tag' => 'adult',
                    'church_id' => $church_id,
                    'gender' => $gender,
                ])
                ->whereIn('partner', [null, 0, $id])
                ->whereNull('deleted_at')
                ->get();
        }
        else{

            $adults = DB::table('people')
                ->where([
                    'tag' => 'adult',
                    'church_id' => $church_id,
                    'gender' => $gender,
                ])
                ->whereIn('partner', [null, 0])
                ->whereNull('deleted_at')
                ->get();
        }

        $notify = $this->notify();

        $qtde = count($notify);

        $children = null;

        if($model->hasKids == 1)
        {
            $parent = $model->gender == "M" ? 'father_id' : 'mother_id';

            $children = $this->repository->findByField($parent, $user->id);

            foreach ($children as $child)
            {
                $child->dateBirth = $this->formatDateView($child->dateBirth);
            }

        }


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    ['people.id', '<>', $id],
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id,
                    'people.deleted_at' => null
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    ['people.id', '<>', $id],
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id,
                    'people.deleted_at' => null
                ]
            )
            ->get();

        $list = $this->listRepository->findByField('person_id', $model->id);

        $arr = [];
        $events = [];

        if(count($list) > 0)
        {
            foreach ($list as $item) {
                $arr[] = $item->event_id;
            }

            $events = DB::table('events')
                ->whereIn('id', $arr)
                ->paginate(5);


            foreach ($events as $event) {
                //$e = $this->eventRepository->find($event->event_id);
                $u = $this->userRepository->find($event->createdBy_id);
                $event->createdBy_name = $u->person->name;
                $event->createdBy_id = $u->person_id;
                $event->group_id = $event->group_id ? $this->groupRepository->find($event->group_id)->name : "Sem Grupo";

            }
        }

        $role = $this->getUserRole();

        return view('people.edit', compact('model', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'adults', 'notify', 'qtde', 'fathers', 'mothers', 'children',
            'leader', 'fields', 'events', 'role', 'route'));
    }


    public function editTeen($id)
    {
        $model = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $model->dateBirth = $this->formatDateView($model->dateBirth);

        $model->dateBaptism = !$model->dateBaptism ? null : $this->formatDateView($model->dateBaptism);

        $location = $this->formatGoogleMaps($model);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $church_id = $this->getUserChurch();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $route = $this->getRoute();


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id
                ]
            )
            ->get();


        $mothers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'F',
                    'users.church_id' => $church_id
                ]
            )
            ->get();

        return view('people.edit-teen', compact('model', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'route'));
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
        $data = $request->except(['email']);

        $email = $request->only('email');

        $teen = $request->get('teen') or null;

        $fields = $this->fieldsRepository->findWhere([
            'model' => 'person',
            'church_id' => $this->getUserChurch()
        ]);

        //Formatação correta do email
        $email = $email["email"];

        if($request->get('dateBirth') == ""){

            \Session::flash("email.exists", "Insira a data de Nascimento");

            if($teen){
                return redirect()->route("teen.edit", ['person' => $id])->withInput();
            }else
            {
                return redirect()->route("person.edit", ['person' => $id])->withInput();
            }

        }

        if(!$teen)
        {
            foreach ($fields as $field) {
                if($field->value == "email"){
                    if($field->required == 1 && $email == ""){
                        \Session::flash("email.exists", "Insira seu email");
                        return redirect()->route("person.edit", ['person' => $id])->withInput();
                    }
                }
            }
        }

        if($teen)
        {
            $verifyFields = $this->verifyRequiredFields($data, 'teen');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("teen.edit", ['person' => $id])->withInput();
            }

        }else{
            $verifyFields = $this->verifyRequiredFields($data, 'person');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("person.edit", ['person' => $id])->withInput();
            }
        }



        //Formatação correta da data
        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        if(isset($data['father_id_input']) || isset($data['mother_id_input'])){
            if($data['father_id_input'] || $data['mother_id_input'])
            {
                $data['father_id'] = $data['father_id_input'] or null;
                $data['mother_id'] = $data['mother_id_input'] or null;
            }
        }


        if(!isset($data['maritalStatus']))
        {
            $data['maritalStatus'] = 'Solteiro';
        }

        if(!isset($data["role_id"]))
        {
            $member = $this->roleRepository->findByField('name', 'Membro')->first()->id;
            $data["role_id"] = $member;
        }

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;

            $status = $this->repository->find($id);

            if($status->maritalStatus == "Casado")
            {
                $this->updateMaritalSingleStatus($status->partner, $data["maritalStatus"], 'people');
            }

        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'people');
        }

        $user = $this->userRepository->findByField('person_id', $id)->first();

        if($email)
        {
            if($this->emailTestEditTrait($email, $user->id)){
                $this->updateEmail($email, $user->id);
            }
            else{
                \Session::flash("email.exists", "Existe uma conta associada para o email informado " . "(".$email.")");
                return redirect()->route("person.edit", ['person' => $id]);
            }
        }

        $this->updateTag($this->tag($data["dateBirth"]), $id, 'people');

        $data["city"] = ucwords($data["city"]);

        $this->repository->update($data, $id);

        if($teen){
            if(is_numeric($data['father_id'])){
                $parentId = $this->repository->find($data['father_id'])->id;

                DB::table('people')
                    ->where('id', $parentId)
                    ->update([
                        'hasKids' => 1,
                        'updated_at' => Carbon::now()
                    ]);
            }
            if(is_numeric($data['mother_id'])){
                $parentId = $this->repository->find($data['mother_id'])->id;

                DB::table('people')
                    ->where('id', $parentId)
                    ->update([
                        'hasKids' => 1,
                        'updated_at' => Carbon::now()
                    ]);
            }

            Session::flash('teen.crud', 'Usuário '. $data['name'] . ' alterado com sucesso');
            return redirect()->route('person.teen');
        }

        Session::flash('person.crud', 'Usuário '. $data['name'] . ' alterado com sucesso');
        return redirect()->route('person.index');
    }

    public function updateEmail($email, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(['email' => $email]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $person = $this->repository->find($id);

        if($person->tag == "adult")
        {
            $user = $person->user->id;
        }
        else{
            $this->destroyTeen($id);
        }

        if(isset($user)) {
            $this->userRepository->delete($user);


            RecentUsers::where('person_id', $id)->delete();

            $person->delete();

            return json_encode(
                [
                    'status' => true,
                    'name' => $person->name . " " . $person->lastName
                ]);
        }

    }

    public function destroyTeen($id)
    {
        $person = $this->repository->find($id);

        RecentUsers::where('person_id', $id)->delete();

        $person->delete();

        return json_encode(
            [
                'status' => true,
                'name' => $person->name . " " . $person->lastName
            ]);
    }

    public function detachTeen($id, $parentId)
    {
        $adult = $this->repository->find($parentId);

        $parent = $adult->gender == "M" ? 'father_id' : 'mother_id';

        DB::table('people')
            ->where('id', $id)
            ->update([
                $parent => null,
                'updated_at' => Carbon::now()
            ]);

        $hasKids = $this->repository->findByField($parent, $parentId);

        if(count($hasKids) == 0)
        {
            DB::table('people')
                ->where('id', $parentId)
                ->update([
                    'hasKids' => null,
                    'updated_at' => Carbon::now()
                ]);
        }

        return json_encode(true);
    }

    /*public function notify()
    {
        $user[] = User::findOrFail(1);

        $user[] = User::findOrFail(11);

        //$user->notify(new Notifications('123'));

        $person = $this->repository->find(1);

        //dd($person);

        $event = Event::findOrFail(1);

        //event(new AgendaEvent($event));

        //event(new PersonEvent($person));

        //event(new PersonEvent("teste"));

        foreach ($user as $item) {
            \Notification::send($item, new Notifications('novo Evento'));
        }


    }*/


    public function email()
    {
        $person = Person::find(1);
        Mail::to(User::find(1))->send(new teste($person));
    }


    public function getList($tag)
    {
        $people = "";

        $church_id = $this->getUserChurch();

        if ($tag == "person") {
            $people = $this->repository->findWhere([
                ['tag' => 'adult'],
                ['church_id' => $church_id]
            ]);
        } elseif ($tag == "teen") {
            $people = $this->repository->findWhere([
                ['tag', '<>', 'adult'],
                ['church_id' => $church_id]
            ]);
        }

        $header[] = "Nome";
        $header[] = "CPF";
        $header[] = "Cargo";
        $header[] = "Data de Nasc.";

        $i = 0;

        $text = "";

        while ($i < count($people)) {
            $people[$i]->dateBirth = $this->formatDateView($people[$i]->dateBirth);

            $people[$i]->role_id = $people[$i]->role->name;

            $x = $i == (count($people) - 1) ? "" : ",";

            $text .= '["' . $people[$i]->name . ' ' . $people[$i]->lastName . '","' . '' . $people[$i]->cpf . '' . '","' . '' . $people[$i]->role_id . '' . '","' . '' . $people[$i]->dateBirth . '"' . ']' . $x . '';

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

    public function getListPeople()
    {
        return $this->getList("person");
    }

    public function getListTeen()
    {
        return $this->getList("teen");
    }

    public function personExcel($format)
    {
        return $this->excel($format, "person");
    }

    public function teenExcel($format)
    {
        return $this->excel($format, "teen");
    }

    public function visitorsExcel($format)
    {
        return $this->excel($format, 'visitors');
    }

    public function inactiveExcel($format)
    {
        return $this->excel($format, 'inactive');
    }

    public function excel($format, $tag)
    {
        $data = "";
        $planName = "";

        if ($tag == "person") {
            $data = $this->repository->findByField('tag', 'adult');
            $planName = 'Adultos';

        } elseif ($tag == "teen") {
            $data = $this->repository->findWhere([
                ['tag', '<>', 'adult']
            ]);

            $planName = 'Crianças e Adolescentes';

        } elseif ($tag == "visitors") {
            $role = $this->roleRepository->findByField('name', 'Visitante')->first();

            $data = $this->repository->findByField('role_id', $role->id);

            $planName = 'Visitantes';
        }
        elseif ($tag == "inactive")
        {
            $data = $this->repository->findWhere([
                ['deleted_at', '<>', null]
            ]);

            $planName = 'Inativos';
        }

        $info = [];

        for ($i = 0; $i < count($data); $i++) {
            $info[$i]["Nome"] = $data[$i]->name;
            $info[$i]["CPF"] = $data[$i]->cpf;
            $info[$i]["Cargo"] = $data[$i]->role->name;
            $info[$i]["Data de Nasc."] = $this->formatDateView($data[$i]->dateBirth);
        }

        Excel::create($planName, function ($excel) use ($info, $planName){

            $excel->sheet($planName, function ($sheet) use ($info, $planName){
                $sheet->fromArray($info);
            });
        })->export($format);
    }

    public function storeVisitors(PersonCreateRequest $request)
    {
        return redirect()->route('person.visitors');
    }

    public function automaticCep($id, $user)
    {
        $user = $user == 1 ? $this->userRepository->find($id)->person : null;

        if($user)
        {
            $person = $this->repository->find($user->id);
        }
        else{
            $person = $this->repository->find($id);
        }


        return json_encode(
            [
                'status' => true,
                'cep' => $person->zipCode,
                'number' => $person->number
            ]
        );
    }

    public function checkCPF($cpf)
    {
        return $this->traitCheckCPF($cpf);
    }

    /*
     * Planilha com todos os contatos da igreja
     */
    public function getChurchContacts(Request $request)
    {
        $church = $this->getUserChurch();

        $file = $request->file('file');

        $name = $file->getClientOriginalName();

        $fileName = 'file.' . $file->getClientOriginalExtension();

        $alias = $this->churchRepository->find($church)->alias;

        $path = 'uploads/sheets/'.$alias.'/';

        $file->move($path, $fileName);

        $i = -1;

        $import['code'] = bin2hex(random_bytes(15));

        $import['table'] = 'people';

        $import['church_id'] = $church;

        $this->importRepository->create($import);

        DB::transaction(function () use($church, $alias, $i, $path, $fileName, $name, $import){

        Excel::load($path . $fileName, function ($reader) use($church, $alias, $i, $import){

            foreach ($reader->get() as $item)
            {
                    /*echo $item->nome . "\n\n";*/

                    //dd($reader->get());

                    $fullName = $this->surname($item->nome);

                    $data["name"] = ucfirst($fullName[0]);
                    $data["lastName"] = ucwords($fullName[1]);

                    $name = $this->repository->findByField('name', $data['name']);

                    $stop = false;

                    if(count($name) > 0)
                    {
                        foreach ($name as $n)
                        {
                            if($n->name == $data["name"] && $n->lastName == $data["lastName"])
                            {
                                $stop = true;
                            }
                        }
                    }

                    //Novo Cadastro
                    if(!$stop) {
                        $data_nasc = "data_nasc.";

                        if ($item->$data_nasc != null) {
                            $data["dateBirth"] = date_format($item->$data_nasc, "Y-m-d");


                            $data["church_id"] = $church;

                            if ($item->membro == "S") {
                                $data["role_id"] = $this->roleRepository->findByField('name', 'Membro')->first()->id;

                                if ($item->classificacao == "PLENA") {
                                    $data["deleted_at"] = null;
                                }
                                else{
                                    $data["deleted_at"] = Carbon::now();
                                }
                            } else {

                                $data["role_id"] = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

                                if ($item->classificacao != "PLENA") {
                                    $data["deleted_at"] = Carbon::now();
                                }
                            }

                            $data['imgProfile'] = 'uploads/profile/noimage.png';

                            $tel = "tel.residencial";

                            $data["tel"] = $item->$tel;

                            $cel = "celular";

                            $data["cel"] = $item->$cel;

                            $gender = isset($item->genero) ? "genero" : isset($item->sexo) ? "sexo" : "gênero";

                            $data["gender"] = $item->$gender;

                            $maritalStatus = "estado_civil";

                            $data["maritalStatus"] = $item->$maritalStatus == "SEPARADO" ? "Divorciado" : ucfirst($item->$maritalStatus);

                            if ($data["maritalStatus"] == "Casado") {
                                $data["partner"] = 0;
                            }

                            $data["tag"] = $this->tag($data["dateBirth"]);

                            $dateBaptism = "dt.batismo";

                            $data["dateBaptism"] = isset($item->$dateBaptism) ? $item->$dateBaptism != null ? date_format($item->$dateBaptism, "Y-m-d") : null : null;

                            $email = isset($item->email) ? "email" : "e_mail";

                            if ($data["tag"] != "adult") {
                                $data["email"] = isset($item->$email) ? $item->$email : null;
                            }

                            $data["zipCode"] = isset($item->cep) ? $item->cep : null;

                            $data["street"] = isset($item->endereco) ? $item->endereco : null;

                            $data["city"] = isset($item->cidade) ? $item->cidade : null;

                            $data["state"] = $item->estado == "EX" ? null : $item->estado;

                            $data["import_code"] = $import["code"];

                            $id = $this->repository->create($data)->id;

                            $i++;

                            if ($data["tag"] == "adult" && isset($item->$email)) {
                                $this->createUserLogin($id, $alias, $item->$email, $church);
                            }
                        }
                    }


                echo $data["name"] . " " . $data["lastName"] .  "\n";
            }



            session(['qtde' => $i]);

        })->get();

        $qtde[] = session('qtde');

        //\Session::flash('upload.success', $qtde[0] . " usuários foram cadastrados");

        $this->uploadComplete($name, $qtde[0]);

        });
        //return redirect()->route('config.person.contacts.view');
        //return response()->json('success', 200);
        //return response()->view('config.dropzone', $qtde, 200);
    }

    public function surname($name)
    {
        $token = strtok($name, " ");

        $i = 0;

        $firstName = '';
        $lastName = '';

        while ($token !== false)
        {
            if($i == 0)
            {
                $firstName = $token;
            }
            else{
                $lastName .= $token . " ";
                $token = strtok(" ");
            }

            $i++;
        }

        $lastName = str_replace($firstName, " ", $lastName);

        $lastName = trim($lastName);

        $arr[] = $firstName;
        $arr[] = $lastName;

        return $arr;
    }

    /*
     * Usado para encontrar eventos/grupos
     * criado pelo usuário prestes a ser excluído
     * $id = id do usuário (person_id)
     */
    public function findUserAction($id)
    {
        $user = $this->repository->find($id)->user;

        $groups = $this->groupRepository->findByField('owner_id', $user->id);

        $events = $this->eventRepository->findByField('createdBy_id', $user->id);

        if(count($groups) > 0 || count($events) > 0)
        {
            return json_encode(
                [
                    'status' => true,
                    'groups' => $groups,
                    'events' => $events
                ]
            );
        }

        return json_encode(['status' => false]);
    }

    /*
     * Ativado quando o usuário é excluído, porém
     * os eventos e/ou grupos criados pelo mesmo serão
     * mantidos e transferidos.
     */
    public function keepActions($id)
    {
        $person = $this->repository->find($id);

        $user = $person->user;

        $groups = $this->groupRepository->findByField('owner_id', $user->id);

        $events = $this->eventRepository->findByField('createdBy_id', $user->id);

        $transfer_to = DB::table('transfer_to')
                ->where(
                    ['church_id' => $this->getUserChurch()]
                )
                ->value('person_id');

        $transfer_to_user = $this->repository->find($transfer_to);

        if(count($groups) > 0)
        {
            $data["owner_id"] = $transfer_to_user->user->id;

            foreach ($groups as $group)
            {
                $this->groupRepository->update($data, $group->id);
            }
        }


        if(count($events) > 0)
        {
            $data["createdBy_id"] = $transfer_to_user->user->id;

            foreach ($events as $event)
            {
                $this->eventServices->UnsubUser($id, $event->id);
                $this->eventServices->subEvent($event->id, $transfer_to);
                $this->eventRepository->update($data, $event->id);
            }
        }

        return json_encode([
            'status' => true,
            'name' => $transfer_to_user->name
        ]);
    }

    /*
     * Ativado quando o usuário é excluído, e
     * os eventos e/ou grupos criados pelo mesmo
     * também serão excluídos.
     */
    public function deleteActions($id)
    {
        $person = $this->repository->find($id);

        $user = $person->user;

        $groups = $this->groupRepository->findByField('owner_id', $user->id);

        $events = $this->eventRepository->findByField('createdBy_id', $user->id);

        if(count($groups) > 0)
        {
            foreach ($groups as $group)
            {
                $group->delete();
            }
        }

        if(count($events) > 0)
        {
            foreach ($events as $event)
            {
                $event->delete();
            }
        }

        return json_encode(['status' => true]);
    }

    /*
     * Verifica o estado civil do usuário a
     * ser excluído. Se for casado marca o conjugê como
     * casado com "Parceiro(a) fora da igreja"
     * id = person_id
     */
    public function verifyMaritalStatus($id)
    {
        $person = $this->repository->find($id);

        if($person->maritalStatus == "Casado" && $person->partner != 0)
        {
            $partner = $this->repository->find($person->partner);

            $partner->partner = "0";
        }

        return json_encode(['status' => true]);
    }

    public function setUploadStatus($name)
    {
        $up = $this->uploadStatusRepository->findByField('name', $name)->first();

        if(count($up) > 0)
        {
            $up->delete();
        }

        $data["name"] = $name;
        $data["status"] = 0;

        $this->uploadStatusRepository->create($data);

        return json_encode(['status' => true]);
    }

    public function getUploadStatus($name)
    {
        $status = $this->uploadStatusRepository->findByField('name', $name)->first();

        if ($status->status == 1)
        {
            return json_encode(['status' => true, 'qtde' => $status->code]);
        }
        else{
            return json_encode(['status' => false]);
        }
    }

    public function uploadComplete($name, $qtde)
    {
        $status = $this->uploadStatusRepository->findByField('name', $name)->first();

        $data['code'] = $qtde;

        $data['status'] = 1;

        $this->uploadStatusRepository->update($data, $status->id);

        return true;
    }

    public function listPeople()
    {
        $people = $this->repository->all();

        return json_encode($people);
    }



}
