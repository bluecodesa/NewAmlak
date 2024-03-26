@extends('Admin.layouts.app')
@section('title', __('Projects'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('properties') / {{ $Property->name }} </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Property.show', $Property->id) }}">@lang('Show')</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card m-b-30 text-white"
                                            style="background-color: #333; border-color: #333;border-radius: 14px;">
                                            <div class="card-body">
                                                <h3 class="card-title font-16 mt-0">
                                                    <footer class="blockquote-footer font-12">
                                                        {{ $Property->name }} <cite title="Source Title"></cite>
                                                    </footer>
                                                </h3>
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <h6> @lang('property name') : <span class="badge font-13 badge-primary">
                                                                {{ $Property->name }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('owner name') : <span class="badge font-13 badge-primary">
                                                                {{ $Property->OwnerData->name ?? __('nothing') }}
                                                            </span> </h6>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <h6> @lang('Property type') : <span class="badge font-13 badge-primary">
                                                                {{ $Property->PropertyTypeData->name ?? __('nothing') }}
                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('location name') :
                                                            <span class="badge font-13 badge-primary" data-toggle="modal"
                                                                data-target=".bs-example-modal-lg">
                                                                {!! Str::limit($Property->location, 10, ' ...') !!}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('city') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Property->CityData->name ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Instrument number') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Property->instrument_number ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Type use') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Property->PropertyUsageData->name ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('service type') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Property->ServiceTypeData->name ?? __('nothing') }}
                                                            </span>
                                                        </h6>
                                                    </div>


                                                </div>
                                                <a href="{{ route('Broker.Property.edit', $Property->id) }}"
                                                    class="btn btn-warning">@lang('Edit') </a>



                                                <a href="{{ route('Broker.Property.CreateUnit', $Property->id) }}"
                                                    class="btn btn-primary">@lang('Add units')</a>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            @forelse($Property->PropertyImages as $image)
                                                <div class="col-6 mb-1">
                                                    <img class="rounded" src="{{ url($image->image) }}"
                                                        alt="{{ $Property->name }}" style="width: 100%;">
                                                </div>
                                            @empty
                                                <img class="d-flex align-self-end rounded mr-3 col"
                                                    src="{{ url('Offices/Projects/default.svg') }}"
                                                    alt="{{ $Property->name }}" height="200">
                                            @endforelse

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>@lang('Residential number')</th>
                                                <th>@lang('owner name')</th>
                                                <th>@lang('number rooms')</th>
                                                {{-- <th>@lang('Number bathrooms')</th> --}}
                                                {{-- <th>@lang('Area (square metres)')</th> --}}
                                                <th>@lang('price')</th>
                                                <th>@lang('Ad type')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($Property->PropertyUnits as $index => $unit)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $unit->number_unit ?? '' }}</td>
                                                    <td>{{ $unit->OwnerData->name ?? '' }}</td>
                                                    <td>{{ $unit->rooms ?? '' }}</td>
                                                    {{-- <td>{{ $unit->bathrooms ?? '' }}</td> --}}
                                                    {{-- <td>{{ $unit->space ?? '' }}</td> --}}
                                                    <td>{{ $unit->price ?? '' }} <sup>@lang('SAR')</sup> </td>
                                                    <td>{{ __($unit->type) ?? '' }}</td>

                                                    <td>
                                                        {{-- <a href="{{ route('Broker.Project.show', $unit->id) }}"
                                                            class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('Show')</a> --}}

                                                        <a href="{{ route('Broker.Unit.edit', $unit->id) }}"
                                                            class="btn btn-outline-info btn-sm waves-effect waves-light">@lang('Edit')</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="handleDelete('{{ $unit->id }}')"
                                                            class="btn btn-outline-danger btn-sm waves-effect waves-light delete-btn">@lang('Delete')</a>
                                                        <form id="delete-form-{{ $unit->id }}"
                                                            action="{{ route('Broker.Unit.destroy', $unit->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
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
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">@lang('location')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <iframe width="100%" height="500" frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?q={{ $Property->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
@endsection
