{{-- @extends('Admin.layouts.app')
@section('title', __('employees'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('employees')</h4>

                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">
                                    <a href="{{ route('Office.Employee.create') }}" class="btn btn-primary btn-sm"><i
                                            class="bi bi-plus-circle"></i>
                                        @lang('Add New') </a>
                                </h4>
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons" class="table  table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Name')</th>
                                                <th scope="col">@lang('Email')</th>
                                                <th scope="col">@lang('phone')</th>
                                                <th scope="col">@lang('city')</th>
                                                <th scope="col">@lang('role name')</th>
                                                <th scope="col">@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employee)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $employee->UserData->name ?? '' }}</td>
                                                    <td>{{ $employee->UserData->email ?? '' }}</td>
                                                    <td>{{ $employee->UserData->phone ?? '' }}</td>
                                                    <td>{{ $employee->CityData->name ?? '' }}</td>
                                                    <td>{{ $employee->UserData->roles[0]->name ?? '' }}</td>
                                                    <td>
                                                        <a href="{{ route('Office.Employee.edit', $employee->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $employee->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">
                                                            @lang('Delete')
                                                        </a>
                                                        <form id="delete-form-{{ $employee->id }}"
                                                            action="{{ route('Office.Employee.destroy', $employee->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
@endsection --}}

@extends('Admin.layouts.app')

@section('title', __('Projects'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Employee.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Employees')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Employees') </h5>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                            aria-controls="DataTables_Table_0"></label></div>
                            </div>

                            <div class="col-8">

                                <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                    <div
                                        class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                        <div class="dt-buttons btn-group flex-wrap d-flex">
                                            <div class="btn-group">
                                                <button onclick="exportToExcel()"
                                                    class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                    tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                    aria-haspopup="dialog" aria-expanded="false"><span>
                                                        <i class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            @if (Auth::user()->hasPermission('create-employee-account'))
                                            <div class="btn-group">
                                                <a href="{{ route('Employee.Employee.create') }}" class="btn btn-primary">
                                                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                            class="d-none d-sm-inline-block">@lang('Add New Employee')</span></span>
                                                </a>

                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th >@lang('Name')</th>
                                <th >@lang('Email')</th>
                                <th >@lang('phone')</th>
                                {{-- <th >@lang('city')</th>
                                <th >@lang('role name')</th> --}}
                                <th >@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($employees as $employee)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                    <td>{{ $employee->UserData->name ?? '' }}</td>
                                    <td>{{ $employee->UserData->email ?? '' }}</td>
                                    <td>{{ $employee->UserData->phone ?? '' }}</td>
                                    {{-- <td>{{ $employee->CityData->name ?? '' }}</td>
                                    <td>{{ $employee->UserData->roles[0]->name ?? '' }}</td> --}}

                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('show-employee-account'))
                                                <a class="dropdown-item"
                                                    href="{{ route('Employee.Employee.show', $employee->id) }}">@lang('Show')</a>
                                                @endif
                                                    @if (Auth::user()->hasPermission('delete-employee-account'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Employee.Employee.edit', $employee->id) }}">@lang('Edit')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('delete-employee-account'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $employee->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $employee->id }}"
                                                        action="{{ route('Employee.Employee.destroy', $employee->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="4">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <span class="alert-icon text-danger me-2">
                                            <i class="ti ti-ban ti-xs"></i>
                                        </span>
                                        @lang('No Data Found!')
                                    </div>
                                </td>
                            @endforelse



                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    @push('scripts')
        <script>
            function exportToExcel() {
                // Get the table by ID
                var table = document.getElementById('table');


                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('properties')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection


