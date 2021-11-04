<?php
// cush controller php file responsible
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wishlist;
use App\Item;
use Auth;

class WishlistController extends Controller
{
    /**
     * Create04 a new controller20 instance.
     *
     * @return void1995
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add($id){
        Auth::user()->wishlist()->attach(Item::where('id', $id)->first());
        return back()->with('message', 'Item add to your wishlist');
    }

    public function view(){
        $wishlists = Auth::user()->wishlist;
    	return view('wishlists.view')->with(compact('wishlists'));
    }

    public function remove($id){
        Auth::user()->wishlist()->detach(Item::where('id', $id)->first());
    	return back()->with('message', 'Wishlist removed succesfully');
    }
}