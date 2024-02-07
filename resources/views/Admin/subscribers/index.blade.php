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
                                                    <td>{{ $subscriber->OfficeData->UserData->name ?? '' }}</td>
                                                    <td>
                                                        @if ($subscriber->SubscriptionTypeData->price > 0)
                                                            <span class="badge badge-pill badge-warning"
                                                                style="background-color: #add0e87d;color: #497AAC;">@lang('paid')</span>
                                                        @else
                                                            <span
                                                                class="badge badge-pill badge-warning">@lang('free')</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $subscriber->SubscriptionTypeData->period . ' ' . __($subscriber->SubscriptionTypeData->period_type) }}
                                                    </td>
                                                    <td>{{ __($subscriber->status) }}</td>
                                                    <td>{{ $subscriber->number_of_clients }}</td>
                                                    <td>{{ $subscriber->OfficeData->CityData->name ?? '' }}</td>
                                                    <td>{{ $subscriber->start_date }}</td>
                                                    <td>{{ $subscriber->end_date }}</td>
                                                    <td>
                                                        <a href="{{ route('Admin.edit-broker-subscribers', $subscriber->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $subscriber->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $subscriber->id }}"
                                                            action="{{ route('Admin.delete-broker-subscribers', $subscriber->id) }}"
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

    <!-- Add New Broker Modal -->
    {{-- <div class="modal fade" id="addBrokerModal" tabindex="-1" role="dialog" aria-labelledby="addBrokerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrokerModalLabel">@lang('Add Broker')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Broker Form -->
                    <form action="{{ route('Admin.create-broker-subscribers') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3 row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('الاسم رباعي')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="license_number"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('رقم رخصة فال')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="license_number" name="license_number">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('البريد الالكتروني')</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="mobile"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الجوال (واتس اب)')</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="mobile" name="mobile">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="city"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('المدينة')</label>
                            <div class="col-md-6">
                                <select class="form-control" id="city" required name="city">
                                    <option value="">إختر</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->name }}"
                                            @if (old('city') == $city->name) {{ 'selected' }} @endif>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('كلمة المرور')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password_confirmation"
                                class="col-md-4 col-form-label text-md-end text-start">@lang('تأكيد كلمة المرور')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="subscription"
                                class="col-md-4 col-form-label text-md-end text-start">@lang(' نوع الاشتراك')</label>
                            <div class="col-md-6">
                                <select class="form-control" id="subscription_type" name="subscription_type">
                                    <option value="">إختر</option>
                                    @foreach ($subscriptionTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->period }} {{ $type->period_type }}
                                            - {{ $type->price }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_number"
                        class="col-md-4 col-form-label text-md-end text-start">@lang('رقم الهوية')</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="id_number" name="id_number">
                    </div>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">@lang('save')</button>
                </div>
                </form>
            </div>
        </div>
    </div> --}}
    </div>
@endsection
