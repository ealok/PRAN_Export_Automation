<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
    protected $fillable=["company_id","bank_id","account_number"];

    public function company(){

      return $this->belongsTo('App\Company');
      
    }
    public function bank(){

      return $this->belongsTo('App\Bank');

    }

}
