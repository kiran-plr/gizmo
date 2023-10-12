<?php

namespace App\Http\Livewire\Vendor;

use App\Actions\ChangeShipmentStatusAction;
use App\Actions\CreateTransactionAction;
use App\Actions\CreateUserPayoutAction;
use App\Helpers\AppHelper;
use App\IMEI_Lookup\IMEI_Lookup;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Sku;
use App\Shipment\Shipment as ShipmentTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShipmentApproveProcess extends Component
{
    use IMEI_Lookup;
    use ShipmentTrait;

    public $steps = 1;
    public $IMEINO;
    public $shipmentId;
    public $selectedProductId;
    public $data = [];
    public $payNow = false;
    public array $imeiResponse;
    public $payoutType;
    public $cardholder;
    public $cardNumber;
    public $confirmCardNumber;
    public $virtualCard;
    public $paymentId;
    public $paymentApiRes;
    public $skuId;
    public $itemCondBroken = false;

    protected $listeners = [
        'updateShipmentItem',
        'rejectTradeIn'
    ];

    public function mount($shipmentId)
    {
        $this->shipmentId = $shipmentId;
        // $this->IMEINO = '358567070000019';
        // $this->selectedProductId = 18;
    }

    public function next($key = null, $value = null)
    {
        if ($this->steps == 2) {
            $this->validate([
                'IMEINO' => 'required|min:11|max:18',
            ], [
                'IMEINO.required' => 'Please enter IMEI number.',
                'IMEINO.min' => 'IMEINO must be at least 11 characters long.',
                'IMEINO.max' => 'IMEINO must be at most 18 characters long.'
            ]);
            $this->data[$key] = $this->IMEINO;
            $mobile = ['serial' => $this->IMEINO, 'dev_name' => 'phone'];
            $response = $this->lookUpIMEI($mobile);
            $this->imeiResponse = $response;
            $this->data['imeiLookupResponse'] = $response;
        } else {
            $this->data[$key] = $value;
        }

        if ($this->steps == 3) {
            $this->checkItemCondition();
        }

        if ($key == 'physicalDamage' && $value == 'true' && !$this->itemCondBroken) {
            $this->displayPopup();
        } elseif ($key == 'screenDiscoloration' && $value == 'true' && !$this->itemCondBroken) {
            $this->displayPopup();
        } else {
            $this->steps++;
        }
    }

    public function getShipmentProperty()
    {
        return Shipment::find($this->shipmentId);
    }

    public function getShipmentItemProperty()
    {
        return ShipmentItem::find($this->selectedProductId);
    }

    public function selectProduct($id)
    {
        $this->selectedProductId = $id;
        $this->steps = 2;
    }

    public function checkProductVerification($id)
    {
        if (ShipmentItem::find($id)->is_verified != 'pending') {
            return true;
        }
        return false;
    }

    public function confirm()
    {
        $item = ShipmentItem::find($this->selectedProductId);
        $item->update(['is_verified' => 'verified', 'approval_response' => json_encode($this->data)]);
        $this->steps++;
        $this->dispatchBrowserEvent('displayAlert');
    }

    public function desclain()
    {
        $item = ShipmentItem::find($this->selectedProductId);
        $item->update(['is_verified' => 'rejected']);
        $this->steps = 1;
        $this->IMEINO = '';
    }

    public function payNow()
    {
        $this->steps = 9;
        $this->selectedProductId = '';
    }

    public function selectPayoutType($type)
    {
        $this->payoutType = $type;
    }

    public function confirmPayoutType()
    {
        /** Based on payout type field validation */
        if ($this->payoutType == 'digital_payment') {
            $this->validate($this->physicalCardDetailRule(), $this->physicalCardDetailRuleMessage());
        } elseif ($this->payoutType == 'virtual_card') {
            $this->validate([
                'virtualCard.email' => 'required|email:rfc,dns,strict,spoof,filter|min:3,max:50'
            ], [
                'virtualCard.email.required' => 'Please enter your email',
                'virtualCard.email' => 'Email must be a valid email',
            ]);
        } else {
            $this->validate([
                'payoutType' => 'required'
            ], [
                'payoutType.required' => 'Please select payout type',
            ]);
        }

        $this->createPayout();
    }

    public function physicalCardDetailRule()
    {
        $validate = [
            'cardNumber' => 'required|digits:16',
            'confirmCardNumber' => 'required|same:cardNumber|digits:16',
            'cardholder.name' => 'required|string|min:6|max:30'
        ];

        return $validate;
    }

    public function physicalCardDetailRuleMessage()
    {
        $message = [
            'cardholder.name.required' => 'Please enter full name',
            'cardholder.name.string' => 'Name must be a string',
            'cardholder.name.min' => 'Name must be at least 6 characters long',
            'cardholder.name.max' => 'Name must be at most 30 characters long'
        ];

        return $message;
    }

    public function setPayoutData()
    {
        $data = [];
        if ($this->payoutType == 'digital_payment') {
            $data = $this->cardholder;
            $data['cardNumber'] = $this->cardNumber;
        } else {
            $data = $this->virtualCard;
        }
        return $data;
    }

    public function createPayout()
    {
        DB::beginTransaction();
        try {
            $shipment = Shipment::findOrFail($this->shipmentId);
            /** Generate Payment ID */
            $this->paymentId = AppHelper::uuid();
            $itemsPriceTotal = $shipment->shipmentItems->where('is_verified', 'verified')->sum('price');
            $shipment->total = $itemsPriceTotal;

            $checkAllVerified = $shipment->shipmentItems->count() == $shipment->shipmentItems->where('is_verified', 'verified')->count() ? true : false;

            $response = $this->generatePayment($shipment);

            if ($response && !isset($response['detail'])) {
                /** @var CreateUserPayoutAction $action */
                $action = app(CreateUserPayoutAction::class);
                $payout = $action->execute($shipment, $this->paymentId);

                /** @var CreateTransactionAction $action */
                $action = app(CreateTransactionAction::class);
                $action->execute($payout, $response, $this->setPayoutData());

                /** @var ChangeShipmentStatusAction $action */
                $action = app(ChangeShipmentStatusAction::class);
                $shipment = $action->execute($shipment, ($checkAllVerified ? 'approved' : 'please-ship'));

                /**Generate label */
                $this->getLabelViaAPI($shipment, 'vendor');

                $shipment->status = 'completed';
                $shipment->save();

                DB::commit();
                AppHelper::notify('Payment has been created successfully', 'success');
                return redirect()->route('vendor.shipment.trade-ins')->with('success', 'Shipment approved successfully');
            } else {
                AppHelper::notify('Please check ' . ($response ? $response['invalidParameters'][0]['name'] : 'code') . ' and try again', 'error');
                DB::rollBack();
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generatePaymentDigital($shipment)
    {
        // get token
        $data = [
            'grant_type'       => 'client_credentials',
            'scope'            => 'payment_management_api_v1',
            'client_id'        => env('ONBE_API_CLIENT_ID'),
            'client_secret'    => env('ONBE_API_CLIENT_SECRET')
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiauth.onbe.com/connect/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);

        $response_obj = json_decode($response);

        $token = $response_obj->access_token ?? '';

        // issue payment
        $data = $this->getPayoutData($shipment);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('ONBE_API_URL') . '/payment/v1/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSLCERT => base_path() . '/certs/onbe_ssl.pem',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Cache-Control: no-cache',
            ),
        ));

        $response = curl_exec($curl);

        $response_headers = curl_getinfo($curl);

        // \Log::info($response);
        // \Log::info($response_headers);


        curl_close($curl);

        return json_decode($response, true);
    }

    public function generatePaymentPhysical($shipment)
    {
        return $this->getPhysicalCard($shipment);
    }


    public function generatePayment($shipment)
    {
        if ($this->payoutType == 'digital_payment') {
            return $this->generatePaymentPhysical($shipment);
        } elseif ($this->payoutType == 'virtual_card') {
            return $this->generatePaymentDigital($shipment);
        }
    }

    public function getPayoutData($shipment)
    {
        $data = [];

        $data["paymentId"] = $this->paymentId;
        $data["amount"] = [
            'amount' => (string)$shipment->total,
            "currencyCode" => "USD"
        ];
        $data["issuanceProductId"] = env('ONBE_PRODUCT_ID');
        $data["locationId"] = env('ONBE_LOCATION_ID');
        $data["recipient"] = [
            // "participantId" => "NLRTy3McrRPaASE8",
            "firstName" => $shipment->user->firstName,
            "lastName" => $shipment->user->lastName,
            "address1" => $shipment->address->address,
            "address2" => $shipment->shipment->address->apartment ?? null,
            "city" => $shipment->address->city,
            "state" => $shipment->address->state,
            "postalCode" => $shipment->address->zip,
            "countryCode" => "USA",
            "emailAddress" => $shipment->user->email,
            "language" => "EN",
            "mobilePhone" => null
        ];
        $data["clientData"] = [
            "clientData1" => null,
        ];
        return collect($data)->toJson();
    }

    public function verify()
    {
        $this->steps = 2;
        $this->next('IMEINO');
    }

    public function getPhysicalCard()
    {
        try {
            $cert_file = base_path() . '/certs/cje_swift.pem';

            $userId = env('PAYMENT_SWIFT_API_USERID');
            $pwd = env('PAYMENT_SWIFT_API_PASSWORD');
            $sourceId = env('PAYMENT_SWIFT_API_SOURCEID');

            $CardNum = $this->cardNumber;

            $FirstName              = $this->shipment->user->first_name;
            $LastName               = $this->shipment->user->last_name;
            $NameOnCard             = $FirstName . ' ' . $LastName; //$this->cardholder['name'];
            $Addr1                  = $this->shipment->address->address;
            $Addr2                  = 'x'; //($this->shipment->address->apartment) ? $this->shipment->address->apartment : '';
            $Addr3                  = 'x';
            $City                   = $this->shipment->address->city;
            $State                  = $this->shipment->address->state;
            $ZipCode                = $this->shipment->address->zip;
            $CountryCode            = 840;
            $Phone                  = '310-555-0000'; //$this->shipment->user->phone;
            $Amount                 = $this->shipment->shipmentItems->where('is_verified', 'verified')->sum('price');

            // SETUP CUSTOMER	
            $url    = "https://a2a.fisprepaid.com/a2a/CO_UpdatePerson.asp";

            $input  = "userid=$userId&";
            $input .= "pwd=$pwd&";
            $input .= "sourceid=$sourceId&";
            $input .= "CardNum=$CardNum&";
            $input .= "FirstName=$FirstName&";
            $input .= "LastName=$LastName&";
            $input .= "NameOnCard=$NameOnCard&";
            $input .= "Addr1=$Addr1&";
            $input .= "Addr2=$Addr2&";
            $input .= "Addr3=$Addr3&";
            $input .= "City=$City&";
            $input .= "State=$State&";
            $input .= "ZipCode=$ZipCode&";
            $input .= "CountryCode=$CountryCode&";
            $input .= "Phone=$Phone&";
            $input .= "resp=w3xml";

            \Log::info($url);
            \Log::info($input);

            $this->doit($url, $input, $cert_file);

            //        die();

            // LOAD VALUE
            $url = "https://a2a.fisprepaid.com/a2a/CO_LoadValue.asp";

            $id = $this->shipment->id;

            $RefNo                  = $id;
            $Comment                = "Gizmogul Retail Request: $id";
            $MerchantNameLoc        = "Gizmogul Corporate";

            $input  = "userid=$userId&";
            $input .= "pwd=$pwd&";
            $input .= "sourceid=$sourceId&";
            $input .= "CardNum=$CardNum&";
            $input .= "Amount=$Amount&";
            $input .= "RefNo=$RefNo&";
            $input .= "Comment=$Comment&";
            $input .= "MerchantNameLoc=$MerchantNameLoc&";
            $input .= "resp=w3xml";

            $this->doit($url, $input, $cert_file);
        } catch (Exception $e) {

            AppHelper::notify($e->getMessage(), 'error');
        }

        return false;
    }

    public function doit($url, $input, $cert_file)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSLCERT, $cert_file);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'ECDHE-RSA-AES256-GCM-SHA384,ECDHE-RSA-AES128-GCM-SHA256,ECDHE-RSA-WITH-AES-256-CBC-SHA384,ECDHE-RSA-WITH-AES-128-CBC-SHA256');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "POST: $url HTTP/1.1",
            'Content-Type: application/json',
            "Content-Length: " . strlen($input)
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        \Log::info($output);
        \Log::info(curl_error($ch));

        if (!$output) {
            AppHelper::notify(curl_error($ch), 'error');
        }

        $this->paymentApiRes = $output;
    }
    public function checkItemCondition()
    {
        foreach ($this->shipmentItem->sku->productAttributes as $productAttribute) {
            if ($productAttribute->attribute->slug == 'condition') {
                $this->itemCondBroken = $productAttribute->attributeValue->slug == 'broken' ? true : false;
            }
        }
    }

    public function displayPopup()
    {
        $attributeIds = [];
        $this->itemCondBroken = false;
        foreach ($this->shipmentItem->sku->productAttributes as $productAttribute) {
            if ($productAttribute->attribute->slug == 'condition') {
                $this->itemCondBroken = $productAttribute->attributeValue->slug == 'broken' ? true : false;
                $condition = $productAttribute->attribute->attributeValues()->where('slug', 'broken')->first();
                $attributeIds[$productAttribute->attribute_id] = $condition->id;
            } else {
                $attributeIds[$productAttribute->attribute_id] = $productAttribute->attribute_value_id;
            }
        }

        /** If condition Broken get price and attribute */
        if (!$this->itemCondBroken) {
            $item = Sku::where('skus.product_id', $this->shipmentItem->sku->product_id)
                ->leftJoin('product_attributes', 'product_attributes.sku_id', '=', 'skus.id')
                ->groupBy('skus.id');
            if ($attributeIds !== null && !empty($attributeIds)) {
                foreach ($attributeIds as $key => $value) {
                    $item->havingRaw("FIND_IN_SET('" . $key . "." . $value . "', GROUP_CONCAT(CONCAT(product_attributes.attribute_id,'.',product_attributes.attribute_value_id) SEPARATOR ','))");
                }
            }

            $data = [];
            $sku = Sku::find($item->first()->sku_id);
            $this->skuId = $sku->id;
            $data['product_name'] = $sku->product->name;
            $data['price'] = $sku->retail_price;
            foreach ($sku->productAttributes as $productAttribute) {
                $data['attributes'][$productAttribute->attribute->name] = $productAttribute->attributeValue->value;
            }
            /** Display popup for broken item condition */
            $this->dispatchBrowserEvent('displayPopup', $data);
        }
    }

    public function updateShipmentItem()
    {
        $price = Sku::find($this->skuId)->retail_price;
        $this->shipmentItem->update(['sku_id' => $this->skuId, 'price' => $price]);
        $this->steps++;
    }

    public function rejectTradeIn()
    {
        $this->desclain();
    }

    public function render()
    {
        return view('livewire.vendor.shipment-approve-process');
    }
}
