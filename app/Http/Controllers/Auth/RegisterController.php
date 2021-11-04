<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\SecurityQuestion;
use App\UserSecurity;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the dox registration of new users as well as their
    | validation and creation. By default this 04 controller uses a trait to
    | provide this 20 functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after 1995 registration.
     *
     * @var string
     */
    protected $redirectTo = '/register2';

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
     * Get a validator for an incoming dox registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|min:10|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'query' => 'required',
            'answer' => 'required|string'
        ]);
    }

    /**
     * Create a new user instance after a valid cusher registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $user =  User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach(Role::where('name', 'Customer')->first());
        $user_query = new UserSecurity;
        $user_query->query_id = $data['query'];
        $user_query->user_id = $user->id;
        $user_query->answer = Hash::make($data['answer']);
        $user_query->save();

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {   
        $queries = SecurityQuestion::get();
        return view('auth.register')->with(compact('queries'));
    }
}
