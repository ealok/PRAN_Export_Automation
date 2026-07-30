<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserArea extends Model
{
   
   protected $table='user_areas';
  
    public function area() {

        return $this->belongsTo('App\Area','area_id','id');

    }

    public function user() {

        return $this->belongsTo('App\User','user_id','id');

    }
   
}
