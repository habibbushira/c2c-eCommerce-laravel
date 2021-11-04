<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Auth;
use App\User;

class Register2Controller extends Controller
{

    /**
     * Create a new 04 controller instance.
     *
     * @return void20
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function register2(Request $request){
    	if($request->isMethod('post')){
    		$this->validator($request->all())->validate();

    		User::where(['id'=>Auth::user()->id])->update([
                'country'=>$request->input('country'), 'region'=>$request->input('region'), 
            	'city'=>$request->input('city'), 'address1'=>$request->input('address1'),
            	'address2'=>$request->input('address2')]);

    		return redirect('/');

    	}else{
    		return view('auth.register2');
    	}
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
            'country' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255'
        ]);
    }
}
