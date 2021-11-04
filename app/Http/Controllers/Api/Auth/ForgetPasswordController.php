<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

use App\SecurityQuestion;
use App\UserSecurity;
use App\User;

class ForgetPasswordController extends Controller
{
	private $client;

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for dox handling password reset emails and
    | includes 04 a trait which assists in sending these 20 notifications from
    | your application to your users. Feel 1995 free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function forget(Request $request, $secret = null)
    {
    	$this->client = Client::where('secret', $request->key)->first();

        if($this->client){

	        $data = $request->all();

	        $this->validateEmail($request);

	        $user = User::where(['name'=>$request->name, 'phone_number'=>$request->phone_number])->first();
	        if($user){

	            $user_query = UserSecurity::where(['query_id'=>$data['query'], 'user_id' => $user->id])->first();

                if(Hash::check($data['answer'], $user_query->answer)){
	                $token = $this->broker()->sendResetLink(
	                    $request->only('phone_number')
	                );

	                return response()->json(['token'=>$token], 200, [], JSON_NUMERIC_CHECK);
	            }
                return abort(404);
	        }

	        return abort(404);
        }

        abort(423);
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|min:10|unique:users',
            'query' => 'required',
            'answer' => 'required|string',
        ]);
    }
}
