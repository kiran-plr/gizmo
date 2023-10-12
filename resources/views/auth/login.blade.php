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
                                    <a href="{{ url('/') }}" class="d-block auth-logo">
                                        <img src="{{ asset('/assets/images/logos/gizmogul-logo.png') }}" alt=""
                                            height="18" class="auth-logo-dark">
                                        <img src="{{ asset('/assets/images/logos/gizmogul-logo-light.png') }}"
                                            alt="" height="18" class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p class="text-muted">Sign in to continue to Gizmogul.</p>
                                    </div>

                                    <div class="mt-4">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email"
                                                    class="form-label">{{ __('Email Address') }}</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" id="email" placeholder="Enter email"
                                                    value="{{ old('email') }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="{{ route('password.request') }}" class="text-muted">Forgot
                                                        password?</a>
                                                </div>
                                                <label class="form-label">{{ __('Password') }}</label>
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" placeholder="Enter password"
                                                        aria-label="Password" aria-describedby="password-addon"
                                                        autocomplete="off" required>
                                                    <button class="btn btn-light " type="button" id="password-addon"
                                                        style="box-shadow: 0px 2px 2px #ddd;">
                                                        <i class="mdi mdi-eye-outline"></i>
                                                    </button>
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mt-3 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light"
                                                    type="submit">Log In</button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Don't have an account ? <a href="{{ route('register') }}"
                                                    class="fw-medium text-primary"> Signup now </a> </p>
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
