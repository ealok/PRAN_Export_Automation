<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScTemp extends Model
{
    protected $table='tbl_sc_temp';
    public $timestamps = false;
    protected $fillable = [
        'item_code', 'ref_code', 'party_name', 'acc_rate_per_ctn', 'party_rate_per_ctn',
        'cbm_per_ctn', 'factor', 'hs_code', 'hs_code2', 'total_ctn', 'total_cbm',
        'total_acc_value', 'total_party_value', 'user_id', 'is_missing'
    ];
}
