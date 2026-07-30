<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class AssignItemClaim extends Model
{
    
    public function itemGroup(){

      return $this->belongsTo('App\ItemGroup');

    }  

    public function CiItemClaim(){

      return $this->belongsTo('App\CiItemClaim');

    } 

}
