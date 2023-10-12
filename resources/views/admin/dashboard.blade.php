@extends('layouts.admin.master')

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
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
                                    <h5 class="text-primary">Welcome Back!</h5>
                                    <p>Dashboard</p>
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
                                            <h5 class="font-size-15">{{ $locationCount }}</h5>
                                            <p class="text-muted mb-0">Locations</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-15">${{ AppHelper::getCompletedShipmentRevenue() }}</h5>
                                            <p class="text-muted mb-0">Revenue</p>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <a href="javascript: void(0);"
                                            class="btn btn-primary waves-effect waves-light btn-sm">View
                                            Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Monthly Earning</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="text-muted">This month</p>
                                <h3>$34,252</h3>
                                <p class="text-muted"><span class="text-success me-2"> 12% <i class="mdi mdi-arrow-up"></i>
                                    </span> From previous period</p>

                                <div class="mt-4">
                                    <a href="javascript: void(0);"
                                        class="btn btn-primary waves-effect waves-light btn-sm">View More
                                        <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-4 mt-sm-0">
                                    <div id="radialBar-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mb-0">We craft digital, graphic and dimensional thinking.</p>
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
                                        <p class="text-muted fw-medium">Shipments</p>
                                        <h4 class="mb-0">{{ AppHelper::getCompletedShipmentsCount() }}</h4>
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
                                        <h4 class="mb-0">${{ number_format(AppHelper::getCompletedShipmentRevenue(), 2) }}
                                        </h4>
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
                                        <h4 class="mb-0">
                                            ${{ number_format(AppHelper::getCompletedShipmentAveragePrice(), 2) }}</h4>
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

                <!-- Chart -->
                <livewire:chart.apex-chart chartId="admin-dashboard-bar-chart" title="Pending Shipments"
                    table="shipments" key="admin-dashboard-bar-chart" />
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Social Source</h4>
                        <div class="text-center">
                            <div class="avatar-sm mx-auto mb-4">
                                <span class="avatar-title rounded-circle bg-primary bg-soft font-size-24">
                                    <i class="mdi mdi-facebook text-primary"></i>
                                </span>
                            </div>
                            <p class="font-16 text-muted mb-2"></p>
                            <h5><a href="javascript: void(0);" class="text-dark">Facebook - <span
                                        class="text-muted font-16">125 sales</span> </a></h5>
                            <p class="text-muted">Maecenas nec odio et ante tincidunt tempus. Donec
                                vitae sapien ut libero venenatis faucibus tincidunt.</p>
                            <a href="javascript: void(0);" class="text-primary font-16">Learn more <i
                                    class="mdi mdi-chevron-right"></i></a>
                        </div>
                        <div class="row mt-4">
                            <div class="col-4">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-primary font-size-16">
                                            <i class="mdi mdi-facebook text-white"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-15">Facebook</h5>
                                    <p class="text-muted mb-0">125 sales</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-info font-size-16">
                                            <i class="mdi mdi-twitter text-white"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-15">Twitter</h5>
                                    <p class="text-muted mb-0">112 sales</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="social-source text-center mt-3">
                                    <div class="avatar-xs mx-auto mb-3">
                                        <span class="avatar-title rounded-circle bg-pink font-size-16">
                                            <i class="mdi mdi-instagram text-white"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-15">Instagram</h5>
                                    <p class="text-muted mb-0">104 sales</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Activity</h4>
                        <ul class="verti-timeline list-unstyled">
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">22 Nov <i
                                                class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            Responded to need “Volunteer Activities
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">17 Nov <i
                                                class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            Everyone realizes why a new common language would be
                                            desirable... <a href="javascript: void(0);">Read more</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list active">
                                <div class="event-timeline-dot">
                                    <i class="bx bxs-right-arrow-circle font-size-18 bx-fade-right"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">15 Nov <i
                                                class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            Joined the group “Boardsmanship Forum”
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="event-list">
                                <div class="event-timeline-dot">
                                    <i class="bx bx-right-arrow-circle font-size-18"></i>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <h5 class="font-size-14">12 Nov <i
                                                class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ms-2"></i>
                                        </h5>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>
                                            Responded to need “In-Kind Opportunity”
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center mt-4"><a href="javascript: void(0);"
                                class="btn btn-primary waves-effect waves-light btn-sm">View More <i
                                    class="mdi mdi-arrow-right ms-1"></i></a></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Top Performing Locations</h4>

                        <div class="text-center">
                            <div class="mb-4">
                                <i class="bx bx-map-pin text-primary display-4"></i>
                            </div>
                            <h3>{{ $topFiveLocations[0]['count'] }}</h3>
                            <p>{{ $topFiveLocations[0]['name'] }}</p>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table align-middle table-nowrap">
                                <tbody>
                                    @foreach ($topFiveLocations as $key => $location)
                                        <tr>
                                            <td style="width: 30%">
                                                <p class="mb-0">{{ $location['name'] }}</p>
                                            </td>
                                            <td style="width: 25%">
                                                <h5 class="mb-0">{{ $location['count'] }}</h5>
                                            </td>
                                            <td>
                                                <div class="progress bg-transparent progress-sm">
                                                    @if ($location['count'] / 10 > 10)
                                                        <div class="progress-bar bg-primary rounded" role="progressbar"
                                                            style="width: {{ $location['count'] / 10 }}%"
                                                            aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="{{ $location['count'] / 10 }}">
                                                        </div>
                                                    @else
                                                        <div class="progress-bar bg-warning rounded" role="progressbar"
                                                            style="width: {{ $location['count'] / 10 }}%"
                                                            aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="{{ $location['count'] / 10 }}">
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Latest Shipments</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
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
                                    @foreach ($shipments->limit(5)->get() as $shipment)
                                        <tr>
                                            <td><a href="{{ route('admin.shipment.show', $shipment->id) }}"
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
                                                @if ($shipment->status == 'pending')
                                                    <span class="badge badge-pill badge-soft-warning font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'approved')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'shipped')
                                                    <span class="badge badge-pill badge-soft-secondary font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'delivered')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'received')
                                                    <span class="badge badge-pill badge-soft-info font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'completed')
                                                    <span class="badge badge-pill badge-soft-success font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 're-packaged')
                                                    <span class="badge badge-pill badge-soft-primary font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'please-ship')
                                                    <span class="badge badge-pill badge-soft-pink font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @elseif($shipment->status == 'cancel')
                                                    <span class="badge badge-pill badge-soft-danger font-size-11">
                                                        {{ ucfirst($shipment->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($shipment->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off <br>
                                                    @if ($shipment->location)
                                                        <a
                                                            href="{{ route('admin.location.show', $shipment->location_id) }}">{{ $shipment->location->name }},
                                                            {{ $shipment->location->city }},
                                                            {{ $shipment->location->state }}</a>
                                                    @endif
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a role="button"
                                                    href="{{ route('admin.shipment.show', $shipment->id) }}"
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
    <!-- dashboard init -->
    <script src="{{ asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endpush
