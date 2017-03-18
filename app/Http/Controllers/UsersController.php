<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\NotifyRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use DateRepository, CountRepository, NotifyRepository;
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
     * UsersController constructor.
     * @param UserRepository $repository
     * @param StateRepository $stateRepository
     */
    public function __construct(UserRepository $repository, StateRepository $stateRepository,
                                RoleRepository $roleRepository, PersonRepository $personRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
    }

    public function myAccount()
    {
        $state = $this->stateRepository->all();

        $dateBirth = $this->formatDateView(\Auth::getUser()->person->dateBirth);

        $changePass = true;

        if (\Auth::getUser()->facebook_id != null || \Auth::getUser()->linkedin_id != null
            || \Auth::getUser()->google_id != null || \Auth::getUser()->twitter_id != null)
        {
            $changePass = false;
        }

        $countPerson[] = $this->countPerson();

        $roles = $this->roleRepository->all();

        $countGroups[] = $this->countGroups();

        $notify = $this->notify();

        $qtde = count($notify);

        $gender = \Auth::getUser()->person->gender == 'M' ? 'F' : 'M';

        $adults = $this->personRepository->findWhere(['tag' => 'adult', 'gender' => $gender]);

        return view('users.myAccount', compact('state', 'dateBirth', 'changePass', 'countPerson', 'roles', 'countGroups',
            'notify', 'qtde', 'adults'));
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->all();

        $password = $data['password'];

        $data['imgPerfil'] = 'uploads/profile/noimage.png';

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $data['password'] = bcrypt($password);

        if($this->repository->create($data)){
            $request->session()->flash('users.store', 'Usuário criado com sucesso');
        }

        return redirect()->back();
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->except('email');

        $email = $request->only(['email']);

        $email = $email["email"];

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        /*
         * Se a pessoa for casada e $data['partner'] = 0 então o parceiro é de fora da igreja
         * Se a pessoa não for casada e $data['partner'] = 0 então não há parceiro para incluir
         * Se a pessoa for casada e $data['partner'] != "0" então a pessoa é casada com o id informado
         *
        */
        if($data['maritalStatus'] != 'Casado')
        {
            $data['partner'] = null;
        }
        else if ($data['partner'] != "0"){
            $this->updateMaritalStatus($data['partner'], $id);
        }

        $this->personRepository->update($data, $id);

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

        $imgName = 'uploads/profile/' . $id . '-' . \Auth::user()->name . '.' .$file->getClientOriginalExtension();

        $file->move('uploads/profile', $imgName);

        DB::table('people')->
            where('id', $id)->
            update(['imgProfile' => $imgName]);

        $request->session()->flash('updateUser', 'Alterações realizadas com sucesso');

        return redirect()->route('users.myAccount');
    }

    public function changePassword(Request $request)
    {
        if($request->new == $request->confirmPassword)
        {
            $result = $this->repository->changePassword($request);

            if($result)
            {
                $request->session()->flash('updateUser', 'Senha Alterada com sucesso');
            }
            else{
                $request->session()->flash('updateUser', 'Sua senha original está incorreta');
            }
        }
        else{
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
}
