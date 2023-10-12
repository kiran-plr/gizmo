@extends('layouts.vendor.master')
@section('title', 'GIZMOGUL || Gizmogul.com Drop Off Approve Process')
@push('styles')
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">New Trade-In</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">New Trade-In</a></li>
                            <li class="breadcrumb-item active">New Trade-In</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="create-shipment-form">
                    <livewire:vendor.create-shipment :categories="$categories">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
