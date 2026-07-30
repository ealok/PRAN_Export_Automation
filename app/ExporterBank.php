<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExporterBank extends Model
{
    protected $fillable=["name","exporter_id","bank_id","account_number"];

    public function exporter(){
      return $this->belongsTo('App\Exporter');
    }
    public function bank(){
      return $this->belongsTo('App\Bank');
    }

}
