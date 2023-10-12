@extends('frontend.layouts.master')
@section('content')
<section class="shipment-list-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="payment-method-list shipment-product-wrapper">
                    <form action="#">
                        <ul>
                            <li>
                                <div class="list-img">
                                    <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                                </div>
                                <div class="list-content">
                                    <span>Order #298987777</span>
                                    <label>December 23, 2021</label>
                                    <p>Apple iPhone X 64GB</p>
                                </div>
                                <div class="list-price">
                                    <button type="button" class="btn">Payment Completed</button>
                                </div>
                                <div class="product-location-process">
                                    <ul>
                                        <li class="active">
                                            <span>Send your device</span>
                                            <p>December 18, 2021</p>
                                        </li>
                                        <li class="active">
                                            <span>Device received</span>
                                            <p>December 23, 2021</p>
                                        </li>
                                        <li>
                                            <span>Assessment completed</span>
                                            <p>By December 25, 2021</p>
                                        </li>
                                        <li>
                                            <span>Payment completed</span>
                                            <p>By December 25, 2021</p>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection