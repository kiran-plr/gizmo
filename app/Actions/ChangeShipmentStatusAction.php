<?php

namespace App\Actions;

use App\Mail\ShipmentStatusChangeMailToAdmin;
use App\Mail\ShipmentStatusChangeMailToUser;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ChangeShipmentStatusAction
{
    public function execute(Shipment $shipment, $status)
    {
        DB::beginTransaction();
        try {
            $shipment->status = $status;
            $shipment->save();

            /** Send Shipment Status Change Mail */
            Mail::to($shipment->user->email)->send(new ShipmentStatusChangeMailToUser($shipment));
            Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new ShipmentStatusChangeMailToAdmin($shipment));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $shipment;
    }
}
