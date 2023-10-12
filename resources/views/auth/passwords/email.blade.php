<!doctype html>
<html lang="en">

@include('layouts.admin.head')
<!-- owl.carousel css -->
<link rel="stylesheet" href="{{ asset('/assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">

<link rel="stylesheet" href="{{ asset('/assets/libs/owl.carousel/assets/owl.theme.default.min.css') }}">

<body class="auth-body-bg">

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-9">
                    @include('auth.testimonials')
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="assets/images/logo-dark.png" alt="" height="18"
                                            class="auth-logo-dark">
                                        <img src="assets/images/logo-light.png" alt="" height="18"
                                            class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div>
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p class="text-muted">Reset Password with Gizmogul.</p>
                                    </div>

                                    <div class="mt-4">
                                        <div class="alert alert-success text-center mb-4" role="alert">
                                            Enter your Email and instructions will be sent to you!
                                        </div>
                                        <form method="POST" action="{{ route('password.email') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Enter email" name="email"
                                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="text-end">
                                                <button class="btn btn-primary w-md waves-effect waves-light"
                                                    type="submit">{{ __('Reset') }}</button>
                                            </div>

                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Remember It ? <a href="{{ route('login') }}"
                                                    class="fw-medium text-primary">
                                                    Sign In here</a> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> Gizmogul.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    <!-- JAVASCRIPT -->
    @include('layouts.admin.scripts')
    <!-- owl.carousel js -->
    <script src="{{ asset('/assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

    <!-- auth-2-carousel init -->
    <script src="{{ asset('/assets/js/pages/auth-2-carousel.init.js') }}"></script>
</body>

</html>
