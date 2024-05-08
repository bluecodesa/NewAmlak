@extends('Admin.layouts.app')

@section('title', __('Users'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Users')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->


            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Users') </h5>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                            aria-controls="DataTables_Table_0"></label></div>
                            </div>

                            <div class="col-6">
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
                                                    @if (Auth::user()->hasPermission('create-users'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Admin.users.create') }}">@lang('Add New Admin')</a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
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
                                <th scope="col">#</th>
                                <th scope="col">@lang('Name')</th>
                                <th scope="col">@lang('Email')</th>
                                <th scope="col">@lang('Roles')</th>
                                <th scope="col">@lang('sections')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{ app()->getLocale() == 'ar' ? $user->roles[0]->name_ar : $user->roles[0]->name ?? '' }}

                                    </td>
                                    <td class="align-middle">
                                        @foreach ($user->getAllPermissions()->unique('section_id') as $permission)
                                            <span class="badge bg-primary">{{ $permission->SectionDate->name ?? '' }}</span>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('view-users-file'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.users.show', $user->id) }}">@lang('Show')</a>
                                                @endif

                                                @if (Auth::user()->hasPermission('update-users'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.users.edit', $user->id) }}">@lang('Edit')</a>
                                                @endif

                                                @if (Auth::user()->hasPermission('delete-users'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $user->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('Admin.users.destroy', $user->id) }}"
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
                                <td colspan="5">
                                    <span class="text-danger">
                                        <strong>No User Found!</strong>
                                    </span>
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

                // Remove the last <td> from each row
                var rows = table.rows;
                for (var i = 0; i < rows.length; i++) {
                    rows[i].deleteCell(-1); // Deletes the last cell (-1) from each row
                }

                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Users')) + '.xlsx');
            }
        </script>
    @endpush
@endsection
