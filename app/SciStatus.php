<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SciStatus extends Model
{
    
    public function sci_status(){

        return $this->hasMany('App\SCI');

    }

}
