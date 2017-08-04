<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\resetPassword;
use App\Models\EventSubscribedList;
use App\Models\User;
use App\Repositories\EventRepository;
use App\Repositories\EventSubscribedListRepository;
use App\Repositories\GroupRepository;
use App\Repositories\VisitorRepository;
use App\Traits\ConfigTrait;
use App\Traits\CountRepository;
use App\Traits\DateRepository;
use App\Traits\EmailTrait;
use App\Traits\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
                                EventRepository $eventRepository, GroupRepository $groupRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
        $this->listRepository = $listRepository;
        $this->eventRepository = $eventRepository;
        $this->groupRepository = $groupRepository;
    }

    public function myAccount()
    {
        $changePass = true;

        if (Auth::getUser()->person) {
            $model = Auth::getUser()->person;
            $role = $model->role->name;
        } else {
            $model = Auth::getUser()->visitors->first();
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

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $adults = $this->personRepository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        $person = $this->personRepository->find($model->id);

        $groups = $person->groups()->paginate() or null;

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

        return view('users.myAccount', compact('state', 'model', 'changePass', 'countPerson', 'role', 'countGroups',
            'notify', 'qtde', 'adults', 'groups', 'countMembers', 'leader', 'events'));
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

        $user = User::select('id')->where('email', $email)->first() or null;

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
            $person_id = $this->repository->find($id)->person_id;

            $this->personRepository->update($data, $person_id);
        }


        DB::table('users')
            ->where('id', $id)
            ->update(['email' => $email]);

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

    public function sendPassword($email)
    {
        $user = User::where("email", $email)->first();

        $url = env('APP_URL');

        $today = date("d/m/Y");

        $time = date("H:i");

        if (count($user) > 0) {


            Mail::to($user)
                ->send(new resetPassword(
                    $user, $url, $today, $time
                ));

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function hasEmail($email, $church_id = null)
    {
        $email = DB::table('users')
            ->where(
                [
                    'email' => $email,
                ]
            )->get();

        if ($church_id) {
            $email = DB::table('users')
                ->where(
                    [
                        'email' => $email,
                        'church_id' => $church_id
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
}
