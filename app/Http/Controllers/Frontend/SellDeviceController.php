<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Shipment;
use App\Models\User;
use App\Shipment\Shipment as ShipmentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DNS2D;

class SellDeviceController extends Controller
{
    use ShipmentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('frontend.sell-your-device', compact('categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shippingInformation()
    {
        $data = Session::get('data') ?? [];
        if ($data) {
            return view('frontend.shipping', compact('data'));
        }
        return redirect()->route('sell-your-device');
    }

    public function shipmentReview()
    {
        $data = Session::get('data') ?? [];
        $shipmentData = Session::get('shipmentData') ?? [];
        if ($data && $shipmentData) {
            $locationId = Session::get('location_id') ?? '';
            $location = Location::find($locationId);
            $user = User::getUser();
            $address = $location ?? $user->addresses()->where('status', '1')->first();
            return view('frontend.shipment-review', compact('data', 'address', 'user', 'shipmentData'));
        }
        return redirect()->route('sell-your-device');
    }

    public function confirmLocation()
    {
        $user = User::getUser();
        $data = Session::get('data') ?? [];
        $shipmentData = Session::get('shipmentData') ?? [];
        if ($user && $data && $shipmentData) {
            DB::beginTransaction();
            try {
                $uuId = $this->getUuid();
                $lastShipment = Shipment::orderBy('id', 'desc')->first();
                $shipmentNo = $lastShipment ? $lastShipment->shipment_no + 1 : '1001';
                $shipmentID = $lastShipment ? $lastShipment->id + 1 : '1';
                $totalPrice = AppHelper::getGrandTotal($data, $shipmentData['shipment_type']);
                $qrCode = $this->getQrCode($uuId, $shipmentID);
                $barcode = $this->getBarcode($shipmentID);
                $shipemtArr = [
                    'user_id' => $user->id,
                    'location_id' => $shipmentData['shipment_type'] == 1 ? $this->getLocation()->id : null,
                    'address_id' => $this->getAddress()->id,
                    'payout_method_id' => $shipmentData['userPayoutMethodId'] ?? null,
                    'total' => round($totalPrice, 2),
                    'sub_total' => round($totalPrice, 2),
                    'shipment_type' => $shipmentData['shipment_type'],
                    'qrcode' => $qrCode,
                    'barcode' => $barcode,
                    'label_url' => '',
                    'uuid' => $uuId,
                    'shipment_no' => $shipmentNo,
                    'tax' => 0,
                ];

                $shipmentItemData = [];

                foreach ($data as $key => $product) {
                    $price = $shipmentData['shipment_type'] == 1 ? $product['sku_retail_price'] : $product['sku_price'];
                    for ($i = 0; $i < $product['quantity']; $i++) {
                        $shipmentItemData[] = [
                            'sku_id' => $product['filtered_sku_id'],
                            'price' => round($price, 2),
                            'quantity' => 1,
                        ];
                    }
                }

                $shipment = $this->create($shipemtArr, $shipmentItemData);

                DB::commit();

                Session::forget('data');
                Session::forget('location_id');
                Session::forget('searched_location');
                Session::forget('shipmentData');

                AppHelper::notify('Your shipment has been created successfully', 'success');
                if ($shipment->shipment_type == '1') {
                    return redirect()->route('ship-my-item');
                } else {
                    return redirect()->route('print-my-label.index');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return redirect()->route('sell-your-device');
    }

    public function shipMyItemIndex()
    {
        $shipment = $this->getShipment();
        if ($shipment) {
            $location = $shipment->location;
            return view('frontend.ship-my-item', compact('shipment', 'location'));
        }
        return redirect()->route('sell-your-device');
    }

    public function printMyLabelIndex()
    {
        $shipment = $this->getShipment();
        $user = User::getUser();
        if ($shipment && $user) {
            $address = $user->addresses()->where('status', '1')->first();
            return view('frontend.print-my-label', compact('shipment', 'address'));
        }
        return redirect()->route('sell-your-device');
    }

    public function printMyLabel()
    {
        $shipment = $this->getShipment();
        $filename = 'Shipment_' . $shipment->uuid . '.pdf';
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($shipment->label_url, $tempImage);
        return response()->download($tempImage, $filename);
    }

    public function getUUID()
    {
        return AppHelper::uuid();
    }

    public function getQrCode($uuId, $shipmentID)
    {
        $path = public_path('/qrcodes/' . $uuId);
        if (!\File::isDirectory($path)) {
            \File::makeDirectory($path, 0777, true, true);
        }
        base64_encode(QrCode::format('png')->size(300)->generate($uuId, $path . '/barcode-' . $shipmentID . '.png'));
        return '/qrcodes/' . $uuId . '/barcode-' . $shipmentID . '.png';
    }

    public function getBarcode($shipmentID)
    {
        return DNS2D::getBarcodePNG($shipmentID, 'PDF417');
    }

    public function generatePdf()
    {
        // $path = public_path('/pdfs/' . $shipment->uuid);
        // if (!\File::isDirectory($path)) {
        //     \File::makeDirectory($path, 0777, true, true);
        // }
        // $data = [
        //     'address' => $address,
        //     'shipment' => $shipment,
        // ];
        // try {
        //     $pdf = PDF::loadView('frontend.pdf.print-label', $data)->save($path . '/label-' . $shipment->id . '.pdf');
        //     return $pdf;
        // } catch (\Exception $e) {
        //     throw $e;
        // }
    }

    public function getLocation()
    {
        $locationId = Session::get('location_id') ?? '';
        return Location::find($locationId);
    }

    public function getShipment()
    {
        $shipmentId = Session::get('shipment_id') ?? '';
        return Shipment::find($shipmentId);
    }

    public function getAddress()
    {
        $user = User::getUser();
        return $user->addresses()->where('status', '1')->first();
    }

    public function cart()
    {
        $data = Session::get('data') ?? [];
        if ($data) {
            return view('frontend.cart', compact('data'));
        }
        return redirect()->route('sell-your-device');
    }
}
