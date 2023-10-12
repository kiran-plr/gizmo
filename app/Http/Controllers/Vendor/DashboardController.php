<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Shipment;

class DashboardController extends Controller
{
    /**
     * Return View.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (count($user->locations) > 0) {
            $locationId = $user->settings['selectedLocation'];

            $shipments = Shipment::getShipments()->where('location_id', $locationId)->whereNotIn('status', ['cancel', 'pending'])->limit(5)->get();
            $tradIns = Shipment::getShipments()->where('location_id', $locationId)->where('status', 'pending')->limit(5)->get();

            $commission = Shipment::getShipments()->where('location_id', $locationId)->whereNotIn('status', ['cancel', 'pending'])->sum('commission');
            $tradeInsCount = Shipment::getShipments()->where('location_id', $locationId)->whereNotIn('status', ['cancel', 'pending'])->count();
            $shipmentAveragePrice = Shipment::getShipments()->where('location_id', $locationId)->where('status', 'completed')->average('total');

            return view('vendor.dashboard', compact('user', 'shipments', 'tradIns', 'commission', 'shipmentAveragePrice', 'tradeInsCount'));
        }

        return redirect()->route('vendor.no-locations');
    }

    public function changeLocation($id)
    {
        $user = Auth::user();
        $location = (bool) $user->locations()->where('locations.id', $id)->count();
        if ($location) {
            $user->settings = collect(['selectedLocation' => $id])->toJson();
            $user->save();
            if (str_contains(url()->previous(), 'location/change')) {
                return redirect()->route('vendor.dashboard');
            }
            return redirect()->back();
        }
        abort(404);
    }

    public function noLocations()
    {
        if (auth()->check() && count(auth()->user()->locations) > 0) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.no-locations');
    }
}
