@extends('frontend.layouts.master')

@section('content')
    <!-- home banner -->
    <section class="home-banner-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner-image">
                        <img class="desktop-banner" src="{{ asset('/assets/images/home/home-banner.png') }}"
                            alt="" />
                        <img class="mobile-banner" src="{{ asset('/assets/images/home/home-mobile-banner.png') }}"
                            alt="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="banner-content">
                        <div>
                            <h1>We'll pay you top dollar <br> for your old device</h1>
                            <p>Free Shipping, Fast payment <br> & Highest payout</p>
                            <a href="{{ route('sell-your-device') }}">Sell a device</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- company logo slider -->
    <section class="logo-slider-wrapper">
        <div class="container">
            <div class="owl-carousel company-logo-slider owl-theme">
                <div class="item"><img src="{{ asset('/assets/images/home/BuzzFeed.svg') }}" alt="">
                </div>
                <div class="item"><img src="{{ asset('/assets/images/home/abc-news-logo-vector 1.svg') }}"
                        alt=""> </div>
                <div class="item"><img src="{{ asset('/assets/images/home/Gizmodo.svg') }}" alt="">
                </div>
                {{-- <div class="item"><img src="{{ asset('/assets/images/home/techcrunch-logo.svg') }}" alt="">
                </div> --}}
            </div>
        </div>
    </section>

    <!-- product-slider -->
    <section class="product-slider-wrapper">
        <div class="container">
            <h2 class="product-title desktop-banner">What device do you want to sell?</h2>
            <h2 class="product-title mobile-banner">What is your device?</h2>
            <div class="owl-carousel product-slider owl-theme">
                <div class="item">
                    <div class="card border rounded ms-2 me-2 pt-2 pb-2">
	                    <a href="/sell-iphone">
	                        <img src="{{ asset('/assets/images/home/mobile-product.png') }}" alt="">
	                        <div class="card-body text-center">
	                            <h5 class="card-title">iPhone</h5>
	                        </div>
	                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card border rounded ms-2 me-2 pt-2 pb-2">
	                    <a href="/sell-your-device">
                        <img src="{{ asset('/assets/images/home/laptop-product.png') }}" alt="">
                        <div class="card-body text-center">
                            <h5 class="card-title">Macbook</h5>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card border rounded ms-2 me-2 pt-2 pb-2">
	                    <a href="/sell-your-device">
                        <img src="{{ asset('/assets/images/home/ipad-product.png') }}" alt="">
                        <div class="card-body text-center">
                            <h5 class="card-title">iPad</h5>
                        </div>
	                    </a>
                    </div>
                </div>
                <div class="item">
                    <div class="card border rounded ms-2 me-2 pt-2 pb-2">
                        <a href="/sell-your-device">
	                         <img src="{{ asset('/assets/images/home/watch-product.png') }}" alt="">
	                        <div class="card-body text-center">
	                            <h5 class="card-title">Watch</h5>
	                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our App  -->
    <section class="deserve-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="video-sction">
                        <iframe width="500" height="340" src="https://www.youtube.com/embed/5Wm__WNdOPw"
                            title="Electronic Afterlife" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="deserve-content">
                        <div>
                            <h3>Get paid what you <br> deserve for your phone</h3>
                            <p>With over 500 retail locations you can take <br> your device in and get paid that
                                very day!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.partials.offer')

{{--  @include('frontend.partials.offer-appstore') --}}

    @include('frontend.partials.certificate-quality')

    @include('frontend.partials.reviews')

    @include('frontend.partials.offer-appstore')
@endsection
