<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\CountRepository;
use App\Repositories\DateRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use DateRepository, CountRepository;
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
     * UsersController constructor.
     * @param UserRepository $repository
     * @param StateRepository $stateRepository
     */
    public function __construct(UserRepository $repository, StateRepository $stateRepository, RoleRepository $roleRepository)
    {
        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->roleRepository = $roleRepository;
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

        return view('users.myAccount', compact('state', 'dateBirth', 'changePass', 'countPerson', 'roles', 'countGroups'));
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
        $data = $request->all();

        $data['dateBirth'] = $this->formatDateBD($data['dateBirth']);

        $this->repository->update($data, $id);

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
}
