<?php

namespace App\Models;

use App\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax',
        'uuid',
        'total',
        'status',
        'qrcode',
        'barcode',
        'user_id',
        'sub_total',
        'label_url',
        'address_id',
        'location_id',
        'shipment_no',
        'shipment_type',
        'shipping_type',
        'payment_method',
        'payout_method_id',
        'tracking_no',
        'tracking_url',
        'shipping_carrier',
        'shipment_status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function shipmentItems()
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function userPayoutMethod()
    {
        return $this->belongsTo(UserPayoutMethod::class, 'payout_method_id');
    }

    public function userPayout()
    {
        return $this->hasOne(UserPayout::class, 'shipment_id');
    }

    public static function shipmentCountByLocation($id)
    {
        return Shipment::where('location_id', $id)->count();
    }

    public function getNotesAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function getShipments()
    {
        if (AppHelper::isUser()) {
            return Shipment::where('user_id', auth()->user()->id)->orderBy('id', 'desc');
        } else {
            return Shipment::orderBy('id', 'desc');
        }
    }
}
