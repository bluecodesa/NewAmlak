@extends('Admin.layouts.app')
@section('title', __('dashboard'))

@section('content')
<style>
    a.card:hover {
        /* background-color: #5c5c5c; */
        scale: 1.06 ;
        /* transition: background-color 0.3s; */
    }

</style>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            @if(!auth()->user()->UserOfficeData->city_id)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class="alert-icon text-danger me-2">
                    <i class="ti ti-ban ti-xs"></i>
                </span>
                @lang(' الرجاء التوجه الي الاعدادات/الملف الشخصي .. لاكمال البيانات الشخصية الخاصه بحسابكم   ')
            </div>
            @endif
            @if(!auth()->user()->UserFalData)
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <span class="alert-icon text-danger me-2">
                    <i class="ti ti-ban ti-xs"></i>
                </span>
                @lang('الرجاء ادخال رخصة هيئه العقار الخاصة بكم لكي تتمكن من تفعيل المعرض واضافة العقارات')
            </div>
            @endif

            <!-- DataTable with Buttons -->
            {{-- <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <h4 class="mt-0 header-title">
                            {{ Auth::user()->UserOfficeData->UserSystemInvoiceLatest->subscription_name }}</h4>
                    </h4>

                    @if ($daysUntilEnd > 0)
                        <p class="sub-title" class="highlighter-rouge">
                            @if ($daysUntilEnd == 1)
                                <p class="sub-title" class="highlighter-rouge">1 @lang('Day Until End') </p>
                            @else
                                <p class="sub-title" class="highlighter-rouge">{{ $daysUntilEnd }} @lang('Days Until End')
                                </p>
                            @endif

                        </p>
                    @elseif($hoursUntilEnd > 0 || $minutesUntilEnd > 0)
                        <p class="sub-title" class="highlighter-rouge"> {{ $hoursUntilEnd }} @lang ('Hours Until
                            End') </p>
                    @else
                        <p class="sub-title" class="highlighter-rouge">{{ __($subscriber->status) }}</p>
                    @endif


                    <div class="progress">
                        <div id="progress-bar-{{ $subscriber->id }}" class="progress-bar" role="progressbar"
                            style="width: {{ $prec }}%;" aria-valuenow="{{ $prec }}" aria-valuemin="0"
                            aria-valuemax="100">
                            {{ $prec }}%
                        </div>
                    </div>

                    <p class="mt-1 mb-0"> @lang('Subscription End') {{ $subscriber->end_date }}</p>
                    <div class="col-12 text-center">

                        @if ($pendingPayment)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <a href="{{ route('welcome') }}#landingPricing" class="btn btn-secondary modal-btn2 w-auto"
                                target="_blank">@lang('Compare Plans')</a>
                        @elseif ($daysUntilEnd <= 7)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <a href="{{ route('welcome') }}#landingPricing" class="btn btn-secondary modal-btn2 w-auto"
                                target="_blank">@lang('Compare Plans')</a>
                        @elseif ($daysUntilEnd <= 0)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                            <p class="text-danger">{{ __($subscriber->status) }}</p>
                        @else
                            @include('Broker.inc._SubscriptionSuspend')
                        @endif
                    </div>
                </div>
            </div> --}}
            <hr>
            <div class="row">

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Unit.IndexByStatus', 'vacant') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-building  ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Units') @lang('vacant')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            @if ($numberOfUnits > 0)
                                @php
                                    $occupiedPercentage = number_format(
                                        ($numberOfVacantUnits / $numberOfUnits) * 100,
                                        1,
                                    );
                                @endphp
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0 text-muted">{{ $numberOfVacantUnits }}</h4>
                                    <span class="text-success">{{ $occupiedPercentage }}%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: {{ $occupiedPercentage }}%"
                                            role="progressbar" aria-valuenow="{{ $occupiedPercentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $numberOfVacantUnits }}</h4>
                                    <span class="text-danger">0%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: 0%" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Unit.IndexByStatus', 'rented') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-building ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Units') @lang('rented')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            @if ($numberOfUnits > 0)
                                @php
                                    $occupiedPercentage = number_format(
                                        ($numberOfRentedUnits / $numberOfUnits) * 100,
                                        1,
                                    );
                                @endphp
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $numberOfRentedUnits }}</h4>
                                    <span class="text-success">{{ $occupiedPercentage }}%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: {{ $occupiedPercentage }}%"
                                            role="progressbar" aria-valuenow="{{ $occupiedPercentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $numberOfVacantUnits }}</h4>
                                    <span class="text-danger">0%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: 0%" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Unit.IndexByUsage', '5') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-building ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Units') @lang('NonResidential')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            @if ($numberOfUnits > 0)
                                @php

                                    $occupiedPercentage = number_format(
                                        ($nonResidentialCount / $numberOfUnits) * 100,
                                        1,
                                    );
                                @endphp
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $nonResidentialCount }}</h4>
                                    <span class="text-success">{{ $occupiedPercentage }}%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: {{ $occupiedPercentage }}%"
                                            role="progressbar" aria-valuenow="{{ $occupiedPercentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $numberOfVacantUnits }}</h4>
                                    <span class="text-danger">0%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: 0%" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Unit.IndexByUsage', '4') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-building ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Units') @lang('Residential')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            @if ($numberOfUnits > 0)
                                @php

                                    $occupiedPercentage = number_format(($residentialCount / $numberOfUnits) * 100, 1);
                                @endphp
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $residentialCount }}</h4>
                                    <span class="text-success">{{ $occupiedPercentage }}%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: {{ $occupiedPercentage }}%"
                                            role="progressbar" aria-valuenow="{{ $occupiedPercentage }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h4 class="mb-0">{{ $numberOfVacantUnits }}</h4>
                                    <span class="text-danger">0%</span>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="progress w-100" style="height: 8px">
                                        <div class="progress-bar bg-primary" style="width: 0%" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Owner.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('owners')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h4 class="mb-0">{{ $numberOfowners }}</h4>
                                <span class="text-success"></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                {{-- <div class="progress w-100" style="height: 8px">
                              <div
                                class="progress-bar bg-primary"
                                style="width: 85%"
                                role="progressbar"
                                aria-valuenow="85"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Gallary.showInterests') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Requests for interest')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h4 class="mb-0">{{ $numberOfInterests }}</h4>
                                <span class="text-success"></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                {{-- <div class="progress w-100" style="height: 8px">
                              <div
                                class="progress-bar bg-primary"
                                style="width: 85%"
                                role="progressbar"
                                aria-valuenow="85"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div> --}}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Gallery.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Gallery visitors')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h4 class="mb-0">{{ $visitorCount }}</h4>
                                <span class="text-success"></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">
                                {{-- <div class="progress w-100" style="height: 8px">
                              <div
                                class="progress-bar bg-primary"
                                style="width: 85%"
                                role="progressbar"
                                aria-valuenow="85"
                                aria-valuemin="0"
                                aria-valuemax="100"></div>
                            </div> --}}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.RealEstateRequest.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-ticket ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Real Estate Requests')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @if ($requests)
                                    @foreach($requests as $request)
                                    @if ($request->requestStatuses)
                                    @foreach($request->requestStatuses as $status)
                                    @if ($status->interestType && $status->interestType->default === 1)
                                        @php
                                            $count++;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach
                                    @endif

                                @endforeach

                            <h4 class="mb-0">{{ $count }}</h4>
                            <span class="text-success"></span>
                                    @endif

                            </div>
                            <div class="d-flex align-items-center mt-1">

                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <a href="{{ route('Office.Tickets.index') }}" class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="ti ti-ticket ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('technical support')</h4>
                            </div>
                            <small class="text-muted"></small>
                        </div>
                        <div class="card-body">
                            <div id="ordersLastWeek"></div>
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <h4 class="mb-0">{{ $tickets->count() }}</h4>
                                <span class="text-success"></span>
                            </div>
                            <div class="d-flex align-items-center mt-1">

                            </div>
                        </div>
                    </a>
                </div>


                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card">
                        <h5 class="card-header">@lang('Unit indicators')</h5>
                        <div class="card-body">
                            @if($numberOfUnits)
                            <canvas id="doughnutChart"></canvas>
                            @else
                            <canvas id="doughnutChart"></canvas>
                            @endif
                        {{-- <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas> --}}
                        <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                            {{-- <li class="ct-series-0 d-flex flex-column">
                            <h5 class="mb-0">@lang('Number units')</h5>
                            <span
                                class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(102, 110, 232); width: 35px; height: 6px"></span>
                            <div class="text-muted">{{ $numberOfUnits }}</div>
                            </li> --}}
                            <li class="ct-series-1 d-flex flex-column">
                            <h5 class="mb-0">@lang('vacant')</h5>
                            <span
                                class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(40, 208, 148); width: 35px; height: 6px"></span>
                                @if($numberOfUnits)
                            <div class="text-muted"> {{ round(($numberOfVacantUnits / $numberOfUnits) * 100) }}%</div>
                            @else
                            <div class="text-muted"> 0%</div>
                            @endif
                            </li>
                            <li class="ct-series-2 d-flex flex-column">
                            <h5 class="mb-0">@lang('rented')</h5>
                            <span
                                class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(253, 172, 52); width: 35px; height: 6px"></span>
                                @if($numberOfUnits)
                            <div class="text-muted"> {{ round(($numberOfRentedUnits / $numberOfUnits) * 100) }}%</div>
                            @else
                            <div class="text-muted"> 0%</div>

                            @endif
                            </li>
                        </ul>

                        </div>
                    </div>
                </div>




            </div>
            {{-- analytics --}}
            <div class="row">
                {{-- <h4 class="ms-1 mb-0">@lang('Interactive Map') -  {{ $allItems->count() }} </h4> --}}

                <div class="nav-align-top nav-tabs-shadow mb-4">

                    <div class="card">

                        <div class="card-body">
                            @include('Admin.layouts.Inc._errors')
                            <div id="map" style="width: 100%; height: 70vh;"></div>
                        </div>
                    </div>
                </div>

            </div>

        {{-- <div class="row">

            <div class="col-lg-6 mb-4 order-md-0 order-lg-0">
                <div class="card">
                    <h5 class="card-header">@lang('Unit indicators')</h5>
                    <div class="card-body">
                        @if($numberOfUnits)
                        <canvas id="doughnutChart"></canvas>
                        @else
                        <canvas id="doughnutChart"></canvas>
                        @endif
                    <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">

                        <li class="ct-series-1 d-flex flex-column">
                        <h5 class="mb-0">@lang('vacant')</h5>
                        <span
                            class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(40, 208, 148); width: 35px; height: 6px"></span>
                            @if($numberOfUnits)
                        <div class="text-muted"> {{ round(($numberOfVacantUnits / $numberOfUnits) * 100) }}%</div>
                        @else
                        <div class="text-muted"> 0%</div>
                        @endif
                        </li>
                        <li class="ct-series-2 d-flex flex-column">
                        <h5 class="mb-0">@lang('rented')</h5>
                        <span
                            class="badge badge-dot my-2 cursor-pointer rounded-pill"
                            style="background-color: rgb(253, 172, 52); width: 35px; height: 6px"></span>
                            @if($numberOfUnits)
                        <div class="text-muted"> {{ round(($numberOfRentedUnits / $numberOfUnits) * 100) }}%</div>
                        @else
                        <div class="text-muted"> 0%</div>

                        @endif
                        </li>
                    </ul>

                    </div>
                </div>



            </div>
        </div> --}}

            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->
            @include('Office.settings.inc._upgradePackage')


        <div class="content-backdrop fade"></div>
        </div>
    </div>

     @include('Home.Payments.pending_payment')
    @include('Home.Payments._view_inv')

    {{-- @include('Office.inc._SubscriptionSuspend') --}}

    @push('scripts')
        @if ((Auth::user()->UserOfficeData->UserSubscriptionSuspend ?? null) && (Auth::user()->UserOfficeData->UserSubscriptionPending ?? null))
            <script>
                $(document).ready(function() {
                    $('.bs-example-modal-center').modal('show');
                });
            </script>

        @elseif (Auth::user()->UserOfficeData->UserSubscriptionPending ?? null)
        <script>
            $(document).ready(function() {
                $('.bs-example-modal-center2').modal('show');
            });

        </script>
    @endif

        <script>
            $('.view_inv').on('click', function() {
                var url = $(this).data('url');
                //
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        $("#ViewInvoice").empty();
                        $("#ViewInvoice").append(data);
                    },
                });
            })

            document.addEventListener("DOMContentLoaded", function() {
                var modalButton = document.getElementById('modalButton');
                if (modalButton) {
                    modalButton.click();
                }
            });
            //
            $('.subscription_type').on('change', function() {
                var url = $(this).data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        alertify.success(@json(__('Subscription has been updated')));
                    },
                });
            });
        </script>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            var numberOfUnits = {{ $numberOfUnits }};
            var numberOfVacantUnits = {{ $numberOfVacantUnits }};
            var numberOfRentedUnits = {{ $numberOfRentedUnits }};

            var vacantPercentage = 0;
            var rentedPercentage = 0;

            if (numberOfUnits > 0) {
                vacantPercentage = (numberOfVacantUnits / numberOfUnits) * 100;
                rentedPercentage = (numberOfRentedUnits / numberOfUnits) * 100;
            }else{
                vacantPercentage = 50;
                rentedPercentage = 50;;
            }

            var ctx = document.getElementById('doughnutChart').getContext('2d');
            var doughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                labels: ['Vacant', 'Rented'],
                datasets: [{
                    data: [vacantPercentage, rentedPercentage],
                    backgroundColor: [
                    'rgb(40, 208, 148)',
                    'rgb(253, 172, 52)'
                    ],
                    hoverOffset: 4
                }]
                },
                options: {
                responsive: true,
                plugins: {
                    legend: {
                    display: false
                    }
                }
                }
            });
            });
        </script>

        {{-- mapbox --}}

        <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />

<!-- Include Mapbox JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY2x6djJiaGZhMDNvdzJoc2djN2k4eHM0MiJ9.eOLXc1f7RLgcsbeIS4Us0Q'; // Replace with your Mapbox access token

    // Initialize Mapbox
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [45.0, 23.8859],
        zoom: 5
    });

    // Initial items (My Properties)
    var items = @json($allItems);
    var allItemsProperties = @json($allItemsProperties);

    function addMarkers(filteredItems) {
        filteredItems.forEach(function(item) {
            if (item.lat_long) {
                var coordinates = item.lat_long.split(',');
                var showRoute = '#';
                var rentPriceAndType = '';

                if (item.isGalleryUnit) {
                    showRoute = `{{ route('Office.Unit.show', ':id') }}`.replace(':id', item.id);
                    rentPriceAndType = `${item.rentPrice} @lang('SAR') / ${item.rent_type_show }`;
                } else if (item.isGalleryProject) {
                    showRoute = `{{ route('Office.Project.show', ':id') }}`.replace(':id', item.id);
                } else if (item.isGalleryProperty) {
                    showRoute = `{{ route('Office.Property.show', ':id') }}`.replace(':id', item.id);
                }
                new mapboxgl.Marker()
                    .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
                    .setPopup(new mapboxgl.Popup({ offset: 25 })
                        .setHTML(`
                        <div id="popup-${item.id}" style="width: 200px; cursor: pointer; display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <h6>${item.name || item.ad_name}</h6>
                            ${!item.isGalleryProject ? `
                                <p>
                                    <i class="ti ti-building-arch"></i> ${item.property_type_data ? item.property_type_data.name : ''} / ${item.type ? item.type : ''}
                                </p>
                            ` : ''}

                            ${item.isGalleryUnit ? `
                            <p>
                                <i class="ti ti-bell-dollar"></i>${rentPriceAndType ? `<span class="pb-1">${rentPriceAndType}</span>` : ''}
                            </p>
                             ` : ''}

                            <p>
                                ${item.isGalleryUnit ?
                                    (item.ProjectData ? `<span class="badge bg-label-secondary mt-1">${item.ProjectData.name}</span>` : '') +
                                    " " +
                                    (item.PropertyData ? `<span class="badge bg-label-secondary mt-1">${item.PropertyData.name}</span>` : '') +
                                    ` <span class="badge bg-label-secondary mt-1">@lang('Unit')</span>`
                                : item.isGalleryProperty ?
                                    (item.ProjectData ? `<span class="badge bg-label-secondary mt-1">${item.ProjectData.name}</span>` : '') +
                                    ` <span class="badge bg-label-secondary mt-1">@lang('Property')</span>`
                                : item.isGalleryProject ?
                                    `<span class="badge bg-label-secondary mt-1">@lang('Project')</span>`
                                : ''}
                            </p>
                            <p>
                                <i class="ti ti-map-pin"></i> ${item.city_data ? item.city_data.name : ''} / ${item.district_data ? item.district_data.name : ''}
                            </p>
                            <a href="${showRoute}" target="_blank" class="btn btn-primary mt-2">@lang('Show')</a>
                        </div>

                        `))
                    .addTo(map);
            }
        });
    }

    // Initial markers for My Properties
    addMarkers(items);

    function filterItems() {
                var adType = $('#adTypeFilter').val();
                var propertyType = $('#propertyTypeFilter').val();
                var typeUse = $('#typeUseFilter').val();
                var city = $('#cityFilter').val();
                var district = $('#districtFilter').val();
                var project = $('#projectFilter').val();

                var filteredItems = items.filter(function(item) {
                    return (!adType || item.type == adType) &&
                           (!propertyType || item.property_type_id == propertyType) &&
                           (!typeUse || item.property_usage_id == typeUse) &&
                           (!city || item.city_id == city) &&
                           (!district || item.district_id == district) &&
                           (!project || item.project_id == project);
                });

                // Remove existing markers
                $('.mapboxgl-marker').remove();

                // Add filtered markers to the first map
                addMarkers(filteredItems);

            }

            // Attach filter event handlers for the first map
            $('#adTypeFilter, #propertyTypeFilter, #typeUseFilter, #cityFilter, #districtFilter, #projectFilter').change(function() {
                filterItems();
            });

    // Toggle functionality
    document.getElementById('myPropertiesBtn').addEventListener('click', function() {
        $('#myPropertiesBtn').addClass('btn-primary').removeClass('btn-secondary');
        $('#allPropertiesBtn').addClass('btn-secondary').removeClass('btn-primary');

        // Remove existing markers
        $('.mapboxgl-marker').remove();

        // Add markers for My Properties
        addMarkers(items);
    });

    document.getElementById('allPropertiesBtn').addEventListener('click', function() {
        $('#myPropertiesBtn').addClass('btn-secondary').removeClass('btn-primary');
        $('#allPropertiesBtn').addClass('btn-primary').removeClass('btn-secondary');

        // Remove existing markers
        $('.mapboxgl-marker').remove();

        // Add markers for All Properties
        addMarkers(allItemsProperties);
    });
</script>

        {{-- end mapbox --}}
    @endpush
@endsection
