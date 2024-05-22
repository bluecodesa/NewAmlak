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

<div class="row">
           <div class="col-md-6 mb-4">
            <div class="card h-50">
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
                    <div id="supportTracker" style="min-height: 257.9px;">
                        <div id="apexcharts1dvprzpx" class="apexcharts-canvas apexcharts1dvprzpx apexcharts-theme-light" style="width: 338px; height: 257.9px;">
                            <svg id="SvgjsSvg1942" width="338" height="257.9" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;">
                                <g id="SvgjsG1944" class="apexcharts-inner apexcharts-graphical" transform="translate(2, -10)">
                                    <defs id="SvgjsDefs1943"><clipPath id="gridRectMask1dvprzpx">
                                        <rect id="SvgjsRect1946" width="342" height="375" x="-3" y="-1" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                    </clipPath>
                                    <clipPath id="forecastMask1dvprzpx">
                                        </clipPath>
                                        <clipPath id="nonForecastMask1dvprzpx"></clipPath>
                                        <clipPath id="gridRectMarkerMask1dvprzpx">
                                            <rect id="SvgjsRect1947" width="340" height="377" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect>
                                        </clipPath>
                                        <linearGradient id="SvgjsLinearGradient1952" x1="1" y1="0" x2="0" y2="1">
                                            <stop id="SvgjsStop1953" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="0.3"></stop>
                                            <stop id="SvgjsStop1954" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="0.7"></stop>
                                            <stop id="SvgjsStop1955" stop-opacity="0.6" stop-color="rgba(255,255,255,0.6)" offset="1"></stop>
                                        </linearGradient>
                                        <linearGradient id="SvgjsLinearGradient1963" x1="1" y1="0" x2="0" y2="1">
                                            <stop id="SvgjsStop1964" stop-opacity="1" stop-color="rgba(115,103,240,1)" offset="0.3"></stop>
                                            <stop id="SvgjsStop1965" stop-opacity="0.6" stop-color="rgba(115,103,240,0.6)" offset="0.7">
                                                </stop>
                                                <stop id="SvgjsStop1966" stop-opacity="0.6" stop-color="rgba(115,103,240,0.6)" offset="1"></stop></linearGradient></defs><g id="SvgjsG1948" class="apexcharts-radialbar"><g id="SvgjsG1949"><g id="SvgjsG1950" class="apexcharts-tracks"><g id="SvgjsG1951" class="apexcharts-radialbar-track apexcharts-track" rel="1"><path id="apexcharts-radialbarTrack-0" d="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 259.1233220103534 244.46154589053606" fill="none" fill-opacity="1" stroke="rgba(255,255,255,0.85)" stroke-opacity="1" stroke-linecap="butt" stroke-width="22.632926829268296" stroke-dasharray="0" class="apexcharts-radialbar-area" data:pathOrig="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 259.1233220103534 244.46154589053606"></path></g></g><g id="SvgjsG1957"><g id="SvgjsG1962" class="apexcharts-series apexcharts-radial-series" seriesName="CompletedxTask" rel="1" data:realIndex="0"><path id="SvgjsPath1967" d="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 286.9530487804878 168" fill="none" fill-opacity="0.85" stroke="url(#SvgjsLinearGradient1963)" stroke-opacity="1" stroke-linecap="butt" stroke-width="22.632926829268296" stroke-dasharray="10" class="apexcharts-radialbar-area apexcharts-radialbar-slice-0" data:angle="230" data:value="85" index="0" j="0" data:pathOrig="M 91.53845410946391 259.1233220103534 A 118.9530487804878 118.9530487804878 0 1 1 286.9530487804878 168"></path></g><circle id="SvgjsCircle1958" r="102.63658536585366" cx="168" cy="168" class="apexcharts-radialbar-hollow" fill="transparent"></circle><g id="SvgjsG1959" class="apexcharts-datalabels-group" transform="translate(0, 0) scale(1)" style="opacity: 1;"><text id="SvgjsText1960" font-family="Public Sans" x="168" y="148" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="500" fill="#a5a3ae" class="apexcharts-text apexcharts-datalabel-label" style="font-family: &quot;Public Sans&quot;;">Completed Task</text><text id="SvgjsText1961" font-family="Public Sans" x="168" y="194" text-anchor="middle" dominant-baseline="auto" font-size="38px" font-weight="500" fill="#5d596c" class="apexcharts-text apexcharts-datalabel-value" style="font-family: &quot;Public Sans&quot;;">85%</text></g></g></g></g><line id="SvgjsLine1968" x1="0" y1="0" x2="336" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1969" x1="0" y1="0" x2="336" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line></g><g id="SvgjsG1945" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 363px; height: 307px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4 order-md-0 order-lg-0">
            <div class="card h-100">
              <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                <div class="card-title mb-0">
                  <h5 class="mb-0">Earning Reports</h5>
                  <small class="text-muted">Weekly Earnings Overview</small>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                    <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                      <h1 class="mb-0">$468</h1>
                      <div class="badge rounded bg-label-success">+4.2%</div>
                    </div>
                    <small class="text-muted">You informed of this week compared to last week</small>
                  </div>
                  <div class="col-12 col-md-8" style="position: relative;">
                    <div id="weeklyEarningReports" style="min-height: 202px;"><div id="apexchartsgj127yhy" class="apexcharts-canvas apexchartsgj127yhy apexcharts-theme-light" style="width: 299px; height: 202px;"><svg id="SvgjsSvg3271" width="299" height="202" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG3273" class="apexcharts-inner apexcharts-graphical" transform="translate(0, 0)"><defs id="SvgjsDefs3272"><linearGradient id="SvgjsLinearGradient3276" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop3277" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop3278" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop3279" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMaskgj127yhy"><rect id="SvgjsRect3281" width="313" height="162.73" x="-2" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="forecastMaskgj127yhy"></clipPath><clipPath id="nonForecastMaskgj127yhy"></clipPath><clipPath id="gridRectMarkerMaskgj127yhy"><rect id="SvgjsRect3282" width="313" height="166.73" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect3280" width="0" height="162.73" x="0" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient3276)" class="apexcharts-xcrosshairs" y2="162.73" filter="none" fill-opacity="0.9"></rect><g id="SvgjsG3301" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG3302" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"><text id="SvgjsText3304" font-family="Public Sans" x="22.071428571428573" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3305">Mo</tspan><title>Mo</title></text><text id="SvgjsText3307" font-family="Public Sans" x="66.21428571428572" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3308">Tu</tspan><title>Tu</title></text><text id="SvgjsText3310" font-family="Public Sans" x="110.35714285714288" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3311">We</tspan><title>We</title></text><text id="SvgjsText3313" font-family="Public Sans" x="154.5" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3314">Th</tspan><title>Th</title></text><text id="SvgjsText3316" font-family="Public Sans" x="198.64285714285714" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3317">Fr</tspan><title>Fr</title></text><text id="SvgjsText3319" font-family="Public Sans" x="242.7857142857143" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3320">Sa</tspan><title>Sa</title></text><text id="SvgjsText3322" font-family="Public Sans" x="286.9285714285715" y="191.73" text-anchor="middle" dominant-baseline="auto" font-size="13px" font-weight="400" fill="#a5a3ae" class="apexcharts-text apexcharts-xaxis-label " style="font-family: &quot;Public Sans&quot;;"><tspan id="SvgjsTspan3323">Su</tspan><title>Su</title></text></g></g><g id="SvgjsG3326" class="apexcharts-grid"><g id="SvgjsG3327" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine3329" x1="0" y1="0" x2="309" y2="0" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3330" x1="0" y1="32.546" x2="309" y2="32.546" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3331" x1="0" y1="65.092" x2="309" y2="65.092" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3332" x1="0" y1="97.638" x2="309" y2="97.638" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3333" x1="0" y1="130.184" x2="309" y2="130.184" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line><line id="SvgjsLine3334" x1="0" y1="162.73" x2="309" y2="162.73" stroke="#e0e0e0" stroke-dasharray="0" stroke-linecap="butt" class="apexcharts-gridline"></line></g><g id="SvgjsG3328" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine3336" x1="0" y1="162.73" x2="309" y2="162.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line><line id="SvgjsLine3335" x1="0" y1="1" x2="0" y2="162.73" stroke="transparent" stroke-dasharray="0" stroke-linecap="butt"></line></g><g id="SvgjsG3283" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG3284" class="apexcharts-series" rel="1" seriesName="seriesx1" data:realIndex="0"><path id="SvgjsPath3288" d="M 13.684285714285716 158.73L 13.684285714285716 101.63799999999999Q 13.684285714285716 97.63799999999999 17.684285714285714 97.63799999999999L 26.45857142857143 97.63799999999999Q 30.45857142857143 97.63799999999999 30.45857142857143 101.63799999999999L 30.45857142857143 101.63799999999999L 30.45857142857143 158.73Q 30.45857142857143 162.73 26.45857142857143 162.73L 17.684285714285714 162.73Q 13.684285714285716 162.73 13.684285714285716 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 13.684285714285716 158.73L 13.684285714285716 101.63799999999999Q 13.684285714285716 97.63799999999999 17.684285714285714 97.63799999999999L 26.45857142857143 97.63799999999999Q 30.45857142857143 97.63799999999999 30.45857142857143 101.63799999999999L 30.45857142857143 101.63799999999999L 30.45857142857143 158.73Q 30.45857142857143 162.73 26.45857142857143 162.73L 17.684285714285714 162.73Q 13.684285714285716 162.73 13.684285714285716 158.73z" pathFrom="M 13.684285714285716 158.73L 13.684285714285716 158.73L 30.45857142857143 158.73L 30.45857142857143 158.73L 30.45857142857143 158.73L 30.45857142857143 158.73L 30.45857142857143 158.73L 13.684285714285716 158.73" cy="97.63799999999999" cx="57.82714285714286" j="0" val="40" barHeight="65.092" barWidth="16.774285714285714"></path><path id="SvgjsPath3290" d="M 57.82714285714286 158.73L 57.82714285714286 60.95549999999999Q 57.82714285714286 56.95549999999999 61.82714285714286 56.95549999999999L 70.60142857142857 56.95549999999999Q 74.60142857142857 56.95549999999999 74.60142857142857 60.95549999999999L 74.60142857142857 60.95549999999999L 74.60142857142857 158.73Q 74.60142857142857 162.73 70.60142857142857 162.73L 61.82714285714286 162.73Q 57.82714285714286 162.73 57.82714285714286 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 57.82714285714286 158.73L 57.82714285714286 60.95549999999999Q 57.82714285714286 56.95549999999999 61.82714285714286 56.95549999999999L 70.60142857142857 56.95549999999999Q 74.60142857142857 56.95549999999999 74.60142857142857 60.95549999999999L 74.60142857142857 60.95549999999999L 74.60142857142857 158.73Q 74.60142857142857 162.73 70.60142857142857 162.73L 61.82714285714286 162.73Q 57.82714285714286 162.73 57.82714285714286 158.73z" pathFrom="M 57.82714285714286 158.73L 57.82714285714286 158.73L 74.60142857142857 158.73L 74.60142857142857 158.73L 74.60142857142857 158.73L 74.60142857142857 158.73L 74.60142857142857 158.73L 57.82714285714286 158.73" cy="56.95549999999999" cx="101.97" j="1" val="65" barHeight="105.7745" barWidth="16.774285714285714"></path><path id="SvgjsPath3292" d="M 101.97 158.73L 101.97 85.365Q 101.97 81.365 105.97 81.365L 114.74428571428571 81.365Q 118.74428571428571 81.365 118.74428571428571 85.365L 118.74428571428571 85.365L 118.74428571428571 158.73Q 118.74428571428571 162.73 114.74428571428571 162.73L 105.97 162.73Q 101.97 162.73 101.97 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 101.97 158.73L 101.97 85.365Q 101.97 81.365 105.97 81.365L 114.74428571428571 81.365Q 118.74428571428571 81.365 118.74428571428571 85.365L 118.74428571428571 85.365L 118.74428571428571 158.73Q 118.74428571428571 162.73 114.74428571428571 162.73L 105.97 162.73Q 101.97 162.73 101.97 158.73z" pathFrom="M 101.97 158.73L 101.97 158.73L 118.74428571428571 158.73L 118.74428571428571 158.73L 118.74428571428571 158.73L 118.74428571428571 158.73L 118.74428571428571 158.73L 101.97 158.73" cy="81.365" cx="146.11285714285714" j="2" val="50" barHeight="81.365" barWidth="16.774285714285714"></path><path id="SvgjsPath3294" d="M 146.11285714285714 158.73L 146.11285714285714 93.5015Q 146.11285714285714 89.5015 150.11285714285714 89.5015L 158.88714285714286 89.5015Q 162.88714285714286 89.5015 162.88714285714286 93.5015L 162.88714285714286 93.5015L 162.88714285714286 158.73Q 162.88714285714286 162.73 158.88714285714286 162.73L 150.11285714285714 162.73Q 146.11285714285714 162.73 146.11285714285714 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 146.11285714285714 158.73L 146.11285714285714 93.5015Q 146.11285714285714 89.5015 150.11285714285714 89.5015L 158.88714285714286 89.5015Q 162.88714285714286 89.5015 162.88714285714286 93.5015L 162.88714285714286 93.5015L 162.88714285714286 158.73Q 162.88714285714286 162.73 158.88714285714286 162.73L 150.11285714285714 162.73Q 146.11285714285714 162.73 146.11285714285714 158.73z" pathFrom="M 146.11285714285714 158.73L 146.11285714285714 158.73L 162.88714285714286 158.73L 162.88714285714286 158.73L 162.88714285714286 158.73L 162.88714285714286 158.73L 162.88714285714286 158.73L 146.11285714285714 158.73" cy="89.5015" cx="190.25571428571428" j="3" val="45" barHeight="73.2285" barWidth="16.774285714285714"></path><path id="SvgjsPath3296" d="M 190.25571428571428 158.73L 190.25571428571428 20.272999999999996Q 190.25571428571428 16.272999999999996 194.25571428571428 16.272999999999996L 203.03 16.272999999999996Q 207.03 16.272999999999996 207.03 20.272999999999996L 207.03 20.272999999999996L 207.03 158.73Q 207.03 162.73 203.03 162.73L 194.25571428571428 162.73Q 190.25571428571428 162.73 190.25571428571428 158.73z" fill="rgba(115,103,240,0.85)" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 190.25571428571428 158.73L 190.25571428571428 20.272999999999996Q 190.25571428571428 16.272999999999996 194.25571428571428 16.272999999999996L 203.03 16.272999999999996Q 207.03 16.272999999999996 207.03 20.272999999999996L 207.03 20.272999999999996L 207.03 158.73Q 207.03 162.73 203.03 162.73L 194.25571428571428 162.73Q 190.25571428571428 162.73 190.25571428571428 158.73z" pathFrom="M 190.25571428571428 158.73L 190.25571428571428 158.73L 207.03 158.73L 207.03 158.73L 207.03 158.73L 207.03 158.73L 207.03 158.73L 190.25571428571428 158.73" cy="16.272999999999996" cx="234.39857142857142" j="4" val="90" barHeight="146.457" barWidth="16.774285714285714"></path><path id="SvgjsPath3298" d="M 234.39857142857142 158.73L 234.39857142857142 77.2285Q 234.39857142857142 73.2285 238.39857142857142 73.2285L 247.17285714285714 73.2285Q 251.17285714285714 73.2285 251.17285714285714 77.2285L 251.17285714285714 77.2285L 251.17285714285714 158.73Q 251.17285714285714 162.73 247.17285714285714 162.73L 238.39857142857142 162.73Q 234.39857142857142 162.73 234.39857142857142 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 234.39857142857142 158.73L 234.39857142857142 77.2285Q 234.39857142857142 73.2285 238.39857142857142 73.2285L 247.17285714285714 73.2285Q 251.17285714285714 73.2285 251.17285714285714 77.2285L 251.17285714285714 77.2285L 251.17285714285714 158.73Q 251.17285714285714 162.73 247.17285714285714 162.73L 238.39857142857142 162.73Q 234.39857142857142 162.73 234.39857142857142 158.73z" pathFrom="M 234.39857142857142 158.73L 234.39857142857142 158.73L 251.17285714285714 158.73L 251.17285714285714 158.73L 251.17285714285714 158.73L 251.17285714285714 158.73L 251.17285714285714 158.73L 234.39857142857142 158.73" cy="73.2285" cx="278.5414285714286" j="5" val="55" barHeight="89.5015" barWidth="16.774285714285714"></path><path id="SvgjsPath3300" d="M 278.5414285714286 158.73L 278.5414285714286 52.81899999999999Q 278.5414285714286 48.81899999999999 282.5414285714286 48.81899999999999L 291.3157142857143 48.81899999999999Q 295.3157142857143 48.81899999999999 295.3157142857143 52.81899999999999L 295.3157142857143 52.81899999999999L 295.3157142857143 158.73Q 295.3157142857143 162.73 291.3157142857143 162.73L 282.5414285714286 162.73Q 278.5414285714286 162.73 278.5414285714286 158.73z" fill="#7367f029" fill-opacity="1" stroke-opacity="1" stroke-linecap="round" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMaskgj127yhy)" pathTo="M 278.5414285714286 158.73L 278.5414285714286 52.81899999999999Q 278.5414285714286 48.81899999999999 282.5414285714286 48.81899999999999L 291.3157142857143 48.81899999999999Q 295.3157142857143 48.81899999999999 295.3157142857143 52.81899999999999L 295.3157142857143 52.81899999999999L 295.3157142857143 158.73Q 295.3157142857143 162.73 291.3157142857143 162.73L 282.5414285714286 162.73Q 278.5414285714286 162.73 278.5414285714286 158.73z" pathFrom="M 278.5414285714286 158.73L 278.5414285714286 158.73L 295.3157142857143 158.73L 295.3157142857143 158.73L 295.3157142857143 158.73L 295.3157142857143 158.73L 295.3157142857143 158.73L 278.5414285714286 158.73" cy="48.81899999999999" cx="322.68428571428575" j="6" val="70" barHeight="113.911" barWidth="16.774285714285714"></path><g id="SvgjsG3286" class="apexcharts-bar-goals-markers" style="pointer-events: none"><g id="SvgjsG3287" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3289" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3291" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3293" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3295" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3297" className="apexcharts-bar-goals-groups"></g><g id="SvgjsG3299" className="apexcharts-bar-goals-groups"></g></g></g><g id="SvgjsG3285" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine3337" x1="0" y1="0" x2="309" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" stroke-linecap="butt" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine3338" x1="0" y1="0" x2="309" y2="0" stroke-dasharray="0" stroke-width="0" stroke-linecap="butt" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG3339" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG3340" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG3341" class="apexcharts-point-annotations"></g></g><g id="SvgjsG3324" class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)"><g id="SvgjsG3325" class="apexcharts-yaxis-texts-g"></g></g><g id="SvgjsG3274" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend" style="max-height: 101px;"></div></div></div>
                  <div class="resize-triggers"><div class="expand-trigger"><div style="width: 324px; height: 203px;"></div></div><div class="contract-trigger"></div></div></div>
                </div>
                <div class="border rounded p-3 mt-2">
                  <div class="row gap-4 gap-sm-0">
                    <div class="col-12 col-sm-4">
                      <div class="d-flex gap-2 align-items-center">
                        <div class="badge rounded bg-label-primary p-1">
                          <i class="ti ti-currency-dollar ti-sm"></i>
                        </div>
                        <h6 class="mb-0">Earnings</h6>
                      </div>
                      <h4 class="my-2 pt-1">$545.69</h4>
                      <div class="progress w-75" style="height: 4px">
                        <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="d-flex gap-2 align-items-center">
                        <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                        <h6 class="mb-0">Profit</h6>
                      </div>
                      <h4 class="my-2 pt-1">$256.34</h4>
                      <div class="progress w-75" style="height: 4px">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="d-flex gap-2 align-items-center">
                        <div class="badge rounded bg-label-danger p-1">
                          <i class="ti ti-brand-paypal ti-sm"></i>
                        </div>
                        <h6 class="mb-0">Expense</h6>
                      </div>
                      <h4 class="my-2 pt-1">$74.19</h4>
                      <div class="progress w-75" style="height: 4px">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
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
