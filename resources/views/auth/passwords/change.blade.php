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
                                        <h5 class="text-primary">Change Password</h5>
                                    </div>

                                    <div class="mt-4">
                                        <form class="needs-validation" method="POST" novalidate
                                            action="{{ route('user.password.change') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="currentpassword"
                                                    class="form-label">{{ __('Current Password') }}</label>
                                                <input type="password" class="form-control" id="currentpassword"
                                                    name="old_password" placeholder="Enter current password" required
                                                    autocomplete="off" minlength="6" maxlength="20">
                                                @error('old_password')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="newpassword"
                                                    class="form-label">{{ __('New Password') }}</label>
                                                <input type="password" class="form-control" id="newpassword"
                                                    name="new_password" placeholder="Enter new password" required
                                                    autocomplete="off" minlength="6" maxlength="20">
                                                @error('new_password')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password-confirm"
                                                    class="form-label">{{ __('Confirm Password') }}</label>
                                                <input type="password" class="form-control" id="password-confirm"
                                                    name="password_confirmation" required autocomplete="off"
                                                    minlength="6" maxlength="20">
                                                @error('password_confirmation')
                                                    <span class="text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="mt-4 d-grid">
                                                <button class="btn btn-primary waves-effect waves-light"
                                                    type="submit">{{ __('Submit') }}</button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Already have an account ? <a href="{{ route('login') }}"
                                                    class="fw-medium text-primary"> Login</a> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> GIZMOGUL. Crafted with <i
                                            class="mdi mdi-heart text-danger"></i> by GIZMOGUL
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

    <!-- validation init -->
    <script src="{{ asset('/assets/js/pages/validation.init.js') }}"></script>

    <!-- auth-2-carousel init -->
    <script src="{{ asset('/assets/js/pages/auth-2-carousel.init.js') }}"></script>
</body>

</html>
