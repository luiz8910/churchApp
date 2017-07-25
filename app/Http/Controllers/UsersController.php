<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\resetPassword;
use App\Models\User;
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
     * UsersController constructor.
     * @param UserRepository $repository
     * @param StateRepository $stateRepository
     */
    public function __construct(UserRepository $repository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, PersonRepository $personRepository,
                                VisitorRepository $visitorRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->visitorRepository = $visitorRepository;
    }

    public function myAccount()
    {
        $changePass = true;

        if(Auth::getUser()->person)
        {
            $user = Auth::getUser()->person;
            $role = $user->role->name;
        }
        else{
            $user = Auth::getUser()->visitors->first();
            $changePass = false;
            $role = "Visitante";
        }

        $state = $this->stateRepository->all();

        $user->dateBirth = $this->formatDateView($user->dateBirth);

        $gender = $user->gender == 'M' ? 'F' : 'M';

        if($user->facebook_id != null || $user->linkedin_id != null
            || $user->google_id != null || $user->twitter_id != null)
        {
            $changePass = false;
        }

        $countPerson[] = $this->countPerson();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify) or 0;

        $leader = $this->getLeaderRoleId();

        $adults = $this->personRepository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        $person = $this->personRepository->find($user->id);

        $groups = $person->groups()->paginate() or null;

        $countMembers = [];

        if($groups)
        {
            foreach ($groups as $group)
            {
                $group->sinceOf = $this->formatDateView($group->sinceOf);
                $countMembers[] = count($group->people->all());
            }
        }

        return view('users.myAccount', compact('state', 'user', 'changePass', 'countPerson', 'role', 'countGroups',
            'notify', 'qtde', 'adults', 'groups', 'countMembers', 'leader'));
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

        $user = User::select('id')->where('email', $email)->first() or null;

        $oldMail = $this->repository->find($id)->email;

        if($user && $oldMail != $email)
        {
            \Session::flash("email.exists", "Existe uma conta associada para o email informado (" .$email. ")");

            $request->flashExcept('password');

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

        if(Auth::getUser()->person)
        {
            $user = Auth::getUser()->person;
            $role = $user->role->name;

            $data["role"] = $role;
        }else{
            $data["role"] = "Visitante";
        }

        if($data["role"] == "Visitante")
        {
            $this->visitorRepository->update($data, $id);
        }else{
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
        $user = User::where("email", $email)->get();

        $url = env('APP_URL');

        $today = date("d/m/Y");

        $time = date("H:i");

        if (count($user) > 0) {
            $u = User::find($user->first()->id);

            Mail::to($u)
                ->send(new resetPassword(
                    $u, $url, $today, $time
                ));

            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function hasEmail($email)
    {
        $email = DB::table('users')
            ->where(
            [
                'email' => $email,
                'church_id' => Auth::user()->church_id
            ]
        )->get();

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
