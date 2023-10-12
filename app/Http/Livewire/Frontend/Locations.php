<?php

namespace App\Http\Livewire\Frontend;

use App\Locations\Distance;
use App\Shipment\Shipment;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Locations extends Component
{
    use Distance;
    public array $data = [];
    public int $zoom = 10;
    public $searchLoaction;
    public array $locationsArr = [];
    public $locationId;
    public $type;

    public function mount($type = null)
    {
        $this->type = $type;
        $this->getData();
        $this->getSearchedLocation();
    }

    public function selectLocation($locationId)
    {
        Session::put('searched_location', $this->searchLoaction);
        Session::put('location_id', $locationId);
        return redirect()->route('shipment-review');
    }

    public function getData()
    {
        if (!$this->type) {
            $data = Session::get('data') ?? [];
            if ($data) {
                $this->data = $data;
            } else {
                return redirect()->route('sell-your-device');
            }
        }
    }

    public function getSearchedLocation()
    {
        if (!$this->type) {
            $this->searchLoaction = Session::get('searched_location') ?? '';
            $this->locationId = Session::get('location_id');
        }
    }

    public function render()
    {
        $this->locationsArr = json_decode(json_encode($this->locations($this->searchLoaction)), true);
        $this->dispatchBrowserEvent('locationFind', []);
        return view('livewire.frontend.locations');
    }
}
