<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeFamily;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::all();
        $product = $request->id ? Product::findOrFail($request->id) : null;
        return view('admin.products.create', compact('categories', 'product'));
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Export the specified resource to CSV.
     */
    public function export()
    {
        $fileName = 'Products.csv';
        $products = Product::all();
        $data = [];
        $count = 0;
        $configurable = false;
        $configurableId = 0;
        $attraArr = [];
        foreach ($products as $key => $product) {
            $configurable = true;
            $configurableId = $count;
            $data[$count] = [
                'sku' => $product->sku,
                'name' => $product->name,
                'type' => $product->type,
                'price' => '0',
                'retail_price' => '0',
                'status' => null,
                'attribute_family' => $product->attributeFamily->name,
                'parent_sku' => 'null',
                'category' => $product->category->name,
                'brand' => $product->brand->name,
                'description' => $product->description,
            ];
            foreach ($product->skus as $key1 => $sku) {
                $count++;
                $data[$count] = [
                    'sku' => $sku->sku,
                    'name' => $product->name,
                    'type' => 'simple',
                    'price' => $sku->price,
                    'retail_price' => $sku->retail_price,
                    'status' => $sku->status == '1' ? 'Active' : 'Inactive',
                    'attribute_family' => null,
                    'parent_sku' => $product->sku,
                    'category' => null,
                    'brand' => null,
                    'description' => null,
                ];

                foreach ($sku->productAttributes as $key => $attr) {
                    $data[$count][$attr->attribute->slug] = $attr->attributeValue->value;
                    $attraArr[$key] = $attr->attribute->slug;
                    if ($configurable) {
                        $data[$configurableId][$attr->attribute->slug] = null;
                    }
                }
                $configurable = false;
            }
            $count++;
        }

        $this->products = $data;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array_merge(['sku', 'name', 'type', 'price', 'retail_price', 'status', 'attribute_family', 'parent_sku', 'category', 'brand', 'description'], array_values($attraArr));

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($this->products as $key => $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import products from csv file
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 minutes

        $this->validate($request, [
            'csv' => 'required|mimes:csv,txt'
        ]);

        // check file exists and it's readable
        if (!file_exists($request->file('csv')) || !is_readable($request->file('csv'))) {
            return redirect()->back()->with('error', 'Unable to read file');
        }

        $logMessages = [];
        if (($handle = fopen($request->csv, 'r')) !== false) {
            $counter = 1;
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                // skip if row is empty
                if (empty(array_filter($row))) {
                    $counter++;
                    continue;
                }

                // set the header row as key for the array
                if (!isset($header)) {
                    $header = $row;
                    $validateColumn = array_diff(['status','sku', 'parent_sku', 'category', 'name', 'description', 'brand', 'type', 'attribute_family', 'price','retail_price'], $header);
                    if (!empty($validateColumn)) {
                        return redirect()->back()->with('error', \implode(',', $validateColumn) . ' columns does not exists in csv file');
                    }
                    $counter++;
                    continue;
                }

                // set the row data as value for the array
                $product = array_combine($header, $row);
                if ($this->isEmpty($product['parent_sku'])) {
                    // check product exists or not
                    $existingProduct = Product::where('sku', $product['sku'])->first();
                    if ($existingProduct) {
                        $counter++;
                        continue;
                    }

                    // configurable product validation
                    $notEmptyFields = [];
                    if ($this->isEmpty($product['category'])) {
                        $notEmptyFields[] = 'category';
                    }
                    if ($this->isEmpty($product['name'])) {
                        $notEmptyFields[] = 'name';
                    }
                    // if ($this->isEmpty($product['description'])) {
                    //     $notEmptyFields[] = 'description';
                    // }
                    if ($this->isEmpty($product['brand'])) {
                        $notEmptyFields[] = 'brand';
                    }
                    if ($this->isEmpty($product['attribute_family'])) {
                        $notEmptyFields[] = 'attribute_family';
                    }
                    if (!empty($notEmptyFields)) {
                        $logMessages['configurable']['create']['validation'][] = $counter . ' Product with sku ' . $product['sku'] . ' has empty fields ' . implode(',', $notEmptyFields);
                        $counter++;
                        continue;
                    }

                    // create configurable product
                    DB::beginTransaction();
                    try {
                        Product::create([
                            'user_id' => Auth::user()->id,
                            'sku' => $product['sku'],
                            'name' => $product['name'],
                            'slug' =>  Str::slug($product['name']),
                            'description' => $product['description'],
                            'category_id' => $this->getCategoryId($product['category']),
                            'brand_id' => $this->getBrandId($product['brand'], $product['category']),
                            'attribute_family_id' => $this->getAttributeFamilyId($product['attribute_family']),
                            'type' => 'configurable',
                            'status' => strtolower($product['status']) == "active" ? '1' : '0'
                        ]);
                        $logMessages['configurable']['create']['success'][] = $counter . ' Product with sku ' . $product['sku'] . ' created';
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $logMessages['configurable']['create']['error'][] = $counter . ' Product with sku ' . $product['sku'] . ' has error ' . $e->getMessage();
                    }
                    $counter++;
                    continue;
                }

                // add variation product start
                $parentProduct = Product::where('sku', $product['parent_sku'])->first();
                if (!$parentProduct) {
                    $logMessages['simple_product']['create']['error'][] = $counter . ' Product with sku ' . $product['sku'] . ' has error parent product with sku ' . $product['parent_sku'] . ' does not exists';
                    $counter++;
                    continue;
                }

                // check simple product exists
                $existsSku = Sku::where('sku', $product['sku'])->first();
                if ($existsSku) {
                    $status = strtolower($product['status']) == "active" ? '1' : '0';
                    if ($existsSku->price !== number_format((int)$product['price'], 2, '.', '') || $existsSku->retail_price !== number_format((int)$product['retail_price'], 2, '.', '') || $existsSku->status !== $status) {
                        $existsSku->price = $product['price'];
                        $existsSku->retail_price = $product['retail_price'];
                        $existsSku->status = $status;
                        $existsSku->save();
                        $logMessages['simple_product']['update']['success'][] = $counter . ' Product with sku ' . $product['sku'] . ' updated';
                    }
                    $counter++;
                    continue;
                }

                // get all attributes after column 11
                $attribute = array_filter(array_slice($product, 11));
                if (count($attribute) == 0) {
                    $logMessages['simple_product']['create']['validation'][] = $counter . ' Product with sku ' . $product['sku'] . ' has error no attributes found. Please add attributes value in csv file';
                    $counter++;
                    continue;
                }

                DB::beginTransaction();
                try {
                    $sku = Sku::create(['product_id' => $parentProduct->id, 'sku' => $product['sku'], 'price' => $product['price'], 'retail_price' => $product['retail_price'],'status' => strtolower($product['status']) == "active" ? '1' : '0']);
                    $productAttribute = [];

                    /* Condition Code */
                    // $condition = \explode('-', $product['sku']);
                    // $condition = $this->getCondition(end($condition));
                    // $attributeId1 = $this->getAttributeId('condition', $parentProduct->attribute_family_id);
                    // $attributeValueId1 = $this->getAttributeValueId($condition, $attributeId1);
                    // $productAttribute[] = ['product_id' => $parentProduct->id, 'sku_id' => $sku->id, 'attribute_id' => $attributeId1, 'attribute_value_id' => $attributeValueId1];

                    foreach ($attribute as $key => $value) {
                        $attributeId = $this->getAttributeId($key, $parentProduct->attribute_family_id);
                        $attributeValueId = $this->getAttributeValueId($value, $attributeId);
                        $productAttribute[] = ['product_id' => $parentProduct->id, 'sku_id' => $sku->id, 'attribute_id' => $attributeId, 'attribute_value_id' => $attributeValueId];
                    }
                    ProductAttribute::insert($productAttribute);
                    DB::commit();
                    $logMessages['simple_product']['create']['success'][] = $counter . ' Product with sku ' . $product['sku'] . ' created';
                } catch (\Exception $e) {
                    DB::rollBack();
                    $logMessages['simple_product']['create']['error'][] = $counter . ' Product with sku ' . $product['sku'] . ' has error ' . $e->getMessage() . ' .Please contact to admin.';
                }
                $counter++;
                continue;
            }
        }
        fclose($handle);
        return back()->with('importLog', $logMessages);
    }

    public function getAttributeId($attributeSlug, $attributeFamilyId)
    {
        $attribute = Attribute::where('slug', Str::slug($attributeSlug))->where('attribute_family_id', $attributeFamilyId)->first();
        if (!$attribute) {
            $attribute = Attribute::create([
                'name' => ucwords($attributeSlug),
                'slug' => Str::slug($attributeSlug),
                'attribute_family_id' => $attributeFamilyId,
            ]);
        }
        return $attribute->id;
    }

    public function getAttributeValueId($attributeValueSlug, $attributeId)
    {
        $attributeValue = AttributeValue::where('slug', Str::slug($attributeValueSlug))->where('attribute_id', $attributeId)->first();
        if (!$attributeValue) {
            $attributeValue = AttributeValue::create([
                'value' => ucwords($attributeValueSlug),
                'slug' => Str::slug($attributeValueSlug),
                'attribute_id' => $attributeId,
            ]);
        }
        return $attributeValue->id;
    }

    public function getCategoryId($categorySlug)
    {
        $category = Category::where('slug', Str::slug($categorySlug))->first();
        if (!$category) {
            $category = Category::create(['name' => ucwords($categorySlug), 'slug' => Str::slug($categorySlug)]);
        }
        return $category->id;
    }

    public function getBrandId($brandSlug, $category)
    {
        $brand = Brand::where('slug', Str::slug($brandSlug))->first();
        if (!$brand) {
            $brand = Brand::create(['name' => ucwords($brandSlug), 'slug' => Str::slug($brandSlug)]);
        }
        return $brand->id;
    }

    public function getAttributeFamilyId($attributeFamilySlug)
    {
        $attributeFamily = AttributeFamily::where('slug', Str::slug($attributeFamilySlug))->first();
        if (!$attributeFamily) {
            $attributeFamily = AttributeFamily::create(['name' => ucwords($attributeFamilySlug), 'slug' => Str::slug($attributeFamilySlug)]);
        }
        return $attributeFamily->id;
    }

    public function isEmpty($data)
    {
        if ($data == null || $data == '' || $data == 'null' || $data == 'NULL' || $data == 'Null' || $data == '-') {
            return true;
        }
        return false;
    }

    public function getCondition($condition)
    {
        if($condition == 'aa') {
            return 'Excellent';
        }
        elseif($condition == 'bb') {
            return 'Good';
        }
        elseif($condition == 'cc') {
            return 'Broken';
        }
        return false;
    }
}
