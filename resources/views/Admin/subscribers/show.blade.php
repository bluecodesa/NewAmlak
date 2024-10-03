@extends('Admin.layouts.app')

@section('title', __('Show'))

@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">

                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.Subscribers.index') }}" class="text-muted fw-light">@lang('Subscribers') </a> /
                        @lang('Subscriber Name') :
                            {{ $subscriber->name ?? '' }}

                    </h4>
                </div>

            </div>

            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                  <li class="nav-item">
                    <button
                      type="button"
                      class="nav-link active"
                      role="tab"
                      data-bs-toggle="tab"
                      data-bs-target="#navs-justified-home"
                      aria-controls="navs-justified-home"
                      aria-selected="true">
                      <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Basic Details')
                      <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1"></span>
                    </button>
                  </li>
                  <li class="nav-item">
                    <button
                      type="button"
                      class="nav-link"
                      role="tab"
                      data-bs-toggle="tab"
                      data-bs-target="#navs-justified-profile"
                      aria-controls="navs-justified-profile"
                      aria-selected="false">
                      <i class="tf-icons ti ti-file-invoice ti-xs me-1"></i> @lang('Record subscription history')
                    </button>
                  </li>
                  @if ($subscriber->is_office)
                  <li class="nav-item">
                    <button
                      type="button"
                      class="nav-link"
                      role="tab"
                      data-bs-toggle="tab"
                      data-bs-target="#navs-justified-messages"
                      aria-controls="navs-justified-messages"
                      aria-selected="false">
                      <i class="tf-icons ti ti-users ti-xs me-1"></i> @lang('Employees')
                    </button>
                  </li>
                  @endif
                  @if ($falLicenses)
                  <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-fal" aria-controls="navs-justified-fal"
                        aria-selected="false">
                        <i class="tf-icons ti ti-picture-in-picture ti-xs me-1"></i>
                        @lang('REGA License')
                    </button>
                </li>
                @endif

                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        <div class="row">
                            <!-- User Sidebar -->
                            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                                <!-- User Card -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="user-avatar-section">
                                            <div class="d-flex align-items-center flex-column">
                                                <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                                    src="{{ $subscriber->avatar ?? url('HOME_PAGE/img/avatars/14.png') }}"
                                                    height="100" width="100" alt="User avatar">
                                                <div class="user-info text-center">
                                                    <h4 class="mb-2">
                                                            {{ $subscriber->name ?? '' }}
                                                    </h4>
                                                    @foreach ($subscriber->roles as $role)
                                                    <span class="badge bg-primary">{{ __($role->name) ?? '' }}</span>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                    @endforeach
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
                                                            @php
                                                            $subscriptionPrice = 0;
                                                            if ($subscriber->is_broker && isset($subscriber->UserBrokerData->UserSubscription->SubscriptionTypeData->price)) {
                                                                $subscriptionData = $subscriber->UserBrokerData->UserSubscription->SubscriptionTypeData;
                                                                $subscriptionPrice = $subscriber->UserBrokerData->UserSubscription->SubscriptionTypeData->price;
                                                                $subscription = $subscriber->UserBrokerData->UserSubscription;
                                                            } elseif ($subscriber->is_office && isset($subscriber->UserOfficeData->UserSubscription->SubscriptionTypeData->price)) {
                                                                $subscriptionPrice = $subscriber->UserOfficeData->UserSubscription->SubscriptionTypeData->price;
                                                                $subscriptionData = $subscriber->UserOfficeData->UserSubscription->SubscriptionTypeData;
                                                                $subscription = $subscriber->UserOfficeData->UserSubscription;
                                                            } elseif ($subscriber->is_owner && isset($subscriber->UserOwnerData->UserSubscription->SubscriptionTypeData->price)) {
                                                                $subscriptionPrice = $subscriber->UserOwnerData->UserSubscription->SubscriptionTypeData->price;
                                                                $subscriptionData = $subscriber->UserOwnerData->UserSubscription->SubscriptionTypeData;
                                                                $subscription = $subscriber->UserOwnerData->UserSubscription;
                                                            }else{
                                                                $subscription=null;
                                                            }
                                                        @endphp

                                                        @if ($subscriptionPrice > 0)
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
                                                                {{ $subscriber->name ?? '' }}

                                                        </span>
                                                    </li>
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('Email'):</span>
                                                        <span>
                                                                {{ $subscriber->email ?? '' }}

                                                        </span>
                                                    </li>
                                                    @if($subscription)
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('Subscription Status'):</span>
                                                        <span
                                                            class="badge bg-label-{{ $subscription->is_suspend == 1 || $subscription->status == 'pending' ? 'danger' : 'success' }}">
                                                            {{ $subscription->is_suspend == 1 ? __('Subscription suspend') : __($subscription->status) }}
                                                        </span>
                                                    </li>
                                                    @endif
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('Account Type'):</span>
                                                        @foreach ($subscriber->roles as $role)
                                                        <span class="badge bg-primary">{{ __($role->name) ?? '' }}</span>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                        @endforeach
                                                    </li>
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('Subscriber City') :</span>
                                                        <span>
                                                            @if ($subscriber->is_office)
                                                                {{ $subscriber->UserOfficeData->CityData->name ?? '' }}
                                                            @endif
                                                            @if ($subscriber->is_broker)
                                                                {{ $subscriber->UserBrokerData->CityData->name ?? '' }}
                                                            @endif
                                                            @if ($subscriber->is_owner)
                                                            {{ $subscriber->UserOwnerData->CityData->name ?? '' }}
                                                            @endif

                                                        </span>
                                                    </li>
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('phone') :</span>
                                                        <span>
                                                                {{ $subscriber->full_phone ?? '' }}

                                                        </span>
                                                    </li>
                                                    <li class="mb-2 pt-1">
                                                        <span class="fw-medium me-1">@lang('id number') :</span>
                                                        <span>
                                                                {{ $subscriber->id_number ?? '' }}

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
                                                        <span class="fw-medium me-1">@lang('Subscription Start join') :</span>
                                                        <span>
                                                            {{ $subscriber->created_at->format('Y-m-d') }}
                                                        </span>
                                                    </li>
                                                </ul>
                                                @if ($subscriber->is_office)
                                                        @if (Auth::user()->hasPermission('update-account-users-limit'))
                                                        <div class="d-flex justify-content-center">
                                                            <span class="fw-medium me-1">@lang('الحد الاقصي من عدد الموظفين') :
                                                                {{ $subscriber->UserOfficeData->max_of_employee ?? '' }}</span>
                                                            <a href="{{ route('Broker.Project.edit', $subscriber->id) }}"
                                                                class="btn btn-warning me-3" data-bs-toggle="modal"
                                                                data-bs-target="#basicModal">@lang('Edit')</a>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel1">@lang('Edit Numbers of Max Employees')
                                                                            </h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <form
                                                                                    action="{{ route('Admin.updateNumOfEmployee', $subscriber->UserOfficeData->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('PUT')

                                                                                    <div class="mb-3">
                                                                                        <label for="max_of_employee"
                                                                                            class="form-label">@lang('Numbers of Employees') <span
                                                                                                class="text-danger">*</span></label>
                                                                                        <input type="number" class="form-select"
                                                                                            name="max_of_employee" id="max_of_employee"
                                                                                            required>
                                                                                    </div>


                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-label-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                @lang('Cancel')
                                                                            </button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">@lang('save')</button>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endif
                                                @endif


                                            </div>
                                        </div>
                                    </div>
                                    <!-- /User Card -->

                                </div>

                                <div class="mb-8 col">
                                    <div class="row">
                                <!-- Card Border Shadow -->
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-primary">
                                            <div class="card-body">
                                            <div class="d-flex align-items-center mb-2 pb-1">
                                                <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-truck ti-md"></i></span>
                                                </div>
                                                <h4 class="ms-1 mb-0">{{ $numberOfowners }}</h4>
                                            </div>
                                            <p class="mb-1">@lang('Number Of Owners')</p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-warning">
                                            <div class="card-body">
                                            <div class="d-flex align-items-center mb-2 pb-1">
                                                <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-warning"
                                                    ><i class="ti ti-alert-triangle ti-md"></i
                                                ></span>
                                                </div>
                                                <h4 class="ms-1 mb-0">{{ $numberOfUnits }}</h4>
                                            </div>
                                            <p class="mb-1">@lang('Number units')</p>

                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-danger">
                                            <div class="card-body">
                                            <div class="d-flex align-items-center mb-2 pb-1">
                                                <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-danger"
                                                    ><i class="ti ti-git-fork ti-md"></i
                                                ></span>
                                                </div>
                                                <h4 class="ms-1 mb-0">{{ $numberOfProperties }}</h4>
                                            </div>
                                            <p class="mb-1">@lang('Number properties')</p>

                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                        <div class="card card-border-shadow-info">
                                            <div class="card-body">
                                            <div class="d-flex align-items-center mb-2 pb-1">
                                                <div class="avatar me-2">
                                                <span class="avatar-initial rounded bg-label-info"><i class="ti ti-clock ti-md"></i></span>
                                                </div>
                                                <h4 class="ms-1 mb-0">{{ $numberOfProjects }}</h4>
                                            </div>
                                            <p class="mb-1">@lang('Number projects')</p>

                                            </div>
                                        </div>
                                        </div>
                                        @if ($numberOfUnits > 0)
                                            @php

                                                $nonResidentialCountPercentage = number_format(
                                                    ($nonResidentialCount / $numberOfUnits) * 100,
                                                    1,
                                                );

                                                $residentialCountPercentage = number_format(($residentialCount / $numberOfUnits) * 100, 1);
                                            @endphp
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                    <span class="avatar-initial rounded bg-label-warning"
                                                        ><i class="ti ti-alert-triangle ti-md"></i
                                                    ></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">{{ $nonResidentialCount }}</h4>
                                                </div>
                                                <p class="mb-1">@lang('Units') @lang('NonResidential')</p>
                                                <p class="mb-0">
                                                    <span class="fw-medium me-1">{{ $nonResidentialCountPercentage }}%</span>
                                                </p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-sm-3 col-lg-3 mb-4">
                                                <div class="card card-border-shadow-warning">
                                                    <div class="card-body">
                                                    <div class="d-flex align-items-center mb-2 pb-1">
                                                        <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-warning"
                                                            ><i class="ti ti-alert-triangle ti-md"></i
                                                        ></span>
                                                        </div>
                                                        <h4 class="ms-1 mb-0">{{ $residentialCount }}</h4>
                                                    </div>
                                                    <p class="mb-1">@lang('Units') @lang('Residential')</p>
                                                    <p class="mb-0">
                                                        <span class="fw-medium me-1">{{ $residentialCountPercentage }}%</span>
                                                    </p>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($galleryItems->isNotEmpty())

                                        <div class="col-sm-3 col-lg-3 mb-4">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                    <span class="avatar-initial rounded bg-label-warning"
                                                        ><i class="ti ti-alert-triangle ti-md"></i
                                                    ></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">{{ $galleryItems->count() }}</h4>
                                                </div>
                                                <p class="mb-1">@lang('Valid Units in Gallery')</p>
                                                </div>
                                            </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-3 col-lg-3 mb-4">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                    <span class="avatar-initial rounded bg-label-warning"
                                                        ><i class="ti ti-alert-triangle ti-md"></i
                                                    ></span>
                                                    </div>
                                                    <h4 class="ms-1 mb-0">{{ $tickets->count() }}</h4>
                                                </div>
                                                <p class="mb-1">@lang('Tickets Support')</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--/ Card Border Shadow -->
                                </div>
                        </div>
                  </div>
                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                            <!-- Plan Card -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    @php
                                        // Fetching subscription data dynamically based on user type
                                        $subscriptionData = null;

                                        if ($subscriber->is_broker) {
                                            $subscriptionData = $subscriber->UserBrokerData->UserSubscription->SubscriptionTypeData ?? null;
                                            $subscription = $subscriber->UserBrokerData->UserSubscription ?? null;
                                        } elseif ($subscriber->is_office) {
                                            $subscriptionData = $subscriber->UserOfficeData->UserSubscription->SubscriptionTypeData ?? null;
                                            $subscription = $subscriber->UserOfficeData->UserSubscription ?? null;
                                        } elseif ($subscriber->is_owner) {
                                            $subscriptionData = $subscriber->UserOwnerData->UserSubscription->SubscriptionTypeData ?? null;
                                            $subscription = $subscriber->UserOwnerData->UserSubscription ?? null;
                                        }
                                    @endphp

                                    @if ($subscriptionData)
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-label-primary">{{ $subscriptionData->name }}</span>
                                            <div class="d-flex justify-content-center">
                                                <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary fw-normal">@lang('SAR')</sup>
                                                <h1 class="mb-0 text-primary">{{ $subscriptionData->price }}</h1>
                                                <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">
                                                    {{ $subscriptionData->period }} / {{ __($subscriptionData->period_type) }}
                                                </sub>
                                            </div>
                                        </div>

                                        @php
                                            $start_date = \Carbon\Carbon::parse($subscription->start_date);
                                            $end_date = \Carbon\Carbon::parse($subscription->end_date);
                                            $current_date = now();

                                            $total_days = $end_date->diffInDays($start_date);
                                            $elapsed_days = $current_date->diffInDays($start_date);
                                            $remaining_days = $total_days - $elapsed_days;
                                            $progress_percentage = ($remaining_days / $total_days) * 100;
                                            $progress_percentage = round($progress_percentage, 1);

                                        @endphp

                                        <ul class="ps-3 g-2 my-3">
                                            <li class="mb-2">@lang('Subscription Start') : {{ $subscription->start_date }}</li>
                                            <li class="mb-2">@lang('Subscription End') : {{ $subscription->end_date }}</li>
                                        </ul>

                                        <div class="progress" style="height: 10px">
                                            <div id="progress-bar-{{ $subscriber->id }}" class="progress-bar" role="progressbar"
                                                style="width: {{ $progress_percentage }}%;"
                                                aria-valuenow="{{ $progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $progress_percentage }}%
                                            </div>
                                        </div>

                                        <span>{{ $remaining_days }} @lang('days remaining')</span>
                                    @else
                                        {{-- <p>@lang('No subscription data available.')</p> --}}
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <span class="alert-icon text-danger me-2">
                                                <i class="ti ti-ban ti-xs"></i>
                                            </span>
                                            @lang('No subscription data available.')
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- /Plan Card -->
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
                                        @forelse ($invoices as $index => $invoice)
                                            <tr>
                                                <td> {{ $invoice->subscription_name }} </td>
                                                <td>{{ __($invoice->period_type) }} </td>

                                                <td>
                                                    @if ($loop->last)
                                                        {{ __($subscription->status) }}
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
                                            @empty
                                            <td colspan="7">
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
                    </div>
                  @if ($subscriber->is_office)
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <div class="card mb-4">
                            <h5 class="card-header">@lang('Employees')</h5>

                            <div class="table-responsive text-nowrap">
                                <table class="table" id="table">
                                    <thead class="table-dark">
                                        <tr>
                                            {{-- <th>#</th> --}}
                                            <th>@lang('Name')</th>
                                            <th>@lang('Email')</th>
                                            <th>@lang('phone')</th>
                                            {{-- <th >@lang('city')</th>
                                            <th >@lang('role name')</th> --}}
                                            <th>@lang('Action')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @forelse($employees as $employee)
                                            <tr>
                                                {{-- <td>{{ $index + 1 }}</td> --}}
                                                <td>{{ $employee->UserData->name ?? '' }}</td>
                                                <td>{{ $employee->UserData->email ?? '' }}</td>
                                                <td>{{ $employee->UserData->phone ?? '' }}</td>
                                                {{-- <td>{{ $employee->CityData->name ?? '' }}</td>
                                                <td>{{ $employee->UserData->roles[0]->name ?? '' }}</td> --}}

                                                <td>

                                                    <div class="dropdown">
                                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item"
                                                                href="{{ route('Office.Employee.show', $employee->id) }}">@lang('Show')</a>
                                                            @if (Auth::user()->hasPermission('delete-employee-account'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('Office.Employee.edit', $employee->id) }}">@lang('Edit')</a>
                                                            @endif
                                                            @if (Auth::user()->hasPermission('delete-employee-account'))
                                                                <a href="javascript:void(0);"
                                                                    onclick="handleDelete('{{ $employee->id }}')"
                                                                    class="dropdown-item delete-btn">@lang('Delete')</a>
                                                                <form id="delete-form-{{ $employee->id }}"
                                                                    action="{{ route('Office.Employee.destroy', $employee->id) }}"
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
                                            <td colspan="4">
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
                    </div>
                  @endif

                    <div class="tab-pane fade" id="navs-justified-fal" role="tabpanel">
                        <div class="row justify-content-center">

                            <!-- DataTable with Buttons -->
                            <div class="card">

                                <div class="row p-1 mb-1">

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
                                                                    class="btn btn-outline-primary btn-sm waves-effect me-2"
                                                                    type="button"><span><i
                                                                            class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                            </div>
                                                            {{-- @if (Auth::user()->hasPermission('create-sections')) --}}
                                                                <div class="btn-group">
                                                                    <a href="{{ route('Broker.Setting.createFalLicense') }}" type="button"
                                                                        class="btn btn-primary">
                                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                                class="d-none d-sm-inline-block">@lang('Add New')</span></span>
                                                                    </a>
                                                                </div>
                                                            {{-- @endif --}}
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
                                                <th>@lang('License Number')</th>
                                                <th>@lang('License Expiry')</th>
                                                <th>@lang('status')</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @forelse ($falLicenses as $index=> $falLicense)
                                                <tr>
                                                    {{-- <th>{{ $index + 1 }}</th> --}}
                                                    <td>{{ $falLicense->falData->name }} </td>
                                                    <td>{{ $falLicense->ad_license_number }} </td>
                                                    <td>{{ $falLicense->ad_license_expiry }} </td>
                                                    <td>{{ __($falLicense->ad_license_status) }} </td>

                                                </tr>
                                            @empty
                                                <td colspan="5">
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

                    </div>

                </div>
              </div>



        </div>

    </div>



@endsection
