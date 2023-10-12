@extends('layouts.vendor.master')

@push('styles')
@endpush

@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor</a></li>
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
                                    <p>Last logged in {{ $user->last_login_at }}</p>
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
                                    @if ($user->avatar && \File::exists(public_path('/users/avatar/' . $user->avatar)))
                                        <img src="{{ asset('users/avatar/' . $user->avatar) }}" alt=""
                                            class="img-thumbnail rounded-circle width-70">
                                    @else
                                        <img class="img-thumbnail rounded-circle"
                                            src="{{ asset('/assets/images/users/avatar-1.jpg') }}" alt="Avatar">
                                    @endif
                                </div>
                                <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                                <p class="text-muted mb-0 text-truncate">{{ $user->email }}</p>
                            </div>

                            <div class="col-sm-8">
                                <div class="pt-4">

                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{ request()->user()->locationCount }}</h5>
                                            <p class="text-muted mb-0">Locations</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-15">${{ number_format($commission, 2) }}</h5>
                                            <p class="text-muted mb-0">Revenue</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="javascript: void(0);"
                                            class="btn btn-primary waves-effect waves-light btn-sm">My
                                            Locations <i class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Earnings</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="text-muted">Total Commission</p>
                                <h3>${{ number_format($commission, 2) }}</h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-4 mt-sm-0">
                                    <div id="radialBar-chart" class="apex-charts"></div>
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
                                        <p class="text-muted fw-medium">Trade-Ins</p>
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
                                        <p class="text-muted fw-medium">Revenue</p>
                                        <h4 class="mb-0">${{ number_format($commission, 2) }}</h4>
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
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Average Price</p>
                                        <h4 class="mb-0">${{ number_format($shipmentAveragePrice, 2) }}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <livewire:chart.apex-chart chartId="vendor-dashboard-bar-chart" title="Trade-Ins" table="shipments"
                    key="vendor-dashboard-bar-chart" />
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Items to Ship</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check font-size-16 align-middle">
                                                <input class="form-check-input" type="checkbox" id="transactionCheck01">
                                                <label class="form-check-label" for="transactionCheck01"></label>
                                            </div>
                                        </th>
                                        <th class="align-middle">Shipment No #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Total</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Shipping Method</th>
                                        <th class="align-middle">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shipments as $item)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="transactionCheck02">
                                                    <label class="form-check-label" for="transactionCheck02"></label>
                                                </div>
                                            </td>
                                            <td><a href="javascript: void(0);"
                                                    class="text-body fw-bold">#{{ $item->shipment_no }}</a>
                                            </td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                {{ date('m/d/Y, g:ia', strtotime($item->created_at)) }}
                                            </td>
                                            <td>
                                                ${{ number_format($item->total, 2) }}
                                            </td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="badge badge-pill badge-soft-warning font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'approved')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'shipped')
                                                    <span class="badge badge-pill badge-soft-secondary font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'delivered')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'received')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'completed')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 're-packaged')
                                                    <span class="badge badge-pill badge-soft-primary font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'please-ship')
                                                    <span class="badge badge-pill badge-soft-pink font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'cancel')
                                                    <span class="badge badge-pill badge-soft-danger font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off <br />
                                                    <span>
                                                        {{ $item->location->name }},
                                                        {{ $item->location->city }},
                                                        {{ $item->location->state }}
                                                    </span>
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a role="button"
                                                    href="{{ route('vendor.shipment.show', $item->id) }}"
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Incoming Trade-Ins</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check font-size-16 align-middle">
                                                <input class="form-check-input" type="checkbox" id="transactionCheck01">
                                                <label class="form-check-label" for="transactionCheck01"></label>
                                            </div>
                                        </th>
                                        <th class="align-middle">Trade-Ins No #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Total</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Shipping Method</th>
                                        <th class="align-middle">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tradIns as $item)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="transactionCheck02">
                                                    <label class="form-check-label" for="transactionCheck02"></label>
                                                </div>
                                            </td>
                                            <td><a href="javascript: void(0);"
                                                    class="text-body fw-bold">#{{ $item->shipment_no }}</a>
                                            </td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>
                                                {{ date('m/d/Y, g:ia', strtotime($item->created_at)) }}
                                            </td>
                                            <td>
                                                ${{ number_format($item->total, 2) }}
                                            </td>
                                            <td>
                                                @if ($item->status == 'pending')
                                                    <span class="badge badge-pill badge-soft-warning font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'approved')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'shipped')
                                                    <span class="badge badge-pill badge-soft-secondary font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'delivered')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'received')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'completed')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 're-packaged')
                                                    <span class="badge badge-pill badge-soft-primary font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'please-ship')
                                                    <span class="badge badge-pill badge-soft-pink font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @elseif($item->status == 'cancel')
                                                    <span class="badge badge-pill badge-soft-danger font-size-11">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off <br />
                                                    <span>
                                                        {{ $item->location->name }},
                                                        {{ $item->location->city }},
                                                        {{ $item->location->state }}
                                                    </span>
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a role="button"
                                                    href="{{ route('vendor.shipment.trade-ins.show', $item->id) }}"
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

    </div>
    <!-- container-fluid -->
@endsection


@push('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        var revenue = {{ number_format($commission / 5000, 2) }};

        var options = {
            chart: {
                height: 200,
                type: "radialBar",
                offsetY: -10
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    dataLabels: {
                        name: {
                            fontSize: "13px",
                            color: void 0,
                            offsetY: 60
                        },
                        value: {
                            offsetY: 22,
                            fontSize: "16px",
                            color: void 0,
                            formatter: function(e) {
                                return e + "%";
                            },
                        },
                    },
                },
            },
            colors: ["#556ee6"],
            fill: {
                type: "gradient",
                gradient: {
                    shade: "dark",
                    shadeIntensity: 0.15,
                    inverseColors: !1,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91],
                },
            },
            stroke: {
                dashArray: 4
            },
            series: [revenue],
            labels: ["Progress to Gold Level"],
        };
        (chart = new ApexCharts(
            document.querySelector("#radialBar-chart"),
            options
        )).render();
    </script>
@endpush
