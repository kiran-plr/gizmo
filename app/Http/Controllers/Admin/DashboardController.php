<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Return View.
     *
     * @return void
     */
    public function index()
    {
        $shipments = Shipment::getShipments();
        $shipmentCount = Shipment::getShipments()->where('status', 'completed')->count();
        $locationCount = Location::count();

        $topFiveLocations = DB::select(DB::raw('SELECT COUNT(shipments.id) as `count`,locations.city as `name`,locations.id as location_id FROM shipments
        LEFT JOIN locations
        ON locations.id=shipments.location_id
        GROUP BY location_id
        ORDER BY `count` DESC
        LIMIT 5'));

        $topFiveLocations = json_decode(json_encode($topFiveLocations),true);

        return view('admin.dashboard', compact('shipments', 'locationCount','topFiveLocations', 'shipmentCount'));
    }
}

