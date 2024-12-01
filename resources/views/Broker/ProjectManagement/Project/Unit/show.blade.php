@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')


    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Unit.index') }}" class="text-muted fw-light">@lang('Units') </a> /
                        {{ $Unit->number_unit }}
                    </h4>
                </div>

            </div>
            <div class="row">

                <!-- User Sidebar -->
                <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                    <!-- project Card -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="user-avatar-section">
                                <div class="d-flex align-items-center flex-column">

                                    <div class="row">
                                        @forelse($Unit->UnitImages as $image)
                                            <div class="col-6 mb-1">
                                                <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ url($image->image) }}"
                                                    alt="{{ $Unit->name }}" height="100" width="100">
                                            </div>
                                        @empty

                                            <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                                src="{{ url('Offices/Projects/default.svg') }}" alt="{{ $Unit->name }}"
                                                height="100" width="100">
                                        @endforelse
                                        <div class="user-info text-center">
                                            <h4 class="mb-2">{{ $Unit->number_unit }}</h4>
                                            <span class="badge bg-label-secondary mt-1">@lang('Unit')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                                <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-checkbox ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium"> @lang('Residential number')</p>
                                        <small> {{ $Unit->number_unit }}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-briefcase ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium">@lang('Region')</p>
                                        <small>{{ $Unit->CityData->RegionData->name ?? __('nothing') }}</small>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                            <div class="info-container">
                                <ul class="list-unstyled">

                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('owner name') :</span>
                                        <span>{{ $Unit->OwnerData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Property type') :</span>
                                        <span>{{ $Unit->PropertyTypeData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('location name') :</span>
                                        <span>{!! Str::limit($Unit->location, 25, ' ...') !!}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1"> @lang('city') :</span>
                                        <span>{{ $Unit->CityData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Instrument number') :</span>
                                        <span>{{ $Unit->instrument_number ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Type use') :</span>
                                        <span>{{ $Unit->PropertyUsageData->name ?? __('nothing') }}
                                        </span>
                                    </li>

                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('service type') :</span>
                                        <span>{{ $Unit->ServiceTypeData->name ?? __('nothing') }}
                                        </span>
                                    </li>

                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Ad type') :</span>
                                        <span>{{ __($Unit->type) ?? __('nothing') }}</span>
                                    </li>

                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Show in Gallery') :</span>
                                        <span> {{ $Unit->show_gallery == 1 ? __('Show') : __('hide') }}</span>
                                    </li>

                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Rental price') :</span>
                                        <span> {{ $Unit->getRentPriceByType() }} <sup>@lang('SAR') /
                                                {{ __($Unit->rent_type_show) }}
                                            </sup> </span>
                                    </li>





                                </ul>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('Broker.Unit.edit', $Unit->id) }}"
                                        class="btn btn-warning me-3">@lang('Edit')</a>

                                    @php($types = ['daily', 'monthly', 'quarterly', 'midterm', 'yearly'])


                                    <div class="">
                                        <select class="form-select UpdateRentPriceByType">
                                            <option disabled value="" selected>@lang('Choose the rental price')
                                            </option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type }}"
                                                    data-url="{{ route('Broker.Unit.UpdateRentPriceByType', $Unit->id) }}"
                                                    data-type="{{ $type }}">
                                                    {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /project Card -->
                    <!-- Plan Card -->

                </div>

                <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <iframe width="100%" height="200" frameborder="0" style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $Unit->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <small class="text-light fw-medium">@lang('Additional details')</small>
                                    <div class="demo-inline-spacing mt-3">
                                        <ul class="list-group">
                                            @forelse ($Unit->UnitFeatureData as $feature)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $feature->FeatureData->name ?? '' }}
                                                    <span class="badge bg-primary">{{ $feature->qty }}</span>
                                                </li>
                                            @empty
                                            @endforelse

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <small class="text-light fw-medium">@lang('services')</small>
                                    <div class="demo-inline-spacing mt-3">
                                        <ul class="list-group">
                                            @forelse ($Unit->UnitServicesData as $service)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $service->ServiceData->name ?? '' }}

                                                </li>
                                            @empty
                                            @endforelse

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- property table -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('Requests for interest')</h5>
                        </div>

                        <div class="card-datatable table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                <div class="card-header border-top rounded-0 py-2">
                                    <div class="row">
                                        <div class="col-6">

                                            <div class="me-5 ms-n2 pe-5">
                                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                        <input id="SearchInput" class="form-control"
                                                            placeholder="@lang('search...')"
                                                            aria-controls="DataTables_Table_0"></label></div>
                                            </div>
                                        </div>
                                        <div class="col-6">

                                            <div
                                                class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                                <div
                                                    class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                    <div class="dt-buttons btn-group flex-wrap d-flex">
                                                        <button onclick="exportToExcel()"
                                                            class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false"><span>
                                                                <i class="ti ti-download me-1 ti-xs"></i><span
                                                                    class="d-none d-sm-inline-block">Export</span></span></button>
                                                        {{-- <button class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                            <span class="d-none d-sm-inline-block">@lang('Add')</span></span></button> --}}


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
                                                <th>@lang('Client Name')</th>
                                                <th>@lang('phone')</th>
                                                <th>@lang('status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($unitInterests as $index => $client)
                                                <tr>
                                                    <td> {{ $client->name }}</td>
                                                    <td>+{{ $client->key_phone }} {{ $client->whatsapp }}</td>
                                                    <td>
                                                        <form method="POST"
                                                            action="{{ route('Broker.Interest.status.update', $client->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $client->id }}">
                                                            <select class="form-control select-input w-auto"
                                                                name="status" onchange="this.form.submit()">
                                                                @foreach ($interestsTypes as $interestsType)
                                                                    <option value="{{ $interestsType->id }}"
                                                                        {{ $client->status == $interestsType->id ? 'selected' : '' }}>
                                                                        {{ __($interestsType->name) }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <button type="submit" class="submit-from"
                                                                hidden=""></button>
                                                        </form>


                                                    </td>

                                                    <td>
                                                        <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light"
                                                            data-toggle="modal"
                                                            data-target="#shareLinkUnit{{ $client->id }}"
                                                            href="tel:{{ env('COUNTRY_CODE') . $client->whatsapp }}"
                                                            onclick="document.querySelector('#shareLinkUnit{{ $client->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                            @lang('Call')</a>
                                                        <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $client->whatsapp }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('محادثة(شات)')</a>


                                                    </td>
                                                </tr>
                                            @empty
                                                <td colspan="6">
                                                    <div class="alert alert-danger d-flex align-items-center"
                                                        role="alert">
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
                    </div>
                    <!-- /property table -->




                </div>
                <!--/ User Content -->
            </div>

            <!-- Modal -->

            <!-- container-fluid -->




            <!-- /Modal -->
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script>
            function exportToExcel() {
                var wb = XLSX.utils.table_to_book(document.getElementById('table'), {
                    sheet: "Sheet1"
                });
                XLSX.writeFile(wb, @json(__('Requests for interest')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
        <script>
            $('.UpdateRentPriceByType').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                var rent_type_show = selectedOption.data('type');
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        rent_type_show: rent_type_show
                    },
                    success: function(data) {
                        alertify.success(@json(__('rental price has been updated')));
                        // setTimeout(location.reload(), 5000);
                        setTimeout(function() {
                            location.reload()
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
