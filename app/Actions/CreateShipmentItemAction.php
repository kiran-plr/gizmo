<?php

namespace App\Actions;

use App\Models\Shipment;

class CreateShipmentItemAction
{
    public function execute(Shipment $shipment, array $data)
    {
        return $shipment->shipmentItems()->createMany($data);
    }
}
