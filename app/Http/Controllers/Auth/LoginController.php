<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CodeRepository;
use App\Repositories\PersonRepository;
use App\Repositories\RoleRepository;
use App\Services\CodeServices;
use App\Traits\ConfigTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ConfigTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PersonRepository
     */
    private $personRepository;
    /**
     * @var CodeServices
     */
    private $codeServices;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository, PersonRepository $personRepository,
                                CodeServices $codeServices)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->roleRepository = $roleRepository;
        $this->personRepository = $personRepository;
        $this->codeServices = $codeServices;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {

            $church = $request->get('church');

            session(['church' => $church]);

            if($user->church_id == $church)
            {
                $role_id = $user->person->role_id;

                $role = Role::where('id', $role_id)->first()->name;

                session(['role' => $role]);

            }
            elseif($user->person_id)
            {
                return redirect()->route('log-out');
            }
            else{
                session(['role' => 'Visitante']);
                return redirect()->route('event.index');
            }

            return redirect()->intended('home');
        }
    }

    public function loginApp(Request $request)
    {
        $email = $request->get('email');

        $password = $request->get('password');

        $church = $request->get('church');

        if(Auth::attempt(['email' => $email, 'password' => $password])){

            $user = User::where('email', $email)->first();

            if($user->church_id == $church)
            {
                $person = $this->personRepository->find($user->person->id);

                $role_id = $user->person->role_id;

                $role = $this->roleRepository->find($role_id)->name;

                return json_encode([
                    'status' => true,
                    'person_id' => $user->person->id,
                    'role_id' => $role_id,
                    'role' => $role,
                    'name' => $person->name . ' ' . $person->lastName,
                    'email' => $email,
                    'tel' => $person->tel,
                    'cel' => $person->cel,
                    'imgProfile' => $person->imgProfile
                ]);
            }

            return json_encode(['status' => false]);

        }

        return json_encode(['status' => false]);
    }


    public function recoverPasswordApp($email)
    {
         $person = $this->personRepository->findByField('email', $email)->first();

         if(count($person) == 1)
         {
             if($this->codeServices->addCode($person))
             {
                 return json_encode(['status' => true]);
             }
         }

         return $this->returnFalse('Usuário não encontrado');

    }

    public function getCode($code)
    {
        return $this->codeServices->getCode($code);

    }
}
