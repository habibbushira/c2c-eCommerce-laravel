<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

use Auth;

class Item extends Model
{
    //
    use SearchableTrait;

    protected $fillable = [
        'name', 'item_type', 'price', 'property_status', 'url', 'description', 'user_id'
    ];

    protected $searchable = [
        'columns' => [
            'items.name' => 10,
            'item_types.name' => 9,
            'items.property_status' => 9,
            'items.price' => 7,
            'items.description' => 5,
        ],
        'joins' => [
            'item_types' => ['items.item_type', 'item_types.id'],
        ],
    ];

    public function images(){
    	return $this->hasMany('App\ItemImage', 'item_id');
    }

    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function wishlist(){
        return $this->hasMany('App\Wishlist', 'item_id');
    }

    public function isItWishlist(){
        return $this->wishlist()->where('user_id', Auth::user()->id);
    }

    public function type(){
        return $this->belongsTo('App\ItemType', 'item_type');
    }

    public function reviews(){
        return $this->hasMany('App\ItemReview', 'item_id');
    }
}