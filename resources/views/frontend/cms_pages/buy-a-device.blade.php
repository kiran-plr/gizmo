@extends('frontend.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/contact-us.css') }}">
@endpush
@section('content')
    <section id="contact" class="">
        <div class="container" id="contact-section">
            <div class="row">
                <div class="col-md-12 col-lg-6 offset-lg-3 col-sm-12">
                    <div class="getaquote shadow-lg bg-white rounded">
                        <form id="contact-form" method="POST" action="{{ route('buy-a-device.inquiry.store') }}"
                            class="form-horizontal" role="form">
                            @csrf
                            <h5 class="font-weight-bold text-left text-dark">Buy a device</h5>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="name" placeholder="none"
                                            name="name" value="{{ old('name') }}" maxlength="50" minlength="3"
                                            required>
                                        <label for="subject" class="form-label">NAME</label>
                                        @error('name')
                                        <div class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
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
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-control">
                                        <input type="text" class="form-input" id="phone" placeholder="none"
                                            name="phone" value="{{ old('phone') }}" maxlength="50" minlength="5"
                                            required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="subject" class="form-label">PHONE</label>
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
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush
