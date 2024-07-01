@extends('Admin.layouts.app')

@section('title', __('Add New Subscriber'))

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Subscribers.index') }}" class="text-muted fw-light">@lang('Subscribers') </a> /
                        @lang('Subscriber Name') : @if ($subscriber->office_id)
                            {{ $subscriber->OfficeData->UserData->name ?? '' }}
                        @elseif ($subscriber->broker_id)
                            {{ $subscriber->BrokerData->UserData->name ?? '' }}
                        @endif
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="row">
                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- User Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">
                                    <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                        src="@if ($subscriber->office_id) {{ $subscriber->OfficeData->company_logo ?? url('HOME_PAGE/img/avatars/14.png') }}
                                                @elseif ($subscriber->broker_id)
                                                    {{ $subscriber->BrokerData->broker_logo ?? url('HOME_PAGE/img/avatars/14.png') }} {{-- Use asset helper --}} @endif"
                                        height="100" width="100" alt="User avatar">
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->UserData->name ?? '' }}
                                            @elseif ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->UserData->name ?? '' }}
                                            @endif
                                        </h4>
                                        <span class="badge bg-label-secondary mt-1">
                                            @if ($subscriber->office_id)
                                                @lang('Office')
                                            @elseif ($subscriber->broker_id)
                                                @lang('Broker')
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                                <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-checkbox ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium">@lang('Subscription Type')</p>
                                        <small>
                                            @if ($subscriber->SubscriptionTypeData->price > 0)
                                                @lang('paid')
                                            @else
                                                @lang('free')
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-briefcase ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium">@lang('Number of Clients')</p>
                                        <small> {{ $subscriber->number_of_clients ?? __('nothing') }}</small>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-medium me-1">@lang('Subscriber Name'):</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->UserData->name ?? '' }}
                                            @elseif ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->UserData->name ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Email'):</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->UserData->email ?? '' }}
                                            @elseif ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->UserData->email ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Subscription Status'):</span>
                                        <span
                                            class="badge bg-label-{{ $subscriber->is_suspend == 1 || $subscriber->status == 'pending' ? 'danger' : 'success' }}">
                                            {{ $subscriber->is_suspend == 1 ? __('Subscription suspend') : __($subscriber->status) }}
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Account Type'):</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                @lang('Office')
                                            @elseif ($subscriber->broker_id)
                                                @lang('Broker')
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Subscriber City') :</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->CityData->name ?? '' }}
                                            @endif
                                            @if ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->CityData->name ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('phone') :</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->userData->full_phone ?? '' }}
                                            @endif
                                            @if ($subscriber->broker_id)
                                                {{-- +{{ $subscriber->BrokerData->key_phone ?? ''  }} {{ $subscriber->BrokerData->mobile ?? '' }} --}}
                                                {{ $subscriber->BrokerData->full_phone ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('id number') :</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->userData->id_number ?? '' }}
                                            @endif
                                            @if ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->id_number ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="pt-1">
                                        <span class="fw-medium me-1">@lang('license number') :</span>
                                        <span>
                                            @if ($subscriber->office_id)
                                                {{ $subscriber->OfficeData->office_license ?? '' }}
                                            @endif
                                            @if ($subscriber->broker_id)
                                                {{ $subscriber->BrokerData->broker_license ?? '' }}
                                            @endif
                                        </span>
                                    </li>
                                    <li class="pt-1">
                                        <span class="fw-medium me-1">@lang('license validity') :</span>
                                        <span>
                                            {{ __($subscriber->BrokerData->license_validity) }}
                                        </span>
                                    </li>
                                    <li class="pt-1">
                                        <span class="fw-medium me-1">@lang('Subscription Start join') :</span>
                                        <span>
                                            {{ $subscriber->created_at->format('Y-m-d') }}
                                        </span>
                                    </li>

                                </ul>


                            </div>
                        </div>
                    </div>
                    <!-- /User Card -->
                    <!-- Plan Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="badge bg-label-primary">{{ $subscriber->SubscriptionTypeData->name }}</span>
                                <div class="d-flex justify-content-center">
                                    <sup
                                        class="h6 pricing-currency mt-3 mb-0 me-1 text-primary fw-normal">@lang('SAR')</sup>
                                    <h1 class="mb-0 text-primary">{{ $subscriber->SubscriptionTypeData->price }}</h1>
                                    <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">{{ $subscriber->SubscriptionTypeData->period }}
                                        /
                                        {{ __($subscriber->SubscriptionTypeData->period_type) }}</sub>
                                </div>
                            </div>
                            @php
                                $start_date = \Carbon\Carbon::parse($subscriber->start_date);
                                $end_date = \Carbon\Carbon::parse($subscriber->end_date);
                                $current_date = now();

                                $total_days = $end_date->diffInDays($start_date);
                                $elapsed_days = $current_date->diffInDays($start_date);
                                $remaining_days = $total_days - $elapsed_days;
                                $progress_percentage = ($remaining_days / $total_days) * 100;
                                $progress_percentage = round($progress_percentage, 1);

                            @endphp

                            <ul class="ps-3 g-2 my-3">
                                <li class="mb-2">@lang('Subscription Start') : {{ $subscriber->start_date }}</li>
                                <li class="mb-2">@lang('Subscription End') : {{ $subscriber->end_date }}</li>
                            </ul>

                            {{-- <div class="progress mb-1" style="height: 8px">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress_percentage }}%"
                                    aria-valuenow="{{ $progress_percentage }}" aria-valuemin="0" aria-valuemax="100"> {{ $progress_percentage }}%</div>
                            </div> --}}
                            <div class="progress" style="height: 10px">
                                <div id="progress-bar-{{ $subscriber->id }}" class="progress-bar" role="progressbar"
                                    style="width: {{ $progress_percentage }}%;" aria-valuenow="{{ $progress_percentage }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $progress_percentage }}%
                                </div>
                            </div>

                            <span>{{ $remaining_days }} @lang('days remaining')</span>

                            {{-- <div class="d-grid w-100 mt-4">
                                <button class="btn btn-primary waves-effect waves-light" data-bs-target="#upgradePlanModal"
                                    data-bs-toggle="modal">
                                    Upgrade Plan
                                </button>
                            </div> --}}
                        </div>
                    </div>
                    <!-- /Plan Card -->
                </div>
                <!--/ User Sidebar -->

                <!-- User Content -->
                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                    <!-- User Pills -->
                    <!-- Project table -->
                    <div class="card mb-4">
                        <h5 class="card-header">@lang('Record subscription history')</h5>

                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-dark">

                                    <tr>
                                        <th>@lang('Subscription Name')</th>
                                        <th>@lang('Subscription Time')</th>
                                        <th>@lang('Subscription Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $index => $invoice)
                                        <tr>
                                            <td> {{ $invoice->subscription_name }} </td>
                                            <td>{{ __($invoice->period_type) }} </td>

                                            <td>
                                                @if ($loop->last)
                                                    {{ __($subscriber->status) }}
                                                @else
                                                    {{ __('expired') }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('Admin.SystemInvoice.show', $invoice->id) }}"
                                                    class="btn btn-dark btn-sm waves-effect waves-light">@lang('view')
                                                    @lang('Invoice')</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <div class="row">


                        <!-- /Project table -->
                        <div class="mb-4 col">
                            <!-- Activity Timeline -->
                            <div class="col-md-12 col-xl-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                                            <img class="img-fluid"
                                                src="{{ url('/assets/img/illustrations/girl-with-laptop.png') }}"
                                                alt="Card girl image" width="140">
                                        </div>
                                        <h4 class="mb-2 pb-1">@lang('statistics')</h4>

                                        <div class="row mb-3 g-3">
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-users ti-md"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap">{{ $numberOfowners }}</h6>
                                                        <small>@lang('Number Of Owners')</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-building ti-md"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap">{{ $numberOfUnits }}</h6>
                                                        <small>@lang('Number units')</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-building ti-md"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap">{{ $numberOfProperties }}</h6>
                                                        <small>@lang('Number properties')</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-building ti-md"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap">{{ $numberOfProjects }}</h6>
                                                        <small>@lang('Number projects')</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary w-100 waves-effect waves-light">@lang('Gallery visitors') :
                                            0</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Activity Timeline -->
                        </div>

                        <div class="mb-4 col">
                            <!-- Activity Timeline -->
                            <div class="col-md-12 col-xl-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                                            <img class="img-fluid"
                                                src="{{ url('/assets/img/illustrations/card-website-analytics-2.png') }}"
                                                alt="Card girl image" width="140" style="height: 159px;"
                                                height="159">
                                        </div>
                                        <h4 class="mb-2 pb-1">@lang('Geographic scope')</h4>

                                        <div class="row mb-3 g-3">
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-building-skyscraper ti-md"></i></span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 text-nowrap">@lang('Region')</h6>
                                                        <small>
                                                            @if ($subscriber->office_id)
                                                                {{ $subscriber->OfficeData->CityData->RegionData->name ?? '' }}
                                                            @endif
                                                            @if ($subscriber->broker_id)
                                                                {{ $subscriber->BrokerData->CityData->RegionData->name ?? '' }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex">
                                                    <div class="avatar flex-shrink-0 me-2">
                                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                                class="ti ti-topology-complex ti-md"></i></span>
                                                    </div>
                                                    <div>

                                                        <h6 class="mb-0 text-nowrap">
                                                            @lang('city')
                                                        </h6>
                                                        <small>
                                                            @if ($subscriber->office_id)
                                                                {{ $subscriber->OfficeData->CityData->name ?? '' }}
                                                            @endif
                                                            @if ($subscriber->broker_id)
                                                                {{ $subscriber->BrokerData->CityData->name ?? '' }}
                                                            @endif
                                                        </small>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);"
                                            class="btn btn-primary w-100 waves-effect waves-light">@lang('Show')
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Activity Timeline -->
                        </div>
                    </div>
                </div>
                <!--/ User Content -->

            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>



@endsection
