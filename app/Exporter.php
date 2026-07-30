<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exporter extends Model
{
    protected $fillable=["company_name","company_idn","erc_no","factory_name","factory_address","bin_no","ho_address"];

}
