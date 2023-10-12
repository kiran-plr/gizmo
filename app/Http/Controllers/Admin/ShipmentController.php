<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChangeShipmentStatusAction;
use App\Actions\CreateUserPayoutAction;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shipments = Shipment::whereNotIn('status', ['cancel'])->with('user', 'location', 'shipmentItems', 'shipmentItems.sku')->orderBy('id', 'DESC')->get();
        return view('admin.shipments.index', compact('shipments'));
    }

    /**
     * Display a cancel shipment listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelShipmentIndex()
    {
        $shipments = Shipment::where('status', 'cancel')->with('user', 'location', 'shipmentItems', 'shipmentItems.sku')->orderBy('id', 'DESC')->get();
        return view('admin.shipments.cancel-shipment-index', compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipment = Shipment::with(['shipmentItems', 'shipmentItems.sku'])->findOrFail($id);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function changeStatus(Request $request)
    {
        $shipment = Shipment::findOrFail($request->id);

        /** @var ChangeShipmentStatusAction $action */
        $action = app(ChangeShipmentStatusAction::class);
        $shipment = $action->execute($shipment, $request->status);

        if ($request->status == 'received') {
            $paymentId = AppHelper::uuid();
            /** @var CreateUserPayoutAction $action */
            $action = app(CreateUserPayoutAction::class);
            $action->execute($shipment, $paymentId);
        }

        return redirect()->back()->with('success', 'Status changed successfully');
    }

    public function cancelShipment($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->status = 'cancel';
        $shipment->save();
        return redirect()->back()->with('success', 'Shipment cancelled successfully');
    }

    /**
     * Export the location
     */
    public function export()
    {
        $fileName = 'Shipment_' . date("Y-m-d") . '.csv';
        $shipments = Shipment::get()->map(function ($shipment) {
            return [
                'shipment_no' => $shipment->shipment_no,
                'billing_name' => $shipment->user->name,
                'date' => date('m/d/Y, g:ia', strtotime($shipment->created_at)),
                'commission' => '$' . number_format($shipment->commission, 2),
                'total' => '$' . number_format($shipment->total, 2),
                'total_qty' => $this->getTotakQty($shipment),
                'status' => ucfirst($shipment->status),
                'shipping_method' => $this->getShippingMethod($shipment),
            ];
        })->toArray();

        $columns = $this->getShipmentsCsvHeader();
        $callback = function () use ($columns, $shipments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($shipments as $key => $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };
        return response()->stream($callback, 200, ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName", "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"]);
    }

    public function getTotakQty($shipment)
    {
        if ($shipment->notes != '') {
            $shipments = Shipment::whereIn('id', explode(',', $shipment->notes['shipment_id']))->get();
            $qty = 0;
            foreach ($shipments as $shipment) {
                $qty += $shipment->shipmentItems->count();
            }
            return $qty;
        } else {
            return $shipment->shipmentItems()->sum('quantity');
        }
    }

    public function getShippingMethod($shipment)
    {
        if ($shipment->shipment_type == 1) {
            return 'Drop-off';
        } else {
            return 'Ship';
        }
    }

    public function getShipmentsCsvHeader()
    {
        return ['Shipment No #', 'Billing Name', 'Date', 'Commission', 'Total', 'Total QTY', 'Status', 'Shipping Method'];
    }
}
