<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $transaction;
    public $mailType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction, $mailType)
    {
        $this->transaction = $transaction;
        $this->mailType = $mailType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->transaction->shipment->shipment_type == '2') {
            return $this->view('email.payment-success-mail')
                ->subject('Payment sent');
        } else {
            return $this->view('email.payment-success-mail')
                ->subject('Payment sent Local Drop-Off');
        }
    }
}
