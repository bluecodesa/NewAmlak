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
                @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                    <div class="col-6 py-3 mb-3 text-end">
                        <a href="{{ route('Admin.SubscriptionTypes.create') }}"
                            class="btn rounded-pill btn-primary  waves-effect waves-light">@lang('Add New Type subscription')</a>

                    </div>
                @endif
            </div>


            <!-- DataTable with Buttons -->


            <div class="card">
                <div class="row">
                    <div class="col-9">
                        <h5 class="card-header">@lang('Types subscriptions')
                            <button type="button" onclick="exportToExcel()"
                                class="btn btn-sm btn-icon btn-success waves-effect waves-light">
                                <span class="ti ti-table-export"></span>
                            </button>
                        </h5>

                    </div>
                    <div class="col-3 py-1">
                        <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                            placeholder="@lang('search...')">
                    </div>


                </div>


                <div class="table-responsive text-nowrap">
                    <table class="table" id="table2">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Subscription Time')</th>
                                <th>@lang('Subscription Type')</th>
                                <th> @lang('role name') </th>
                                <th>@lang('price')</th>
                                <th>@lang('status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($subscriptions as $index => $sub)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
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
                                            {{ $role->RoleData->name ?? '' }}
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
                    <i class="ti ti-trash"></i>
                </div>
            </div>

            <div class="card">
                <div class="row">
                    <div class="col-9">
                        <h5 class="card-header">@lang('Record Deleted subscriptionTypes')
                            <button type="button" onclick="exportToExcel2()"
                                class="btn btn-sm btn-icon btn-success waves-effect waves-light">
                                <span class="ti ti-table-export"></span>
                            </button>
                        </h5>

                    </div>
                    <div class="col-3 py-1">
                        <input id="SearchInput2" class="form-control rounded-pill mt-3" type="text"
                            placeholder="@lang('search...')">
                    </div>


                </div>


                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
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
                                    <td>{{ $index + 1 }}</td>
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
                                            {{ $role->RoleData->name_ar ?? '' }}
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
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Types subscriptions')) + '.xlsx');
            }
        </script>

        <script>
            function exportToExcel2() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Record Deleted subscriptionTypes')) + '.xlsx');
            }
        </script>
    @endpush
@endsection
