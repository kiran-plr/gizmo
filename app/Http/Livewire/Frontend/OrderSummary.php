<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class OrderSummary extends Component
{
    public array $data = [];
    public $shipmentType;

    public function mount($data,$shipmentType)
    {
        $this->data = $data;
        $this->shipmentType = $shipmentType;
    }

    public function render()
    {
        return view('livewire.frontend.order-summary');
    }
}
