@extends('Admin.layouts.app')

@section('title', __('dashboard'))

@section('content')



    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
         <div class="col-xl-3 col-md-4 col-6 mb-4">
            <a class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Office')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $numOffice }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Broker')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $numBroker }}</h4>
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
            <a class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Renters')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $numRenter }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Property Finder')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $numProertyFinder }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Property Finder')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $numOfOwners }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-menu-order ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Interests Order')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $unit_interests }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-menu-order ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Real Estate Requests')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $RealEstateRequests }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-ticket ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Tickets')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $tickets }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('New subscriptions')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $subscriptions }}</h4>
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
            <a  class="card h-100">
                <div class="card-header pb-3">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary"><i
                                    class="ti ti-users ti-md"></i></span>
                        </div>
                        <h4 class="ms-1 mb-0">@lang('Expired subscriptions')</h4>
                    </div>
                    <small class="text-muted"></small>
                </div>
                <div class="card-body">
                    <div id="ordersLastWeek"></div>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <h4 class="mb-0">{{ $subscriptionsEndingToday}}</h4>
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
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="card">
                <h5 class="card-header">@lang('Clients')</h5>
                <div class="card-body">
                    <canvas id="rolesChart" height="100"></canvas>
                    <ul class="doughnut-legend d-flex justify-content-around ps-0 mb-2 pt-1">
                        <li class="ct-series-0 d-flex flex-column">
                            <h5 class="mb-0">@lang('Office')</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(102, 110, 232); width: 35px; height: 6px"></span>
                            <div class="text-muted">{{ $numberOfOffices }} ({{ round($officePercentage, 2) }}%)</div>
                        </li>
                        <li class="ct-series-1 d-flex flex-column">
                            <h5 class="mb-0">@lang('Broker')</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(40, 208, 148); width: 35px; height: 6px"></span>
                            <div class="text-muted">{{ $numberOfBrokers }} ({{ round($brokerPercentage, 2) }}%)</div>
                        </li>
                        <li class="ct-series-2 d-flex flex-column">
                            <h5 class="mb-0">@lang('Property Finder')</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(253, 172, 52); width: 35px; height: 6px"></span>
                            <div class="text-muted">{{ $numberOfPropertyFinders }} ({{ round($propertyFinderPercentage, 2) }}%)</div>
                        </li>
                        <li class="ct-series-3 d-flex flex-column">
                            <h5 class="mb-0">@lang('Renters')</h5>
                            <span class="badge badge-dot my-2 cursor-pointer rounded-pill"
                                style="background-color: rgb(235, 75, 75); width: 35px; height: 6px"></span>
                            <div class="text-muted">{{ $numberOfRenters }} ({{ round($renterPercentage, 2) }}%)</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 col-6 mb-4">
            <div class="card">
                <h5 class="card-header">@lang('Gallery visitors')</h5>
                <div class="card-body">
                <canvas id="dayChart" height="200"></canvas>
                </div>
            </div>
        </div>


    </div>

        </div>
        <!-- / Content -->

        <!-- Footer -->

        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Pending Payment Modal -->

    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
    @endif --}}

    <script></script>

    @push('scripts')
        <script>
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
        var ctx = document.getElementById('rolesChart').getContext('2d');
        var rolesChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['offices', 'Brokers', 'Property Finders', 'Renters'],
                datasets: [{
                    data: [
                        {{ $officePercentage }},
                        {{ $brokerPercentage }},
                        {{ $propertyFinderPercentage }},
                        {{ $renterPercentage }}
                    ],
                    backgroundColor: [
                        'rgb(102, 110, 232)',
                        'rgb(40, 208, 148)',
                        'rgb(253, 172, 52)',
                        'rgb(235, 75, 75)'
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('dayChart').getContext('2d');
        var dayChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                datasets: [{
                    label: 'Number of Visitors',
                    data: [
                        {{ $visitorCounts['Sunday'] }},
                        {{ $visitorCounts['Monday'] }},
                        {{ $visitorCounts['Tuesday'] }},
                        {{ $visitorCounts['Wednesday'] }},
                        {{ $visitorCounts['Thursday'] }},
                        {{ $visitorCounts['Friday'] }},
                        {{ $visitorCounts['Saturday'] }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(40, 208, 148, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(40, 208, 148, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
    @endpush


@endsection
