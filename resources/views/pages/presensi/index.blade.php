@extends('layouts.app')

@section('title', 'attendance')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3 mb-3">Tables</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col">
                        <a href="{{ route('attendances.create') }}" class="btn btn-primary px-3 ml-3">Tambah</a>
                    </div>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">DataTable Import</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Date</th>
                                    <th>LatLon In</th>
                                    <th>LatLon Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance as $user)
                                    <tr>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->time_in }}</td>
                                        <td>{{ $user->time_out }}</td>
                                        <td>{{ $user->date }}</td>
                                        <td>{{ $user->latlon_in }}</td>
                                        <td>{{ $user->latlon_out }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('attendances.edit', $user->id) }}'
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class='fadeIn animated bx bx-comment-edit'></i> Edit
                                                </a>
                                                <form action="{{ route('attendances.destroy', $user->id) }}" method="POST"
                                                    class="ml-2">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                        <i class="fadeIn animated bx bx-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>User ID</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Date</th>
                                    <th>LatLon In</th>
                                    <th>LatLon Out</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
