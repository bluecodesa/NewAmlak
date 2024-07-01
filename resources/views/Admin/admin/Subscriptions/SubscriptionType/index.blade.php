@extends('Admin.layouts.app')

@section('title', __('Types subscriptions'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 py-3 mb-3">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        @lang('Types subscriptions')</h4>
                </div>

            </div>


            <!-- DataTable with Buttons -->


            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <form action="{{ route('Admin.SubscriptionTypes.index') }}" method="GET" id="subscriptionsForm">
                            <div class="row">
                                <div class="col-12 col-md-3 mb-3">
                                    <span>@lang('Subscription Status')</span>
                                    <select class="form-select" id="status_filter" name="status_filter">
                                        <option value="all" {{ $status_filter == 'all' ? 'selected' : '' }}>
                                            @lang('All')</option>
                                        <option value="1" {{ $status_filter == 1 ? 'selected' : '' }}>
                                            @lang('active')
                                        </option>
                                        <option value="0" {{ $status_filter == 0 ? 'selected' : '' }}>
                                            @lang('inactive')
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <span>@lang('Subscription Time')</span>
                                    <select class="form-select" id="period_filter" name="period_filter">
                                        <option value="all" {{ $period_filter == 'all' ? 'selected' : '' }}>
                                            @lang('All')
                                        </option>
                                        <option value="day" {{ $period_filter == 'day' ? 'selected' : '' }}>
                                            @lang('day')
                                        </option>
                                        <option value="week" {{ $period_filter == 'week' ? 'selected' : '' }}>
                                            @lang('week')</option>
                                        <option value="month" {{ $period_filter == 'month' ? 'selected' : '' }}>
                                            @lang('month')
                                        </option>
                                        <option value="year" {{ $period_filter == 'year' ? 'selected' : '' }}>
                                            @lang('year')
                                        </option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <span>@lang('price')</span>
                                    <select class="form-select" id="price_filter" name="price_filter">
                                        <option value="all" {{ $price_filter == 'all' ? 'selected' : '' }}>
                                            @lang('All')
                                        </option>
                                        @foreach ($prices as $price)
                                            <option value="{{ $price }}"
                                                {{ $price_filter == $price ? 'selected' : '' }}>
                                                {{ $price }} ريال فيما اقل
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center col-md-3 mt-3">
                                    <button type="submit"
                                        class="w-auto btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                                    @php
                                        $filter_counter =
                                            ($period_filter != 'all') +
                                            ($price_filter != 'all') +
                                            ($status_filter != 'all');
                                    @endphp
                                    @if ($filter_counter > 0)
                                        <a href="{{ route('Admin.SubscriptionTypes.index') }}"
                                            class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                                            style="margin-bottom: 0!important;">@lang('Cancel') @lang('Filter')
                                            ({{ $filter_counter }})</a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="divider divider-success">
                <div class="divider-text">@lang('Types subscriptions')</div>
            </div>

            <div class="card">
                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Types subscriptions') </h5>
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
                                            @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                                                <div class="btn-group">

                                                    <a href="{{ route('Admin.SubscriptionTypes.create') }}" type="button"
                                                        class="btn btn-primary">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add New Type subscription')</span></span>
                                                    </a>
                                                    {{-- <ul class="dropdown-menu">
                                                    @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Admin.SubscriptionTypes.create') }}">@lang('Add New Type subscription')</a>
                                                        </li>
                                                    @endif

                                                </ul> --}}
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
                    <table class="table" id="table2">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>@lang('Name')</th>
                                <th>@lang('Subscription Time')</th>
                                <th>@lang('Subscription Type')</th>
                                <th>@lang('role name') </th>
                                <th>@lang('price')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 sortable">
                            @foreach ($subscriptions as $index => $sub)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                    <td>{{ $sub->name }}</td>
                                    <td>
                                        @if ($sub->price > 0)
                                            <span class="badge rounded-pill bg-primary">
                                                {{ $sub->period }} {{ __($sub->period_type) }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning">
                                                {{ $sub->period }} {{ __($sub->period_type) }}
                                            </span>
                                        @endif

                                    </td>

                                    <td>
                                        @if ($sub->price > 0)
                                            <span class="badge rounded-pill bg-success">@lang('paid')</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">@lang('free')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($sub->RolesData as $role)
                                            {{ app()->getLocale() == 'ar' ? $role->RoleData->name_ar : $role->RoleData->name ?? '' }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>{{ $sub->price }} <sup>@lang('SAR')</sup> </td>

                                    <td>{{ $sub->status == 1 ? __('active') : __('inactive') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('update-SubscriptionTypes'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.SubscriptionTypes.edit', $sub->id) }}">@lang('Edit')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('delete-SubscriptionTypes'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $sub->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $sub->id }}"
                                                        action="{{ route('Admin.SubscriptionTypes.destroy', $sub->id) }}"
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
            <!-- Modal to add new record -->
            <div class="divider divider-danger">
                <div class="divider-text">
                    @lang('Record Deleted subscriptionTypes')
                </div>
            </div>


            <div class="card">

                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Record Deleted subscriptionTypes') </h5>
                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                        <input id="SearchInput2" class="form-control" placeholder="@lang('search...')"
                                            aria-controls="DataTables_Table_0"></label></div>
                            </div>

                            <div class="col-8">
                                <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                    <div
                                        class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                        <div class="dt-buttons btn-group flex-wrap d-flex">
                                            <div class="btn-group">
                                                <button onclick="exportToExcel2()"
                                                    class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                    tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                    aria-haspopup="dialog" aria-expanded="false"><span>
                                                        <i class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                            </div>
                                            {{-- <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                            class="d-none d-sm-inline-block">@lang('Add')</span></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Admin.SubscriptionTypes.create') }}">@lang('Add New Type subscription')</a>
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


                </div>


                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>@lang('Name')</th>
                                <th>@lang('Subscription Time')</th>
                                <th>@lang('Subscription Type')</th>
                                <th> @lang('role name') </th>
                                <th>@lang('price')</th>
                                <th>@lang('status')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($subscriptionsDeleted as $index => $sub_deleted)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                    <td>{{ $sub_deleted->name }}</td>
                                    <td>
                                        @if ($sub_deleted->price > 0)
                                            <span class="badge rounded-pill bg-primary">
                                                {{ $sub_deleted->period }} {{ __($sub_deleted->period_type) }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning">
                                                {{ $sub_deleted->period }} {{ __($sub_deleted->period_type) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($sub_deleted->price > 0)
                                            <span class="badge rounded-pill bg-success">@lang('paid')</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">@lang('free')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($sub_deleted->RolesData as $role)
                                            {{ app()->getLocale() == 'ar' ? $role->RoleData->name_ar : $role->RoleData->name ?? '' }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>{{ $sub_deleted->price }} <sup>@lang('SAR')</sup> </td>

                                    <td>{{ $sub_deleted->status == 1 ? __('active') : __('inactive') }}</td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


    <div class="modal animate__animated animate__zoomIn" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">@lang('Add New Subscriber')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <a href="{{ route('Admin.Subscribers.create') }}"
                                class="btn btn-primary">@lang('Office')</a>
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{ route('Admin.Subscribers.CreateBroker') }}"
                                class="btn btn-primary">@lang('Broker')</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
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
                XLSX.writeFile(wb, @json(__('Types subscriptions')) + '.xlsx');

                alertify.success(@json(__('Download done')));
            }
        </script>

        <script>
            function exportToExcel2() {
                // Get the table by ID
                var table = document.getElementById('table');

                // Remove the last <td> from each row


                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Record Deleted subscriptionTypes')) + '.xlsx');

                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush

    @push('scripts')
        <script>
            document.querySelector('#subscriptionsForm').addEventListener('submit', function(event) {
                let flag = false;
                if (document.querySelector('select#status_filter').value != 'all' ||
                    document.querySelector('select#period_filter').value != 'all' ||
                    document.querySelector('select#price_filter').value != 'all'
                )
                    flag = true;

                if (!flag && !document.querySelector('#subscriptionsForm a.clear-filter')) event.preventDefault();

            });
        </script>
    @endpush
@endsection
