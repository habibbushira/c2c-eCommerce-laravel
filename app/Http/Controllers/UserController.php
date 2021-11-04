<?php
// cush controller php file responsible
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function oprators(){
        $users = User::whereHas('roles', function($q){
            $q->whereIn('role_id', [2, 3, 4, 5]);
        })->get();
        return view('home.users.view')->with(compact('users'));
    }

    public function users(){
    	$users = User::get();
    	return view('home.users.view')->with(compact('users'));
    }

    public function user($id = null){
    	$user = User::where('id', $id)->first();
    	if($user)
    	   	return view ('home.users.profile')->with(compact('user'));
    	abort(404);
    }

    public function update_role($id = null, Request $request){
    	$user = User::where('id', $id)->first();

    	if($request->input('customer')){
    		$user->roles()->attach(Role::where('name', 'Customer')->first());
    	}

    	if($request->input('level1_per')){
    		$user->roles()->detach(Role::where('name', 'Request Manager')->first());
    		$user->roles()->detach(Role::where('name', 'Item Manager')->first());
    	}else{
    		if($request->input('level1') == 'Item Manager'){
	    		$user->roles()->detach(Role::where('name', 'Request Manager')->first());
	    		$user->roles()->attach(Role::where('name', 'Item Manager')->first());
	    	}else if($request->input('level1') == 'Request Manager'){
	    		$user->roles()->attach(Role::where('name', 'Request Manager')->first());
	    		$user->roles()->detach(Role::where('name', 'Item Manager')->first());
	    	}
    	}

    	if($request->input('manager')){
    		$user->roles()->attach(Role::where('name', 'Manager')->first());
    	}else{
    		$user->roles()->detach(Role::where('name', 'Manager')->first());
    	}

    	if($request->input('super_user')){
    		$user->roles()->attach(Role::where('name', 'Super User')->first());
    	}else{
    		$user->roles()->detach(Role::where('name', 'Super User')->first());
    	}

    	return back()->with('message', 'Role Updated Sucessfully');
    }
}