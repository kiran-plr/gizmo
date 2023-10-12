@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Payouts List')
@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $status == 'draft' ? 'Pending' : ucfirst($status) }} Payout List
                    </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Payout </a></li>
                            <li class="breadcrumb-item active">{{ $status == 'draft' ? 'Pending' : ucfirst($status) }} List
                            </li>
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
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover table table-bordered data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Shipment No #</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Payout Method</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payouts as $key => $payout)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.shipment.show', $payout->shipment->id) }}">
                                                    {{ $payout->shipment->shipment_no }}
                                                </a>
                                            </td>
                                            <td> {{ $payout->user->name }} </td>
                                            <td> {{ $payout->user->email }} </td>
                                            <td> {{ $payout->userPayoutMethod->name }} </td>
                                            <td> ${{ number_format($payout->amount, 2) }} </td>
                                            <td>
                                                @if ($status == 'draft')
                                                    <a href="{{ route('admin.payout.checkout', $payout->id) }}"
                                                        class="btn btn-primary btn-sm">Process Payout</a>
                                                @endif
                                                <a href="{{ route('admin.payout.show', $payout->id) }}"
                                                    class="btn btn-info btn-sm">View</a>
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
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                "order": [0, "desc"]
            });
        });
    </script>
@endpush
