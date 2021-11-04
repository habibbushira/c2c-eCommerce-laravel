<?php
// cush auth controller php file responsible
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Laravel\Passport\Client;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Auth;
use Image;

use App\Customer;
use App\User;
use App\Item;

class UserController extends Controller
{
    //
    public function profile($key=null){
    	$this->client = Client::where('secret', $key)->first();
    	if($this->client){
            $no_vendors = Auth::user()->vendors()->count();
            $no_customers = Auth::user()->customers()->count();
            $no_wishlist = Auth::user()->wishlist()->count();
            $no_items = Auth::user()->owned()->count();
    		return response()->json(['user'=>Auth::user(), 'no_vendors'=>$no_vendors, 'no_customers'=>$no_customers, 'no_wishlist'=>$no_wishlist, 'no_items'=>$no_items], 200, [], JSON_NUMERIC_CHECK);
    	}

    	abort(423);
    }

    public function customers($key=null){
    	$this->client = Client::where('secret', $key)->first();
    	if($this->client){
    		return response()->json(['shops'=>Auth::user()->customers], 200, [], JSON_NUMERIC_CHECK);
    	}

    	abort(423);
    }

     public function peoples($key=null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $peoples = User::has('ownedItems')->paginate(30);
            
            return response()->json($peoples, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function vendors($key=null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $peoples = Auth::user()->vendors()->paginate(30);
            return response()->json($peoples, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function mycustomers($key=null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $peoples = Auth::user()->customers()->paginate(30);
            return response()->json($peoples, 200, [], JSON_NUMERIC_CHECK);
        }

        abort(423);
    }

    public function wishlist($key=null){
    	$this->client = Client::where('secret', $key)->first();
    	if($this->client){
    		return response()->json(Auth::user()->wishlist()->with('images')->paginate(5), 200, [], JSON_NUMERIC_CHECK);
    	}

    	abort(423);    	
    }

    public function setWishlist(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            if($request->wishlist == 0)
                Auth::user()->wishlist()->attach(Item::where('id', $request->item_id)->first());
            else
                Auth::user()->wishlist()->detach(Item::where('id', $request->item_id)->first());

            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function setVendor(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
             Auth::user()->vendors()->attach(User::where('id', $request->input('user_id'))->first());
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

     public function removeVendor(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
             Auth::user()->vendors()->detach(User::where('id', $request->input('user_id'))->first());
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_name(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->name = $request->name;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_phone(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->phone_number = $request->phone;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_email(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->email = $request->email;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_region(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->region = $request->region;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_city(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->city = $request->city;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_address1(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->address1 = $request->address1;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_address2(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            Auth::user()->address2 = $request->address2;
            Auth::user()->update();
            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function change_password(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            if(!Hash::check($request->get('password'), Auth::user()->password))
                abort(422);

            User::where(['id'=>Auth::user()->id])->update([
                'password'=>Hash::make($request->input('new_password'))]);

            return response()->json(['response'=>true], 200, [], JSON_NUMERIC_CHECK);
        }
        
        abort(423);
    }

    public function update_profile(Request $request, $key = null){
        $this->client = Client::where('secret', $key)->first();
        if($this->client){
            $profile = Auth::user()->profile;

            if($request->hasFile('image')){   
                $folder_small = 'storage/users/small/';
                $folder_large = 'storage/users/large/';

                $folder_date = date("F").''.date("Y");
                
                $image = $this->image('image', $folder_large.$folder_date, $folder_small.$folder_date); 

                if($image != null){
                    Auth::user()->profile = $image;
                    Auth::user()->update();
                    $this->removeImage($profile,$folder_large, $folder_small);
                    return response()->json(['profile'=>$image], 200, [], JSON_NUMERIC_CHECK);
                }                    
            }            
        }
        
        abort(423);
    }

    private function image($img, $folder_large, $folder_small = null){
        $image_tmp = Input::file($img);
        if($image_tmp->isValid()){
            $extension = $image_tmp->getClientOriginalExtension();
            $img = Str::random(20).'.'.$extension;

            if(!file_exists($folder_large)){
                mkdir($folder_large);
            }

            $large_image_path = $folder_large.'/'.$img;

            //#resize image
            Image::make($image_tmp)->save($large_image_path);


            if($folder_small != null){
                if(!file_exists($folder_small)){
                    mkdir($folder_small);
                }

                $small_image_path = $folder_small.'/'.$img;

                Image::make($image_tmp)->resize(300, 300)->save($small_image_path);
            }

            return date("F").''.date("Y").'/'.$img;
        }
    }

    public function removeImage($img, $folder_large, $folder_small = null){
        //Get image path-1995

        if(strcmp('default.png', $img) != 0){
            $large = $folder_large.$img;
            //Delete doximage
            if(file_exists($large)){
                unlink($large);
            }

            if($folder_small != null){
                $small = $folder_small.$img;
                if(file_exists($small)){
                    unlink($small);
                }
            }
        }
    }
}