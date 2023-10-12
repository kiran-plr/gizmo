@extends('frontend.layouts.master')
@section('content')
    <section class="ship-item-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="ship-item-left-content">
                        <span>Shipment #{{ $shipment->shipment_no }}</span>
                        @if ($shipment->shipment_type == 1)
                            <h3>Your money is waiting for you!</h3>
                            <div class="barcode-wrapper">
                                <div class="qr-code">
                                    <p>Your QR code</p>
                                    <img src="{{ $shipment->qrcode }}">
                                </div>
                                <div class="drop-store">
                                    <p>Drop off store</p>
                                    <ul>
                                        <li>{{ $location->name }}</li>
                                        <li>{{ $location->address }}</li>
                                        @if ($location->address2)
                                            <li>{{ $location->address2 }}</li>
                                        @endif
                                        <li>{{ $location->city . ' ' . $location->zip }}</li>
                                        <li>{{ $location->phone }}</li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instructions-wrapper">
                        <h2>Instructions</h2>
                        <ul>
                            <li>
                                <span>Step 1</span>
                                <p>Bring device to drop off location</p>
                            </li>
                            <li>
                                <span>Step 2</span>
                                <p>Show the QR code & Shipment #</p>
                            </li>
                            <li>
                                <span>Step 3</span>
                                <p>Get Paid!</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
