<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\resetPassword;
use App\Models\Church;
use App\Models\EventSubscribedList;
use App\Models\Responsible;
use App\Models\User;
use App\Repositories\ChurchRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\GroupRepository;
use App\Repositories\ResponsibleRepository;
use App\Repositories\VisitorRepository;
use App\Services\EventServices;
use App\Services\FeedServices;
use App\Services\PeopleServices;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersController extends Controller
{
    use DateRepository, CountRepository, NotifyRepository, EmailTrait, ConfigTrait;
    /**
     * @var UserRepository
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
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var EventSubscribedListRepository
     */
    private $listRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var GroupRepository
     */
    private $groupRepository;
    /**
     * @var FeedServices
     */
    private $feedServices;
    /**
     * @var EventServices
     */
    private $eventServices;
    /**
     * @var ChurchRepository
     */
    private $churchRepository;
    /**
     * @var ResponsibleRepository
     */
    private $responsibleRepository;
    /**
     * @var PeopleServices
     */
    private $peopleServices;

    /**
     * UsersController constructor.
     * @param UserRepository $repository
     * @param StateRepository $stateRepository
     * @param RoleRepository $roleRepository
     * @param PersonRepository $personRepository
     * @param VisitorRepository $visitorRepository
     * @param EventSubscribedListRepository $listRepository
     */
    public function __construct(UserRepository $repository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, PersonRepository $personRepository,
                                VisitorRepository $visitorRepository, EventSubscribedListRepository $listRepository,
                                EventRepository $eventRepository, GroupRepository $groupRepository,
                                FeedServices $feedServices, EventServices $eventServices, ChurchRepository $churchRepository,
                                ResponsibleRepository $responsibleRepository, PeopleServices $peopleServices)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
        $this->listRepository = $listRepository;
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
        $this->feedServices = $feedServices;
        $this->eventServices = $eventServices;
        $this->churchRepository = $churchRepository;
        $this->responsibleRepository = $responsibleRepository;
        $this->peopleServices = $peopleServices;
    }

    public function myAccount()
    {
        $changePass = true;

        $resp = '';

        $church_id = $this->getUserChurch();

        if (Auth::user()->person) {
            $model = Auth::user()->person;
            $role = $model->role->name;

            $church = $this->churchRepository->find($church_id);

            $responsible = $this->responsibleRepository->find($church->responsible_id);

            $resp = $responsible->person_id;

        } else {
            $model = Auth::user()->visitors->first();
            $changePass = false;
            $role = "Visitante";
        }



        $state = $this->stateRepository->all();

        $model->dateBirth = $this->formatDateView($model->dateBirth);

        $gender = $model->gender == 'M' ? 'F' : 'M';

        if ($model->facebook_id != null || $model->linkedin_id != null
            || $model->google_id != null || $model->twitter_id != null
        ) {
            $changePass = false;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $countMembers = [];

        $notify = $this->notify();

        $qtde = $notify ? count($notify) : 0;

        $leader = $this->getLeaderRoleId();

        $admin = $this->getAdminRoleId();

        $route = $this->getRoute();

        $adults = $this->personRepository->findWhere(
            ['tag' => 'adult', 'gender' => $gender, 'church_id' => $church_id]);

        $person = $role == "Visitante" ? $this->visitorRepository->find($model->id) :
            $this->personRepository->find($model->id);

        $groups = $person->groups()->paginate() or null;

        if($role == "Visitante")
        {
            $list = $this->eventServices->getListSubVisitor($model->id);
        }
        else{
            $list = $this->eventServices->getListSubPerson($model->id);
        }


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
                $u = $this->repository->find($event->createdBy_id);
                $event->createdBy_name = $u->person->name;
                $event->createdBy_id = $u->person_id;
                $event->group_id = $event->group_id ? $this->groupRepository->find($event->group_id)->name : "Sem Grupo";

            }
        }


        if ($groups) {
            foreach ($groups as $group) {
                $group->sinceOf = $this->formatDateView($group->sinceOf);
                $countMembers[] = count($group->people->all());
            }
        }


        $feeds = null;

        if($church_id){
            $feeds = $this->feedServices->myFeeds();
        }


        return view('users.myAccount', compact('state', 'model', 'changePass', 'countPerson', 'role', 'countGroups',
            'notify', 'qtde', 'adults', 'groups', 'countMembers', 'leader', 'events', 'route', 'feeds',
            'admin', 'resp', 'church_id'));
    }


    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $password = $data['password'];

        $data['imgPerfil'] = 'uploads/profile/noimage.png';

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['password'] = bcrypt($password);

        if ($this->repository->create($data)) {
            $request->session()->flash('users.store', 'Usuário criado com sucesso');
        }

        return redirect()->back();
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->except('email');

        $email = $request->only(['email']);

        $email = $email["email"];

        if ($email == "") {
            $request->session()->flash("email.exists", "Preencha o campo email");
            return redirect()->route("users.myAccount")->withInput();
        }

        $user = $this->repository->findByField('email', $email)->first();

        $oldMail = $this->repository->find($id)->email;

        if ($user && $oldMail != $email) {
            \Session::flash("email.exists", "Existe uma conta associada para o email informado (" . $email . ")");

            $request->flashExcept('password');

            return redirect()->route("users.myAccount")->withInput();
        }

        $verifyFields = $this->verifyRequiredFields($data, 'person');

        if ($verifyFields) {
            $request->session()->flash("error.required-fields", "Preencha o campo " . $verifyFields);
            return redirect()->route("users.myAccount")->withInput();
        }

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if ($data['maritalStatus'] != 'Casado') {
            $data['partner'] = null;
        } else if ($data['partner'] != "0") {
            $this->updateMaritalStatus($data['partner'], $id);
        }

        if (Auth::getUser()->person) {
            $user = Auth::getUser()->person;
            $role = $user->role->name;

            $data["role"] = $role;
        } else {
            $data["role"] = "Visitante";
        }

        if ($data["role"] == "Visitante") {
            $this->visitorRepository->update($data, $id);
        } else {

            $data['email'] = $email;

            $this->personRepository->update($data, Auth::getUser()->person->id);

        }


        $x['email'] = $email;

        $this->repository->update($x, $id);

        $request->session()->flash('updateUser', 'Alterações realizadas com sucesso');

        return redirect()->route('users.myAccount');
    }

    public function imgProfile(Request $request)
    {
        $file = $request->file('img');

        $id = \Auth::user()->id;

        $imgName = 'uploads/profile/' . $id . '-' . \Auth::user()->name . '.' . $file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
        where('id', $id)->
        update(['imgProfile' => $imgName]);

        $request->session()->flash('updateUser', 'Alterações realizadas com sucesso');

        return redirect()->route('users.myAccount');
    }

    public function changePassword(Request $request)
    {
        if ($request->new == $request->confirmPassword) {
            $result = $this->repository->changePassword($request);

            if ($result) {
                $request->session()->flash('updateUser', 'Senha Alterada com sucesso');
            } else {
                $request->session()->flash('updateUser', 'Sua senha original está incorreta');
            }
        } else {
            $request->session()->flash('updateUser', 'As senhas não combinam');
        }


        return redirect()->route('users.myAccount');
    }

    public function updateMaritalStatus($partner, $id)
    {
        DB::table('people')
            ->where('id', $partner)
            ->update(
                ['partner' => $id, 'maritalStatus' => 'Casado']
            );
    }

    public function passResetView($email)
    {
        return view("auth.passwords.new", compact('email'));
    }

    public function passReset(Request $request)
    {
        $email = $request->get('email');

        $password = $request->get("password");

        DB::table('users')
            ->where('email', $email)
            ->update(['password' => bcrypt($password)]);

        $user = $this->repository->findByField('email', $email);

        Auth::loginUsingId($user->first()->id, true);

        return redirect()->route('index');

    }

    /*
     * Senha reenviada no form de esqueci minha senha
     */
    public function sendPassword($email, $password = null)
    {
        if($this->peopleServices->sendPassword($email, $password))
        {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);

    }

    /*
     * Senha Reenviada dentro do perfil do usuário selecionado
     * Somente para líderes
     */
    public function sendPasswordUser($person)
    {
        $person = $this->personRepository->find($person);

        $user = $person->user;

        if($this->peopleServices->sendPassword($user->email))
        {
            return json_encode([
                'status' => true,
                'email' => $user->email
            ]);
        }

        return json_encode(['status' => false]);

    }

    public function hasEmail($email, $church_id = null)
    {
        $email = DB::table('users')
            ->where(
                [
                    'email' => $email,
                    'deleted_at' => null
                ]
            )->get();

        if ($church_id) {
            $email = DB::table('users')
                ->where(
                    [
                        'email' => $email,
                        'church_id' => $church_id,
                        'deleted_at' => null
                    ]
                )->get();


        }

        //dd($email);

        if (count($email) > 0) {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function emailTestEdit($email, $id)
    {
        if ($this->emailTestEditTrait($email, $id)) {
            return json_encode(['status' => true]);
        } else {
            return json_encode(['status' => false]);
        }
    }

    public function forgotPassword()
    {
        return view("auth.passwords.forgot");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try{

            $token = JWTAuth::attempt($credentials);
        }catch (JWTException $exception){
            return response()->json([
                'error' => 'token_not_create'
            ], 500);
        }

        if(!$token)
        {
            return response()->json([
                'error' => 'Invalid Credentials'
            ], 401);
        }

        return response()->json(compact('token'));
    }

    public function newPassword($person_id)
    {
        $person = $this->personRepository->findByField('id', $person_id)->first();

        if($person)
        {
            try{
                if($person->cel != "")
                {
                    $password = bcrypt($person->cel);

                    $id = $person->user->id;

                    if($id)
                    {
                        DB::table('users')->
                        where('id', $id)->
                        update(['password' => $password]);

                        DB::commit();

                        return json_encode(['status' => true]);
                    }

                    DB::rollBack();

                    return json_encode(['status' => false, 'msg' => 'Usuário não existe']);
                }

                DB::rollBack();

                return json_encode(['status' => false, 'msg' => 'Telefone não existe']);

            }catch (\Exception $e)
            {
                DB::rollBack();

                return json_encode(['status' => false, 'msg' => $e->getMessage()]);
            }

        }

        return json_encode(['status' => false, 'msg' => 'Pessoa não existe']);
    }
}
