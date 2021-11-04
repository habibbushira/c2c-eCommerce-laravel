<?php
// cush controller php file responsible
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\ItemType;
use App\Item;
use App\Image;
use App\Wishlist;
use App\User;

use Auth;
use Session;
use Cart;

class IndexController extends Controller
{
    public function index(){

        $vendor_items = null;

        if(Auth::user()){
            $vendor_items = Auth::user()->vendors;
        }
        
    	// In Descending order
    	$items = Item::where('status', 1)->orderBy('updated_at', 'DESC')->paginate(30);

    	return view('index')->with(compact('items', 'vendor_items'));
    }

    public function item($url = null){
        $itemInfo = Item::with('owner')->where('url', $url)->first();

        if(!$itemInfo)
            abort(404);

        $wishlist = false;
        if(Auth::user())
            if(Wishlist::where(['user_id'=>Auth::user()->id, 'item_id'=>$itemInfo->id])->count() != 0)
                $wishlist = true;

        $relatedItem = Item::where('url','!=', $url)->where('item_type', $itemInfo->item_type)->get();

        return view('items.item')->with(compact('itemInfo', 'relatedItem', 'wishlist'));
    }

    //Recently uploade
    public function recentlyUploaded(){
        $items = Item::where('status', 1)->orderby('created_at', 'DESC')->paginate(30);

        return view('items.recently_uploaded')->with(compact('items'));
    }

    //Top Sold
    public function topSolds(){
        return view('items.top_solds');
    }

    public function search(Request $request){
        $query = $request->get('query');
        $items = Item::where('status', 1)->search($query)->paginate(30);

        return view('items.search-results')->with(compact('items'));
    }

    public function search_peoples(Request $request){
        $query = $request->get('query');

        $peoples = User::search($query)->paginate(30)->filter(function($value, $key){
                return Item::where('user_id', $value['id'])->first() != null;
            });

        return view('peoples.search-results')->with(compact('peoples'));
    }

    public function itemTypes(){
        $types = ItemType::get();
        return view('items.types')->with(compact('types'));
    }

    public function typeItems($id = null){
        $type = ItemType::where('id', $id)->first();
        return view('items.listTypeItems')->with(compact('type'));
    }

    public function comparision(Request $request){
        
        if($request->isMethod('post')){
           
            $duplicates = Cart::instance('comparision')->search(function($cartItem, $rowId) use ($request){
                return $cartItem->id === $request->id;
            });

            if($duplicates->isNotEmpty()){
                echo 0;
            }else{
                Cart::instance('comparision')->add($request->id, 'compare', 1, 1)->associate('App\Item');

                echo 1;
            }
        }else{

            return view('items.compare');
        }
    }

    public function remove_comparision($rowId){
        Cart::instance('comparision')->remove($rowId);
        return back()->with('message', 'Item has been removed!');
    }

    public function privacy(){
        return view('terms_and_privacy.privacy');
    }

    /**
     * Get a validator for 04 an incoming registration request.
     *
     * @param  array  $data20
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pin' => 'required',
            'fname' => 'required|string|max:255|min:3',
            'phone' => 'required|min:10|max:12',
        ]);
    }
}