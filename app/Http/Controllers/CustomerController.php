<?php
// cush controller php file responsible
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Category;
use App\User;
use App\Item;

use Session;
use Auth;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   	public function vendor(Request $request){
      if($request->isMethod('post')){
        Auth::user()->vendors()->attach(User::where('id', $request->input('person_id'))->first());
        return back()->with('message', 'You are now a custoemr for the shop');
      }

      return view('customers.view_user_vendors');

   	}

   	public function vendor_remove($person_id){
      Auth::user()->vendors()->detach(User::where('id', $person_id)->first());
   		return back()->with('message', 'Your customer relation with the shop now cancled');	
   	}

    public function view_user_customers(){
      $customers = Auth::user()->customers;

      return view('customers.view_user_customers')->with(compact('customers'));
    }

    public function peoples(){
      $peoples = User::get()->filter(function($value, $key){
        return Item::where('user_id', $value['id'])->first() != null;
      });

      return view('peoples.view')->with(compact('peoples'));
    }

    public function person_items($id = null){
      $person = User::where('id', $id)->first();
      return view('peoples.detail')->with(compact('person'));
    }
}