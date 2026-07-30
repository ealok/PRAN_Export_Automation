<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifyParty extends Model
{
    protected $fillable=["code","name","address"];

    public function desk(){

      return $this->belongsTo('App\Desk');

    }

    public function notify_party_item(){

      return $this->belongsTo('App\NotifyPartyItem');

    }

}
