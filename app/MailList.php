<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
   protected $table='mail_lists';	 
   protected $fillable=["email","name","is_active"];  
}
