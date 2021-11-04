<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;

use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;


class ResetPasswordController extends Controller
{
    //
    use ResetsPasswords;
    use IssueTokenTrait;

    private $client;


    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request, $key = null)
    {
    	$this->client = Client::where('secret', $request->key)->first();

        if($this->client){

	        // Here we will attempt to reset the user's password. If it is successful we
	        // will update the password on an actual user model and persist it to the
	        // database. Otherwise we will parse the error and return the response.

	        $response = $this->broker()->reset(
	            $this->credentials($request), function ($user, $password) {
	                $this->resetPassword($user, $password);
	            }
	        );

	        // If the password was successfully reset, we will redirect the user back to
	        // the application's home authenticated view. If there is an error we can
	        // redirect them back to where they came from with their error message.

	        if($response == Password::PASSWORD_RESET){
	        	return $this->issueTokenTrait($request, 'password');
	        }else
	        	abort(500);
        }

        abort(423);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

    }

     /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'phone_number', 'password', 'password_confirmation', 'token'
        );
    }

}
