@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Add Or Edit User')
@push('styles')
    <link href="{{ asset('/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ asset('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $user ? 'Edit User' : 'Add User' }} </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                            <li class="breadcrumb-item active">{{ $user ? 'Edit User' : 'Add User' }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <form method="POST" action="{{ route('admin.user.store', $user->id ?? '') }}" class="form" id="user-form">
            @csrf
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Personal Information</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first_name"
                                            placeholder="Enter first name" name="first_name"
                                            value="{{ $user ? $user->first_name : old('first_name') }}">
                                        @error('first_name')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last_name"
                                            placeholder="Enter last name" name="last_name"
                                            value="{{ $user ? $user->last_name : old('last_name') }}">
                                        @error('last_name')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email address" autocomplete="off"
                                            value="{{ $user ? $user->email : old('email') }}"
                                            {{ $user ? 'readonly' : '' }}>
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if (!$user)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password<span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Enter password" autocomplete="off" name="password">
                                            @error('password')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password<span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="confirm_password"
                                                placeholder="Enter confirm password" autocomplete="off"
                                                name="confirm_password">
                                            @error('confirm_password')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter phone number"
                                            value="{{ $user ? $user->phone : old('phone') }}">
                                        @error('phone')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if (!$user || $user->hasRole('user'))
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="role" id="role">
                                                <option value="" disabled selected>Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $user && $role->id == $user->role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Basic Information</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address<span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" rows="3" name="address" class="form-control" id="address"
                                            placeholder="Enter address">{{ $user ? $user->address : old('address') }}</textarea>
                                        @error('address')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address2" class="form-label">Address2</label>
                                        <textarea type="text" rows="2" class="form-control" name="address2" id="address2">{{ $user ? $user->address2 : old('address2') }}</textarea>
                                        @error('address2')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="city" class="form-control" id="city"
                                            placeholder="Enter city" value="{{ $user ? $user->city : old('city') }}">
                                        @error('city')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="state" class="form-label">State<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="state" class="form-control" id="state"
                                            placeholder="Enter state" value="{{ $user ? $user->state : old('state') }}">
                                        @error('state')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="zip" class="form-label">Zip<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="zip" class="form-control" id="zip"
                                            placeholder="Enter zip code" value="{{ $user ? $user->zip : old('zip') }}">
                                        @error('zip')
                                            <span class="text-danger" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                                <button type="reset" class="btn btn-light w-md ms-2">Reset</button>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <!-- select 2 plugin -->
    <script src="{{ asset('/assets/libs/select2/js/select2.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('/assets/js/pages/ecommerce-select2.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Validtion Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // $('.form').on('submit', function(e) {
        //     e.preventDefault();
        // });
        $(document).ready(function() {
            $("#user-form").validate({
                errorClass: "text-danger error_message",
                validClass: "valid success-alert",
                rules: {
                    first_name: {
                        required: true,
                        lettersonly: true
                    },
                    last_name: {
                        required: true,
                        lettersonly: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        pwcheck: true,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    },
                    phone: {
                        required: true,
                    },
                    role: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    city: {
                        required: true,
                        lettersonly: true
                    },
                    state: {
                        required: true,
                        lettersonly: true
                    },
                    zip: {
                        required: true,
                        maxlength: 10,
                        minlength: 5,
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter first name",
                        lettersonly: "Only letters are allowed"
                    },
                    last_name: {
                        required: "Please enter last name",
                        lettersonly: "Only letters are allowed"
                    },
                    email: {
                        required: "Please enter email",
                        email: "The email should be in the format: abc@domain.tld"
                    },
                    password: {
                        required: "Please enter password",
                        pwcheck: "Enter passwords characters with uppercase letters, lowercase letters and at least one number and special Character"
                    },
                    confirm_password: {
                        required: "Your confirm password is required",
                        equalTo: "Password and confirm password should be same"
                    },
                    phone: {
                        required: "Please enter phone number",
                    },
                    role: {
                        required: "Please select role"
                    },
                    address: {
                        required: "Please enter address"
                    },
                    city: {
                        required: "Please enter city",
                        lettersonly: "Only letters are allowed"
                    },
                    state: {
                        required: "Please enter state",
                        lettersonly: "Only letters are allowed"
                    },
                    zip: {
                        required: "Please enter ZIP Code",
                        minlength: "Zip Code must be 5 digit in length",
                        maxlength: "Zip Code must be between 6 to 10 digits in length"
                    },
                }
            });
            $.validator.addMethod("pwcheck", function(value) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/.test(value) &&
                    /[a-z]/.test(value) && /\d/.test(value)
            });
        });
    </script>
@endpush
