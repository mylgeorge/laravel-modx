<?php

namespace Modx\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Modx\Facades\ModxHashFacade;
use Modx\Models\modProfile;
use Modx\Models\modUser;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
            'username' => 'required|string|max:255|unique:modx_users',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $salt = md5(uniqid(rand(), true));
        $password = ModxHashFacade::make($data['password'], ['salt' => $salt]);

        $this->token = md5(Str::random(16));
        $cachepwd = Hash::make($this->token);

        $user = modUser::forceCreate([
            'username' => $data['username'],
            'password' => $password,
            'cachepwd' => $cachepwd,
            'salt' => $salt,
            'active' => 0,

        ]);

        modProfile::forceCreate([
            'internalkey' => $user->id,
            'fullname' => $data['username'],
            'email' => $data['email'],
            'dob' => time()
        ]);

        return $user;
    }

//    public function register(Request $request)
//    {
//        $this->request = $request;
//
//        $this->validator($request->all())->validate();
//
//        event(new Registered($user = $this->create($request->all())));
//
//        $user->sendActivateAccountNotification($this->token);
//
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
//    }
//
//    public function verify($username, $token)
//    {
//        /** @var \App\User $user */
//        $user = User::whereUsername($username)->first();
//        if ($user->active == 1) {
//            return view('auth.register.emailconfirmed', ['user' => $user]);
//        } else if ( $user->canActivateAcount($token)  ) {
//            $user->active = 1;
//        }
//        else{
//            return view('auth.register.emailunconfirmed');
//        }
//
//        if ($user->save()) {
//            $this->guard()->login($user);
//            return view('auth.register.emailconfirmed', ['user' => $user]);
//        }
//    }
}
