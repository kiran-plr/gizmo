<?php

namespace App\Http\Livewire\Frontend;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class MyCart extends Component
{
    public $data;

    protected $listeners = [
        'removeProduct'
    ];

    public function mount($data)
    {
        $this->data = $data;
    }

    public function addQuantity($key)
    {
        $this->data[$key]['quantity'] += 1;
        $this->data[$key]['total_price'] = $this->data[$key]['sku_price'] * $this->data[$key]['quantity'];
    }

    public function removeQuantity($key)
    {
        if ($this->data[$key]['quantity'] > 1) {
            $this->data[$key]['quantity'] -= 1;
            $this->data[$key]['total_price'] = $this->data[$key]['sku_price'] * $this->data[$key]['quantity'];
        } else {
            return false;
        }
    }

    public function removeProduct($key)
    {
        unset($this->data[$key]);
        Session::put('data', $this->data);
    }

    public function submit()
    {
        Session::put('data', $this->data);
        return redirect()->route('shipment-process');
    }

    public function render()
    {
        return view('livewire.frontend.my-cart');
    }
}
