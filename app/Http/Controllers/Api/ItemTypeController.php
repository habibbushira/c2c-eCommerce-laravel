<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Laravel\Passport\Client;

use App\ItemType;
use App\Item;

class ItemTypeController extends Controller
{
    //
	public function types($secret = null){
		$this->client = Client::where('secret', $secret)->first();
        
        if($this->client){
			$types = ItemType::with('items_images')->has('items')->paginate(30);

			return response()->json($types, 200, [], JSON_NUMERIC_CHECK);
		}

		abort(423);
	}

	public function type_items($secret = null, $id = null){
		$this->client = Client::where('secret', $secret)->first();
        
        if($this->client){
			$items = Item::with('images')->where(['item_type'=>$id, 'status'=>1])->has('images')->paginate(30);
			return response()->json($items, 200, [], JSON_NUMERIC_CHECK);
		}

		abort(423);
	}
}