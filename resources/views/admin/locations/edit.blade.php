@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Location Edit')
@push('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $location ? 'Edit Location' : 'Create New' }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                            <li class="breadcrumb-item active">{{ $location ? 'Edit Location' : 'Create New' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ $location ? 'Edit Location' : 'Create New Location' }}</h4>
                        <form id="LocationForm" class="needs-validation" method="POST" enctype="multipart/form-data"
                            action="{{ route('admin.location.store', $location ? ['id' => $location->id] : '') }}"
                            novalidate>
                            @csrf
                            <div class="row mb-4">
                                <label for="" class="col-form-label col-lg-2">Location Name</label>
                                <div class="col-lg-10">
                                    <input id="" name="name" type="text" class="form-control"
                                        placeholder="Enter Location Name..." required maxlength="30"
                                        value="{{ $location->name ?? old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="email" class="col-form-label col-lg-2">Location Email</label>
                                <div class="col-lg-10">
                                    <input id="email" name="email" type="email" class="form-control"
                                        placeholder="Enter Location Email..." required maxlength="70"
                                        {{ $location ? 'readonly' : '' }}
                                        value="{{ $location->email ?? old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="address" class="col-form-label col-lg-2">Location Address</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="address" name="address" rows="2" placeholder="Enter Location Address..."
                                        required maxlength="155">{{ $location->address ?? old('address') }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="address2" class="col-form-label col-lg-2">Location Address 2</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="address2" rows="2" name="address2" placeholder="Enter Location Address 2..."
                                        maxlength="155">{{ $location->address2 ?? old('address2') }}</textarea>
                                    @error('address2')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="city" class="col-form-label col-lg-2">Location City</label>
                                <div class="col-lg-10">
                                    <input id="city" name="city" type="text" class="form-control"
                                        placeholder="Enter Location City..." required maxlength="30"
                                        value="{{ $location->city ?? old('city') }}">
                                    @error('city')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="state" class="col-form-label col-lg-2">Location State</label>
                                <div class="col-lg-10">
                                    <input id="state" name="state" type="text" class="form-control"
                                        placeholder="Enter Location State..." required maxlength="30"
                                        value="{{ $location->state ?? old('state') }}">
                                    @error('state')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="zip" class="col-form-label col-lg-2">Location Zip</label>
                                <div class="col-lg-10">
                                    <input id="zip" name="zip" type="number" class="form-control"
                                        placeholder="Enter Location Zip..." required
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="8" value="{{ $location->zip ?? old('zip') }}">
                                    @error('zip')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="phone" class="col-form-label col-lg-2">Location Phone</label>
                                <div class="col-lg-10">
                                    <input id="phone" name="phone" type="number" class="form-control"
                                        placeholder="Enter Location Phone..." required
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        maxlength="10" value="{{ $location->phone ?? old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="hours_of_opration" class="col-form-label col-lg-2">Location Hours of
                                    Operation</label>
                                <div class="col-lg-10">
                                    <input id="hours_of_opration" name="hours_of_opration" type="number"
                                        class="form-control" placeholder="Enter Location Hours of Operation..."
                                        value="{{ $location->hours_of_opration ?? old('hours_of_opration') }}">
                                    @error('hours_of_opration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="geo_lat" class="col-form-label col-lg-2">Location Geo Lat</label>
                                <div class="col-lg-10">
                                    <input id="geo_lat" name="geo_lat" type="number" class="form-control"
                                        placeholder="Enter Location Geo Lat..."
                                        value="{{ $location->geo_lat ?? old('geo_lat') }}">
                                    @error('geo_lat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="geo_lng" class="col-form-label col-lg-2">Location Geo Long</label>
                                <div class="col-lg-10">
                                    <input id="geo_lng" name="geo_lng" type="number" class="form-control"
                                        placeholder="Enter Location Geo Long..."
                                        value="{{ $location->geo_lng ?? old('geo_lng') }}">
                                    @error('geo_lng')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="geo_lng" class="col-form-label col-lg-2">Assign User</label>
                                <div class="col-lg-10">
                                    <select class="select2 form-control select2-multiple" multiple="multiple"
                                        data-placeholder="Select user to assign location..." name="user_id[]">
                                        @foreach ($users as $user)
                                            @if ($user->role && $user->role->slug == 'vendor')
                                                <option value="{{ $user->id }}"
                                                    {{ in_array($user->id, old('user_id', [])) || (isset($location) && $location->users->contains($user->id)) ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-lg-10">
                                    <button type="submit"
                                        class="btn btn-{{ $location ? 'success' : 'primary' }}">{{ $location ? 'Update Location' : 'Create Location' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
@endsection

@push('scripts')
    <!-- validation init -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $('#LocationForm').validate({
            errorClass: "invalid-feedback",
            validClass: "valid success-alert",
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                address: {
                    required: true,
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                zip: {
                    required: true
                },
                phone: {
                    required: true
                },
                geo_lat: {
                    required: true
                },
                geo_lng: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter location name."
                },
                email: {
                    required: "Please enter location email.",
                    email: "Please enter valid location email."
                },
                address: {
                    required: "Please enter location address."
                },
                city: {
                    required: "Please enter location city."
                },
                state: {
                    required: "Please enter location state."
                },
                zip: {
                    required: "Please enter location zip."
                },
                phone: {
                    required: "Please enter location phone."
                },
                geo_lat: {
                    required: "Please enter location geo lat."
                },
                geo_lng: {
                    required: "Please enter location geo long."
                }
            }
        });
    </script>
@endpush
