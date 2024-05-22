@extends('Admin.layouts.app')

@section('title', __('Roles'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Roles')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Roles') </h5>
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
                                @if (Auth::user()->hasPermission('create-role'))
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
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (Auth::user()->hasPermission('create-role'))
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('Admin.roles.CreateUser') }}">@lang('Add New Role User')</a>
                                                            </li>
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('Admin.roles.create') }}">@lang('Add New Role Admin')</a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>@lang('Name')</th>
                                <th>@lang('Role type')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($roles as $index=> $role)
                                <tr>
                                    {{-- <th>{{ $index + 1 }}</th> --}}
                                    <td>{{ app()->getLocale() == 'ar' ? $role->name_ar : $role->name }}
                                    </td>
                                    <td>{{ __($role->type) }}</td>
                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('view-role'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.roles.show', $role->id) }}">@lang('Show')</a>
                                                @endif

                                                @if (Auth::user()->hasPermission('view-role'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.roles.edit', $role->id) }}">@lang('Edit')</a>
                                                @endif

                                                @if (Auth::user()->hasPermission('delete-role'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $role->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $role->id }}"
                                                        action="{{ route('Admin.roles.destroy', $role->id) }}"
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
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');

                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
