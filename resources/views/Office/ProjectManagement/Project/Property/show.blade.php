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
                        <a href="{{ route('Office.Property.index') }}" class="text-muted fw-light">@lang('properties') </a> /
                        @lang('property') : {{ $Property->name }}
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
                        data-bs-target="#navs-justified-units"
                        aria-controls="navs-justified-units"
                        aria-selected="false">
                        <i class="tf-icons ti ti-building-arch ti-xs me-1"></i> @lang('Units')
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

                            @if ($Property->show_in_gallery != 1)
                                <i class="tf-icons ti ti-alarm me-1 text-danger animate-alarm icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة غير منشورة في المعرض اضغط هنا للنشر')"></i>
                                <span class=" text-danger">@lang(' الاعلان العقاري')</span>
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
                                                    @if ($Property->show_in_gallery != 1)
                                                    <i class="tf-icons ti ti-alarm me-1 text-danger animate-alarm icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذا الاعلان غير منشورة في المعرض اضغط هنا للنشر')">
                                                    <span class="text-danger">@lang('Unpublished')</span>

                                                    </i>

                                                @else
                                                    <i class="tf-icons ti ti-alarm me-1 text-success icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذا الاعلان منشوره في المعرض')">
                                                    <span class="text-success">@lang('Published')</span>

                                                    </i>
                                                @endif
                                                @forelse($Property->PropertyImages as $image)
                                                    <div class="col-6 mb-1">
                                                        <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ url($image->image) }}"
                                                            alt="{{ $Property->name }}" height="100" width="100">
                                                    </div>
                                                @empty
                                                    <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                                        src="{{ url('Offices/Projects/default.svg') }}" alt="{{ $Property->name }}"
                                                        height="100" width="100">
                                                @endforelse
                                                <div class="user-info text-center">
                                                    <h4 class="mb-2">{{ $Property->name }}</h4>
                                                    @if ($Property->ProjectData)
                                                    <span class="badge bg-label-secondary mt-1"> <a class="bg-label-secondary waves-effect" href="{{ route('Office.Project.show', $Property->ProjectData->id) }}" class="text-white">
                                                        {{ $Property->ProjectData->name ?? '' }}
                                                    </a></span>
                                                    @endif
                                                    <span class="badge bg-label-secondary mt-1">@lang('property')</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                                            <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                                <span class="badge bg-label-primary p-2 rounded"><i
                                                        class="ti ti-checkbox ti-sm"></i></span>
                                                <div>
                                                    <p class="mb-0 fw-medium">{{ $Property->PropertyUnits->count() }}</p>
                                                    <small>@lang('Number units')</small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start mt-3 gap-2">
                                                <span class="badge bg-label-primary p-2 rounded"><i
                                                        class="ti ti-briefcase ti-sm"></i></span>
                                                <div>
                                                    <p class="mb-0 fw-medium">@lang('Region')</p>
                                                    <small>{{ $Property->CityData->RegionData->name ?? __('nothing') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                                        <div class="info-container">
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-1"> @lang('property name'):</span>
                                                    <span>{{ $Property->name }}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('owner name') :</span>
                                                    <span>{{ $Property->OwnerData->name ?? __('nothing') }}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Property type') :</span>
                                                    <span>{{ $Property->PropertyTypeData->name ?? __('nothing') }}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('location name') :</span>
                                                    <span>{!! Str::limit($Property->location, 25, ' ...') !!}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1"> @lang('city') :</span>
                                                    <span>{{ $Property->CityData->name ?? __('nothing') }}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Instrument number') :</span>
                                                    <span>{{ $Property->instrument_number ?? __('nothing') }}</span>
                                                </li>
                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('Type use') :</span>
                                                    <span>{{ $Property->PropertyUsageData->name ?? __('nothing') }}
                                                    </span>
                                                </li>

                                                <li class="mb-2 pt-1">
                                                    <span class="fw-medium me-1">@lang('service type') :</span>
                                                    <span>{{ $Property->ServiceTypeData->name ?? __('nothing') }}
                                                    </span>
                                                </li>

                                            </ul>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('Office.Property.edit', $Property->id) }}"
                                                    class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light me-3">@lang('Edit')</a>

                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-outline-primary btn-sm waves-effect me-2 dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span><span class="d-none d-sm-inline-block">@lang('Download')</span></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if ($Property->property_masterplan)
                                                            <li>
                                                                <a href="{{ $Property->property_masterplan }}" target="_blank"
                                                                    class="dropdown-item">@lang('Download') @lang('المخطط الرئيسي')</a>
                                                            </li>
                                                        @endif

                                                        @if ($Property->property_brochure)
                                                            <li>

                                                                <a href="{{ $Property->property_brochure }}" target="_blank"
                                                                    class="dropdown-item">@lang('Download') @lang('البروشور')</a>
                                                            </li>
                                                        @endif


                                                    </ul>
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
                                                src="https://www.google.com/maps/embed/v1/place?q={{ $Property->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                                        </div>
                                    </div>
                                </div>
                            <hr>
                                @if ($Property->UnitFeatureData->isNotEmpty())
                                <div class="row">

                                    <div class="col-lg-6 mb-1">
                                        <div class="card">
                                            <div class="card-body">

                                                <small class="text-light fw-medium">@lang('Additional details')</small>
                                                <div class="demo-inline-spacing mt-3">
                                                    <ul class="list-group">
                                                        @forelse ($Property->UnitFeatureData as $feature)
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



                                </div>
                                @endif


                            </div>
                            <!--/ User Content -->
                        </div>

                  </div>
                  <div class="tab-pane fade" id="navs-justified-units" role="tabpanel">

                        <!-- unit table -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">@lang('Units')</h5>
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
                                                                tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                                aria-haspopup="dialog" aria-expanded="false"><span>
                                                                    <i class="ti ti-download me-1 ti-xs"></i><span
                                                                        class="d-none d-sm-inline-block">Export</span></span></button>
                                                            {{-- <button class="btn btn-secondary add-new btn-primary ms-2 ms-sm-0 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                                                <span class="d-none d-sm-inline-block">@lang('Add')</span></span></button> --}}

                                                                <a href="{{ route('Office.Property.CreateUnit', $Property->id) }}"
                                                                    class="btn btn-primary me-3">@lang('Add unit')</a>
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
                                                    <th>@lang('Residential number')</th>
                                                    <th>@lang('owner name')</th>
                                                    <th>@lang('number rooms')</th>

                                                    {{-- <th>@lang('price')</th> --}}
                                                    <th>@lang('Ad type')</th>
                                                    <th>@lang('Action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($Property->PropertyUnits as $index => $unit)
                                                    <tr>
                                                        {{-- <td>{{ $index + 1 }}</td> --}}
                                                        <td>{{ $unit->number_unit ?? '' }}</td>
                                                        <td>{{ $unit->OwnerData->name ?? '' }}</td>
                                                        <td>{{ $unit->rooms ?? '' }}</td>
                                                        {{-- <td>{{ $unit->price ?? '' }} <sup>@lang('SAR')</sup> </td> --}}
                                                        <td>{{ __($unit->type) ?? '' }}</td>

                                                        <td>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn p-0 dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ti ti-dots-vertical"></i>
                                                                </button>
                                                                <div class="dropdown-menu" style="">
                                                                    @if (Auth::user()->hasPermission('read-unit'))
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('Office.Unit.show', $unit->id) }}"
                                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a>
                                                                    @endif
                                                                    @if (Auth::user()->hasPermission('update-unit'))
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('Office.Unit.edit', $unit->id) }}"
                                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>
                                                                    @endif
                                                                    @if (Auth::user()->hasPermission('delete-unit'))
                                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                                            onclick="handleDelete('{{ $unit->id }}')"
                                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                                        <form id="delete-form-{{ $unit->id }}"
                                                                            action="{{ route('Office.Unit.destroy', $unit->id) }}"
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
                        <!-- /unit table -->
                  </div>
                  <div class="tab-pane fade" id="navs-justified-license" role="tabpanel">

                        <div class="row">
                            <div class="col-lg-6 mb-1">
                                <div class="card">
                                    <div class="card-body">

                                        <small class="text-light fw-medium">@lang('Ad License Information')</small>
                                        <div class="demo-inline-spacing mt-3">
                                            <ul class="list-group">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        @lang('Ad License Number')
                                                        <span>{{ __($Property->ad_license_number ?? '' ) }}</span>
                                                    </li>
                                                    <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    @lang(' صلاحية الاعلان')
                                                    <span class="badge bg-primary">{{ __($Property->ad_license_status) }}</span>
                                                    </li>
                                                    @if ($Property->show_in_gallery != 1)
                                                    <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    @lang('Ad Status')
                                                    <span class="badge bg-primary">@lang('Unpublished')</span>
                                                    </i>

                                                    @else
                                                    <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    @lang('Ad Status')
                                                    <span class="badge bg-primary">@lang('Published')</span>

                                                        </i>
                                                    @endif
                                            </ul>
                                        </div>
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

            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myLargeModalLabel">Large modal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <iframe width="100%" height="200" frameborder="0" style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $Property->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>


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
                XLSX.writeFile(wb, @json(__('Units')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush

@endsection
