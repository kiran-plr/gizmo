<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = auth()->user()->shipments;
        return view('users.shipments.index', compact('shipments'));
    }

    public function show($id)
    {
        $shipment = auth()->user()->shipments()->find($id);
        return view('users.shipments.show', compact('shipment'));
    }
}
