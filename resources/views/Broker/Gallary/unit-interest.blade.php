@extends('Admin.layouts.app')

@section('title', __('Requests for interest'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Requests for interest')</h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('Broker.Gallary.showInterests') }}" class="row" method="GET"
                        id="interestsForm">


                        <div class="col-12 col-md-4 mb-3">
                            <span>@lang('status')</span>
                            <select class="form-select form-control-sm" id="status_filter" name="status_filter"
                                onchange="reloadInterests()">
                                <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>
                                    @lang('All')</option>
                                @foreach ($interestsTypes as $interestsType)
                                    <option value="{{ __($interestsType->id) }}"
                                        {{ $statusFilter == $interestsType->id ? 'selected' : '' }}>
                                        {{ __($interestsType->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <span>@lang('Project')</span>
                            <select class="form-select form-control-sm " id="prj_filter" required="" name="prj_filter"
                                style="width:95%!important" onchange="reloadInterests()">
                                <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>
                                    @lang('All')</option>
                                @foreach ($unitInterests as $unitInterest)
                                    @if ($unitInterest->PropertyData && $unitInterest->PropertyData->ProjectData)
                                        <option value="{{ $unitInterest->PropertyData->ProjectData->id }}"
                                            {{ $projectFilter == $unitInterest->PropertyData->ProjectData->id ? 'selected' : '' }}>
                                            {{ $unitInterest->PropertyData->ProjectData->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <span>@lang('property')</span>
                            <select class="form-select form-control-sm" id="prop_filter" required="" name="prop_filter"
                                style="width:95%!important" onchange="reloadInterests()">
                                <option value="all" {{ $propFilter == 'all' ? 'selected' : '' }}>
                                    @lang('All')</option>
                                @foreach ($unitInterests as $unitInterest)
                                    @if ($unitInterest->PropertyData)
                                        <option value="{{ $unitInterest->PropertyData->id }}"
                                            {{ $propFilter == $unitInterest->PropertyData->id ? 'selected' : '' }}>
                                            {{ $unitInterest->PropertyData->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <span>@lang('Unit')</span>
                            <select class="form-select form-control-sm" id="unit_filter" required="" name="unit_filter"
                                style="width:95%!important" onchange="reloadInterests()">
                                <option value="all" {{ $unitFilter == 'all' ? 'selected' : '' }}>
                                    @lang('All')</option>
                                @foreach ($unitInterests->unique('number_unit') as $unitInterest)
                                    @if ($unitInterest->unit)
                                        <option value="{{ $unitInterest->unit->id }}"
                                            {{ $unitFilter == $unitInterest->unit->id ? 'selected' : '' }}>
                                            {{ $unitInterest->unit->number_unit }}
                                        </option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="col-12 col-md-4 mb-3">
                            <span>@lang('Client Name')</span>
                            <select class="form-select form-control-sm" id="client_filter" required=""
                                name="client_filter" style="width:95%!important" onchange="reloadInterests()">
                                <option value="all" {{ $clientFilter == 'all' ? 'selected' : '' }}>
                                    @lang('All')</option>
                                @foreach ($unitInterests as $unitInterest)
                                    @if ($unitInterest->name)
                                        <option value="{{ $unitInterest->id }}"
                                            {{ $clientFilter == $unitInterest->id ? 'selected' : '' }}>
                                            {{ _($unitInterest->name) }}
                                        </option>
                                    @endif
                                @endforeach


                            </select>
                        </div>



                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">@lang('Filter')</button>
                            <a href="{{ route('Broker.Gallary.showInterests') }}"
                                class="btn btn-danger">@lang('Cancel')</a>
                        </div>

                    </form>
                </div>
            </div>
            <hr>
            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Requests for interest') </h5>
                    </div>

                    <div class="col-12">
                        <hr>
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
                                <th>@lang('Residential number')</th>
                                <th>@lang('property')</th>
                                <th>@lang('Client Name')</th>
                                <th>@lang('phone')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($unitInterests as $index => $client)
                                <tr>


                                    <td>{{ $client->unit->number_unit ?? '' }}</td>
                                    <td>{{ $client->unit->PropertyData->name ?? __('nothing') }}</td>
                                    <td> {{ $client->name }}</td>
                                    <td>+{{ $client->key_phone }} {{ $client->whatsapp }}</td>
                                    <td>
                                        @if (Auth::user()->hasPermission('update-requests-interest'))
                                            <form method="POST"
                                                action="{{ route('Broker.Interest.status.update', $client->id) }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $client->id }}">
                                                <select class="form-control select-input w-auto" name="status"
                                                    onchange="this.form.submit()">
                                                    @foreach ($interestsTypes as $interestsType)
                                                        <option value="{{ $interestsType->id }}"
                                                            {{ $client->status == $interestsType->id ? 'selected' : '' }}>
                                                            {{ __($interestsType->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="submit-from" hidden=""></button>
                                            </form>
                                        @endif


                                    </td>

                                    <td>
                                        <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light"
                                            data-toggle="modal" data-target="#shareLinkUnit{{ $client->id }}"
                                            href="tel:+{{ $client->key_phone }}{{ $client->whatsapp }}"
                                            onclick="document.querySelector('#shareLinkUnit{{ $client->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                            @lang('مكالمة')</a>
                                        <a href="https://web.whatsapp.com/send?phone=+{{ $client->key_phone }}{{ $client->whatsapp }}"
                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('محادثة(شات)')</a>


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
