<?php

namespace App\Http\Livewire\Frontend;

use App\Helpers\AppHelper;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellYourDevice extends Component
{
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
    public $quantity = [];
    public $cartQty = 1;
    public $grandTotal;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->progress = $this->getProgress();
        $this->getData();
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
        // $this->progress += $this->getProgress();
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
        return Product::find($this->productId) ?? Session::forget('data');
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

            // if (in_array($product->sku_id, array_column($this->data, 'filtered_sku_id')) && $this->cartQty > 1) {
            //     unset($this->data[$this->cartQty]);
            //     unset($this->attributeValueIds[$this->cartQty]);
            //     unset($this->attributeIds[$this->cartQty]);
            //     $this->cartQty--;
            //     $this->data[$this->cartQty]['quantity'] += 1;
            // } else {
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
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 2);
            // }
        }
    }

    public function submitForm()
    {
        Session::put('data', $this->data);
        return redirect()->route('shipment-process');
    }

    public function getData()
    {
        $this->data = Session::get('data') ?? [];
        $data = Session::get('selected_data') ?? [];
        if ($this->data) {
            $this->cartQty = count($this->data) + 1;
        }
        if ($data) {
            $this->sectionId = $data[$this->cartQty]['section_id'];
            $this->categoryId = $data[$this->cartQty]['category'];
            $this->brandId = $data[$this->cartQty]['brand'];
            $this->productId = $data[$this->cartQty]['product'];
            $this->data = $data;
            Session::forget('selected_data');
        }
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
        $this->grandTotal = AppHelper::getGrandTotal($this->data, 2);
    }

    public function removeQuantity($key)
    {
        if ($this->data[$key]['quantity'] > 1) {
            $this->data[$key]['quantity'] -= 1;
            $this->data[$key]['total_price'] = $this->data[$key]['sku_price'] * $this->data[$key]['quantity'];
            $this->data[$key]['total_retail_price'] = $this->data[$key]['sku_retail_price'] * $this->data[$key]['quantity'];
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 2);
        } else {
            return false;
        }
    }

    public function removeProduct($key)
    {
        if (count($this->data) > 1) {
            unset($this->data[$key]);
            $this->grandTotal = AppHelper::getGrandTotal($this->data, 2);
        }
    }

    public function render()
    {
        return view('livewire.frontend.sell-your-device');
    }
}
