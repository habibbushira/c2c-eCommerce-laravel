<?php
// cush controller php file responsible
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Image;
use Session;

use App\User;

use Auth;

class SettingController extends Controller
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

    public function account(Request $request){
        if($request->isMethod('post')){

            $this->account_validator($request->all())->validate();

            if(!Hash::check($request->get('password'), Auth::user()->password))
                return back()->with('message_error', 'Your current password does not match with the password you provided. Please try again.');
            if(strcmp($request->get('password'), $request->get('newpassword')) == 0)
                return back()->with('message_error', 'New password cannot be same as your current password. Please choose a different new password');

            User::where(['id'=>Auth::user()->id])->update([
                'password'=>Hash::make($request->input('newpassword'))]);

            return back()->with('message', 'Your account has been updated');
        }

        return view('settings.account');
    }

    public function user_profile(Request $request){
    	if($request->isMethod('post')){
            
            $this->user_validator($request->all())->validate();

            $image = Auth::user()->profile;
            if($request->hasFile('image')){
                $folder_small = 'storage/users/small/';
                $folder_large = 'storage/users/large/';

                $folder_date = date("F").''.date("Y");

                $this->removeImage($image,$folder_large, $folder_small);
                $image = $this->image('image', $folder_large.$folder_date, $folder_small.$folder_date);
            }

            User::where(['id'=>Auth::user()->id])->update([
                'name'=>$request->input('name'), 
                'phone_number'=>$request->input('phone_number'),
                'email'=>$request->input('email'),
                'profile'=>$image,
                'country'=>$request->input('country'),
                'region'=>$request->input('region'),
                'city'=>$request->input('city'),
                'address1'=>$request->input('address1'),
                'address2'=>$request->input('address2')]);

            return back()->with('message', 'Your profile has been updated');
        }


    	return view('settings.user_profile');
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

    protected function user_validator(array $data){
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.Auth::user()->id,
            'phone_number' => 'required|string|max:15|min:10|unique:users,phone_number,'.Auth::user()->id,
            'image' => 'image',
        ]);
    }

    protected function account_validator(array $data){
        return Validator::make($data, [
            'password' => 'required|string|min:6',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);
    }
}