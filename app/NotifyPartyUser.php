<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifyPartyUser extends Model
{
    protected $fillable=["notify_party_id","ci_item_id","desk_item_name","acc_rate","party_rate"];

    public function notify_party(){

      return $this->belongsTo('App\NotifyParty');

    }
    public function user(){
    	
      return $this->belongsTo('App\User');
    }

}
