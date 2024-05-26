@extends('Admin.layouts.app')

@section('title', __('Subscribers'))

@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                {{-- header --}}
                <div class="row p-1 mb-1">
                    <div class="col-12">
                        <h5 class="card-header">@lang('Subscribers') </h5>
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
                                                    @if (Auth::user()->hasPermission('create-SubscriptionTypes'))
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Admin.Subscribers.create') }}">@lang('Add')
                                                                @lang('Office')</a>
                                                        </li>

                                                        <li><a class="dropdown-item"
                                                                href="{{ route('Admin.Subscribers.CreateBroker') }}">@lang('Add')
                                                                @lang('Broker')</a>
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

                {{-- table --}}
                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead class="table-dark">
                            <tr>
                                {{-- <th>#</th> --}}
                                <th>@lang('Subscriber Name')</th>
                                <th>@lang('Account Type')</th>
                                {{-- <th>@lang('Subscription Type')</th> --}}
                                {{-- <th>@lang('Subscription Time')</th> --}}
                                <th>@lang('Subscription Status')</th>
                                {{-- <th>@lang('Number of Clients')</th> --}}
                                <th>@lang('Subscriber City')</th>
                                <th>@lang('Subscription Start')</th>
                                {{-- <th>@lang('Subscription End')</th> --}}
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 sortable">

                            @foreach ($subscribers as $index => $subscriber)
                                <tr>
                                    {{-- <td>{{ $index + 1 }}</td> --}}

                                    <td>
                                        @if ($subscriber->office_id)
                                            {{ $subscriber->OfficeData->UserData->name ?? '' }}
                                        @elseif ($subscriber->broker_id)
                                            {{ $subscriber->BrokerData->UserData->name ?? '' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($subscriber->office_id)
                                            @lang('Office')
                                        @elseif ($subscriber->broker_id)
                                            @lang('Broker')
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if ($subscriber->SubscriptionTypeData->price > 0)
                                            <span class="badge rounded-pill bg-success">@lang('paid')</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">@lang('free')</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td> {{ $subscriber->SubscriptionTypeData->period }}
                                        {{ __($subscriber->SubscriptionTypeData->period_type) }}
                                    </td> --}}
                                    <td>

                                        <span
                                            class=" badge bg-{{ $subscriber->is_suspend == 1 || $subscriber->status == 'pending' ? 'danger' : 'primary' }}">
                                            {{ $subscriber->is_suspend == 1 ? __('Subscription suspend') : __($subscriber->status) }}
                                        </span>

                                    </td>
                                    {{-- <td>{{ $subscriber->number_of_clients }}</td> --}}
                                    <td>
                                        @if ($subscriber->office_id)
                                            {{ $subscriber->OfficeData->CityData->name ?? '' }}
                                        @endif
                                        @if ($subscriber->broker_id)
                                            {{ $subscriber->BrokerData->CityData->name ?? '' }}
                                        @endif
                                    </td>

                                    <td>{{ $subscriber->start_date }}</td>
                                    {{-- <td>{{ $subscriber->end_date }}</td> --}}
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                @if (Auth::user()->hasPermission('log-in-as-user'))
                                                    @if ($subscriber->office_id)
                                                        <a class="dropdown-item"
                                                            href="{{ route('Admin.Subscribers.LoginByUser', $subscriber->OfficeData->UserData->id) }}">@lang('login')</a>
                                                    @elseif ($subscriber->broker_id)
                                                        <a class="dropdown-item"
                                                            href="{{ route('Admin.Subscribers.LoginByUser', $subscriber->BrokerData->UserData->id) }}">@lang('login')</a>
                                                    @endif
                                                @endif

                                                @if (Auth::user()->hasPermission('suspend-user-subscriber'))
                                                    @if ($subscriber->is_suspend)
                                                        <form
                                                            action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="text" hidden value="{{ 0 }}"
                                                                name="is_suspend">
                                                            <button class="dropdown-item">@lang('re active')</button>
                                                        </form>
                                                    @else
                                                        <form
                                                            action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="text" hidden value="{{ 1 }}"
                                                                name="is_suspend">
                                                            <button class="dropdown-item">@lang('suspend')</button>
                                                        </form>
                                                    @endif
                                                @endif


                                                @if (Auth::user()->hasPermission('read-subscriber-file'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('Admin.Subscribers.show', $subscriber->id) }}">@lang('Show')</a>
                                                @endif

                                                @if (Auth::user()->hasPermission('delete-subscriber'))
                                                    <a href="javascript:void(0);"
                                                        onclick="handleDelete('{{ $subscriber->id }}')"
                                                        class="dropdown-item delete-btn">@lang('Delete')</a>
                                                    <form id="delete-form-{{ $subscriber->id }}"
                                                        action="{{ route('Admin.Subscribers.destroy', $subscriber->id) }}"
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

                {{ $subscribers->links() }}
            </div>

        </div>
        <div class="content-backdrop fade"></div>
    </div>


    {{-- <div class="modal animate__animated animate__zoomIn" id="largeModal" tabindex="-1" aria-hidden="true">
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
    </div> --}}

    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Subscribers')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
