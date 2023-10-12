@extends('layouts.user.master')

@push('styles')
@endpush
@section('title', 'GIZMOGUL || Dashboard')
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p>User Dashboard</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{ asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-md profile-user-wid mb-4">
                                    @if (auth()->user()->avatar && \File::exists(public_path('/users/avatar/' . auth()->user()->avatar)))
                                        <img src="{{ asset('users/avatar/' . auth()->user()->avatar) }}" alt=""
                                            class="img-thumbnail rounded-circle width-70">
                                    @else
                                        <img class="img-thumbnail rounded-circle"
                                            src="{{ asset('/assets/images/users/avatar-1.jpg') }}" alt="Avatar">
                                    @endif
                                </div>
                                <h5 class="font-size-15 text-truncate">{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-0 text-truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="col-sm-8">
                                <div class="pt-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">${{ number_format($totalAmountReceived, 2) }}</h5>
                                            <p class="text-muted mb-0">Amount Received</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Devices Traded-In</p>
                                        <h4 class="mb-0">{{ $tradeInsCount }}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Amount Received</p>
                                        <h4 class="mb-0">${{ number_format($totalAmountReceived, 2) }}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Trade-Ins</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">Trade-Ins ID #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Total</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Shipping Method</th>
                                        <th class="align-middle">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tradeIns as $shipment)
                                        <tr>
                                            <td>
                                                <a href="javascript: void(0);"
                                                    class="text-body fw-bold">#{{ $shipment->shipment_no }}</a>
                                            </td>
                                            <td>{{ $shipment->user->name }}</td>
                                            <td>
                                                {{ date('m/d/Y, g:ia', strtotime($shipment->created_at)) }}
                                            </td>
                                            <td>
                                                ${{ number_format($shipment->total, 2) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-pill badge-soft-success font-size-11">{{ ucfirst($shipment->status) }}</span>
                                            </td>
                                            <td>
                                                @if ($shipment->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off <br>
                                                    <span>
                                                        {{ $shipment->location->name }},
                                                        {{ $shipment->location->city }},
                                                        {{ $shipment->location->state }}
                                                    </span>
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a role="button" href="{{ route('user.shipment.show', $shipment->id) }}"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
@endsection
@push('scripts')
@endpush
