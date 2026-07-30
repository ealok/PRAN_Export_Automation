<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleContract extends Model
{
    protected $fillable=["sales_contract_no","dated","country_id","sales_term_id","company_id","bank_id","importer_id","notify_pary_id","carrying_mode_id","loading_place_id","final_destination"];

    public function country(){

      return $this->belongsTo('App\Country');
    }
    public function sales_term(){

      return $this->belongsTo('App\SalesTerm');

    }
    public function company(){

      return $this->belongsTo('App\Company');

    }
    public function bank(){

      return $this->belongsTo('App\Bank');

    }
    public function bank_importer(){

      return $this->belongsTo('App\BankImporter');

    }
    public function importer(){

      return $this->belongsTo('App\Importer');

    }
    public function notify_pary(){

      return $this->belongsTo('App\NotifyParty');

    }
    public function carrying_mode(){

      return $this->belongsTo('App\CarryingMode');
    }
    public function loading_place(){
      
      return $this->belongsTo('App\LoadingPlace');
    }
    public function sale_contract_details(){

       return $this->hasMany('App\SaleContractDetail');

    }

    public function sci(){
      
      return $this->hasOne('App\Sci');
    }
    
    public function user(){

       return $this->belongsTo('App\User','creator_id','id');

    }
    
    public function currency(){

      return $this->belongsTo('App\CurrencySetup','currency_id','id');

    }

    public function customStation(){

      return $this->belongsTo('App\CustomStation','custom_station_id','id');

    }

}
