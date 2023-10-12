@extends('layouts.vendor.master')
@section('main-content')
    <section class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="home-wrapper">
                        <div class="mb-5">
                            <a href="{{ route('vendor.dashboard') }}" class="d-block auth-logo">
                                <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt=""
                                    height="20" class="auth-logo-dark mx-auto">
                                <img src="{{ asset('/assets/images/logos/gizmogul-logo-light.png') }}" alt=""
                                    height="20" class="auth-logo-light mx-auto">
                            </a>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="{{ asset('assets/images/maintenance.svg') }}" alt=""
                                        class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-5">Your account is pending setup. </h3>
                        <p>Please contact support@gizmogul.com if you have any questions</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
