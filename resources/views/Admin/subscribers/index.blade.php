@extends('Admin.layouts.app')
@section('title', __('Subscribers'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Subscribers')</h4>
                                </div>

                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.Subscribers.index') }}">@lang('Subscribers')</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
                                    </ol>
                                </div>

                                <div class="col-md-6" style="text-align: end">
                                    <a href="{{ route('Admin.Subscribers.create') }}"
                                        class="btn btn-primary col-3 p-1 m-1 waves-effect waves-light" data-toggle="modal"
                                        data-target="#addSubscriberModal">
                                        @lang('Add New Subscriber')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('Subscriber Name')</th>
                                                <th>@lang('Account Type')</th>
                                                <th>@lang('Subscription Type')</th>
                                                <th>@lang('Subscription Time')</th>
                                                <th>@lang('Subscription Status')</th>
                                                <th>@lang('Number of Clients')</th>
                                                <th>@lang('Subscriber City')</th>
                                                <th>@lang('Subscription Start')</th>
                                                <th>@lang('Subscription End')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscribers as $index => $subscriber)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
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
                                                    <td>
                                                        @if ($subscriber->SubscriptionTypeData->price > 0)
                                                            <span class="badge badge-pill badge-warning"
                                                                style="background-color: #add0e87d;color: #497AAC;">@lang('paid')</span>
                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-warning">@lang('free')</span>
                                                        @endif
                                                    </td>
                                                    <td> {{ $subscriber->SubscriptionTypeData->period }}
                                                        {{ __('ar.' . $subscriber->SubscriptionTypeData->period_type) }}
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge badge-pill p-1 badge-{{ $subscriber->is_suspend == 1 || $subscriber->status == 'pending' ? 'danger' : 'info' }}">
                                                            {{ $subscriber->is_suspend == 1 ? __('Subscription suspend') : __($subscriber->status) }}
                                                        </span>

                                                    </td>
                                                    <td>{{ $subscriber->number_of_clients }}</td>
                                                    <td>
                                                        @if ($subscriber->office_id)
                                                            {{ $subscriber->OfficeData->CityData->name ?? '' }}
                                                        @endif
                                                        @if ($subscriber->broker_id)
                                                            {{ $subscriber->BrokerData->CityData->name ?? '' }}
                                                        @endif
                                                    </td>

                                                    <td>{{ $subscriber->start_date }}</td>
                                                    <td>{{ $subscriber->end_date }}</td>
                                                    <td>
                                                        @if ($subscriber->is_suspend)
                                                            <form
                                                                action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="text" hidden value="{{ 0 }}"
                                                                    name="is_suspend">
                                                                <button
                                                                    class="btn  btn-outline-info btn-sm waves-effect waves-light">@lang('re active')</button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('Admin.Subscribers.SuspendSubscription', $subscriber->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="text" hidden value="{{ 1 }}"
                                                                    name="is_suspend">
                                                                <button
                                                                    class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('suspend')</button>
                                                            </form>
                                                        @endif

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $subscriber->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $subscriber->id }}"
                                                            action="{{ route('Admin.Subscribers.destroy', $subscriber->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div>
            <!-- container-fluid -->

        </div>

        <!-- Add New Subscriber Modal -->
        <div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog"
            aria-labelledby="addSubscriberModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSubscriberModalLabel">@lang('Add New Subscriber')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-deck">
                            <!-- Add New Office Card -->
                            <div class="card">
                                <div class="card-body">
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
                            <!-- Add New Broker Card -->

                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $('.SuspendSubscription').on('click', function() {
                var url = $(this).data('url');
                var is_suspend = $(this).data('is_suspend');
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        is_suspend: is_suspend,
                    },
                    success: function(data) {
                        if (is_suspend == 0) {

                            alertify.success(@json(__('Subscription has been activated')));
                        } else {
                            alertify.success(@json(__('Subscription has been suspended')));

                        }
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        </script>
    @endpush


@endsection
