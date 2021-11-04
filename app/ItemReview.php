<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemReview extends Model
{
    //
    public function user(){
    	return $this->belongsTo('App\User');
    }
}