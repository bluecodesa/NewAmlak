@extends('Admin.layouts.app')
@section('title', __('dashboard'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- DataTable with Buttons -->
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <h4 class="mt-0 header-title">
                            {{ Auth::user()->UserBrokerData->UserSystemInvoiceLatest->subscription_name }}</h4>
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
            </div>
            <hr>
            <div class="row">

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('vacant')</h4>
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
                                    <h4 class="mb-0">{{ $numberOfVacantUnits }}</h4>
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
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-success"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('rented')</h4>
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
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-info"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Number units') @lang('NonResidential')</h4>
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
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-3">
                            <div class="d-flex align-items-center mb-2 pb-1">
                                <div class="avatar me-2">
                                    <span class="avatar-initial rounded bg-label-info"><i
                                            class="ti ti-users ti-md"></i></span>
                                </div>
                                <h4 class="ms-1 mb-0">@lang('Number units') @lang('Residential')</h4>
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
                    </div>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
                      <div class="card-header pb-3">
                        <div class="d-flex align-items-center mb-2 pb-1">
                            <div class="avatar me-2">
                              <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-users ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">@lang('Number Of Owners')</h4>
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
                </div>
                </div>
                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
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
                    </div>
                </div>

                <div class="col-xl-3 col-md-4 col-6 mb-4">
                    <div class="card h-100">
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
                    </div>
                </div>

            </div>
            {{-- analytics --}}

            <div class="row">
                {{-- <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between pb-0">
                <div class="card-title mb-0">
                  <h5 class="mb-0">@lang('Unit indicators')</h5>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                    <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                      <h1 class="mb-0">{{ $numberOfUnits }}</h1>
                      <p class="mb-0">@lang('Number units')</p>
                    </div>
                    <ul class="p-0 m-0">
                      <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                        <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i></div>
                        <div>
                          <h6 class="mb-0 text-nowrap"> @lang('vacant')</h6>
                          <small class="text-muted">{{$numberOfVacantUnits}}</small>
                        </div>
                      </li>
                      <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                        <div class="badge rounded bg-label-info p-1">
                          <i class="ti ti-circle-check ti-sm"></i>
                        </div>
                        <div>
                          <h6 class="mb-0 text-nowrap">@lang('rented')</h6>
                          <small class="text-muted">{{ $numberOfRentedUnits }}</small>
                        </div>
                      </li>

                    </ul>
                  </div>
                  <div class="col-12 col-sm-8 col-md-12 col-lg-8" style="position: relative;">
                   </div>
              </div>
            </div>
          </div>
           </div> --}}
                <div class="col-lg-6 mb-4 order-md-0 order-lg-0">
            <div class="card">
                <h5 class="card-header">@lang('Unit indicators')</h5>
                <div class="card-body">
                    <canvas id="doughnutChart"></canvas>

                  {{-- <canvas id="doughnutChart" class="chartjs mb-4" data-height="350"></canvas> --}}
                  <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                    <li class="ct-series-0 d-flex flex-column">
                      <h5 class="mb-0">@lang('Number units')</h5>
                      <span
                        class="badge badge-dot my-2 cursor-pointer rounded-pill"
                        style="background-color: rgb(102, 110, 232); width: 35px; height: 6px"></span>
                      <div class="text-muted">{{ $numberOfUnits }}</div>
                    </li>
                    <li class="ct-series-1 d-flex flex-column">
                      <h5 class="mb-0">@lang('vacant')</h5>
                      <span
                        class="badge badge-dot my-2 cursor-pointer rounded-pill"
                        style="background-color: rgb(40, 208, 148); width: 35px; height: 6px"></span>
                        @if($numberOfUnits)
                      <div class="text-muted"> {{ round(($numberOfVacantUnits / $numberOfUnits) * 100) }}%</div>
                      @endif
                    </li>
                    <li class="ct-series-2 d-flex flex-column">
                      <h5 class="mb-0">@lang('rented')</h5>
                      <span
                        class="badge badge-dot my-2 cursor-pointer rounded-pill"
                        style="background-color: rgb(253, 172, 52); width: 35px; height: 6px"></span>
                        @if($numberOfUnits)
                      <div class="text-muted"> {{ round(($numberOfRentedUnits / $numberOfUnits) * 100) }}%</div>
                      @endif
                    </li>
                  </ul>

                </div>
            </div>





            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->
            @include('Broker.settings.inc._upgradePackage')

        </div>

        <div class="content-backdrop fade"></div>
    </div>

     @include('Home.Payments.pending_payment')
    @include('Home.Payments._view_inv')

    @include('Broker.inc._SubscriptionSuspend')

    @push('scripts')
        @if ((Auth::user()->UserBrokerData->UserSubscriptionSuspend ?? null) && (Auth::user()->UserBrokerData->UserSubscriptionPending ?? null))
            <script>
                $(document).ready(function() {
                    $('.bs-example-modal-center').modal('show');
                });
            </script>

        @elseif (Auth::user()->UserBrokerData->UserSubscriptionPending ?? null)
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

    @endpush
@endsection
