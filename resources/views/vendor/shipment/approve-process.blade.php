@extends('layouts.vendor.master')
@section('title', 'GIZMOGUL | Drop Off Approve Process')
@push('styles')
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Gizmogul.com Drop Off Approve Process</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Gizmogul.com Drop Off Approve Process</a></li>
                            <li class="breadcrumb-item active">Gizmogul.com Drop Off Approve Process</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <livewire:vendor.shipment-approve-process :shipmentId="$id" />

    </div>
@endsection
@push('scripts')
@endpush
