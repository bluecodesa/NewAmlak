@extends('Admin.layouts.app')
@section('title', __('properties'))
@section('content')


    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-3">
                    <h4 class="">
                        <a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('properties')
                    </h4>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('properties')</h5>
                </div>
                {{-- <div class="col-3 py-1">
                    <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                        placeholder="@lang('search...')">
                </div> --}}
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header border-top rounded-0 py-2">
                            <div class="row">
                                <div class="col-6">

                                    <div class="me-5 ms-n2 pe-5">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
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
                                                            <i class="ti ti-download me-1 ti-xs"></i><span class="d-none d-sm-inline-block">Export</span></span></button>
                                                        </div>
                                                        @if (Auth::user()->hasPermission('create-building'))
                                                        <a href="{{ route('Broker.Property.create') }}" class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                        <span class="d-none d-sm-inline-block">@lang('Add new property')</span></span></a>
                                                        @endif

                                                {{-- <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (Auth::user()->hasPermission('create-project'))
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('Broker.Project.create') }}">@lang('Add New Project')</a>
                                                            </li>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('create-building'))
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('Broker.Property.create') }}">@lang('Add new property')</a>
                                                            </li>
                                                        @endif
                                                        @if (Auth::user()->hasPermission('create-unit'))
                                                            <li><a class="dropdown-item"
                                                                    href="{{ route('Broker.Unit.create') }}">@lang('Add unit')</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table" id="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
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
                            <tbody>
                                @foreach ($properties as $index => $property)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
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
                                                    <a class="dropdown-item" href="{{ route('Broker.Property.CreateUnit', $property->id) }}"
                                                        class="btn btn-outline-dark btn-sm waves-effect waves-light">@lang('Add units')</a>
                                                @endif
                                                <a class="dropdown-item" href="{{ route('Broker.Property.show', $property->id) }}"
                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>
                                                @if (Auth::user()->hasPermission('update-building'))
                                                    <a class="dropdown-item" href="{{ route('Broker.Property.edit', $property->id) }}"
                                                        class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('delete-building'))
                                                    <a class="dropdown-item"  href="javascript:void(0);"
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
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->
    </div>




    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('properties')) + '.xlsx');
            }
        </script>

        <script>
            function exportToExcel2() {
                var wb = XLSX.utils.table_to_book(document.getElementById('DataTables_Table_0'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Record Deleted subscriptionTypes')) + '.xlsx');
            }
        </script>
    @endpush

@endsection
