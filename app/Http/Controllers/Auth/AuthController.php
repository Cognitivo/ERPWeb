<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Security_User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Input;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
     */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectPath = '/';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
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
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request)
    {

        //Api
        if ($request->ajax) {

            if (($user = Security_User::where(['name' => $request->get('name'), 'password' => $request->get('password')])->first()) instanceof Security_User) {

                Auth::login($user);

                return response()->json(['message' => true, 'user' => Auth::user()]);

            } else {

                $rules = [
                    'email'    => 'required|email',
                    'password' => 'required',
                ];

                $messages = [
                    'email.required'    => 'El campo email es requerido',
                    'email.email'       => 'El formato de email es incorrecto',
                    'password.required' => 'El campo password es requerido',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                return response()->json(['validator' => $validator->errors()->all(), 'message' => 'Error al iniciar sesión']);

            }

        }

        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required',
        ]);

        if (($user = Security_User::where(['name' => $request->get('name'), 'password' => $request->get('password')])->first()) instanceof Security_User) {

            Auth::login($user);

            return redirect()->intended('/');
        }

        $errors = ["message" => "The Credentials are Incorrect"];
        return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));
    }

    public function getLogout(Request $request)
    {

        \Session::flush();

        if($request->ajax){

             return response()->json(['message'=>true]);
        }

        return redirect('auth/login');
    }
    public function Login($username,$password)
    {

      if (($user = Security_User::where(['name' =>$username, 'password' => $password ])->first()) instanceof Security_User) {

          Auth::login($user);

          return response()->json([true]);

      }
      else {
            return response()->json([false]);
      }
    }
}
