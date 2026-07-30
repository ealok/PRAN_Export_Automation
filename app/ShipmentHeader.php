<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentHeader extends Model
{
  
    protected $table = 'shipment_headers';
    protected $fillable = [
        'invoice_id',
        'invoice_no',
        'stuffing_date',
        'container_qty',
        'scheduled_reaching',
        'bl_no',
        'scheduled_money_transfer',
        'actual_transfer_date',
        'actual_reaching',
        'cleared_godown',
        'started_selling',
        'created_by',
        'updated_by'
    ];

}
