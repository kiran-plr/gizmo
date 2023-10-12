<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FreeQuoteMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;
    public $mailType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $mailType)
    {
        $this->data = $data;
        $this->mailType = $mailType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->mailType != 'admin') {
            return $this->view('email.free-quote-mail')
                ->attach(public_path('/file/Corporate_BuyBack_Mobile.xlsx', [
                    'as' => 'Corporate_BuyBack_Mobile.xlsx',
                    'mime' => 'application/xlsx',
                ]))
                ->subject('Gizmogul Corporate Recycling Request');
        } else {
            return $this->view('email.free-quote-mail')
                ->subject('Gizmogul Corporate Recycling Request');
        }
    }
}
