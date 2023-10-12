<?php

namespace App\View\Components\Frontend;

use App\Models\UserPayoutMethod;
use Illuminate\View\Component;

class ShipmentType extends Component
{
    public $shipmentType;
    public $payoutMethods;
    public $payoutMethod;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($shipmentType, $payoutMethod)
    {
        $this->shipmentType = $shipmentType;
        $this->payoutMethods = $this->getPayoutMethods();
        $this->payoutMethod = $payoutMethod;
    }

    public function getPayoutMethods()
    {
        return UserPayoutMethod::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.shipment-type');
    }
}
