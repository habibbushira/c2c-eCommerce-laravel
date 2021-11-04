<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\SecurityQuestion;
use App\UserSecurity;
use App\User;

class ForgotPasswordController extends Controller
{

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $queries = SecurityQuestion::get();
        return view('auth.passwords.email')->with(compact('queries'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $data = $request->all();

        $this->validateEmail($request);

        $user = User::where(['name'=>$request->name, 'phone_number'=>$request->phone_number])->first();
        if($user){

            $user_query = UserSecurity::where(['query_id'=>$data['query'], 'user_id' => $user->id])->first();

            if(Hash::check($data['answer'], $user_query->answer)){
                $token = $this->broker()->sendResetLink(
                    $request->only('phone_number')
                );

                return redirect()->route('password.reset', $token);
            }

        }

        return redirect()->back()->with('message', 'Incorrect information please check and try again')
                ->withInput($request->all());
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