@extends('Admin.layouts.app')

@section('title', __('Projects'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Employee.home') }}" class="text-muted fw-light">@lang('dashboard')
                            /</a>
                        @lang('Projects')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Projects') </h5>
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
                                                    class="btn btn-outline-primary btn-sm waves-effect me-2"
                                                    type="button"><span><i
                                                            class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                            class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if (Auth::user()->hasPermission('create-project'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Employee.Project.create') }}">@lang('Add New Project')</a>
                                                        </li>
                                                    @endif
                                                    @if (Auth::user()->hasPermission('create-building'))
                                                        {{-- <li><a class="dropdown-item"
                                                                href="{{ route('Employee.Property.create') }}">@lang('Add new property')</a>
                                                        </li> --}}
                                                    @endif


                                                    @if (Auth::user()->hasPermission('create-unit'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Employee.Unit.create') }}">@lang('Add unit')</a>
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
                                {{-- <th>#</th> --}}
                                <th>@lang('project name')</th>
                                <th>@lang('city')</th>
                                <th>@lang('Number Properties')</th>
                                <th>@lang('Number units')</th>

                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($Projects as $index => $project)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                    <td>{{ $project->name ?? '' }}</td>
                                    <td>{{ $project->CityData->name ?? '' }}</td>
                                    <td> {{ $project->PropertiesProject->count() }} </td>
                                    <td> {{ $project->UnitsProject->count() }} </td>

                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <a class="dropdown-item"
                                                    href="{{ route('Employee.Project.show', $project->id) }}">@lang('Show')</a>
                                                @if (Auth::user()->hasPermission('read-project'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Employee.Project.edit', $project->id) }}">@lang('Edit')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('delete-project'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $project->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $project->id }}"
                                                        action="{{ route('Employee.Project.destroy', $project->id) }}"
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
                XLSX.writeFile(wb, @json(__('Projects')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
