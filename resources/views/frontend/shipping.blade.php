@extends('frontend.layouts.master')
@section('content')
    <!-- shipping information -->
    <section class="shipping-info-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-5 mb-lg-0">
                    <div class="shipping-info-from">
                        <livewire:frontend.shipment-process :data="$data" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="order-summary">
                        <p><i class='bx bx-shopping-bag'></i> Order summary</p>
                        <livewire:frontend.order-summary :data="$data" :shipmentType="2">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection