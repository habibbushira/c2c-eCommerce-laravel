<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		//$this->client = Client::find(1);
	}

    public function login(Request $request){
    	$this->client = Client::where('secret', $request->key)->first();

        if($this->client){

        	$this->validate($request, [
	            'username' => 'required|string',
	            'password' => 'required|string',
	        ]);
	        return $this->issueTokenTrait($request, 'password');
        }

        abort(423);

    }

    public function refresh(Request $request){
    	$this->client = Client::where('secret', $request->key)->first();
        
        if($this->client){
        	$this->validate($request, [
	    		'refresh_token'
	    	]);

	    	return $this->issueTokenTrait($request, 'refresh_token');
        }

        abort(423);
    }

    public function logout(Request $request){
    	$this->client = Client::where('secret', $request->key)->first();
        
        if($this->client){
        	$accessToken = Auth::user()->token();

	    	DB::table('oauth_refresh_tokens')
	    			->where('access_token_id', $accessToken)
	    			->update(['revoked'=>true]);

	    	$accessToken->revoked();

	    	return response()->json([], 204);
        }

        abort(423);
    }
}
