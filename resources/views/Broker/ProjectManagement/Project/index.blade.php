@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-3">
                    <h4 class="">
                        <a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Projects')
                    </h4>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Projects')</h5>
                </div>
                {{-- <div class="col-3 py-1">
                    <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                        placeholder="@lang('search...')">
                </div> --}}
                <div class="card-datatable table-responsive">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="card-header border-top rounded-0 py-2">
                            <div class="row">
                                <div class="col-4 col-md-6">

                                    <div class="me-10 ms-n2 pe-10">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                <input id="SearchInput" class="form-control" placeholder="@lang('search...')"
                                                    aria-controls="DataTables_Table_0"></label></div>
                                    </div>
                                </div>
                                <div class="col-8 col-md-6">

                                    <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                        <div
                                            class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                            <div class="dt-buttons btn-group flex-wrap d-flex">
                                                <div class="btn-group">
                                                    <button onclick="exportToExcel()"
                                                        class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                        tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                        aria-haspopup="dialog" aria-expanded="false"><span>
                                                            <i class="ti ti-download me-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">Export</span></span></button>
                                                </div>
                                                {{-- <button class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                        <span class="d-none d-sm-inline-block">@lang('Add')</span></span></button> --}}

                                                <div class="btn-group">
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
                                                </div>
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
                                    <th>@lang('project name')</th>
                                    <th>@lang('city')</th>
                                    <th>@lang('Number Properties')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($Projects as $index => $project)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $project->name ?? '' }}</td>
                                        <td>{{ $project->CityData->name ?? '' }}</td>
                                        <td> {{ $project->PropertiesProject->count() }} </td>
                                        <td>

                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    <a class="dropdown-item"
                                                        href="{{ route('Broker.Project.show', $project->id) }}">@lang('Show')</a>
                                                    @if (Auth::user()->hasPermission('read-project'))
                                                        <a class="dropdown-item"
                                                            href="{{ route('Broker.Project.edit', $project->id) }}">@lang('Edit')</a>
                                                    @endif
                                                    @if (Auth::user()->hasPermission('delete-project'))
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $project->id }}')"
                                                            class="dropdown-item delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $project->id }}"
                                                            action="{{ route('Broker.Project.destroy', $project->id) }}"
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


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}







    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show the modal when the page is fully loaded
            var modal = document.getElementById('pendingPaymentModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'block';
                modal.removeAttribute('aria-hidden');
            }
        });
    </script>

    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Projects')) + '.xlsx');
            }
        </script>
    @endpush

@endsection
