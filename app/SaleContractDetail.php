<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleContractDetail extends Model
{
    
    protected $fillable=["ci_item_id","ci_item_name","sale_contract_id","hs_code","rate_per_ctn",'rate_per_ctn_for_acc','rate_per_ctn_for_party',"ctn",'ci_rate_pl_freight',"pcs_in_ctn","total_amount"];
    
    public function ci_item(){

      return $this->belongsTo('App\CiItem');

    }

    public function sale_contract(){
    
      return $this->belongsTo('App\SaleContract');

    }

    public function bu(){
    
      return $this->belongsTo('App\Bu');

    }
     
    public function item_group(){

       return $this->belongsTo('App\ItemGroup');

    } 




}
