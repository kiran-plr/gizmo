@extends('layouts.admin.master')
@section('title', 'GIZMOGUL || Users List')
@push('styles')
    <!-- DataTables -->
    <link href="{{ asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main-content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Users List</h4>
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
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" style="width: 60px;">Avatar</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Attached Locations</th>
                                        <th scope="col" style="width: 300px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $user->name }} </td>
                                            <td>
                                                <img src="{{ $user->avatar }}" alt="user-img"
                                                    class="rounded-circle avatar-xs" style="width: 35px;">
                                            </td>
                                            <td> {{ $user->role->name ?? '' }} </td>
                                            @php
                                                $locations = $user->locations
                                                    ->map(function ($location) {
                                                        return '<a href="' . route('admin.location.show', $location->id) . '">' . $location->name . '</a>';
                                                    })
                                                    ->implode(', ');
                                            @endphp
                                            <td>
                                                {!! $locations !!}
                                            </td>
                                            <td>
                                                <div class="action-button-wrapper">
                                                    <a href="{{ route('admin.user.login', $user->id) }}"
                                                        class="btn btn-primary btn-sm waves-effect waves-light"
                                                        role="button">Log in as user</a>
                                                    <a href="{{ route('admin.user.createOrEdit', $user->id) }}"
                                                        class="btn btn-info btn-sm waves-effect waves-light"
                                                        role="button"><i class="fas fa-edit"></i></a>
                                                    @if ($user->role->slug != 'admin')
                                                        <form action="{{ route('admin.user.delete', $user->id) }}"
                                                            class="delete-form" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm waves-effect waves-light deleteBtn"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </form>
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
    </div>
    <!-- container-fluid -->
@endsection
@push('scripts')
    <script src="{{ asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('.data-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": [5]
                }, {
                    "targets": [0, 1, 2, 3, 4, 5],
                    "className": "text-center",
                }],
                "order": [0, "desc"],
                "dom": 'l<"toolbar">frtip',
                initComplete: function() {
                    $("div.toolbar").html(
                        '<a href="{{ route('admin.user.createOrEdit') }}" role="button" class="btn btn-primary add-user-button">Add User</a>'
                    );
                }
            });

            $('.deleteBtn').on('click', function(e) {
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "Want to delete this user?",
                    icon: "error",
                    showCancelButton: !0,
                    cancelButtonColor: "#f46a6a",
                    cancelButtonText: "Cancel",
                    confirmButtonColor: "#34c38f",
                    confirmButtonText: "Submit",
                }).then(function(t) {
                    if (t.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
