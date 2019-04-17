<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\BaseController;
use App\Mail\AccountActivationMail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends BaseController
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Mail::to($user->email)->send(new AccountActivationMail($user));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    public function validator(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();

        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:' . $users_table,
            'password' => 'required|min:6|confirmed',
            'address' => 'required|max:255',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'address' => $data['address'],
            'activation_code' => str_random(15) . time()
        ]);
    }

    public function showRegistrationForm()
    {
        return view('web.register.index');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect('/register')->with('message', 'Successfully created a new account. Please check your email and activate your account.');
    }


    /**
     * Activate the user with given activation code.
     * @param string $activationCode
     * @return string
     */
    public function activateUser($activationCode)
    {
        try {
            $user = User::where('activation_code', $activationCode)->first();
            if (!$user) {
                return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
            }
            $user->active = 1;
            $user->activation_code = null;
            $user->save();
//            auth()->login($user);
            $status = "Your e-mail is verified. You can now login.";
            return redirect('/login')->with('message', $status);

        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
    }


    /**
     * Resend activation code to user e-mail.
     * @param string $email
     * @return string
     */
    public function resendActivationMail(Request $request, $email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
            }
            $user->activation_code = str_random(15) . time();
            $user->save();

            Mail::to($user->email)->send(new AccountActivationMail($user));
            $status = 'We have sent you an activation email. Please check your email and activate your account.';

            return redirect('/login')->with('message', $status);

        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
    }
}
