<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostingMaster extends Model
{
     protected $table='costing_master';
     public $timestamps = false;
     public function notify_party()
     {
         return $this->belongsTo(NotifyParty::class, 'party_id', 'id');
     }
      
     public function location()
     {
         return $this->belongsTo(Location::class, 'location_id', 'id');
     }

     public function bu()
     {
         return $this->belongsTo(SalesTerm::class, 'bu', 'code');
     }
          
}
