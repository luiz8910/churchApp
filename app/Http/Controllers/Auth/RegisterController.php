<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\VisitorRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, DateRepository;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * @var VisitorRepository
     */
    private $visitorRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VisitorRepository $visitorRepository, UserRepository $userRepository,
                                RoleRepository $roleRepository)
    {
        $this->middleware('guest');
        $this->visitorRepository = $visitorRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'imgProfile' => 'uploads/profile/noimage.png'
        ]);
    }

    public function preFbLogin($church, $app = null)
    {
        session(['church' => $church]);

        if($app)
        {
            session(['app' => true]);
        }

        return $this->redirectToProvider();
    }

    public function preGoogleLogin($church, $app = null)
    {
        session(['church' => $church]);

        if($app)
        {
            session(['app' => true]);
        }

        return $this->redirectToGoogleProvider();
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
        //return Socialite::driver('facebook')->with(['church' => $church])->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return boolean
     */
    public function handleProviderCallback()
    {
        try{
            $app = session('app');

            $church = session('church');

            $social = Socialite::driver('facebook')->user();

            $userType = "Visitante";

            $user = $this->userRepository->findByField('facebook_id', $social->id)->first();

            if(count($user) > 0)
            {
                if ($user->church_id == $church)
                {
                    $userType = $this->roleRepository->find($user->person->role_id)->name;
                }
            }
            else{
                $user = $this->userRepository->findByField('email', $social->email)->first();

                if(count($user) == 0)
                {
                    \Session::flash('email.error', 'O email informado não existe');

                    return $app ? $this->wrongLogin() : redirect()->route('login');
                }


                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['facebook_id' => $social->getId()]);

                DB::table('people')
                    ->where("id", $user->person->id)
                    ->update(['imgProfile' => $social->getAvatar()]);

                $userType = $this->roleRepository->find($user->person->role_id)->name;
            }


            if($userType == "Visitante")
            {
                $visitor = $this->visitorRepository->findByField('email', $social->getEmail())->first();

                if(count($visitor) > 0){

                    $data['facebook_id'] = $social->getId();
                    $data['name'] = $social->getName();
                    $data['imgProfile'] = $social->getAvatar();

                    $id = $visitor->users()->first()->id;

                    $this->visitorRepository->update($data, $visitor->id);

                    DB::table('users')
                        ->where('id', $id)
                        ->update(['facebook_id' => $social->getId()]);

                    auth()->loginUsingId($id);
                    DB::commit();

                    return redirect()->route('event.index');
                }
                else{
                    \Session::flash('email.error', 'O email informado não existe');

                    return $app ? $this->wrongLogin() : redirect()->route('login');
                }
            }
            else{

                auth()->loginUsingId($user->id);

                DB::commit();

                return $app ? $this->loginSuccessful($user) : redirect()->route('index');
            }


        }catch(\Exception $e){
            DB::rollback();

            dd($e);
        }

    }


    public function wrongLogin()
    {
        return json_encode([
            'status' => false,
            'msg' => 'O Email informado não existe'
        ]);
    }

    public function loginSuccessful($user)
    {
        return json_encode([
            'status' => true,
            //'id' => $user->id,
            'church_id' => $user->church_id,
            'person_id' => $user->person_id,
            'facebook_id' => $user->facebook_id,
            'google_id' => $user->google_id,
            'email' => $user->email,
            'name' => $user->person->name,
            'lastName' => $user->person->lastName,
            'imgProfile' => $user->person->imgProfile
        ]);
    }

    /**
     * Redirect the user to the Linkedin authentication page.
     *
     * @return Response
     */
    public function redirectToLinkedinProvider()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from Linkedin.
     *
     * @return Response
     */
    public function handleLinkedinProviderCallback()
    {
        $user = Socialite::driver('linkedin')->user();

        $member = User::where('linkedin_id', $user->getId())->first();

        if(!$member){

            $email = User::where('email', $user->getEmail())->first();

            if(count($email) == 0){
                $member = User::create([
                    'linkedin_id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'church_id' => 1,
                    'imgProfile' => $user->getAvatar(),
                    'role' => 'membro'
                ]);

            }else{
                \Session::flash('email.error', 'O email informado já existe');
                return redirect()->route('login');
            }

        }

        auth()->login($member);

        return redirect()->route('index');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleGoogleProviderCallback()
    {
        $church = session('church');

        $app = session('app');

        $social = Socialite::driver('google')->user();

        $userType = "visitor";

        $user = $this->userRepository->findByField('google_id', $social->id)->first();

        if(count($user) > 0)
        {
            if ($user->church_id == $church)
            {
                $userType = $this->roleRepository->find($user->person->role_id)->name;
            }
        }
        else{
            $user = $this->userRepository->findByField('email', $social->email)->first();

            if(count($user) == 0)
            {
                \Session::flash('email.error', 'O email informado não existe');

                return $app ? $this->wrongLogin() : redirect()->route('login');
            }


            DB::table('users')
                ->where('id', $user->id)
                ->update(['google_id' => $social->getId()]);

            DB::table('people')
                ->where("id", $user->person->id)
                ->update(['imgProfile' => $social->getAvatar()]);

            $userType = $this->roleRepository->find($user->person->role_id)->name;
        }

        if($userType == "Visitante")
        {
            $visitor = $this->visitorRepository->findByField('email', $social->getEmail())->first();

            if(count($visitor) > 0){

                $data['google_id'] = $social->getId();
                $data['name'] = $social->getName();
                $data['imgProfile'] = $social->getAvatar();

                $id = $visitor->users()->first()->id;

                $this->visitorRepository->update($data, $visitor->id);

                DB::table('users')
                    ->where('id', $id)
                    ->update(['google_id' => $social->getId()]);

                auth()->loginUsingId($id);

                return redirect()->route('event.index');
            }
            else{
                \Session::flash('email.error', 'O email informado não existe');

                return $app ? $this->wrongLogin() : redirect()->route('login');
            }
        }
        else{

            auth()->loginUsingId($user->id);

            return $app ? $this->loginSuccessful($user) : redirect()->route('index');
        }
    }

    public function loginVisitor(Request $request, VisitorRepository $visitorRepository)
    {
        $visitor = $visitorRepository->findByField('email', $request->get('email'))->first();

        $church = $request->get('church');

        $id = $visitor->users->first();

        if($visitor){
            auth()->loginUsingId($id->id);

            return redirect()->route('home.visitor', ['church' => $church]);
        }

        return false;
    }

}
