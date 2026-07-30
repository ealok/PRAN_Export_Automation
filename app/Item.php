<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=["name","code","ci_item_code","ci_item_name"];


}
