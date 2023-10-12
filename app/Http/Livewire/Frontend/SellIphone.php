<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class SellIphone extends Component
{
    public $category;
    public $brand;
    public $perPageItem = 30;

    public function mount($category, $brand)
    {
        $this->category = $category;
        $this->brand = $brand;
    }

    public function getProductsProperty()
    {
        $products = Product::where('category_id', $this->category->id)
            ->where('brand_id', $this->brand->id)
            ->where('attribute_family_id', 2)
            ->where('type', 'configurable')
            ->limit($this->perPageItem)
            ->get();

        return $products;
    }

    public function selectProduct($productId)
    {
        $productData = Session::get('data') ?? [];
        $key = count($productData) == 0 ? 1 : count($productData) + 1;
        $data = $productData;
        $data[$key]['section_id'] = 4;
        $data[$key]['category'] = $this->category->id;
        $data[$key]['brand'] = $this->brand->id;
        $data[$key]['product'] = $productId;
        $data[$key]['quantity'] = 1;
        $data[$key]["attribute_family_id"] = 2;

        Session::put('selected_data', $data);
        return redirect()->route('sell-your-device');
    }

    public function loadMore()
    {
        $this->perPageItem += 5;
    }

    public function render()
    {
        return view('livewire.frontend.sell-iphone');
    }
}
