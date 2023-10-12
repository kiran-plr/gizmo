<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/libs/owl.carousel/assets/owl.theme.default.min.css') }}">
    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custome Css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <!-- Custome Css End -->

    <!-- responsive Css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!-- responsive Css End -->

    @livewireStyles

    @stack('styles')
    
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MSWJ8KS');</script>
<!-- End Google Tag Manager -->    
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MSWJ8KS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    @flasher_render({limit:1})

    <!-- Header -->
    @include('frontend.layouts.header')
    <!-- End sHeader -->

    <!-- Home Page Slider -->
    <div class="owl-carousel header-top-slider owl-theme banner-top-slider">
        <div class="item">
            <h4>Excellent</h4>
            <img src="{{ asset('/assets/images/star-top.png') }}" alt="" height="17">
        </div>
        <div class="item">
            <h4>Excellent</h4>
            <img src="{{ asset('/assets/images/star-top.png') }}" alt="" height="17">
        </div>
        <div class="item">
            <h4>Excellent</h4>
            <img src="{{ asset('/assets/images/star-top.png') }}" alt="" height="17">
        </div>
    </div>
    <!-- Home Page Slider End -->

    <!-- Main Content -->
    @yield('content')
    {{ isset($slot) ? $slot : '' }}
    <!-- End Main Content -->

    <!-- Footer -->
    @include('frontend.layouts.footer')
    <!-- End Footer -->

    @livewireScripts

    @stack('scripts')

    <script src="{{ asset('frontend/js/homeInit.js') }}"></script>

</body>

</html>
