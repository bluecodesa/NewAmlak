@extends('Admin.layouts.app')

@section('title', __('properties'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('properties')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('properties') </h5>
                        <hr>
                    </div>
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
                                            @if (Auth::user()->hasPermission('create-building'))
                                                <div class="btn-group">
                                                    <a href="{{ route('Broker.Property.create') }}" class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add new property')</span></span>
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
                                <th>@lang('property name')</th>
                                <th>@lang('city')</th>
                                {{-- <th>@lang('location')</th> --}}
                                <th>@lang('Property type')</th>
                                <th>@lang('Type use')</th>
                                <th>@lang('owner name')</th>
                                {{-- <th>@lang('Instrument number')</th> --}}
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($properties as $index => $property)
                                <tr>

                                    <td>{{ $property->name ?? '' }}</td>
                                    <td>{{ $property->CityData->name ?? '' }}</td>
                                    {{-- <td>{{ $property->location ?? '' }}</td> --}}
                                    <td>{{ $property->PropertyTypeData->name ?? '' }}</td>
                                    <td>{{ $property->PropertyUsageData->name ?? '' }}</td>
                                    <td>{{ $property->OwnerData->name ?? '' }}</td>
                                    {{-- <td>{{ $property->instrument_number ?? '' }}</td> --}}

                                    <td>

                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('create-unit'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Broker.Property.CreateUnit', $property->id) }}"
                                                        class="btn btn-outline-dark btn-sm waves-effect waves-light">@lang('Add units')</a>
                                                @endif
                                                <a class="dropdown-item"
                                                    href="{{ route('Broker.Property.show', $property->id) }}"
                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>
                                                @if (Auth::user()->hasPermission('update-building'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Broker.Property.edit', $property->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('delete-building'))
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $property->id }}')"
                                                        class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $property->id }}"
                                                        action="{{ route('Broker.Property.destroy', $property->id) }}"
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
                                <td colspan="6">
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
