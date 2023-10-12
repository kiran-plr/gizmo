@extends('frontend.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/contact-us.css') }}">
@endpush
@section('content')
    <section id="contact" class="page-vertical-text contact-us-page">
        <div class="container" id="contact-section">
            <div class="row">
                <div class="col-md-4 col-lg-3 col-sm-12">
                    <h3 class="text-dark font-weight-bold  ml-4">
                        Contact
                    </h3>
                    <h6 class="text-secondary font-weight-bold  ml-4">
                        Need answers?<br>
                        Find them here!
                    </h6>
                    <h6 class="text-secondary text-left font-weight-bold ml-4" style="margin-top: 100%;">
                        Monday through Friday.<br>
                        9:00am to 5:00pm (EST).<br>
                        Available by email 24/7
                    </h6>
                </div>
                <div class="col-md-7 col-lg-5 col-sm-12">
                    <div class="getaquote shadow-lg bg-white rounded">
                        <form id="contact-form" method="POST" action="{{ route('contact-us.store') }}"
                            class="form-horizontal" role="form">
                            @csrf
                            <h5 class="font-weight-bold text-left text-dark">Contact us</h5>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="name" placeholder="none"
                                            name="name" value="{{ old('name') }}" maxlength="50" minlength="3"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="subject" class="form-label">NAME</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <input type="email" class="form-input" id="email" placeholder="none"
                                            name="email" value="{{ old('email') }}" maxlength="50" minlength="5"
                                            required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="subject" class="form-label">EMAIL</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group message-box">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <textarea class="form-input" rows="10" placeholder="none" name="message" maxlength="500" minlength="10" required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="subject" class="form-label">MESSAGE</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    {!! NoCaptcha::display() !!}
                                </div>
                                @error('g-recaptcha-response')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-primary send-button" id="submit" type="submit" value="SEND">
                                <div class="alt-send-button">
                                    <i class="fa fa-paper-plane"></i><span class="send-text">SEND</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-1 col-lg-4 col-sm-12">
                </div>
            </div>
            <hr class="my-5" />
            <div class="row contact-footer-info">
                <div class="col-md-4 col-lg-3 col-sm-6 offset-lg-1">
                    <h3 class="font-weight-bold text-dark">For Individuals</h3>
                    <div class="mb-3">
                        <span class="text-size-14 text-dark">General Inquiries</span>
                        <a href="mailto:info@gizmogul.com">info@gizmogul.com</a>
                    </div>
                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Customer Service</span>
                        <a href="mailto:{{ AppHelper::SITE_EMAIL }}">{{ AppHelper::SITE_EMAIL }}</a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6 offset-lg-1">
                    <h3 class="font-weight-bold text-dark">For Companies</h3>

                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Bulk sales &amp; corporate buyback</span>
                        <a href="mailto:buyback@gizmogul.com">buyback@gizmogul.com</a>
                    </div>
                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Wholesale volume purchasing</span>
                        <a href="mailto:inventory@gizmogul.com">inventory@gizmogul.com</a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 col-sm-6 offset-lg-1">
                    <h3 class="font-weight-bold text-dark">Other</h3>

                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Marketing</span>
                        <a href="mailto:marketing@gizmogul.com">marketing@gizmogul.com</a>
                    </div>
                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Press</span>
                        <a href="mailto:press@gizmogul.com">press@gizmogul.com</a>
                    </div>
                    <div class="mb-3">
                        <span class="text-size-14 text-dark">Legal</span>
                        <a href="mailto:press@gizmogul.com">legal@gizmogul.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush
