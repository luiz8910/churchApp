<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repositories\VisitorRepository;
use App\Traits\DateRepository;
use App\Traits\FormatGoogleMaps;
use Illuminate\Http\Request;
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();

        $member = User::where('facebook_id', $user->getId())->first();

        if (!$member)
        {
            $email = User::where('email', $user->getEmail())->first();

            if(count($email) == 0){
                $member = User::create([
                    'facebook_id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'church_id' => 1,
                    'imgProfile' => $user->getAvatar(),
                    'role' => 'membro'
                ]);
            }
            else{
                \Session::flash('email.error', 'O email informado já existe');
                return redirect()->route('login');
            }
        }

        auth()->login($member);

        return redirect()->route('index');
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
        $user = Socialite::driver('google')->user();

        $member = User::where('google_id', $user->getId())->first();

        if(!$member){

            $email = User::where('email', $user->getEmail())->first();

            if(count($email) == 0){
                $member = User::create([
                    'google_id' => $user->getId(),
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

    public function loginVisitor(Request $request, VisitorRepository $visitorRepository)
    {
        $visitor = $visitorRepository->findByField('email', $request->get('email'))->first();

        $id = $visitor->users()->first();

        if($visitor){
            auth()->loginUsingId($id);

            return redirect()->route('index');
        }

        return false;
    }
}
