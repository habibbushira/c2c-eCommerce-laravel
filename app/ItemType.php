<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    // 
    public function items(){
    	return $this->hasMany('App\Item', 'item_type');
    }


    public function items10(){
    	return $this->items()->with('images')->take(10);
    }

    public function items_images(){
    	return $this->items()->where('status', 1)->with('images')->has('images');
    }
}