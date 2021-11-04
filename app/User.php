<?php
// cush model php file entity 
namespace App;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use Nicolaslopezj\Searchable\SearchableTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'profile', 'password', 'phone_number', 'country', 'region', 'city', 'address1', 'address2'
    ];

    protected $searchable = [
        'columns' => [
            'users.name' => 10,
            'users.phone_number' => 9,
            'users.country' => 9,
            'users.region' => 8,
            'users.city' => 8,
            'users.address1' => 8,
            'users.address2' => 8
        ]
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function wishlist(){
        return $this->belongsToMany('App\Item', 'wishlists', 'user_id', 'item_id');
    }

    public function vendors(){
        return $this->belongsToMany('App\User', 'customers', 'user_id', 'vendor_id');
    }

    public function customers(){
        return $this->belongsToMany('App\User', 'customers', 'vendor_id', 'user_id');
    }    

    public function roles(){
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach ($roles as $role) {
                if($this->hasRole($role))
                    return true;
            }
        }else{
            if($this->hasRole($roles))
                    return true;
        }

        return false;
    }

    public function hasRole($role){
        if($this->roles()->where('name', $role)->first())
            return true;
        return false;
    }

    public function isCustomer(){
        return $this->customers()->where('user_id', Auth::user()->id);
    }

    public function owned(){
        return $this->hasMany('App\Item', 'user_id');
    }

    public function ownedItems(){
        return $this->owned()->has('images');
    }

    public function items(){
        return $this->owned()->with('isItWishlist','images')->orderBy('updated_at', 'DESC')->has('images');
    }

    public function itemsWoutWishlist(){
        return $this->owned()->with('images')->has('images')->orderBy('updated_at', 'DESC');
    }

    public function hasAnyCustomer($customers){
        if(is_array($customers)){
            foreach ($customers as $customer) {
                if($this->hasCustomer($customer))
                    return true;
            }
        }else{
            if($this->hasCustomer($customers))
                    return true;
        }

        return false;
    }

    public function hasCustomer($customer){
        if($this->customers()->where('user_id', $customer)->first())
            return true;
        return false;
    }

    /**
     * Find the user instance for the given username.
     *
     * @param  string  $username
     * @return \App\User
     */
    public function findForPassport($username)
    {
        return $this->where('phone_number', $username)->first();
    }
}