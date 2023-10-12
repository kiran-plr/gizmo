<?php

namespace App\Shipment;

use App\Actions\CreateShipmentAction;
use App\Actions\CreateShipmentItemAction;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\ShipmentCreatedMail;

trait Shipment
{
    public $type = 'user';

    public function create(array $shipmentData, array $shipmentItem, $tradeInstype = null)
    {
        /** @var CreateShipmentAction $action */
        $action = app(CreateShipmentAction::class);
        $shipment = $action->execute($shipmentData);

        Session::put('shipment_id', $shipment->id);

        /** @var CreateShipmentItemAction $action */
        $action = app(CreateShipmentItemAction::class);
        $action->execute($shipment, $shipmentItem);

        $this->getLabelViaAPI($shipment, 'user');

        /** Send Mail To User or User and Admin Based on Shipment Type */
        if ($shipment->shipment_type == '1' && $tradeInstype != 'walk-in') {
            Mail::to($shipment->user->email)->send(new ShipmentCreatedMail($shipment));
        } elseif ($shipment->shipment_type == '2') {
            Mail::to($shipment->user->email)->send(new ShipmentCreatedMail($shipment));
            Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new ShipmentCreatedMail($shipment, 'admin'));
        }

        return $shipment;
    }

    public function getLabelViaAPI($shipment, $type = null)
    {
        $this->type = $type;

        $payload = array();
        $payload['order_id']    = $shipment->id;
        $payload['status']        = $shipment->status;
        $payload['created_at']    = (string)$shipment->created_at;
        $payload['items']        = array();

        foreach ($shipment->shipmentItems as $key => $shipmentItem) {
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
        $shipment->tracking_no      = $custom_shipping_number;
        $shipment->shipping_type    = $custom_shipping_type;
        $shipment->label_url        = $custom_label_url;
        $shipment->save();
    }

    public function getShippingAddress($userAddress, $shipment)
    {
        if (env('APP_ENV') == 'staging' || env('APP_ENV') == 'production') {
            if ($shipment->address && $this->type == 'user') {
                return [
                    'first_name'        => $shipment->user->firstName,
                    'last_name'         => $shipment->user->lastName,
                    'address1'          => $shipment->address->address,
                    'address2'          => $shipment->address->apartment,
                    'postcode'          => $shipment->address->zip,
                    'city'              => $shipment->address->city,
                    'state'             => $shipment->address->state,
                    'country'           => 'USA',
                ];
            } elseif ($this->type == 'vendor') {
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
                return [
                    'first_name'        => $shipment->user->firstName,
                    'last_name'         => $shipment->user->lastName,
                    'address1'          => '',
                    'address2'          => '',
                    'postcode'          => '',
                    'city'              => '',
                    'state'             => '',
                    'country'           => 'USA',
                ];
            }
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
}
