<?php

namespace App\Http\Livewire\Vendor;

use App\Actions\CreateUserAction;
use App\Actions\CreateUserAddressAction;
use App\Helpers\AppHelper;
use App\Models\Attribute;
use App\Models\Country;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Sku;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserPayoutMethod;
use App\Shipment\Shipment as ShipmentTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateShipment extends Component
{
    use ShipmentTrait;

    public $categories;
    public $sectionId = 1;
    public $categoryId;
    public $brandId;
    public $productId;
    public $progress;
    public $attrbuteFamilyId;
    public $data = [[]];
    public $attributeIds;
    public $attributeValueIds = [];
    public $cartQty = 1;
    public $grandTotal;
    public $customerInfo = false;
    public $customer;
    public $userData;
    public $userPayoutMethodId;
    public $customerId;
    public $shipmentData = [];
    public $countryId;
    public $shipping;
    public $addressType;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->countryId = '1';
        $this->shipping['country_id'] = '1';
        $this->progress = $this->getProgress();
        $this->addressType = 'new';
        $this->getData();
        $this->getUser();
    }

    public function next($type, $id, $attrVal = null, $attrId = null)
    {
        if ($type == 'category') {
            $this->data[$this->cartQty]['category'] = $id;
            $this->categoryId = $id;
        } elseif ($type == 'brand') {
            $this->data[$this->cartQty]['brand'] = $id;
            $this->brandId = $id;
        } elseif ($type == 'product') {
            $this->data[$this->cartQty]['product'] = $id;
            $this->productId = $id;
            $this->data[$this->cartQty]['attribute_family_id'] = $this->product->attribute_family_id;
            $this->attrbuteFamilyId = $this->product->attribute_family_id;
            $this->data[$this->cartQty]['quantity'] = 1;
        } else {
            $this->data[$this->cartQty]['attributes'][$type]['id'] = $id;
            $this->data[$this->cartQty]['attributes'][$type]['value'] = $attrVal;
            $this->attributeValueIds[$this->cartQty][$this->sectionId] = $id;
            $this->attributeIds[$this->cartQty][$attrId] = $id;
        }
        $this->sectionId += 1;
        $this->setData();
    }

    public function previous()
    {
        if ($this->sectionId > 1) {
            $this->sectionId -= 1;
            if (!empty($this->attributeIds[$this->cartQty])) {
                array_pop($this->attributeIds[$this->cartQty]);
            }
        }
    }

    public function getCategoryProperty()
    {
        return $this->categories->find($this->categoryId);
    }

    public function getBrandsProperty()
    {
        return Product::where('category_id', $this->categoryId)->where('type', 'configurable')->get()->unique('brand_id')->map(function ($product) {
            return $product->brand;
        });
    }

    public function getProductsProperty()
    {
        return Product::where('category_id', $this->categoryId)->where('brand_id', $this->brandId)->where('type', 'configurable')->get();
    }

    public function getAttributesProperty()
    {
        $attributeIds = $this->attributeIds[$this->cartQty] ?? [];
        $attributes = Attribute::select('attributes.id', 'attributes.name', 'attributes.slug', 'attributes.attribute_question', 'attributes.description', 'attribute_values.id as valueId', 'attribute_values.value')
            ->leftJoin('product_attributes', 'product_attributes.attribute_id', '=', 'attributes.id')
            ->leftJoin('attribute_values', 'attribute_values.id', '=', 'product_attributes.attribute_value_id')
            ->leftJoin('skus', 'skus.id', '=', 'product_attributes.sku_id')
            ->where('skus.status', '1')
            ->whereIn('product_attributes.sku_id', function ($query) use ($attributeIds) {
                $query->select('skus.id')->from('skus')
                    ->leftJoin('product_attributes', 'product_attributes.sku_id', '=', 'skus.id')
                    ->where('skus.product_id', $this->productId)
                    ->where('skus.status', '1')
                    ->groupBy('skus.id');
                if ($attributeIds !== null && !empty($attributeIds)) {
                    foreach ($attributeIds as $key => $value) {
                        $query->havingRaw("FIND_IN_SET('" . $key . "." . $value . "', GROUP_CONCAT(CONCAT(product_attributes.attribute_id,'.',product_attributes.attribute_value_id) SEPARATOR ','))");
                    }
                }
            })
            ->whereNotIn('attributes.id', $attributeIds ? array_keys($attributeIds) : [])
            ->groupBy('attribute_values.id')
            ->orderBy('attributes.id', 'asc')
            ->get()
            ->toArray();
        return $this->getVariantFilter($attributes);
    }

    public function getVariantFilter($filterData)
    {
        $response = [];
        if (isset($filterData) && !empty($filterData)) {
            $response = reset($filterData);
            foreach ($filterData as $key => $value) {
                if ($value['id'] == $response['id']) {
                    $response['variants'][$value['valueId']] = $value['value'];
                }
            }
        }
        return $response;
    }

    public function getSectionCountsProperty()
    {
        $count = 4;
        $count = Attribute::count() + $count;
        return $count;
    }

    public function getProgress()
    {
        return round(100 / $this->sectionCounts, 2);
    }

    public function getProductProperty()
    {
        return Product::find($this->productId) ?? Session::forget('shipment_data');
    }

    public function getFilterSkuProperty()
    {
        $productAttr = Sku::where('skus.product_id', $this->productId)
            ->leftJoin('product_attributes', 'product_attributes.sku_id', '=', 'skus.id')
            ->groupBy('skus.id');
        if ($this->attributeIds[$this->cartQty] !== null && !empty($this->attributeIds[$this->cartQty])) {
            foreach ($this->attributeIds[$this->cartQty] as $key => $value) {
                $productAttr->havingRaw("FIND_IN_SET('" . $key . "." . $value . "', GROUP_CONCAT(CONCAT(product_attributes.attribute_id,'.',product_attributes.attribute_value_id) SEPARATOR ','))");
            }
        }

        return $productAttr->first();
    }

    public function setData()
    {
        if (isset($this->attributeIds[$this->cartQty])) {
            $product = $this->filterSku;
            $this->data[$this->cartQty]['sku_price'] = $product->price;
            $this->data[$this->cartQty]['sku_retail_price'] = $product->retail_price;
            $this->data[$this->cartQty]['total_price'] = $product->price * $this->data[$this->cartQty]['quantity'];
            $this->data[$this->cartQty]['total_retail_price'] = $product->retail_price * $this->data[$this->cartQty]['quantity'];
            $this->data[$this->cartQty]['product_name'] = $product->product->name;
            $this->data[$this->cartQty]['filtered_sku_id'] = $product->sku_id;
            $this->data[$this->cartQty]['attribute_ids'] = $this->attributeIds[$this->cartQty];
            $this->data[$this->cartQty]['progress'] = $this->progress;
            $this->data[$this->cartQty]['section_id'] = $this->sectionId;
            $this->data[$this->cartQty]['attribute_value_ids'] = $this->attributeValueIds[$this->cartQty];
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 1);
        }
    }

    public function submitForm()
    {
        Session::put('shipment_data', $this->data);
        $this->customerInfo = true;
    }

    public function getData()
    {
        $this->data = Session::get('shipment_data') ?? [];
        if ($this->data) {
            $this->cartQty = count($this->data) + 1;
        }

        $this->shipmentData = Session::get('shipmentData') ?? [];
        $this->userPayoutMethodId = $this->shipmentData['userPayoutMethodId'] ?? '';
    }

    public function addMoreDevices()
    {
        $this->sectionId = 1;
        $this->cartQty++;
        $this->categoryId = '';
        $this->brandId = '';
        $this->productId = '';
    }

    public function addQuantity($key)
    {
        $this->data[$key]['quantity'] += 1;
        $this->data[$key]['total_price'] = $this->data[$key]['sku_price'] * $this->data[$key]['quantity'];
        $this->data[$key]['total_retail_price'] = $this->data[$key]['sku_retail_price'] * $this->data[$key]['quantity'];
        $this->grandTotal = AppHelper::getGrandTotal($this->data, 1);
    }

    public function removeQuantity($key)
    {
        if ($this->data[$key]['quantity'] > 1) {
            $this->data[$key]['quantity'] -= 1;
            $this->data[$key]['total_price'] = $this->data[$key]['sku_price'] * $this->data[$key]['quantity'];
            $this->data[$key]['total_retail_price'] = $this->data[$key]['sku_retail_price'] * $this->data[$key]['quantity'];
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 1);
        } else {
            return false;
        }
    }

    public function removeProduct($key)
    {
        if (count($this->data) > 1) {
            unset($this->data[$key]);
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 1);
        }
    }

    /**
     * Store Personal Information
     */
    public function storeUserInformation()
    {
        $userData = User::where('email', ($this->customer && isset($this->customer['email']) ? $this->customer['email'] : ''))->first();
        if ($userData) {
            Session::put('user', $userData);
        } elseif (!$userData) {
            Session::forget('user');
        }
        $this->getUser();

        /** Validate User Info */
        if ($this->addressType == 'new') {
            $this->validate(array_merge($this->personalInfoRules(), $this->shippingRules()), array_merge($this->personalInfoRuleMessage(), $this->shippingRuleMessage()));
        } else {
            /** Validate Personal Info */
            $this->validate($this->personalInfoRules(), $this->personalInfoRuleMessage());
        }

        $this->storeData();

        $this->createUserPayoutMethod();
    }

    /**
     * Store Data
     *
     */
    public function storeData()
    {
        DB::beginTransaction();
        try {
            /** Create User If Not available */
            if (!isset($this->userData->id)) {
                /** @var CreateUserAction $action */
                $action = app(CreateUserAction::class);
                $this->customer['name'] = $this->customer['first_name'] . ' ' . $this->customer['last_name'];
                $user = $action->execute($this->customer);
                $this->userData = $user;

                Session::put('user', $user);

                $this->shipping['email'] = $this->customer['email'];
                $this->shipping['first_name'] = $this->customer['first_name'];
                $this->shipping['last_name'] = $this->customer['last_name'];
            }

            /** Update existing user address if available or create new */
            if ($this->addressType == 'new') {
                $this->shipping['name'] = $this->shipping['first_name'] . ' ' . $this->shipping['last_name'];
                unset($this->shipping['first_name'], $this->shipping['last_name']);
                $this->shipping['user_id'] = $this->userData->id;

                /** @var CreateUserAddressAction $action */
                $action = app(CreateUserAddressAction::class);
                $action->execute($this->shipping);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Get the validation rules for the personal information.
     *
     * @return array
     */
    public function personalInfoRules()
    {
        return collect(User::getCreateValidationRule('vendor'))
            ->mapWithKeys(
                fn ($item, $key) => ['customer.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the personal information.
     *
     * @return array
     */
    public function personalInfoRuleMessage()
    {
        return collect(User::getCreateValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['customer.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules for the shipping information.
     *
     * @return array
     */
    public function shippingRules()
    {
        return collect(UserAddress::getCreateValidationRule())
            ->mapWithKeys(
                fn ($item, $key) => ['shipping.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Get the validation rules message for the shipping information.
     *
     * @return array
     */
    public function shippingRuleMessage()
    {
        return collect(UserAddress::getCreateValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['shipping.' . $key => $item]
            )
            ->toArray();
    }

    /**
     * Return User
     */
    public function getUser()
    {
        $this->userData = User::getUser();
        if ($this->userData) {
            $this->shipping['email'] = $this->userData->email;
            $this->shipping['first_name'] = $this->userData->first_name;
            $this->shipping['last_name'] = $this->userData->last_name;
        } elseif ($this->customer) {
            $this->shipping['email'] = $this->customer['email'];
            $this->shipping['first_name'] = $this->customer['first_name'];
            $this->shipping['last_name'] = $this->customer['last_name'];
        }
    }

    public function createUserPayoutMethod()
    {
        $this->shipmentData['shipment_type'] = 1;
        $this->shipmentData['payoutMethod'] = 'digital_payment';

        $userPayoutMethod = UserPayoutMethod::updateOrCreate(['id' => $this->userPayoutMethodId], [
            'user_id' => $this->userData->id,
            'email' => null,
            'type' => 'digital_payment',
            'name' => ucfirst('digital_payment'),
        ]);

        $this->userPayoutMethodId = $userPayoutMethod->id;

        $this->shipmentData['userPayoutMethodId'] = $this->userPayoutMethodId;

        Session::put('shipmentData', $this->shipmentData);
        $this->createShipment();
    }

    public function createShipment()
    {
        $user = User::getUser();
        $data = Session::get('shipment_data') ?? [];
        $shipmentData = Session::get('shipmentData') ?? [];
        if ($user && $data && $shipmentData) {
            DB::beginTransaction();
            try {
                $uuId = $this->getUuid();
                $lastShipment = Shipment::orderBy('id', 'desc')->first();
                $shipmentNo = $lastShipment ? $lastShipment->shipment_no + 1 : '1001';
                $totalPrice = AppHelper::getGrandTotal($data, $shipmentData['shipment_type']);
                $qrCode = null;
                $barcode = null;
                $shipemtArr = [
                    'user_id' => $user->id,
                    'location_id' => auth()->user()->settings['selectedLocation'],
                    'address_id' => $user->addresses()->where('status', '1')->first()->id,
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
                    $price = $product['sku_retail_price'];
                    for ($i = 0; $i < $product['quantity']; $i++) {
                        $shipmentItemData[] = [
                            'sku_id' => $product['filtered_sku_id'],
                            'price' => round($price, 2),
                            'quantity' => 1,
                        ];
                    }
                }

                $shipment = $this->create($shipemtArr, $shipmentItemData, 'walk-in');

                DB::commit();

                Session::forget('shipment_data');
                Session::forget('shipmentData');

                AppHelper::notify('Shipment has been created successfully', 'success');
                return redirect()->route('vendor.shipment.trade-ins.show', $shipment->id);
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', $e->getMessage());
            }
        }

        return redirect()->route('vendor.shipment.trade-ins');
    }

    public function getUUID()
    {
        return AppHelper::uuid();
    }

    /**
     * Return Country Code
     */
    public function countryCode($data)
    {
        $this->shipping['phone_code'] = $data['iso2'];
    }

    /**
     * Return Countries
     */
    public function getCountriesProperty()
    {
        return Country::all();
    }

    /**
     * Set Country Id
     */
    public function setCountry($countryId)
    {
        $this->countryId = $countryId;
        $this->shipping['country_id'] = $countryId;
    }

    /**
     * Return Country
     */
    public function getCountryProperty()
    {
        return Country::find($this->countryId);
    }

    /**
     * Set Address Type (OLD / NEW)
     */
    public function setAddressType($type)
    {
        $this->addressType = $type;
    }

    public function getAddressProperty()
    {
        $userData = User::where('email', ($this->customer && isset($this->customer['email']) ? $this->customer['email'] : ''))->first();
        $address = $userData ? $userData->addresses()->where('status', '1')->first() : null;
        if ($address == null && $this->addressType == 'old') {
            $this->addressType = 'new';
        }
        return $address;
    }

    public function render()
    {
        return view('livewire.vendor.create-shipment');
    }
}
