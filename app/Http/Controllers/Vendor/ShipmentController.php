<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\CreateShipmentAction;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Shipment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $shipments = Shipment::getShipments()
            ->select('shipments.*')
            ->where('location_id', $user->settings ? $user->settings['selectedLocation'] : '')
            ->whereNotIn('status', ['pending', 're-packaged', 'cancel'])
            ->leftJoin('users', 'users.id', '=', 'shipments.user_id')
            ->where(function ($query) use ($request) {
                $query->where('shipments.shipment_no', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $request->search . '%');
            })
            ->get();

        $lastShipment = Shipment::orderBy('id', 'desc')->first();
        $newShipmentNo = $lastShipment ? $lastShipment->shipment_no + 1 : '1001';

        return view('vendor.shipment.index', compact('shipments', 'newShipmentNo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tradeIns(Request $request)
    {
        $user = Auth::user();
        $shipments = Shipment::getShipments()
            ->select('shipments.*')
            ->where('location_id', $user->settings ? $user->settings['selectedLocation'] : '')
            ->where('status', 'pending')
            ->leftJoin('users', 'users.id', '=', 'shipments.user_id')
            ->where(function ($query) use ($request) {
                $query->where('shipments.shipment_no', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $request->search . '%');
            })
            ->get();

        return view('vendor.shipment.trade-ins', compact('shipments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $shipment = Shipment::getShipments()->where('location_id', $user->settings['selectedLocation'])->findOrFail($id);
        return view('vendor.shipment.show', compact('shipment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tradeInShow($id)
    {
        $user = Auth::user();
        $shipment = Shipment::getShipments()->where('location_id', $user->settings['selectedLocation'])->where('status', 'pending')->findOrFail($id);
        return view('vendor.shipment.trade-in-show', compact('shipment'));
    }

    public function approveProcess($id)
    {
        Shipment::where('status', 'pending')->findOrFail($id);
        return view('vendor.shipment.approve-process', compact('id'));
    }

    public function createShipment()
    {
        $categories = Category::all();
        return view('vendor.shipment.create', compact('categories'));
    }

    public function downloadLabel($id)
    {
        $shipment = Shipment::find($id);
        $filename = 'Shipment_' . $shipment->uuid . '.pdf';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($shipment->label_url, $tempImage);
        return response()->download($tempImage, $filename);
    }

    public function groupShipments(Request $request)
    {
        $user = Auth::user();
        $shipments = Shipment::getShipments()
            ->select('shipments.*')
            ->where('location_id', $user->settings ? $user->settings['selectedLocation'] : '')
            ->whereIn('id', explode(',', $request->shipment_ids))
            ->get();

        DB::beginTransaction();
        try {
            $shipemtArr = [];
            $lastShipment = Shipment::orderBy('id', 'desc')->first();
            $shipmentNo = $lastShipment ? $lastShipment->shipment_no + 1 : '1001';
            $shipment = $shipments->first();
            $shipemtArr = [
                'user_id' => $shipment->user->id,
                'location_id' => $user->settings['selectedLocation'],
                'address_id' => null,
                'payout_method_id' => null,
                'shipment_type' => $shipment->shipment_type,
                'qrcode' => null,
                'barcode' => null,
                'label_url' => '',
                'uuid' => AppHelper::uuid(),
                'shipment_no' => $shipmentNo,
                'tax' => 0,
                'status' => 'please-ship',
            ];

            $tracking_no = $shipments->map(function ($shipment) {
                return $shipment->tracking_no;
            })->implode(', ');

            $commission = $shipments->sum('commission');
            $total = $shipments->sum('total');
            $subTotal = $shipments->sum('sub_total');

            $shipemtArr['commission'] = $commission;
            $shipemtArr['total'] = $total;
            $shipemtArr['sub_total'] = $subTotal;

            $notes = [
                'tacking_no' => $tracking_no,
                'shipment_id' => $request->shipment_ids
            ];

            $shipemtArr['notes'] = json_encode($notes);
            $newShipment = $this->create($shipemtArr);
            $this->generateLabel($newShipment, $shipments);

            $shipments->map(function ($shipment) {
                $shipment->update(['status' => 're-packaged']);
            });

            DB::commit();

            return redirect()->back()->with('success', 'Shipment grouped successfully');
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function create($shipmentData)
    {
        /** @var CreateShipmentAction $action */
        $action = app(CreateShipmentAction::class);
        $shipment = $action->execute($shipmentData);
        return $shipment;
    }

    public function generateLabel($newShipment, $shipments)
    {
        $payload = array();
        $payload['order_id']    = $newShipment->id;
        $payload['status']        = $newShipment->status;
        $payload['created_at']    = (string)$newShipment->created_at;
        $payload['items']        = array();

        foreach ($shipments as $key1 => $shipment) {
            foreach ($shipment->shipmentItems as $key2 => $shipmentItem) {
                $sku = $shipmentItem->sku;
                $productType = $sku->product->attributeFamily->name;
                $attrArr = [];
                foreach ($sku->productAttributes as $key3 => $productAttribute) {
                    $attrArr[$productAttribute->attribute->slug] = $productAttribute->attributeValue->value;
                }

                $payload['items'][] = array_merge([
                    'sku'             => $sku->sku,
                    'product_type'    => $productType,
                    'cost'             => ($shipmentItem->price * $shipmentItem->quantity),
                    'brand'            => $sku->product->brand->name,
                    'name'             => $sku->product->name,
                    'qty'             => $shipmentItem->quantity,
                ], $attrArr);
            }
        }

        $payload['customer'] = array();
        $payload['customer']['customer_email']    = $shipment->user->email;
        $userAddress = $shipment->user->addresses->where('status', '1')->first();
        if ($userAddress) {
            $payload['customer']['customer_phone']    = $userAddress->phone;
        } else {
            $payload['customer']['customer_phone']    = '';
        }

        $payload['customer']['first_name']        = 'TEST';
        $payload['customer']['last_name']         = 'TEST';

        $payload['shipping_address'] = $this->getShippingAddress($userAddress, $shipment);

        // $payload['refund_via'] = $_REQUEST['refund_via'];
        // $payload['refund_via_paypal_email'] = $_REQUEST['refund_via_paypal_email'];

        // $payload['return_via'] = $_REQUEST['return_via'];

        $payload[39] = "Standard";
        $payload['__server'] = $_SERVER;
        $payload['__cookie'] = $_COOKIE;
        $payload['gclid_field'] = isset($payload['gclid_field']) ? $payload['gclid_field'] : '';

        $data = json_encode($payload);
        $method = 'AES-128-CBC';
        $key = 'BGhnk8LU6gKZaP9PtyTm';

        $secret_iv = '5cEnVAnYonXwWoj/P5Ixpc7zJ+5FHvKyFOa9XkMnrLA=';
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        $encrypted_data = openssl_encrypt($data, $method, $key, 0, $iv);

        $url = 'https://leads.gizmogul.com/insert_gizmogul_new.php';


        $fields = array(
            'encrypted_data' => $encrypted_data,
        );

        $fields_string = '';
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        list($custom_shipping_number, $custom_shipping_type, $custom_label_url) = explode('|', $result);

        // Update Shipment based on reasult
        $newShipment->tracking_no      = $custom_shipping_number;
        $newShipment->shipping_type    = $custom_shipping_type;
        $newShipment->label_url        = $custom_label_url;
        $newShipment->save();
    }

    public function getShippingAddress($userAddress, $shipment)
    {
        if (env('APP_ENV') == 'staging' || env('APP_ENV') == 'production') {
            return [
                'first_name'        => $shipment->location->name,
                'last_name'         => '',
                'address1'          => $shipment->location->address,
                'address2'          => $shipment->location->address2,
                'postcode'          => $shipment->location->zip,
                'city'              => $shipment->location->city,
                'state'             => $shipment->location->state,
                'country'           => 'USA',
            ];
        } else {
            if ($userAddress) {
                return [
                    'first_name'        => 'TEST',
                    'last_name'         => 'TEST',
                    'address1'          => '6 Merchant Street',
                    'address2'          => '#5 Sharon, MA 02067',
                    'postcode'          => '02067',
                    'city'              => 'Sharon',
                    'state'             => 'MA',
                    'country'           => 'USA',
                ];
            } else {
                return [
                    'first_name'        => 'TEST',
                    'last_name'         => 'TEST',
                ];
            }
        }
    }

    public function cancelShipment($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->status = 'cancel';
        $shipment->save();
        return redirect()->back()->with('success', 'Shipment cancelled successfully');
    }
}
