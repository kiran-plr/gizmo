<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipment_id',
        'user_payout_method_id',
        'payment_id',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userPayoutMethod()
    {
        return $this->belongsTo(UserPayoutMethod::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
