@extends('email.layouts.master')
@section('title', 'Shipment Status Change Mail')
@section('main-content')
    <div style="padding: 30px;  box-shadow: 0px 0px 8px 0px #f1f1f1; border-radius: 5px; background-color:#fff;">
        <div>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">
                Shipment Status Change Mail
            </p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">
                Shipment Status: {{ ucfirst($shipment->status) }}
            </p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; ">
                Shipment Date: {{ $shipment->created_at->format('d M, Y') }}
            </p>
            <p style="font-size:16px; color:#586578; font-weight:500; margin:15px 0; line-height:1.3; ">
                Regards,<br />
                Gizmogul-Buyback
            </p>
        </div>
    </div>
@endsection
