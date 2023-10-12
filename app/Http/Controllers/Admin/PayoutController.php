<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChangeShipmentStatusAction;
use App\Http\Controllers\Controller;
use App\Models\UserPayout;

class PayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        $payouts = UserPayout::select('id', 'user_id', 'shipment_id', 'user_payout_method_id', 'amount')
            ->with('user:id,name,email')
            ->with('userPayoutMethod:id,name')
            ->where('status', $status)->get();

        return view('admin.payouts.index', compact('payouts', 'status'));
    }

    /**
     * Process the payout.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processCheckout($id)
    {
        $payout = UserPayout::findOrFail($id);
        if ($payout->status == 'draft') {
            $payout->status = 'completed';
            $payout->save();

            /** @var ChangeShipmentStatusAction $action */
            $action = app(ChangeShipmentStatusAction::class);
            $action->execute($payout->shipment, 'completed');
        }

        return redirect()->back()->with('success', 'Process checkout successfully');
    }

    /**
     * Display the detail of resource
     */
    public function show($id)
    {
        $payout = UserPayout::findOrFail($id);
        $shipment = $payout->shipment;
        return view('admin.payouts.show',compact('payout','shipment'));
    }
}
