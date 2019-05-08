<?php

namespace App\Http\Controllers;

use App\Events\AgendaEvent;
use App\Events\PersonEvent;
use App\Http\Requests\PersonCreateRequest;
use App\Mail\ForLeaders;
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
use App\Repositories\VisitorRepository;
use App\Services\ChurchServices;
use App\Services\EventServices;
use App\Services\FeedServices;
use App\Services\qrServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\FeedTrait;
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
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var FeedServices
     */
    private $feedServices;
    /**
     * @var ChurchServices
     */
    private $churchServices;
    /**
     * @var qrServices
     */
    private $qrServices;

    public function __construct(PersonRepository $repository, StateRepository $stateRepositoryTrait, RoleRepository $roleRepository,
                                UserRepository $userRepository, RequiredFieldsRepository $fieldsRepository, EventSubscribedListRepository $listRepository,
                                GroupRepository $groupRepository, ChurchRepository $churchRepository, EventRepository $eventRepository,
                                EventServices $eventServices, UploadStatusRepository $uploadStatusRepository, ImportRepository $importRepository,
                                VisitorRepository $visitorRepository, FeedServices $feedServices, ChurchServices $churchServices, qrServices $qrServices)
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
        $this->visitorRepository = $visitorRepository;
        $this->feedServices = $feedServices;
        $this->churchServices = $churchServices;
        $this->qrServices = $qrServices;
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
                'church_id' => $this->getUserChurch(),
                'status' => 'active'
            ])->orderBy('name')->paginate(5);


        foreach ($adults as $item) {
            if($item->dateBirth)
            {
                $item->dateBirth = $this->formatDateView($item->dateBirth);
            }

            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        return view('people.index', compact('adults', 'countPerson', 'countGroups', 'notify', 'qtde',
            'leader', 'admin', 'visitor_id'));
    }

    public function teenagers()
    {
        $teen = DB::table("people")
            ->where([
                ['tag', '<>', 'adult'],
                'deleted_at' => null,
                'church_id' => $this->getUserChurch(),
                'status' => 'active'
            ])->paginate(5);

        foreach ($teen as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        return view('people.teenagers', compact('teen', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader', 'admin'));
    }

    public function visitors()
    {
        $visitor_id = $this->roleRepository->findByField('name', 'Visitante')->first()->id;

        $visitors = DB::table("people")
            ->where([
                'role_id' => $visitor_id,
                'deleted_at' => null,
                'church_id' => $this->getUserChurch(),
                'status' => 'active'
            ])->orderBy('name')->paginate(5);


        foreach ($visitors as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
            $item->role = $this->roleRepository->find($item->role_id)->name;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        return view('people.visitors', compact('visitors', 'countPerson', 'countGroups', 'notify', 'qtde',
            'leader', 'admin'));

    }


    public function inactive()
    {
        $inactive = Person::onlyTrashed()->where('status', '<>', 'deleted')->orderBy('name')->paginate(5);

        foreach ($inactive as $item) {
            $item->dateBirth = $this->formatDateView($item->dateBirth);
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        return view('people.inactive', compact('inactive', 'countPerson', 'countGroups', 'notify', 'qtde', 'leader', 'admin'));
    }

    public function reactivate($person)
    {
        $person = Person::onlyTrashed()
                    ->where('id', $person)
                    ->first();

        if($person)
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

            Session::flash('reactivate.success', 'O Usuário ' . $person->name . ' foi reativado');

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function forceDelete($person)
    {
        $person = Person::onlyTrashed()
            ->where('id', $person)
            ->first();

        if($person)
        {
            if ($person->tag == 'adult') {
                $user = $person->user()->withTrashed()->first();

                if($user){
                    $user->forceDelete();
                }
            }

            $person->forceDelete();

            return json_encode(['status' => true, 'name' => $person->name]);
        }

        return json_encode(['status' => false]);
    }

    public function forceDeleteAll()
    {
        try{

            Person::onlyTrashed()
                ->where('church_id', $this->getUserChurch())
                ->update(['status' => 'deleted']);

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e)
        {
            DB::rollBack();

            return json_encode(['status' => false]);
        }



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

        $admin_sys = $this->roleRepository->findByField('name', 'Administrador de Sistema')->first()->id;

        $roles = $this->roleRepository->findWhereNotIn('id', [$visitor_id, $admin_sys]);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

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
            'adults', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'fields', 'route',
            'admin'));
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

        $admin = $this->getAdminRoleId();

        $church_id = $this->getUserChurch();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

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
            'adults', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'route', 'admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $origin = null)
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


        /*if($request->get('dateBirth') == ""){

            if($origin == 'app')
            {
                return json_encode(['status' => false, 'msg' => 'Insira a data de Nascimento']);
            }
            else{

                \Session::flash("email.exists", "Insira a data de Nascimento");

                if($teen)
                {
                    return redirect()->route("teen.create")->withInput();
                }
                else{
                    return redirect()->route("person.create")->withInput();
                }
            }


        }*/


        $user = User::select('id')->where('email', $email)->first() or null;

        if($user)
        {
            if($origin == 'app')
            {

                return json_encode([
                    'status' => false,
                    'msg' => 'Existe uma conta associada para o email informado (' . $email . ')'
                ]);

            }
            else{


                \Session::flash("email.exists", "Existe uma conta associada para o email informado (" .$email. ")");

                $request->flashExcept('password');

                return redirect()->route("person.create")->withInput();
            }

        }

        $data = $request->except(['img', 'password', 'confirm-password', '_token']);

        if($teen)
        {
            $data["email"] = $email;

            $verifyFields = $this->verifyRequiredFields($data, 'teen');

            if($verifyFields)
            {
                if($origin == 'app')
                {

                    return json_encode([
                        'status' => false,
                        'msg' => 'Preencha o campo ' . $verifyFields
                    ]);

                }
                else{

                    \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);

                    return redirect()->route("teen.create")->withInput();
                }

            }

        }else{
            //unset($data["email"]);

            $verifyFields = $this->verifyRequiredFields($data, 'person');

            if($verifyFields)
            {
                if($origin == 'app')
                {

                    return json_encode([
                        'status' => false,
                        'msg' => 'Preencha o campo ' . $verifyFields
                    ]);

                }
                else{

                    \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                    return redirect()->route("person.create")->withInput();

                }

            }
        }




        $data['imgProfile'] = 'uploads/profile/noimage.png';

        $children = $request->get('group-a');

        if(isset($data['father_id_input']) || isset($data['mother_id_input'])){
            if($data['father_id_input'] || $data['mother_id_input'])
            {
                $data['father_id'] = $data['father_id_input'] or null;
                $data['mother_id'] = $data['mother_id_input'] or null;
            }
        }

        /*if(!isset($data["maritalStatus"])){
            $data["maritalStatus"] = "Solteiro";
        }*/

        if(!isset($data["role_id"])){
            $member = $this->roleRepository->findByField('name', 'Participante')->first()->id;

            $data["role_id"] = $member;
        }

        $data["church_id"] = $this->getUserChurch();

        $data["city"] = ucwords($data["city"]);

        if($origin)
        {
            $data['status'] = 'waiting';
        }

        if(isset($data['cel']) || $data['cel'] != "")
        {
            $data['cel'] = str_replace('(', '', $data['cel']);
            $data['cel'] = str_replace(')', '', $data['cel']);
            $data['cel'] = str_replace('-', '', $data['cel']);
        }

        $id = $this->repository->create($data)->id;

        if(!isset($data['dateBirth']) || $data['dateBirth'] == "")
        {
            $this->updateTag('adult', $id, 'people');
        }
        else{

            $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

            $this->updateTag($this->tag($data['dateBirth']), $id, 'people');

        }

        $church_id = $this->getUserChurch();

        $password = $this->randomPassword();

        $user = $this->createUserLogin($id, $password, $email, $church_id);

        $this->welcome($user, $password);


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



        if ($file) {
            $this->imgProfile($file, $id, $data['name'], 'people');
        }

        $this->qrServices->generateQrCode($id);

        if(!$origin)
        {
            $this->newRecentUser($id, $church_id);

            $this->feedServices->newFeed(5, 'Novo Usuário Cadastrado', $id, null, 'person', $id );

        }
        else{
            $this->feedServices->newFeed(5, 'Novo Usuário Aguardando Aprovação', $id, null, 'person', $id);

            //Envio Email aguardando aprovação
            $person = $this->repository->find($id);

            $this->newWaitingApproval($person, $church_id);

            Session::flash('person.crud', 'Usuário '. $data['name'] . ' criado com sucesso');

            if($teen)
            {
                Session::flash('teen.crud', 'Usuário '. $data['name'] . ' criado com sucesso');

                return 'teen';
            }

            Session::flash('person.crud', 'Usuário '. $data['name'] . ' criado com sucesso');

            return 'person';

        }

        if($request->session()->has('new-responsible-exhibitors'))
        {
            DB::table('exhibitor_person')
                ->where(['exhibitor_id' => $request->session()->get('new-responsible-exhibitors')])
                ->delete();

            DB::table('exhibitor_person')
                ->insert([
                    'exhibitor_id' => $request->session()->get('new-responsible-exhibitors'),
                    'person_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ]);

            $request->session()->forget('new-responsible-exhibitors');
        }

        if($request->session()->has('new-responsible-exhibitors'))
        {
            DB::table('exhibitor_person')
                ->where(['exhibitor_id' => $request->session()->get('new-responsible-exhibitors')])
                ->delete();

            DB::table('exhibitor_person')
                ->insert([
                    'exhibitor_id' => $request->session()->get('new-responsible-exhibitors'),
                    'person_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ]);

            $request->session()->forget('new-responsible-exhibitors');
        }

        if($request->session()->has('new-responsible-sponsor'))
        {
            DB::table('sponsor_person')
                ->where(['sponsor_id' => $request->session()->get('new-responsible-sponsor')])
                ->delete();

            DB::table('sponsor_person')
                ->insert([
                    'sponsor_id' => $request->session()->get('new-responsible-sponsor'),
                    'person_id' => $id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ]);

            $request->session()->forget('new-responsible-sponsor');
        }

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

        $model->dateBirth = $model->dateBirth ? date_format(date_create($model->dateBirth), 'd/m/Y') : null;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

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
                    'status' => 'active'
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
                    'status' => 'active'
                ])
                ->whereIn('partner', [null, 0])
                ->whereNull('deleted_at')
                ->get();
        }

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $children = null;

        /*if($model->hasKids == 1)
        {
            $parent = $model->gender == "M" ? 'father_id' : 'mother_id';

            $children = $this->repository->findByField($parent, $user->id);

            foreach ($children as $child)
            {
                $child->dateBirth = $this->formatDateView($child->dateBirth);
            }

        }*/


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    ['people.id', '<>', $id],
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id,
                    'people.deleted_at' => null,
                    'status' => 'active'
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
                    'people.deleted_at' => null,
                    'status' => 'active'
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
            'leader', 'fields', 'events', 'role', 'route', 'admin'));
    }


    public function editTeen($id)
    {
        $model = $this->repository->find($id);

        $state = $this->stateRepository->all();

        $roles = $this->roleRepository->all();

        $model->dateBirth = $this->formatDateView($model->dateBirth);

        $location = $this->formatGoogleMaps($model);

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $church_id = $this->getUserChurch();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $route = $this->getRoute();


        $fathers = DB::table('people')
            ->join('users', 'users.person_id', 'people.id')
            ->where(
                [
                    'people.tag' => 'adult',
                    'people.gender' => 'M',
                    'users.church_id' => $church_id,
                    'status' => 'active'
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
                    'status' => 'active'
                ]
            )
            ->get();

        return view('people.edit-teen', compact('model', 'state', 'location', 'roles', 'countPerson',
            'countGroups', 'notify', 'qtde', 'fathers', 'mothers', 'leader', 'route', 'admin'));
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

        /*if($teen)
        {
            $verifyFields = $this->verifyRequiredFields($data, 'teen');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("teen.edit", ['person' => $id])->withInput();
            }

        }else{*/
            $verifyFields = $this->verifyRequiredFields($data, 'person');

            if($verifyFields)
            {
                \Session::flash("error.required-fields", "Preencha o campo " . $verifyFields);
                return redirect()->route("person.edit", ['person' => $id])->withInput();
            }



        if($data['dateBirth'] != '')
        {
            //Formatação correta da data
            $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

            /*if(isset($data['father_id_input']) || isset($data['mother_id_input'])){
                if($data['father_id_input'] || $data['mother_id_input'])
                {
                    $data['father_id'] = $data['father_id_input'] or null;
                    $data['mother_id'] = $data['mother_id_input'] or null;
                }
            }*/
        }


        if(!isset($data["role_id"]) || $data["role_id"] == "")
        {
            $member = $this->roleRepository->findByField('name', 'Participante')->first()->id;
            $data["role_id"] = $member;
        }

        /*if(!isset($data['maritalStatus']))
        {
            $data['maritalStatus'] = 'Solteiro';
        }




         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *

        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;

            $status = $this->repository->find($id);

            if($status->maritalStatus == "Casado")
            {
                $this->updateMaritalSingleStatus($status->partner, $data["maritalStatus"], 'people');
            }

        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id, 'people');
        }*/

        $user = $this->userRepository->findByField('person_id', $id)->first();

        if($email && $user)
        {
            if($this->emailTestEditTrait($email, $user->id)){
                $this->updateEmail($email, $user->id);
            }
            else{
                \Session::flash("email.exists", "Existe uma conta associada para o email informado " . "(".$email.")");
                return redirect()->route("person.edit", ['person' => $id]);
            }
        }

        $tag = 'adult';

        $person = $this->repository->findByField('id', $id)->first();

        $church_id = $this->getUserChurch();

        if($person)
        {
            if($email)
            {
                $password = $this->randomPassword();

                $this->createUserLogin($id, $password, $email, $church_id);
            }
            else{

                \Session::flash("error.required-fields", "Preencha o campo Email");

                return redirect()->route("teen.edit", ['person' => $id])->withInput();
            }

        }

        $this->updateTag($tag, $id, 'people');

        $data["city"] = ucwords($data["city"]);

        /*if($person->status != 'active')
        {
            $this->newWaitingApproval($person, $church_id, 'Dados alterados - ');

            $data['status'] = 'waiting';
        }*/

        $data['email'] = $email;

        if(isset($data['cel']) || $data['cel'] != "")
        {
            $data['cel'] = str_replace('(', '', $data['cel']);
            $data['cel'] = str_replace(')', '', $data['cel']);
            $data['cel'] = str_replace('-', '', $data['cel']);
        }

        $this->repository->update($data, $id);

        /*if($teen){
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
        }*/

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


    public function getSimpleContact(Request $request)
    {
        ini_set('max_execution_time', '60');

        $request->session()->forget('errors');

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
        Excel::load($path . $fileName, function ($reader) use($church, $alias, $i, $import, $request){

            $errors = [];

            $count_reader = count($reader->get());

            $x = 1;

            foreach ($reader->get() as $item) {

                if($x == $count_reader)
                {
                    break;
                }
                else{
                    $x++;
                }

                $stop = false;

                $nome = '';
                $email = '';
                $tel = '';

                if(isset($item->email))
                {
                    $email =  "email";
                }
                elseif (isset($item->e_mail))
                {
                    $email = "e_mail";
                }
                elseif(isset($item->Email))
                {
                    $email = "Email";
                }
                elseif (isset($item->EMAIL))
                {
                    $email = "EMAIL";
                }
                else{
                    $stop = true;

                    $errors[] = 'Email não informado ou coluna com nome incorreto';
                }

                if(!$stop)
                {
                    if($item->$email == "")
                    {
                        $stop = true;

                        $errors[] = 'Campo Email está em branco';
                    }
                }

                if(!$stop)
                {

                    if(isset($item->nome))
                    {
                        $nome = 'nome';
                    }
                    elseif(isset($item->Nome)){
                        $nome = 'Nome';
                    }
                    elseif(isset($item->NOME)){
                        $nome = 'NOME';
                    }
                    else{
                        $stop = true;

                        $errors[] = 'Nome não informado ou coluna com nome incorreto';
                    }
                }

                if(!$stop)
                {
                    if($item->$nome == '')
                    {
                        $stop = true;

                        $errors[] = 'Nome em branco';
                        //$data["name"] = strstr($item->$email, '@', true);
                    }
                    else{

                        $fullName = $this->surname($item->$nome);

                        $data["name"] = ucfirst($fullName[0]);

                        $data["lastName"] = ucwords($fullName[1]);
                    }

                }

                if(!$stop)
                {
                    if(isset($item->tel))
                    {
                        $data['cel'] = $item->tel;
                    }
                    elseif(isset($item->Tel))
                    {
                        $data['cel'] = $item->Tel;
                    }
                    elseif(isset($item->telefone))
                    {
                        $data['cel'] = $item->telefone;
                    }
                    elseif (isset($item->Telefone))
                    {
                        $data['cel'] = $item->Telefone;

                        $tel = 'Telefone';
                    }
                    else{

                        $stop = true;

                        $errors[] = 'Telefone não informado ou coluna com nome incorreto';
                    }
                }

                if(!$stop)
                {
                    if(!$this->emailExists($item->$email))
                    {

                        $data["email"] = $item->$email;


                        $data['cel'] = str_replace('(', '', $data['cel']);
                        $data['cel'] = str_replace(')', '', $data['cel']);
                        $data['cel'] = str_replace('-', '', $data['cel']);

                        $password = $data['cel']; //$this->randomPassword();

                        $data['church_id'] = $church;

                        $data['role_id'] = 2;

                        $data['tag'] = 'adult';

                        $data['imgProfile'] = 'uploads/profile/noimage.png';

                        //$data['cel'] = $item->Telefone;

                        $person_id = $this->repository->create($data)->id;

                        $this->qrServices->generateQrCode($person_id);

                        $church = $this->getUserChurch();

                        $this->createUserLogin($person_id, $password, $data['email'], $church);

                        /*if($user)
                        {
                            $this->welcome($user, $password);
                        }*/

                        if($item->event_id != "")
                        {
                            $event = $this->eventRepository->findByField('id', $item->event_id)->first();

                            if($event)
                            {
                                $this->eventServices->subEvent($event->id, $person_id);
                            }
                        }

                        $i++;

                        unset($data);
                    }
                }



            }

            session(['qtde' => $i]);

            session(['errors' => $errors]);

            print_r(session('errors'));

        })->get();

        $qtde = session('qtde');

        //\Session::flash('upload.success', $qtde[0] . " usuários foram cadastrados");

        $this->uploadComplete($name, $qtde);
    }

    /*
     * Planilha com todos os contatos da igreja
     */
    public function getChurchContacts(Request $request)
    {
        ini_set('max_execution_time', '60');

        $request->session()->forget('errors');

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



        DB::transaction(function () use($church, $alias, $i, $path, $fileName, $name, $import, $request){

        Excel::load($path . $fileName, function ($reader) use($church, $alias, $i, $import, $request){

            $errors = [];

            $count_reader = count($reader->get());

            $x = 1;

            foreach ($reader->get() as $item)
            {
                    //echo $item->nome . "\n\n";

                    //dd($reader->get());

                    if($x == $count_reader)
                    {
                        break;
                    }
                    else{
                        $x++;
                    }

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

                                $errors[] = 'Já existe um usuário com o nome ' . $data['name'] . ' ' . $data['lastName'] . ' na base de dados';
                            }
                        }
                    }


                    //Novo Cadastro
                    if(!$stop) {
                        $data_nasc = "data_nasc.";

                        if ($item->$data_nasc != null) {
                            $data["dateBirth"] = date_format($item->$data_nasc, "Y-m-d");


                            if ($item->membro == "S" && ($item->classificacao == "PLENA" ||
                                    $item->classificacao == "DESLIGADO" || $item->classificacao == "FALECIDO")) {



                                $data["role_id"] = $this->roleRepository->findByField('name', 'Membro')->first()->id;

                                if ($item->classificacao == "PLENA") {
                                    $data["deleted_at"] = null;
                                }
                                else if($item->classificacao == "DESLIGADO" || $item->classificacao == "FALECIDO"){
                                    $data["deleted_at"] = Carbon::now();
                                }
                            } else {

                                $data["role_id"] = $this->roleRepository->findByField('name', 'Visitante')->first()->id;


                                $data["deleted_at"] = null;

                            }

                            $data['imgProfile'] = 'uploads/profile/noimage.png';

                            $tel = "tel.residencial";

                            $data["tel"] = $item->$tel;

                            $cel = "celular";

                            $data["cel"] = $item->$cel;

                            $gender = isset($item->genero) ? "genero" : isset($item->sexo) ? "sexo" : "gênero";

                            $data["gender"] = $item->$gender;

                            $maritalStatus = "estado_civil";

                            if($item->$maritalStatus == "Viúvo" || $item->$maritalStatus == "VIÚVO" || $item->$maritalStatus == "viúvo")
                            {
                                $item->$maritalStatus = "Viuvo";
                            }

                            $item->$maritalStatus = strtolower($item->$maritalStatus);

                            //echo $item->$maritalStatus . "\n\n";

                            $item->$maritalStatus = ucfirst($item->$maritalStatus);


                            if($item->$maritalStatus == "Separado")
                            {
                                $data["maritalStatus"] = "Divorciado";
                            }
                            else{
                                $data["maritalStatus"] = $item->$maritalStatus;

                                if ($data["maritalStatus"] == "Casado") {
                                    $data["partner"] = 0;
                                }
                            }


                            $data["tag"] = $this->tag($data["dateBirth"]);

                            $dateBaptism = "dt.batismo";

                            $data["dateBaptism"] = isset($item->$dateBaptism) ? $item->$dateBaptism != null ? date_format($item->$dateBaptism, "Y-m-d") : null : null;

                            $email = isset($item->email) ? "email" : "e_mail";

                            $data["email"] = isset($item->$email) ? !$this->emailExists($item->$email) ? $item->$email : null : null;

                            $data["zipCode"] = isset($item->cep) ? $item->cep : null;

                            $data["street"] = isset($item->endereco) ? $item->endereco : null;

                            $data["city"] = isset($item->cidade) ? $item->cidade : null;

                            $data["state"] = $this->churchServices->getUF($item->estado) ? $item->estado : null;

                            $data["import_code"] = $import["code"];

                            $data["church_id"] = $church;

                            $id = $this->repository->create($data)->id;

                            if ($data["tag"] == "adult") {
                                if(!$this->createUserLogin($id, $alias, $item->$email, $church))
                                {
                                    $errors[] = 'Os dados de acesso para o usuário ' . $data['name'] . " " . $data['lastName'] . " não pode ser realizado porque já existe um usuário com o email " . $item->$email;
                                }
                            }

                            $i++;

                        }// Data Nasc.
                        else{
                            $errors[] = 'A coluna email está com o nome incorreto ou o campo data de nascimento do usuário '. $data["name"] . " " . $data["lastName"] .' está vazio.';


                        }
                    } // $stop


                //echo $data["name"] . " " . $data["lastName"] . ' i = ' . $i .  "<br>";
            }



            session(['qtde' => $i]);

            session(['errors' => $errors]);

            print_r(session('errors'));

        })->get();

        $qtde = session('qtde');

        //\Session::flash('upload.success', $qtde[0] . " usuários foram cadastrados");

        $this->uploadComplete($name, $qtde);

        });
        //return redirect()->route('config.person.contacts.view');
        //return response()->json('success', 200);
        //return response()->view('config.dropzone', $qtde, 200);
    }



    /*
     * Usado para encontrar eventos/grupos
     * criado pelo usuário prestes a ser excluído
     * $id = id do usuário (person_id)
     */
    public function findUserAction($id)
    {
        $user = $this->repository->find($id)->user;

        $groups = $user ? $this->groupRepository->findByField('owner_id', $user->id)->first() : 0;

        $events = $user ? $this->eventRepository->findByField('createdBy_id', $user->id)->first() : 0;

        if($groups || $events)
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

        if($up)
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

        if($status)
        {
            $data['code'] = $qtde;

            $data['status'] = 1;

            $this->uploadStatusRepository->update($data, $status->id);

            return true;
        }

        return false;

    }

    public function listPeople()
    {
        $people = $this->repository->all();

        return json_encode($people);
    }

    /*
     * Usado para um visitante tornar-se membro
     * $id = id do visitante
     * */
    public function makeMember($id)
    {
        //dd($this->eventServices->getListSubVisitor($id)->first());
        try{
            $visitor = $this->visitorRepository->find($id);

            $church = $this->getUserChurch();

            $visitor->church_id = $church;

            $visitor->role_id = $this->roleRepository->findByField('name', 'Membro')->first()->id;

            $tag = $this->tag($visitor->dateBirth);

            DB::beginTransaction();

            $data = $visitor->toArray();

            $person_id = $this->repository->create($data)->id;

            if(count($visitor->users) > 0)
            {
                $user = $visitor->users->first();

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(
                        [
                            'person_id' => $person_id,
                            'church_id' => $church
                        ]);

                $visitor->users()->detach();
            }
            else{
                if($tag == "adult")
                {
                    $email = isset($visitor->email) ? $visitor->email : null;
                    $password = $this->randomPassword();

                    $this->createUserLogin($person_id, $password, $email, $church);
                }
            }

            $events = $this->eventServices->getListSubVisitor($id);

            if(count($events) > 0)
            {
                foreach ($events as $event) {
                    $this->eventServices->subEvent($event->event_id, $person_id);
                }

                $this->eventServices->UnsubVisitorAll($id);
            }

            $visitor->delete();

            DB::commit();

            return json_encode(['status' => true]);

        }catch(\Exception $e){


            DB::rollBack();

            dd($e);
            return json_encode(['status' => false]);
        }





    }

    public function waitingApproval()
    {
        $people = Person::
            where([
                ['status', '<>', 'active'],
                'deleted_at' => null,
                'church_id' => $this->getUserChurch()
            ])->orderBy('name')->paginate(5);


        if(count($people) > 0)
        {
            foreach ($people as $item) {
                $item->dateBirth = $this->formatDateView($item->dateBirth);

                $item->role = $this->roleRepository->find($item->role_id)->name;

                $item->date_created = date_format(date_create($item->created_at), 'd/m/Y');
            }
        }


        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        return view('config.waiting-approval', compact('people', 'countPerson', 'countGroups', 'notify', 'qtde',
            'leader', 'admin'));
    }

    public function approveMember($id)
    {
        $data['status'] = 'active';

        try{

            $this->repository->update($data, $id);

            $person = $this->repository->findByField('id', $id)->first();

            if($person)
            {
                $password = $this->randomPassword();

                $this->welcome($person->user, $password);

                DB::commit();

                return json_encode(['status' => true]);
            }

            return json_encode(['status' => false, 'msg' => 'Usuário não encontrado']);

        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return json_encode(['status' => false, 'msg' => $e->getMessage()]);
        }

    }

    public function denyMember(Request $request, $id)
    {
        try{

            //Recuperando a mensagem deixada pelo líder/admin
            $msg = $request->get('msg');

            //Gravação da mensagem no BD
            DB::table('denies_messages')
                ->insert([
                    'denied_person' => $id,
                    'msg' => $msg,
                    'denied_by_person' => Auth::user()->person->id,
                    'deleted_at' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);


            //Recuperando dados de login
            $user = $this->repository->find($id)->user;


            //Status alterado de "waiting" para "negado"
            $data['status'] = 'denied';


            //Update status
            $this->repository->update($data, $id);

            //Confirmando alterações
            DB::commit();


            //Email de recusa
            $this->denyUser($user, $msg);


            //Mensagem de sucesso para o usuário
            $request->session()->flash('success.msg', 'As informações foram enviadas para o usuário no email ' . $user->email);


            //Redirecionando para a página anterior (listagem de pré aprovados)
            return redirect()->route('person.waitingApproval');

        }catch(\Exception $e)
        {
            //Revertendo alterações
            DB::rollBack();


            //Mensagem de erro para o usuário
            $request->session()->flash('error.msg', 'Um erro ocorreu, tente novamente mais tarde');


            //Redirecionando para a página anterior (listagem de pré aprovados)
            return redirect()->route('person.waitingApproval');
        }


    }

    //$id = id do usuário negado
    public function denyDetails($id)
    {
        $details = DB::table('denies_messages')
            ->where('denied_person', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        if($details)
        {
            $denied_by = $this->repository->find($details->denied_by_person);

            $details->denied_by_person = $denied_by->name . ' ' . $denied_by->lastName;

            return json_encode(['status' => true, 'details' => $details]);
        }


        return json_encode(['status' => false]);
    }

    public function storeWaitingApproval(Request $request)
    {
        $result = $this->store($request, 'member');

        if($result == 'teen')
        {
            return redirect()->route('person.teen');

        }

        return redirect()->route('person.index');
    }

//--------------------------------------------- Testes -----------------------------------------------------------------

    public function generateUsers($stop_number)
    {
        $i = 0;
        $users_count = 0;

        if($this->getUserChurch())
        {
            while ($users_count < $stop_number)
            {
                $verif_name = 'Teste ' . $i;

                $verif_email =  'teste_'.$i.'@teste.com';

                $name = $this->repository->findByField('name', $verif_name)->first();

                $email = $this->repository->findByField('email', $verif_email)->first();

                if(!$name && !$email)
                {
                    $data['name'] = $verif_name;

                    $data['email'] = $verif_email;

                    $data['cel'] = '15999999999';

                    $data['church_id'] = $this->getUserChurch();

                    $data['tag'] = 'adult';

                    $data['role_id'] = $this->roleRepository->findByField('name', 'Participante')->first()->id;

                    $data['imgProfile'] = 'uploads/profile/noimage.png';

                    $data['status'] = 'test';

                    $id = $this->repository->create($data)->id;

                    $password = $this->randomPassword();

                    $this->createUserLoginTest($id, $password, $data['email'], $this->getUserChurch());

                    //Qrcode
                    $this->qrServices->generateQrCode($id);

                    $users_count++;
                }

                $i++;
            }

            return 'Foram cadastrados ' .$users_count. ' novos usuários';
        }

        return 'Org não encontrada';

    }


    public function check_inQr()
    {
        if($this->getUserChurch())
        {
            $people = $this->repository->findByField('status', 'test');

            return view('people.qr-check_in', compact('people'));
        }

        return 'Org não encontrada';
    }

    public function subTestUsers($event_id)
    {
        if($this->getUserChurch())
        {
            $people = $this->repository->findByField('status', 'test');

            foreach ($people as $person)
            {
                $this->eventServices->subUnique($event_id, $person->id);
            }

            return true;
        }

        return 'Org não encontrada';

    }

    public function checkTestUsers($event_id)
    {
        if($this->getUserChurch())
        {
            $people = $this->repository->findByField('status', 'test');

            foreach ($people as $person)
            {
                $this->eventServices->checkApp($person->id, $event_id);
            }

            return true;
        }

        return 'Org não encontrada';
    }


    public function testeTelefone()
    {
        $tel = '(15)99761-7918';

        $tel = str_replace('(', '', $tel);
        $tel = str_replace(')', '', $tel);
        $tel = str_replace('-', '', $tel);

        echo $tel;
    }


//--------------------------------------------------------- API --------------------------------------------------------

    public function storeWaitingApprovalApp(Request $request)
    {
        $this->store($request, 'app');
    }


    public function ExcludeVisitorsModel()
    {

        $visitors = $this->visitorRepository->all();

        $visitor_id = 3;

        foreach ($visitors as $visitor) {

            $data['name'] = $visitor->name;

            $data['lastName'] = $visitor->lastName;

            $data['role_id'] = $visitor_id;

            $data['imgProfile'] = $visitor->imgProfile;

            $data['tel'] = $visitor->tel;

            $data['cel'] = $visitor->cel;

            $data['gender'] = $visitor->gender;

            $data['father_id'] = $visitor->father_id;

            $data['mother_id'] = $visitor->mother_id;

            $data['cpf'] = $visitor->cpf;

            $data['rg'] = $visitor->rg;

            $data['maritalStatus'] = $visitor->maritalStatus;

            $data['partner'] = $visitor->partner;

            $data['dateBirth'] = $visitor->dateBirth;

            $data['hasKids'] = $visitor->hasKids;

            $data['tag'] = $visitor->tag;

            $data['specialNeeds'] = $visitor->specialNeeds;

            $data['street'] = $visitor->street;

            $data['neighborhood'] = $visitor->neighborhood;

            $data['city'] = $visitor->city;

            $data['zipCode'] = $visitor->zipCode;

            $data['state'] = $visitor->state;

            $data['created_at'] = $visitor->created_at;

            $data['updated_at'] = $visitor->updated_at;

            $data['deleted_at'] = $visitor->deleted_at;

            $data['number'] = $visitor->number;

            $data['dateBaptism'] = $visitor->dateBaptism;

            $data['email'] = $visitor->email;

            $data['import_code'] = $visitor->import_code;

            $data['status'] = 'active';

        }
    }
}
