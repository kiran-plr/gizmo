@extends('frontend.layouts.master')
@section('content')
    <!-- sell device -->
    <section class="sell-device-wrapper">
        <div class="container">
            <h2 class="sell-title">Sell Your Device</h2>
            <p class="sell-de">Answer a few questions to receive an instant quote.</p>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="sell-product-form">

                        <input type="hidden" name="seq_id" value="2" id="seq_id">

                        <livewire:frontend.sell-your-device :categories="$categories">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="getup-right-product">
                        <p>Get Up to</p>
                        <span>$950.00</span>
                        <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                        <ul>
                            <li><i class='bx bx-check'></i> Free Shipping</li>
                            <li><i class='bx bx-check'></i> Same Day Payment</li>
                            <li><i class='bx bx-check'></i> Highest Payout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
