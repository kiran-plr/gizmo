@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Location View')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Location View</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Location</a></li>
                            <li class="breadcrumb-item active">Location View</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-truncate font-size-15">{{ $location->name }}</h5>
                                <p class="text-muted">
                                    {{ $location->address . ', ' . $location->city . ', ' . $location->state . ', ' . $location->zip }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Shipments</p>
                                        <h4 class="mb-0">{{ $location->shipments()->count() }}</h4>
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
                                        <h4 class="mb-0">$35, 723</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
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
                                        <h4 class="mb-0">$16.2</h4>
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Monthly Sales</h4>
                                <div id="overview-chart" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Top Selling Product</h4>

                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="bx bx-map-pin text-primary display-4"></i>
                                    </div>
                                    <h3>1,456</h3>
                                    <p>San Francisco</p>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table align-middle table-nowrap">
                                        <tbody>
                                            <tr>
                                                <td style="width: 30%">
                                                    <p class="mb-0">San Francisco</p>
                                                </td>
                                                <td style="width: 25%">
                                                    <h5 class="mb-0">1,456</h5>
                                                </td>
                                                <td>
                                                    <div class="progress bg-transparent progress-sm">
                                                        <div class="progress-bar bg-primary rounded" role="progressbar"
                                                            style="width: 94%" aria-valuenow="94" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="mb-0">Los Angeles</p>
                                                </td>
                                                <td>
                                                    <h5 class="mb-0">1,123</h5>
                                                </td>
                                                <td>
                                                    <div class="progress bg-transparent progress-sm">
                                                        <div class="progress-bar bg-success rounded" role="progressbar"
                                                            style="width: 82%" aria-valuenow="82" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="mb-0">San Diego</p>
                                                </td>
                                                <td>
                                                    <h5 class="mb-0">1,026</h5>
                                                </td>
                                                <td>
                                                    <div class="progress bg-transparent progress-sm">
                                                        <div class="progress-bar bg-warning rounded" role="progressbar"
                                                            style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Assigned Users</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap">
                                <tbody>
                                    @foreach ($location->users as $key => $user)
                                        <tr>
                                            <td style="width: 50px;">
                                                <img src="{{ $user->avatar }}" class="rounded-circle avatar-xs"
                                                    alt="">
                                            </td>
                                            <td>
                                                <h5 class="font-size-14 m-0"><a href="javascript: void(0);"
                                                        class="text-dark">{{ $user->name }}</a></h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-block" data-bs-toggle="modal"
                                data-bs-target=".assign-userModal">Assign User</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Shipments</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="align-middle">Shipment ID #</th>
                                        <th class="align-middle">Billing Name</th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Total</th>
                                        <th class="align-middle">Status</th>
                                        <th class="align-middle">Shipping Method</th>
                                        <th class="align-middle">View Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($location->shipments as $shipment)
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
                                                <span
                                                    class="badge badge-pill badge-soft-success font-size-11">{{ ucfirst($shipment->status) }}</span>
                                            </td>
                                            <td>
                                                @if ($shipment->shipment_type == 1)
                                                    <i class="fas fa-people-carry"></i> Drop-off
                                                @else
                                                    <i class="fas fa-barcode"></i> Ship
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a role="button"
                                                    href="{{ route('admin.shipment.show', $shipment->id) }}"
                                                    class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target=".transaction-detailModal">
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
    <!-- Assign user Modal -->
    <div id="assign_user" class="modal fade assign-userModal" tabindex="-1" role="dialog"
        aria-labelledby="assign-userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.location.assign-user', $location->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="assign-userModalLabel">Assign User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="user">Select User</label>
                        </div>
                        <div class="col-md-12">
                            <select id="user_id" class="select2 form-control select2-multiple" multiple="multiple"
                                style="width: 80%" data-placeholder="Select user to assign location..." name="user_id[]"
                                required>
                                @foreach ($users as $user)
                                    @if ($user->role && $user->role->slug == 'vendor')
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('user_id', [])) || (isset($location) && $location->users->contains($user->id)) ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal -->
@endsection

@push('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('/assets/js/pages/project-overview.init.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                dropdownParent: $('#assign_user'),
                width: 'resolve',
            }).width();
        });
    </script>
@endpush
