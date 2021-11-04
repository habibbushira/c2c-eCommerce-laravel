<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Input;

use App\Item;
use App\ItemType;
use App\ItemImage;
use App\ItemReview;
use App\User;

use Auth;
use Image;

class ItemController extends Controller
{
    //
    public function home(Request $request, $secret = null){

        $this->client = Client::where('secret', $secret)->first();
        
        if($this->client){
            if(Auth::user()){
                if($request->page > 0){
                    $items = Item::orderby('updated_at', 'ASEC')->with('isItWishlist','images')->has('images')->paginate(30);
                    return response()->json(['items'=>$items], 200, [], JSON_NUMERIC_CHECK); 
                }else{
                    $vendors = Auth::user()->vendors()->with('items')->get();
                    $items = Item::orderby('updated_at', 'ASEC')->with('isItWishlist','images')->has('images')->paginate(30);
                    return response()->json(['items'=>$items, 'vendors'=>$vendors], 200, [], JSON_NUMERIC_CHECK);
                }
            }else{
                $items = Item::orderby('updated_at', 'ASEC')->with('images')->->has('images')->paginate(30);
                return response()->json(['items'=>$items], 200, [], JSON_NUMERIC_CHECK);                
            }
        }

        abort(423);
    }

    public function item($secret = null, $id = null){
        $this->client = Client::where('secret', $secret)->first();
        
        if($this->client){
            if(Auth::user())
                $item = Item::where('id', $id)->with('isItWishlist', 'images', 'reviews', 'type', 'owner')->first();
            else
                $item = Item::where('id', $id)->with('images', 'reviews', 'type', 'owner')->first();
        	foreach($item->reviews as $review){
        		$review->user_name = $review->user->name;
        		unset($review->user);
        	}
        	return response()->json(['item'=>$item], 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function related_items($key = null, $id = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $items = Item::where(['item_type'=>Item::where('id', $id)->first()->item_type, 'status'=>1])->with('images')->has('images')->paginate(30);
            return response()->json($items, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function user_items($key = null, $id = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $items = User::where('id', $id)->first()->items()->has('images')->paginate(20);
            $customers = User::where('id', $id)->first()->customers()->count();
            $isCustomer = User::where('id', $id)->first()->isCustomer;
            return response()->json(['items'=>$items, 'customers'=>$customers, 'isCustomer'=>$isCustomer], 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function only_user_items($key = null, $id){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $items = User::where('id', $id)->first()->items()->paginate(30);
            return response()->json($items, 200, [], JSON_NUMERIC_CHECK);
        }
        abort(423);
    }

    public function my_items($key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $items = Auth::user()->itemsWoutWishlist()->paginate(30);
            return response()->json($items, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function item_types($key=null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $types = ItemType::pluck('name');
            return response()->json(["types"=>$types], 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function post(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $data = array();  

            $data['type'] = str_replace('"', '', $request->type);
            $data['name'] = str_replace('"', '', $request->name);
            $data['description'] = str_replace('"', '', $request->description);
            $data['status'] = str_replace('"', '', $request->status);

            $url = $data['type'].Str::random(10).'_'.$data['name'];
            $data['url'] = strtolower(str_replace(' ', '_', $url));

            $type = ItemType::where('name', $data['type'])->first();
            if($type == null){
                $type = new ItemType;
                $type->name = strtolower($data['type']);
                $type->description = $data['description'];
                $type->user_id = Auth::user()->id;
                $type->save();
            }

            $item = Item::where(['name'=>$data['name'], 'item_type'=>$type->id, 'description'=>$data['description']])->first();

            if($item == null){
                $item = new Item;
                $item->item_type=$type->id;
                $item->name=$data['name'];
                $item->price=$request->price;
                $item->description = $data['description'];
                $item->property_status = $data['status'];
                $item->url=$data['url'];
                $item->user_id = Auth::user()->id;
                $item->save();
            }

            return response()->json(['item'=>$item], 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function update_item(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $type = ItemType::where('name', $request->type)->first();
            if($type == null){
                $type = new ItemType;
                $type->name = strtolower($request->type);
                $type->description = $request->description;
                $type->user_id = Auth::user()->id;
                $type->save();
            }

            $url = $type->name.Str::random(10).'_'.$request->name;
            $url= strtolower(str_replace(' ', '_', $url));

            Item::where('id', $request->id)->update([
                    'item_type' => $type->id,
                    'name' =>$request->name,
                    'price' => $request->price,
                    'description' =>$request->description,
                    'property_status' => $request->property_status,
                    'url' => $url
                ]);

            return response()->json(true, 200, [], JSON_NUMERIC_CHECK);
        }
        abort(423);
    }

    public function change_status(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Item::where(['id'=>$request->item_id])->update([
                'status'=>$request->status]);
            return response()->json(true, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);

    }

    public function add_image(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            foreach ($request->images as $image) {
                $tmpimage = $this->image($image);
                if($tmpimage != null){
                    $newimage = new ItemImage;
                    $newimage->image = $tmpimage;
                    $newimage->item_id = $request->item_id;
                    $newimage->save();
                }           
            }

            return response()->json(true, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    
    private function image($image){
        $image_tmp = base64_decode($image);

        $img = Str::random(20).'.jpg';

        $folder_name_large = 'storage/items/large/'.date("F").''.date("Y");
        $folder_name_small = 'storage/items/small/'.date("F").''.date("Y");

        if(!file_exists($folder_name_large)){
            mkdir($folder_name_large);
        }
        if(!file_exists($folder_name_small)){
            mkdir($folder_name_small);
        }

        $large_image_path = $folder_name_large.'/'.$img;
        $small_image_path = $folder_name_small.'/'.$img;

        //#resize image
        Image::make($image_tmp)->save($large_image_path);
        Image::make($image_tmp)->resize(300, 300)->save($small_image_path);

        return date("F").''.date("Y").'/'.$img;

    }

    public function remove_image(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){

            $image = ItemImage::where('id', $request->image_id)->first();

            $large = 'storage/items/large/'.$image->image;
            $small = 'storage/items/small/'.$image->image;
            //Delete image
            if(file_exists($large)){
                unlink($large);
            }

            if(file_exists($small)){
                unlink($small);
            }

            $image->delete();

            return response()->json(true, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);

    }

    public function review(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $review = new ItemReview;
            $review->user_id = Auth::user()->id;
            $review->review = $request->review;
            $review->item_id = $request->item_id;
            $review->rate = $request->rate;
            $review->save();
            return response()->json(["review"=>$review], 200, [], JSON_NUMERIC_CHECK);
        }
        abort(423);
    }
}