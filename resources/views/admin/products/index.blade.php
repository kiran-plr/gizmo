@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Products List')
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
                    <h4 class="mb-sm-0 font-size-18">Products</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                            <li class="breadcrumb-item active">List</li>
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

                        <div class="row">
                            <!-- Export Csv Button -->
                            <div class="float-right mb-3 button-flex">
                                <a href="{{ route('admin.product.export') }}" class="btn btn-primary">
                                    <i class="bx bx-download me-2"></i>Export CSV
                                </a>
                                {{-- <a href="javascript:;" class="btn btn-primary waves-effect waves-light">
                                    <i class="bx bx-download me-2"></i>Export CSV
                                </a> --}}
                            </div>

                            <!-- Import Csv Button -->
                            <div class="float-right mb-3 button-flex">

                                <button role="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target=".bs-import-csv-modal">
                                    <i class="bx bx-upload me-2"></i>Import CSV
                                </button>
                                <div class="modal fade bs-import-csv-modal" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form id="csv-upload-form" method="POST"
                                                action="{{ route('admin.product.import') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Select CSV File</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" name="csv"
                                                            id="csv-file">
                                                        @error('csv')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        <span id="csv_file_error"></span>
                                                        <span id="csv_file_type"></span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="sbumit-csv"
                                                        class="btn btn-primary">Import</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-hover table table-bordered data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Brand Name</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Attribute Family Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td> {{ $product->photo }} </td>
                                            <td> {{ $product->name }} </td>
                                            <td> {{ $product->category->name }} </td>
                                            <td> {{ $product->brand->name }} </td>
                                            <td> {{ $product->type }} </td>
                                            <td> {{ $product->attributeFamily->name }} </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle card-drop"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.product.createOrEdit', $product->id) }}">Edit</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.product.show', $product->id) }}">View</a>
                                                    </div>
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
    </div>
    @if (session()->has('importLog'))
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Log Import CSV.</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body log-message">
                        @foreach (session()->get('importLog') as $key => $productType)
                            @foreach ($productType as $type => $value)
                                <h3> {{ ucwords(str_replace('_', ' ', $key) . ' ' . $type) }} </h3>
                                <ul>
                                    @foreach ($value as $t => $v)
                                        <h5> {{ ucwords($t) }} </h4>
                                            @foreach ($v as $error)
                                                <li> {{ $error }} </li>
                                            @endforeach
                                    @endforeach
                                </ul>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script type="text/javascript">
        @if (session()->has('importLog'))
            $(window).on('load', function() {
                $('#myModal').modal('show');
            });
        @endif
        $(function() {
            $('.data-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                }, {
                    "targets": [0, 2, 3, 4, 5, 6],
                    "className": "text-center",
                }],
                "order": [0, "desc"],
            });


            $("#csv-upload-form").validate({
                errorClass: "invalid-feedback",
                validClass: "valid success-alert",
                rules: {
                    csv: {
                        required: true,
                    },
                },
                messages: {
                    csv: {
                        required: "Please select CSV file",
                    }
                }
            });

            $("#csv-file").change(function() {
                $("#csv_file_error").html("");
                $("#csv_file_type").html("");
                var file_size = $('#csv-file')[0].files[0].size;
                var fileType = $('#csv-file')[0].files[0].type;
                var validTypes = ['text/csv'];
                if (false == validTypes.includes(fileType)) {
                    $("#csv_file_type").html(
                        "<p style='color:#FF0000'>Please select valid file type - CSV</p>"
                    );
                    $('#sbumit-csv').prop('disabled', true);
                } else if (parseInt(file_size) >= 3000000) {
                    $("#csv_file_error").html(
                        "<p style='color:#FF0000'>Please upload file size is less than 3MB</p>");
                    $('#sbumit-csv').prop('disabled', true);
                } else if (parseInt(file_size) <= 3000000) {
                    $('#sbumit-csv').prop('disabled', false);
                } else {
                    $('#sbumit-csv').prop('disabled', false);
                }
            });
        });
    </script>
@endpush
