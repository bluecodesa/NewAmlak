@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

        <div class="content-wrapper">
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
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h5 class="card-header">@lang('Types subscriptions')
                                            <button type="button" onclick="exportToExcel()"
                                                class="btn btn-sm btn-icon btn-success waves-effect waves-light">
                                                <span class="ti ti-table-export"></span>
                                            </button>
                                        </h5>

                                    </div>
                                    <div class="col-3 py-1">
                                        <input id="SearchInput" class="form-control  rounded-pill mt-3" type="text"
                                            placeholder="@lang('search...')">
                                    </div>


                                </div>
                                <div class="table-responsive text-nowrap">
                                    <table class="table" id="table2">
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
                                                    {{-- <td>
                                                        {{ $property->is_divided == 1 ? __('property') : __('Unit') }}
                                                    </td> --}}
                                                    {{-- <td>{{ $property->instrument_number ?? '' }}</td> --}}

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

@endsection
