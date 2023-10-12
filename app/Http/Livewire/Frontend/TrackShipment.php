<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class TrackShipment extends Component
{
    public $trackingNumber;
    public $html;

    protected $rules = [
        'trackingNumber' => 'required|digits_between:6,12',
    ];

    protected $messages = [
        'trackingNumber.required' => 'Please enter your tracking number.',
        'trackingNumber.digits_between' => 'The tracking number must be numeric,min 6 digits, max 12 digits.',
    ];

    public function submit()
    {
        $this->validate();

        $url = 'https://leads.gizmogul.com/tracking.php';
        $fields = array(
            'data' => $this->trackingNumber,
        );

        //open connection
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

        $this->html = $result;
    }

    public function render()
    {
        return view('livewire.frontend.track-shipment');
    }
}
