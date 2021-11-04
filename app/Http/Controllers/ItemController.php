<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Item;
use App\ItemImage;
use App\ItemType;
use App\ItemReview;

use Auth;
use Image;

class ItemController extends Controller
{
    //
    public function __construct()
    {     
        $this->middleware('auth');
    }

    public function post(Request $request){
    	if($request->isMethod('post')){
            $data = $request->all();  
            $url = $data['type'].Str::random(10).'_'.$data['name'];
            $data['url'] = strtolower(str_replace(' ', '_', $url));
            
            $this->validator($data)->validate();

            $type = ItemType::where('name', strtolower($data['type']))->first();
            if($type == null){
                $type = new ItemType;
                $type->name = $data['type'];
                $type->description = $data['description'];
                $type->user_id = Auth::user()->id;
                $type->save();
            }

            $item = Item::where(['name'=>$data['name'], 'item_type'=>$type->id, 'description'=>$data['description'])->first();

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

            //how to get the last value inserted
            $id = Item::where('url', $data['url'])->first()->id;

            foreach ($data['images'] as $key => $image) {
                if($request->hasFile('images')){    
                    $tmpimage = $this->image('images', $key);
                    if($tmpimage != null){
                        $newimage = new ItemImage;
                        $newimage->image = $tmpimage;
                        $newimage->item_id = $id;
                        $newimage->save();
                    }                    
                }
                
            }

            return redirect()->route('items');
    	}else{
            if(Auth::user()->country == NULL || Auth::user()->country == '')
                return redirect()->route('register2')->with('message', 'Please complete the informations below to post items');

            $types = ItemType::pluck('name')->toArray();
            return view('items.add')->with(compact('types'));
        }
    }

    private function image($img, $key){
        $image_tmp = Input::file($img);
        
        if(!array_key_exists($key, $image_tmp))
            return null;

        if($image_tmp[$key]->isValid()){
            $extension = $image_tmp[$key]->getClientOriginalExtension();
            $img = Str::random(20).'.'.$extension;

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
            Image::make($image_tmp[$key])->save($large_image_path);
            Image::make($image_tmp[$key])->resize(300, 300)->save($small_image_path);

            return date("F").''.date("Y").'/'.$img;
        }

        return null;
    }

    public function items(){
        $items = Auth::user()->owned()->orderBy('updated_at', 'DESC')->get();
        $itemTypes = ItemType::where('user_id', Auth::user()->id)->get();

        return view('items.listing')->with(compact('items', 'itemTypes'));
    }

    public function typeItems($id = null){
        $type = ItemType::where('id', $id)->first();
        $itemTypes = ItemType::where('user_id', Auth::user()->id)->get();
        return view('items.typeItems')->with(compact('type', 'itemTypes'));
    }

    public function manage_item(Request $request, $id = null){
        if($request->isMethod('get')){
            $item = Item::where('id', $id)->first();
            $types = ItemType::pluck('name')->toArray();
            return view('items.manage')->with(compact('item', 'types'));
        }else{
            $data = $request->all();  

            $type = ItemType::where('name', $data['type'])->first();
            if($type == null){
                $type = new ItemType;
                $type->name = strtolower($data['type']);
                $type->description = $data['description'];
                $type->user_id = Auth::user()->id;
                $type->save();
            }

            $url = $type->name.Str::random(10).'_'.$data['name'];
            $data['url'] = strtolower(str_replace(' ', '_', $url));
            
            $this->validator_update($data, $id)->validate();
            
            Item::where('id', $id)->update([
                'item_type' => $type->id,
                'name' => $data['name'],
                'price' => $data['price'],
                'description' => $data['description'],
                'url' => $data['url']
            ]);

            return back()->with('message', 'Item updated successfully');

        }
    }

    public function status(Request $request){
        
        $status = 0;

        if($request->status == 0)
            $status = 1;
        
        Item::where(['id'=>$request->itemId])->update([
                'status'=>$status]);

        echo $status;
    }

    public function image_remove(Request $request){
        //Get image path
        $large = 'storage/items/large/'.$request->image;
        $small = 'storage/items/small/'.$request->image;
        //Delete image
        if(file_exists($large)){
            unlink($large);
        }

        if(file_exists($small)){
            unlink($small);
        }

        ItemImage::where('id', $request->id)->delete();
        echo true;
    }

    public function image_upload(Request $request){
        foreach ($request->images as $key => $image) {
            if($request->hasFile('images')){    
                $tmpimage = $this->image('images', $key);
                if($tmpimage != null){
                    $newimage = new ItemImage;
                    $newimage->image = $tmpimage;
                    $newimage->item_id = $request->id;
                    $newimage->save();
                }                    
            }
            
        }

        return back()->with('message', 'uploaded successfully');   
    }

    public function review(Request $request){
        if(Auth::user()){
            $review = new ItemReview;
            $review->user_id = Auth::user()->id;
            $review->review = $request->review;
            $review->item_id = $request->item_id;
            $review->rate = $request->rate;
            $review->save();
            return back()->with('message', 'Review posted successfully');
        }
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
            'type' => 'required|string|max:255|min:3',
            'name' => 'required|string|max:255|min:3',
            'url' => 'required|unique:items',
            'description' => 'required|min:10',
            'price' => 'required|numeric',
            'images' => 'required'
        ]);
    }

    /**
     * Get a validator for 04 an incoming registration request.
     *
     * @param  array  $data20
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator_update(array $data, $id)
    {
        return Validator::make($data, [
            'type' => 'required|string|max:255|min:3',
            'name' => 'required|string|max:255|min:3',
            'url' => 'required|unique:items,url,'.$id,
            'description' => 'required|min:10',
            'price' => 'required|numeric'
        ]);
    }
}