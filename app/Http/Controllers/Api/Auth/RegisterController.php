<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\User;
use App\Role;
use App\SecurityQuestion;
use App\UserSecurity;

use Auth;

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		//$this->client = Client::find(1);
	}

    public function queries($key = null){
        
        $this->client = Client::where('secret', $key)->first();

        if($this->client){
            $queries = SecurityQuestion::get();
            return response()->json(['queries'=>$queries], 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function register(Request $request){
        $this->client = Client::where('secret', $request->key)->first();

        if($this->client){
            $this->validator($request->all())->validate();

            $user = User::create([
                'name' => request('name'),
                'phone_number' => request('phone_number'),
                'password' => Hash::make(request('password'))
            ]);

            $user->roles()->attach(Role::where('name', 'Customer')->first());

            $data = $request->all();

            $user_query = new UserSecurity;
            $user_query->query_id = $data['query'];
            $user_query->user_id = $user->id;
            $user_query->answer = Hash::make($data['answer']);
            $user_query->save();

            return $this->issueTokenTrait($request, 'password');
        }

        abort(423);	
    }

    public function complete_registration(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();

        if($this->client){
                
            User::where('id', Auth::user()->id)->update(['country'=>$request->country, 'region'=>$request->region, 'city'=>$request->city, 'address1'=>$request->address1, 'address2'=>$request->address2]);

            $user = User::where('id', Auth::user()->id)->first();

            return response()->json(['user'=>$user], 200, [], JSON_NUMERIC_CHECK); 
        }

        abort(423);
    }

    

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|min:10|unique:users',
            'password' => 'required|string|min:6',
            'answer' => 'required|string'
        ]);
    }
}