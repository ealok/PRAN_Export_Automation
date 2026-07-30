<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SaleContract;
class JobOrderMaster extends Model
{
    
    public function importer(){

      return $this->belongsTo('App\NotifyParty');

    }

   
    public function sales_contact(){

      return $this->belongsTo('App\SaleContract','sale_contract_id');

    }


}
