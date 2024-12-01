@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    {{-- <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-6 py-3 mb-3">

                        <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                            <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                            @lang('Project') : {{ $project->name }}
                        </h4>
                    </div>

                </div>

                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-9">
                                        <div class="card bg-dark text-white mb-3">
                                            <div class="card-body">
                                                <h3 class="card-title font-16 mt-0">
                                                    <footer class="blockquote-footer font-12">
                                                        {{ $project->name }} <cite title="Source Title"></cite>
                                                    </footer>
                                                </h3>
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('project name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->name }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('owner name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->OwnerData->name ?? __('nothing') }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('Developer name') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->DeveloperData->name ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('Advisor name') : <span class="badge font-13 badge-primary">
                                                                {{ $project->AdvisorData->name ?? __('nothing') }}
                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('location name') :
                                                            <span class="badge font-13 badge-primary" data-toggle="modal"
                                                                data-target=".bs-example-modal-lg">
                                                                {!! Str::limit($project->location, 20, ' ...') !!}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('city') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->CityData->name ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6 class="card-title text-white"> @lang('Number Properties') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $project->PropertiesProject->count() }}
                                                                @lang('property')
                                                            </span>
                                                        </h6>
                                                    </div>

                                                </div>
                                                <a href="{{ route('Broker.Project.edit', $project->id) }}"
                                                    class="btn btn-warning">@lang('Edit') </a>
                                                    @if (Auth::user()->hasPermission('create-building'))
                                                <a href="{{ route('Broker.Project.CreateProperty', $project->id) }}"
                                                    class="btn btn-primary">@lang('Add new property')</a>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <img class="rounded mr-2" alt="200x200" style="width: 100%;height: 86%;"
                                            src="{{ $project->image_url }}" data-holder-rendered="true">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">@lang('properties')</h5>
                                </div>

                                <div class="card-datatable table-responsive">
                                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                                        <div class="card-header d-flex border-top rounded-0 flex-wrap py-2">
                                            <div class="me-5 ms-n2 pe-5">
                                                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>
                                                    <input id="SearchInput" class="form-control" placeholder="@lang('search...')" aria-controls="DataTables_Table_0"></label></div>
                                            </div>
                                            <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                                <div class="dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row">
                                                    <div
                                                        class="dt-buttons btn-group flex-wrap d-flex">
                                                        <div class="btn-group">
                                                            <button onclick="exportToExcel()" class="btn btn-success buttons-collection  btn-label-secondary me-3 waves-effect waves-light" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false"><span>
                                                                <i class="ti ti-download me-1 ti-xs"></i>Export</span></button>
                                                            </div>



                                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table" id="table">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('property name')</th>
                                                <th>@lang('Property type')</th>
                                                <th>@lang('Type use')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($project->PropertiesProject as $index => $property)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $property->name ?? '' }}</td>

                                                    <td>{{ $property->PropertyTypeData->name ?? '' }}</td>
                                                    <td>{{ $property->PropertyUsageData->name ?? '' }}</td>
                                                    <td>{{ $property->OwnerData->name ?? '' }}</td>

                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </button>
                                                        <div class="dropdown-menu" style="">
                                                        @if ($property->is_divided == 1)
                                                        <a class="dropdown-item"
                                                        href="{{ route('Broker.Property.show', $property->id) }}">@lang('Add units')</a>
                                                        @endif

                                                        <a class="dropdown-item"
                                                        href="{{ route('Broker.Property.show', $property->id) }}">@lang('Show')</a>
                                                            @if (Auth::user()->hasPermission('update-building'))
                                                            <a class="dropdown-item"
                                                            href="{{ route('Broker.Property.edit', $property->id) }}">@lang('Edit')</a>
                                                            @endif
                                                            @if (Auth::user()->hasPermission('delete-building'))
                                                            <a class="dropdown-item"
                                                            href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $property->id }}')">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $property->id }}"
                                                            action="{{ route('Broker.Property.destroy', $property->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        @endif
                                                        </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div> <!-- end row -->


        </div>
        <!-- container-fluid -->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="display: none;">
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
                                src="https://www.google.com/maps/embed/v1/place?q={{ $project->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

            </div>
        </div> --}}




    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                        @lang('Project') : {{ $project->name }}
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
                                    <img class="img-fluid rounded mb-3 pt-1 mt-4" src="{{ $project->image_url }}"
                                        height="100" width="100" alt="User avatar" />
                                    <div class="user-info text-center">
                                        <h4 class="mb-2">{{ $project->name }}</h4>
                                        <span class="badge bg-label-secondary mt-1">@lang('Project')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
                                <div class="d-flex align-items-start me-4 mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-building ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium"> @lang('Number Properties')</p>
                                        <small> {{ $project->PropertiesProject->count() }} </small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mt-3 gap-2">
                                    <span class="badge bg-label-primary p-2 rounded"><i
                                            class="ti ti-building-skyscraper ti-sm"></i></span>
                                    <div>
                                        <p class="mb-0 fw-medium">@lang('Region')</p>
                                        <small>{{ $project->CityData->RegionData->name ?? __('nothing') }}</small>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-4 small text-uppercase text-muted">@lang('Details')</p>
                            <div class="info-container">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <span class="fw-medium me-1"> @lang('project name'):</span>
                                        <span>{{ $project->name }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('owner name') :</span>
                                        <span>{{ $project->OwnerData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Developer name'):</span>
                                        <span>{{ $project->DeveloperData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Advisor name'):</span>
                                        <span>{{ $project->AdvisorData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('location name'):</span>
                                        <span>{!! Str::limit($project->location, 20, ' ...') !!}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('city'):</span>
                                        <span>{{ $project->CityData->name ?? __('nothing') }}</span>
                                    </li>
                                    <li class="mb-2 pt-1">
                                        <span class="fw-medium me-1">@lang('Number Properties'):</span>
                                        <span class="badge bg-label-success">{{ $project->PropertiesProject->count() }}
                                            @lang('property')</span>
                                    </li>

                                </ul>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('Broker.Project.edit', $project->id) }}"
                                        class="btn btn-warning me-3">@lang('Edit')</a>
                                    @if (Auth::user()->hasPermission('create-building'))
                                        <a href="{{ route('Broker.Project.CreateProperty', $project->id) }}"
                                            class="btn btn-primary me-3">@lang('Add new property')</a>
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
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $project->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- property table -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">@lang('properties')</h5>
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
                                                            tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                                            aria-haspopup="dialog" aria-expanded="false"><span>
                                                                <i class="ti ti-download me-1 ti-xs"></i><span
                                                                    class="d-none d-sm-inline-block">Export</span></span></button>

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
                                                <th>@lang('property name')</th>
                                                <th>@lang('Property type')</th>
                                                <th>@lang('Type use')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($project->PropertiesProject as $index => $property)
                                                <tr>
                                                    {{-- <td>{{ $index + 1 }}</td> --}}
                                                    <td>{{ $property->name ?? '' }}</td>

                                                    <td>{{ $property->PropertyTypeData->name ?? '' }}</td>
                                                    <td>{{ $property->PropertyUsageData->name ?? '' }}</td>
                                                    <td>{{ $property->OwnerData->name ?? '' }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical"></i>
                                                            </button>
                                                            <div class="dropdown-menu" style="">
                                                                @if ($property->is_divided == 1)
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('Broker.Property.show', $property->id) }}">@lang('Add units')</a>
                                                                @endif

                                                                <a class="dropdown-item"
                                                                    href="{{ route('Broker.Property.show', $property->id) }}">@lang('Show')</a>
                                                                @if (Auth::user()->hasPermission('update-building'))
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('Broker.Property.edit', $property->id) }}">@lang('Edit')</a>
                                                                @endif
                                                                @if (Auth::user()->hasPermission('delete-building'))
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="handleDelete('{{ $property->id }}')">@lang('Delete')</a>
                                                                    <form id="delete-form-{{ $property->id }}"
                                                                        action="{{ route('Broker.Property.destroy', $property->id) }}"
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
                                                <td colspan="5">
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
                                    src="https://www.google.com/maps/embed/v1/place?q={{ $project->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
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
                XLSX.writeFile(wb, @json(__('properties')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush

@endsection
