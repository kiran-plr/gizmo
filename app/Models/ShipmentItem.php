<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'sku_id',
        'price',
        'quantity',
        'approval_response',
        'is_verified',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
