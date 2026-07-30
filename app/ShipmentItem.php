<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    protected $table = 'shipment_items';
    protected $fillable = [
        'shipment_header_id',
        'item_code',
        'item_name',
        'hs_code',
        'unit',
        'factor',
        'ctn_qty',
        'pcs_qty',
        'delivery_qty',
        'pending_qty',
        'status',
        'created_by',
        'updated_by'
    ];
    
}
