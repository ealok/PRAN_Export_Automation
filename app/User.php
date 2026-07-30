<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
        'name','email','password','username','active','login_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


   
    public function truckUploaders() {

      return $this->has_many('App\TruckDetails','uploader_id');

    }

    public function truckSenders() {

        return $this->has_many('App\TruckDetails','sender_id');

    }

    public function companies() {
        return $this->belongsTo('App\Company');
    }

    public function head() {

        return $this->belongsTo('App\User','head_id');

    }

    // public function features() {
    //   return $this->has_many('Feature');
    // }


}
