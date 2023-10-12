<?php

namespace App\Actions;

use App\Mail\PaymentSuccessMail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;

class CreateTransactionAction
{
    public function execute($payout, $response, $payoutData)
    {
        $data = [];

        $data['user_id'] = auth()->user()->id;
        $data['customer_id'] = $payout->user_id;
        $data['shipment_id'] = $payout->shipment_id;
        $data['user_payout_id'] = $payout->id;
        $data['data'] = collect($payoutData)->toJson();
        $data['response'] = collect($response)->toJson();

        $transaction = Transaction::create($data);

        /** Send Pyament Success Mail */

        // Send to Customer
        Mail::to($transaction->customer->email)->send(new PaymentSuccessMail($transaction, 'user'));
        // Send to Vendor
        Mail::to($transaction->vendor->email)->send(new PaymentSuccessMail($transaction, 'vendor'));
        // Send to Admin
        Mail::to(env('ADMIN_NOTIFICATIONS_EMAIL'))->send(new PaymentSuccessMail($transaction, 'admin'));

        return $transaction;
    }
}
