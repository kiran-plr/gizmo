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
                                    <img src="{{ asset('/assets/images/home/mobile-product-img.png') }}" alt="">
                                </div>
                                <div class="list-content">
                                    <span>Order #298987777</span>
                                    <label>December 23, 2021</label>
                                    <p>Apple iPhone X 64GB</p>
                                </div>
                                <div class="list-price">
                                    <button type="button" class="btn">Payment Completed</button>
                                </div>
                            </li>
                            <li>
                                <div class="list-img">
                                    <img src="{{ asset('/assets/images/home/mobile-product-img.png') }}" alt="">
                                </div>
                                <div class="list-content">
                                    <span>Order #298987777</span>
                                    <label>December 23, 2021</label>
                                    <p>Apple iPhone X 64GB</p>
                                </div>
                                <div class="list-price">
                                    <button type="button" class="btn">Payment Completed</button>
                                </div>
                            </li>
                            <li>
                                <div class="list-img">
                                    <img src="{{ asset('/assets/images/home/mobile-product-img.png') }}" alt="">
                                </div>
                                <div class="list-content">
                                    <span>Order #298987777</span>
                                    <label>December 23, 2021</label>
                                    <p>Apple iPhone X 64GB</p>
                                </div>
                                <div class="list-price">
                                    <button type="button" class="btn">Payment Completed</button>
                                </div>
                            </li>
                            <li>
                                <div class="list-img">
                                    <img src="{{ asset('/assets/images/home/mobile-product-img.png') }}" alt="">
                                </div>
                                <div class="list-content">
                                    <span>Order #298987777</span>
                                    <label>December 23, 2021</label>
                                    <p>Apple iPhone X 64GB</p>
                                </div>
                                <div class="list-price">
                                    <button type="button" class="btn">Payment Completed</button>
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