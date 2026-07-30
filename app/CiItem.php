<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CiItem extends Model
{
    protected $fillable=["ci_item_name","ci_item_code","p_net_weight","factor","ci_factor","d_net_weight","d_gross_weight","ci_item_rate","hs_code","bapa_percent","bu_id","is_ci_eligible"];

    public function bu(){

      return $this->belongsTo('App\Bu');
      
    }

    

    public function item_group_assign_india(){

      return $this->hasMany('App\IndiaItemGorupAssign','india_item_id','ci_item_id');
      
    }


}
