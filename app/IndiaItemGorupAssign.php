<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\ItemGroupIndia;
use App\CiItem;
class IndiaItemGorupAssign extends Model
{
       
    protected $table = 'item_group_assign_india';

    public function itemGroupIndia()
    {
        return $this->hasMany(ItemGroupIndia::class, 'id', 'india_group_id');
    }
    
    public function item_name()
    {
      
        return $this->hasMany(CiItem::class, 'id', 'india_item_id');
    }

    
}
