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
                        <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                        <a href="{{ route('welcome') }}#landingPricing" class="btn btn-secondary modal-btn2 w-auto"
                            target="_blank">@lang('Compare Plans')</a>
                    @elseif ($daysUntilEnd <= 7)
                        <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#basicModal">@lang('Subscription upgrade')</button>
                        <a href="{{ route('welcome') }}#landingPricing" class="btn btn-secondary modal-btn2 w-auto"
                            target="_blank">@lang('Compare Plans')</a>
                    @elseif ($daysUntilEnd <= 0)
                        <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
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
                              <span class="avatar-initial rounded bg-label-success"><i class="ti ti-users ti-md"></i></span>
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
                              <div
                                class="progress-bar bg-primary"
                                style="width: {{ $occupiedPercentage }}%"
                                role="progressbar"
                                aria-valuenow="{{ $occupiedPercentage }}"
                                aria-valuemin="0"
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
                            <div
                              class="progress-bar bg-primary"
                              style="width: 0%"
                              role="progressbar"
                              aria-valuenow="0"
                              aria-valuemin="0"
                              aria-valuemax="100"></div>
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
                              <span class="avatar-initial rounded bg-label-success"><i class="ti ti-users ti-md"></i></span>
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
                              <div
                                class="progress-bar bg-primary"
                                style="width: {{ $occupiedPercentage }}%"
                                role="progressbar"
                                aria-valuenow="{{ $occupiedPercentage }}"
                                aria-valuemin="0"
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
                            <div
                              class="progress-bar bg-primary"
                              style="width: 0%"
                              role="progressbar"
                              aria-valuenow="0"
                              aria-valuemin="0"
                              aria-valuemax="100"></div>
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
                              <span class="avatar-initial rounded bg-label-info"><i class="ti ti-users ti-md"></i></span>
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
                              <div
                                class="progress-bar bg-primary"
                                style="width: {{ $occupiedPercentage }}%"
                                role="progressbar"
                                aria-valuenow="{{ $occupiedPercentage }}"
                                aria-valuemin="0"
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
                            <div
                              class="progress-bar bg-primary"
                              style="width: 0%"
                              role="progressbar"
                              aria-valuenow="0"
                              aria-valuemin="0"
                              aria-valuemax="100"></div>
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
                              <span class="avatar-initial rounded bg-label-info"><i class="ti ti-users ti-md"></i></span>
                            </div>
                            <h4 class="ms-1 mb-0">@lang('Number units') @lang('Residential')</h4>
                          </div>
                        <small class="text-muted"></small>
                      </div>
                      <div class="card-body">
                        <div id="ordersLastWeek"></div>
                        @if ($numberOfUnits > 0)
                        @php

                            $occupiedPercentage = number_format(
                                ($residentialCount / $numberOfUnits) * 100,
                                1,
                            );
                        @endphp
                        <div class="d-flex justify-content-between align-items-center gap-3">
                          <h4 class="mb-0">{{ $residentialCount }}</h4>
                          <span class="text-success">{{ $occupiedPercentage }}%</span>
                        </div>
                        <div class="d-flex align-items-center mt-1">
                            <div class="progress w-100" style="height: 8px">
                              <div
                                class="progress-bar bg-primary"
                                style="width: {{ $occupiedPercentage }}%"
                                role="progressbar"
                                aria-valuenow="{{ $occupiedPercentage }}"
                                aria-valuemin="0"
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
                            <div
                              class="progress-bar bg-primary"
                              style="width: 0%"
                              role="progressbar"
                              aria-valuenow="0"
                              aria-valuemin="0"
                              aria-valuemax="100"></div>
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
                              <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-users ti-md"></i></span>
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


           <div class="col-md-6 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex justify-content-between pb-0">
                <div class="card-title mb-0">
                  <h5 class="mb-0">Support Tracker</h5>
                  <small class="text-muted">Last 7 Days</small>
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
                      <h1 class="mb-0">164</h1>
                      <p class="mb-0">Total Tickets</p>
                    </div>
                    <ul class="p-0 m-0">
                      <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                        <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i></div>
                        <div>
                          <h6 class="mb-0 text-nowrap">New Tickets</h6>
                          <small class="text-muted">142</small>
                        </div>
                      </li>
                      <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                        <div class="badge rounded bg-label-info p-1">
                          <i class="ti ti-circle-check ti-sm"></i>
                        </div>
                        <div>
                          <h6 class="mb-0 text-nowrap">Open Tickets</h6>
                          <small class="text-muted">28</small>
                        </div>
                      </li>
                      <li class="d-flex gap-3 align-items-center pb-1">
                        <div class="badge rounded bg-label-warning p-1"><i class="ti ti-clock ti-sm"></i></div>
                        <div>
                          <h6 class="mb-0 text-nowrap">Response Time</h6>
                          <small class="text-muted">1 Day</small>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-12 col-sm-8 col-md-12 col-lg-8" style="position: relative;">
                    <div id="supportTracker" style="min-height: 257.9px;"><div id="apexcharts1dvprzpx" class="apexcharts-canvas apexcharts1dvprzpx apexcharts-theme-light" style="width: 338px; height: 257.9px;"><svg id="SvgjsSvg1942" width="338" height="257.9" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1944" class="apexcharts-inner apexcharts-graphical" transform="translate(2, -10)"><defs id="SvgjsDefs1943"><clipPath id="gridRectMask1dvprzpx"><rect id="SvgjsRect1946" width="342" height="375" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMask1dvprzpx"></clipPath><clipPath id="nonForecastMask1dvprzpx"></clipPath><clipPath id="gridRectMarkerMask1dvprzpx"><rect id="SvgjsRect1947" width="340" height="377" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><linearGradient id="SvgjsLinearGradient1952" x1="1" y1="0" x2="0" y2="1"><stop id="SvgjsStop1953" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="0.3"></stop><stop id="SvgjsStop1954" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="0.7"></stop><stop id="SvgjsStop1955" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="1"></stop></linearGradient><linearGradient id="SvgjsLinearGradient1963" x1="1" y1="0" x2="0" y2="1"><stop id="SvgjsStop1964" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="0.3"></stop><stop id="SvgjsStop1965" stop-opacity="0.6" stop-color="rgba(115,103,240,0.6)" offset="0.7"></stop><stop id="SvgjsStop1966" stop-opacity="0.6" stop-color="rgba(115,103,240,0.6)" offset="1"></stop></linearGradient></defs><g id="SvgjsG1948" class="apexcharts-radialbar"><g id="SvgjsG1949"><g id="SvgjsG1950" class="apexcharts-tracks"><g id="SvgjsG1951" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 259.1233220103534 244.46154589053606" fill="none" fill-opacity="1" stroke="rgba(255,255,255,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="22.632926829268296" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 259.1233220103534 244.46154589053606"></path></g></g><g id="SvgjsG1957"><g id="SvgjsG1962" class="apexcharts-series apexcharts-radial-series" seriesName="CompletedxTask" rel="1" data:realIndex="0"><path id="SvgjsPath1967" d="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 286.9530487804878 168" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient1963)" stroke-opacity="1" stroke-linecap="butt" stroke-width="22.632926829268296" stroke-dasharray="10" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="230" data:value="85" index="0" j="0" data:pathOrig="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 286.9530487804878 168"></path></g><circle id="SvgjsCircle1958" r="102.63658536585366" cx="168" cy="168" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1959" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;"><text id="SvgjsText1960" font-family="Public Sans" x="168" y="148" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="500" fill="#a5a3ae" class="apexcharts-text apexcharts-datalabel-label" style="font-family: &quot;Public Sans&quot;;">Completed Task</text><text id="SvgjsText1961" font-family="Public Sans" x="168" y="194" text-anchor="middle" dominant-baseline="auto" font-size="38px" font-weight="500" fill="#5d596c" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">85%</text></g></g></g></g><line id="SvgjsLine1968" x1="0" y1="0" x2="336" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1969" x1="0" y1="0" x2="336" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1945" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 363px; height: 307px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
            </div>
          </div>

            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->
            @include('Broker.settings.inc._upgradePackage')

        </div>

        <div class="content-backdrop fade"></div>
    </div>

    @if (Auth::user()->UserBrokerData->UserSubscriptionPending ?? null)
        @include('Home.Payments.pending_payment')
    @endif
    @include('Home.Payments._view_inv')

    @include('Broker.inc._SubscriptionSuspend')

    @push('scripts')
        @if (Auth::user()->UserBrokerData->UserSubscriptionSuspend ?? null)
            <script>
                $(document).ready(function() {
                    $('.bs-example-modal-center').modal('show');
                });
            </script>
        @endif

        @if (Auth::user()->UserBrokerData->UserSubscriptionPending ?? null)
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
        <script>
            // Function to calculate percentage completion
            function calculatePercentage(start_date, end_date) {
                var startDate = new Date(start_date);
                var endDate = new Date(end_date);
                var currentDate = new Date();
                var totalDuration = endDate - startDate;
                var remainingDuration = endDate - currentDate;
                var percentageCompletion = (remainingDuration / totalDuration) * 100;

                return Math.min(Math.max(percentageCompletion, 0), 100); // Ensure percentage is between 0 and 100
            }

            // Call the function to update the progress bar
            var startDate = '{{ $subscriber->start_date }}';
            var endDate = '{{ $subscriber->end_date }}';
            var percentage = calculatePercentage(startDate, endDate);
            document.getElementById('progress-bar-{{ $subscriber->id }}').style.width = percentage + '%';
            document.getElementById('progress-bar-{{ $subscriber->id }}').innerText = percentage.toFixed(2) +
                '%'; // Round to 2 decimal places
        </script>





    @endpush
@endsection
