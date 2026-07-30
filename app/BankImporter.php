<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankImporter extends Model
{
    protected $fillable=["bank_name","account_name","branch","ac_or_iban","swift_code","other"];


}
