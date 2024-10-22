@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

<style>
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.animate-alarm {
    color: red; /* Change the color to red */
    animation: pulse 1s infinite; /* Add pulse animation */
}

.icon-large {
    font-size: 35px; /* Adjust the size of the icon here */
    transition: transform 0.2s; /* Smooth scale effect on hover */
}

.icon-large:hover {
    transform: scale(1.2); /* Enlarge the icon slightly on hover */
}
</style>
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Unit.index') }}" class="text-muted fw-light">@lang('Units') </a> /
                        {{ $Unit->number_unit }}
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
                        data-bs-target="#navs-justified-requests"
                        aria-controls="navs-justified-requests"
                        aria-selected="false">
                        <i class="tf-icons ti ti-adjustments ti-xs me-1"></i> @lang('Requests for interest')
                      </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-justified-license"
                            aria-controls="navs-justified-license"
                            aria-selected="false">

                            @if ($Unit->show_gallery != 1)
                                <i class="tf-icons ti ti-alarm me-1 text-danger animate-alarm icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة غير منشورة في المعرض اضغط هنا للنشر')"></i>
                                <span class=" text-danger animate-alarm">@lang(' الاعلان العقاري')</span>
                            @else
                                <i class="tf-icons ti ti-alarm ti-xs me-1 text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة منشوره في المعرض')"></i>
                                <span class="text-success">@lang(' الاعلان العقاري')</span>
                            @endif


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
                        <i class="tf-icons ti ti-list-check ti-xs me-1"></i> @lang('عقود إيجار')
                      </button>
                    </li>
                    <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-justified-services"
                          aria-controls="navs-justified-services"
                          aria-selected="false">
                          <i class="tf-icons ti ti-list-details ti-xs me-1"></i> @lang('Additional services')
                        </button>
                      </li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">

                    <div class="row">

                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- project Card -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            @if ($Unit->show_gallery != 1)
                                                <i class="tf-icons ti ti-alarm me-1 text-danger animate-alarm icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة غير منشورة في المعرض اضغط هنا للنشر')">
                                                <span class="text-danger">@lang('Unpublished')</span>

                                                </i>

                                            @else
                                                <i class="tf-icons ti ti-alarm me-1 text-success icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة منشوره في المعرض')">
                                                <span class="text-success">@lang('Published')</span>

                                                </i>
                                            @endif
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
                                                    @if ($Unit->ProjectData)
                                                    <span class="badge bg-label-secondary mt-1"> <a class="bg-label-secondary" href="{{ route('Office.Project.show', $Unit->ProjectData->id) }}" class="text-white">
                                                        {{ $Unit->ProjectData->name ?? '' }}
                                                    </a></span>
                                                    @endif
                                                    @if ( $Unit->PropertyData)
                                                    <span class="badge bg-label-secondary mt-1"> <a class="bg-label-secondary" href="{{ route('Office.Property.show', $Unit->PropertyData->id) }}" class="text-white">
                                                        {{ $Unit->PropertyData->name ?? '' }}
                                                    </a></span>
                                                    @endif
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
                                                @if ($Unit->type == 'rent and sale')
                                                <span>@lang('sale')</span> /
                                                <span>@lang('rent')</span>

                                                @else
                                                <span>{{ __($Unit->type) ?? __('nothing') }}</span>
                                                @endif
                                            </li>

                                            <li class="mb-2 pt-1">
                                                <span class="fw-medium me-1">@lang('Show in Gallery') :</span>
                                                <span> {{ $Unit->show_gallery == 1 ? __('Published') : __('Unpublished') }}</span>
                                            </li>

                                                @if ($Unit->type == 'rent')
                                                @if ($Unit->getRentPriceByType())
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Rental price') :</span>
                                                    <span >
                                                        {{ $Unit->getRentPriceByType() }} @lang('SAR') / {{ __($Unit->rent_type_show) }}
                                                    </span>
                                                </li>
                                                @endif
                                            @elseif ($Unit->type == 'sale')
                                                @if ($Unit->price)
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Sale price') :</span>
                                                    <span >
                                                {{ $Unit->price }} @lang('SAR')
                                                    </span>
                                                </li>
                                                @endif
                                            @else
                                                @if ($Unit->getRentPriceByType())
                                                <li class="mb-2 pt-1">
                                                <span class="fw-medium me-1">@lang('Rental price') :</span>
                                                <span class="pb-1">
                                                    {{ $Unit->getRentPriceByType() }} @lang('SAR') / {{ __($Unit->rent_type_show) }}
                                                </span>
                                                </li>
                                                @elseif ($Unit->price)
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Sale price') :</span>
                                                <span class="pb-1">
                                                {{ $Unit->price }} @lang('SAR')
                                                </span>
                                                </li>
                                                @endif
                                            @endif
                                            {{-- @if ($Unit->getRentPriceByType())
                                            <li class="mb-2 pt-1">
                                                <span class="fw-medium me-1">@lang('Rental price') :</span>
                                                <span> {{ $Unit->getRentPriceByType() }} <sup>@lang('SAR') /
                                                        {{ __($Unit->rent_type_show) }}
                                                    </sup> </span>
                                            </li>
                                            @endif --}}

                                            @php($types = ['daily', 'monthly', 'quarterly', 'midterm', 'yearly'])

                                            @if ($Unit->getRentPriceByType())
                                            <div class="">
                                                <select class="form-select UpdateRentPriceByType">
                                                    <option disabled value="" selected>@lang('Choose the rental price')
                                                    </option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type }}"
                                                            data-url="{{ route('Office.Unit.UpdateRentPriceByType', $Unit->id) }}"
                                                            data-type="{{ $type }}">
                                                            {{ __($type) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @endif




                                        </ul>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('Office.Unit.edit', $Unit->id) }}"
                                                class="btn btn-primary me-3">@lang('Edit')</a>

                                                @if($Unit->unit_masterplan)

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Download')</span></span>
                                                    </button>
                                                    <ul class="dropdown-menu">

                                                            <li>
                                                                <a href="{{ $Unit->unit_masterplan }}" target="_blank"
                                                                    class="dropdown-item">@lang('Download') @lang('Unit Masterplan')</a>
                                                            </li>

                                                    </ul>
                                                </div>
                                                @endif

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

                                <div class="col-lg-6 mb-1">
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

                                <div class="col-lg-6 mb-1">
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

                        </div>
                        <!--/ User Content -->
                    </div>


                  </div>
                  <div class="tab-pane fade" id="navs-justified-requests" role="tabpanel">

                         <!-- requests table -->
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
                                                                class="btn btn-outline-primary me-3 waves-effect waves-light"
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
                                                                action="{{ route('Office.Interest.status.update', $client->id) }}">
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
                        <!-- /request table -->
                  </div>
                  <div class="tab-pane fade" id="navs-justified-license" role="tabpanel">


                    <div class="col-lg-6 mb-1">
                        <div class="card">
                            <div class="card-body">

                                <small class="text-light fw-medium">@lang('Ad License Information')</small>
                                <div class="demo-inline-spacing mt-3">
                                    <ul class="list-group">
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                @lang('Ad License Number')
                                                <span>{{ __($Unit->ad_license_number ?? '' ) }}</span>
                                            </li>
                                            <li
                                            class="list-group-item d-flex justify-content-between align-items-center">
                                            @lang(' صلاحية الاعلان')
                                            <span class="badge bg-primary">{{ __($Unit->ad_license_status) }}</span>
                                            </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                    @include('Office.ProjectManagement.Project.Unit.inc._contracts')
                  </div>
                </div>
              </div>


            <!-- Modal -->

            <!-- container-fluid -->




            <!-- /Modal -->
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>

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
