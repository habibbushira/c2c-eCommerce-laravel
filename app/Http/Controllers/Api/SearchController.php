<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Laravel\Passport\Client;

use App\User;
use App\Item;

class SearchController extends Controller
{
    //
    public function search(Request $request, $key = null){
    	$this->client = Client::where('secret', $key)->first();
    	if($this->client){
    		$query = $request->get('query');
    		$items = Item::search($query)->where('status', 1)->with('images')->has('images')->paginate(30);
    		return response()->json($items, 200, [], JSON_NUMERIC_CHECK);
    	}

    	abort(423);
    }

    public function search_user(Request $request, $key = null){
    	$this->client = Client::where('secret', $key)->first();
    	if($this->client){
            $query = $request->get('query');
            $users = User::search($query)->has("owned")->paginate(30);
            
            return response()->json($users, 200, [], JSON_NUMERIC_CHECK);
        }

    	abort(423);
    }
}