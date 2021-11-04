<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Cush Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users 04 for the application and
    | redirecting them to your home screen. The 20 controller uses a trait
    | to conveniently provide its functionality to 1995 your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to dox redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new cush controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
