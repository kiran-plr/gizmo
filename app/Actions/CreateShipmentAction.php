<?php

namespace App\Actions;

use App\Models\Shipment;

class CreateShipmentAction
{
    public function execute(array $data)
    {
        return Shipment::create($data);
    }
}
