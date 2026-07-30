<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SCI extends Model
{
      
    protected $table='s_c_i_s';
    public function sale_contract()
    {
        return $this->belongsTo('App\SaleContract');
    }
    public function sci_status(){

        return $this->belongsTo('App\SciStatus');

    }

}
