<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable=["name","code","erc_no","bin_no","factory_name","factory_address","ho_address","group_id"];

    public function group(){

      return $this->belongsTo('App\Group');
      
    }

}
