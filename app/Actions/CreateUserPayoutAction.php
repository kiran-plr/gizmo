<?php

namespace App\Actions;

use App\Models\Shipment;
use App\Models\UserPayout;

class CreateUserPayoutAction
{
    public function execute(Shipment $shipment,$paymentId)
    {
        $userPayout = new UserPayout();
        $userPayout->payment_id = $paymentId;
        $userPayout->user_id = $shipment->user_id;
        $userPayout->shipment_id = $shipment->id;
        $userPayout->user_payout_method_id = $shipment->payout_method_id;
        $userPayout->amount = $shipment->total;
        $userPayout->save();
        return $userPayout;
    }
}
