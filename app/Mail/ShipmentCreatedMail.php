<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShipmentCreatedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $shipment;
    public $mailType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shipment, $mailType = null)
    {
        $this->shipment = $shipment;
        $this->mailType = $mailType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->shipment->shipment_type == '2') {
            return $this->view('email.shipment-created-mail')
                ->attach($this->shipment->label_url)
                ->subject('Gizmogul Order Confirmation #' . $this->shipment->shipment_no);
        } else {
            return $this->view('email.shipment-created-mail')
                ->subject('Its time to get paid, Confirmation #' . $this->shipment->shipment_no);
        }
    }
}
