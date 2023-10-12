<?php

namespace App\Http\Livewire\Admin\Product;

use App\Helpers\AppHelper;
use App\Models\Attribute;
use App\Models\AttributeFamily;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Sku;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateOrUpdateProduct extends Component
{
    public $categories;
    public $productArr;
    public $product;
    public $productId;
    public $attrvalues = [];
    public $configuration = [];
    public $combinationsArr = [];
    public $count = 0;
    public $photos;

    protected $listeners = [
        'newAttrSelect',
        'setSlug',
        'setPhotos',
        'slugChange',
        'changeAttributeFamily',
    ];

    public function mount($categories, $product)
    {
        $this->categories = $categories;
        $this->product = $product;
        $this->getProductData();
    }

    public function getBrandsProperty()
    {
        return Brand::orderBy('id', 'desc')->get();
    }

    public function getAttributeFamiliesProperty()
    {
        return AttributeFamily::all();
    }

    public function getAttributesProperty()
    {
        return Attribute::where('attribute_family_id', $this->productArr['attribute_family_id'])->get();
    }

    public function getFamilyProperty()
    {
        return $this->attributeFamilies->find($this->productArr['attribute_family_id']);
    }

    public function setSlug()
    {
        $this->productArr['slug'] = (isset($this->productArr['name']) ? Str::slug($this->productArr['name']) : '');
    }

    public function setPhotos($url)
    {
        $this->photos = $url;
    }

    public function getCombinationsProperty()
    {
        $newCombinations = [[]];
        if (isset($this->productArr['attribute_family_id']) && !$this->productId) {
            $array = $this->attrvalues;
            $combinations = [[]];

            $comKeys = array_keys(array_filter($array));
            for ($count = 0; $count < count($comKeys); $count++) {
                $tmp = [];
                foreach ($combinations as $comb) {
                    foreach ($array[$comKeys[$count]] as $val) {
                        $tmp[] = $comb + [$comKeys[$count] => ['slug' => unserialize($val)['slug'], 'id' => unserialize($val)['id']]];
                    }
                }
                $combinations = $tmp;
            }
            $sku = '';
            $count = 0;
            foreach ($combinations as $key => $combs) {
                $sku = AppHelper::SELL . (isset($this->productArr['slug']) ? '-' . $this->productArr['slug'] : '');
                foreach ($combs as $key => $attr) {
                    $sku .= '-' . $attr['slug'];
                }
                $newCombinations[$sku] = $combs;
                $count++;
            }
            $newCombinations = array_filter($newCombinations);
        }
        $this->combinationsArr = $newCombinations;
        return $newCombinations;
    }

    public function createProduct()
    {
        $this->validate($this->productRule(), $this->productRuleMessage());

        $this->productArr['user_id'] = auth()->user()->id;
        $this->productArr['sku'] = AppHelper::SELL . (isset($this->productArr['slug']) ? '-' . $this->productArr['slug'] : '');
        $this->createConfigurableProduct();
    }

    public function updateProduct()
    {
        $this->createProduct();
    }

    public function createConfigurableProduct()
    {
        DB::beginTransaction();
        try {
            $this->productArr['photos'] = $this->photos ? implode(',', $this->photos) : '';
            $configurableProduct = Product::updateOrCreate(['id' => $this->productId ?? null], $this->productArr);

            foreach ($this->configuration as $key => $product) {
                if (isset($product['price'])) {
                    $sku = Sku::updateOrCreate(['sku' => $this->productId ? $product['sku'] : null], [
                        'product_id' => $configurableProduct->id,
                        'sku' => $product['sku'],
                        'status' => $product['status'],
                        'price' => $product['price'],
                        'retail_price' => $product['retail_price'],
                    ]);
                }
                if (!$this->productId) {
                    foreach (unserialize($product['attribute']) as $key => $val) {
                        $attribute = [
                            "sku_id" => $sku->id,
                            "product_id" => $configurableProduct->id,
                            "attribute_id" => $key,
                            "attribute_value_id" => $val
                        ];
                        ProductAttribute::create($attribute);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.product.index')->with('success', ($this->productId ? 'Product updated successfully' : 'Product created successfully'));
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', $e->getMessage());
        }
    }

    public function productRule()
    {
        $productRule = [];
        $productRule = collect(Product::getCreateValidationRule($this->productId))
            ->mapWithKeys(
                fn ($item, $key) => ['productArr.' . $key => $item]
            )
            ->toArray();

        $ProductRuleBasedOntype = [];
        $ProductRuleBasedOntype = collect(Product::getConfigurableRule())
            ->mapWithKeys(
                fn ($item, $key1) => ['configuration.*.' . $key1 => $item]
            )->toArray();
        return array_merge($productRule, $ProductRuleBasedOntype);
    }

    public function productRuleMessage()
    {
        $productRule = [];
        $productRule = collect(Product::getCreateValidationMessage())
            ->mapWithKeys(
                fn ($item, $key) => ['productArr.' . $key => $item]
            )
            ->toArray();

        $ProductRuleBasedOntype = [];
        $ProductRuleBasedOntype = collect(Product::getConfigurableRuleMessage())
            ->mapWithKeys(
                fn ($item, $key1) => ['configuration.*.' . $key1 => $item]
            )->toArray();

        return array_merge($productRule, $ProductRuleBasedOntype);
    }

    public function getProductData()
    {
        if ($this->product) {
            $this->productArr = $this->product->toArray();
            $this->productId = $this->product->id;
            $this->photos = $this->product->photos;
            $this->getAttrValues();
        }
    }

    public function getAttrValues()
    {
        $attrvalues = [];
        $productAttributes = ProductAttribute::where('product_id', $this->productId)->get();
        foreach ($productAttributes as $key => $productAttribute) {
            $attrvalues[$productAttribute->attribute_id][] = serialize(['id' => $productAttribute->attribute_value_id, 'slug' => $productAttribute->attributeValue->slug]);
        }
        $this->attrvalues = $attrvalues;
        $this->getConfigurationsProduct();
    }

    public function getConfigurationsProduct()
    {
        $this->configuration = Sku::where('product_id', $this->productId)->get()->map(function ($item) {
            $attr = [];
            $productAttrs = ProductAttribute::where('sku_id', $item->id)->get();
            foreach ($productAttrs as $key => $productAttr) {
                $attr[$productAttr->attribute_id] = $productAttr->attribute_value_id;
                $this->combinationsArr[$item->sku][] = ['id' => $productAttr->attribute_value_id, 'slug' => $productAttr->attributeValue->slug];
            }

            return [
                'sku' => $item->sku,
                'price' => $item->price,
                'retail_price' => $item->retail_price,
                'status' => $item->status,
                'attribute' => serialize($attr)
            ];
        });
    }

    public function newAttrSelect()
    {
        $this->configuration = [];
        $count = 0;
        foreach ($this->combinations as $key => $comb) {
            if (!isset($this->configuration[$count])) {
                $this->configuration[$count] = ['price' => null, 'status' => '1'];
            }
            $count++;
        }
    }

    public function slugChange()
    {
        $combinactions = $this->combinationsArr;
        $newCombinations = [];
        foreach ($combinactions as $key => $combs) {
            $sku = AppHelper::SELL . (isset($this->productArr['slug']) ? '-' . $this->productArr['slug'] : '');
            foreach ($combs as $key => $attr) {
                $sku .= '-' . $attr['slug'];
            }
            $newCombinations[$sku] = $combs;
        }
        $this->combinationsArr = $newCombinations;
    }

    public function changeAttributeFamily()
    {
        $this->combinationsArr = [];
        $this->attrvalues = [];
    }

    public function render()
    {
        return view('livewire.admin.product.create-or-update-product');
    }
}
