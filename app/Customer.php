<?php
// cush model php file entity 
namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
