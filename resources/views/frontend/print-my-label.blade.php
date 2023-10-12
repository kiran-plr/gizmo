@extends('frontend.layouts.master')
@section('content')
    <section class="ship-item-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-5 mb-lg-0">
                    <div class="ship-item-left-content">
                        <span class="text-18">Shipment #{{ $shipment->shipment_no }}</span>
                        @if ($shipment->shipment_type == 2)
                            <h3>Your money is waiting for you!</h3>
                        @endif
                        <div class="barcode-wrapper">
                            @include('frontend.partials.label')
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instructions-wrapper">
                        <h2>Instructions</h2>
                        <ul>
                            <li>
                                <span>Step 1</span>
                                <p>Package your item with care</p>
                            </li>
                            <li>
                                <span>Step 2</span>
                                <p>Affix the label to the package</p>
                            </li>
                            <li>
                                <span>Step 3</span>
                                <p>Drop your package to UPS</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ship-item-bottom-btn">
                        {{-- <a href="#">You changed your mind?</a> --}}
                        <a href="{{ route('print-my-label') }}" role="button" class="btn btn-primary" data-value="2">Print
                            my label</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
