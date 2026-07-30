<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderDetails extends Model
{
    public function ci_item(){

      return $this->belongsTo('App\CiItem','item_id');

    }

}
