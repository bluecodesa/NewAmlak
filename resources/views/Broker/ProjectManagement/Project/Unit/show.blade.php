@extends('Admin.layouts.app')
@section('title', __('Unit'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Unit') / {{ $Unit->number_unit }} </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item" style="margin-top: 2.1px;"><a href="#">
                                        {{ $Unit->number_unit }} </a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Unit.show', $Unit->id) }}">@lang('Unit')</a></li>

                                <li class="breadcrumb-item"><a href="{{ route('Broker.Unit.index') }}">@lang('Units')</a>
                                </li>

                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Broker.Project.index') }}">@lang('Projects')</a></li>
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
                                                        {{ $Unit->number_unit }} <cite title="Source Title"></cite>
                                                    </footer>
                                                </h3>
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <h6> @lang('Residential number') : <span class="badge font-13 badge-primary">
                                                                {{ $Unit->number_unit }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('owner name') : <span class="badge font-13 badge-primary">
                                                                {{ $Unit->OwnerData->name ?? '' }}
                                                            </span> </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Region') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->CityData->RegionData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('city') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->CityData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Property type') : <span class="badge font-13 badge-primary">
                                                                {{ $Unit->PropertyTypeData->name ?? '' }}
                                                            </span> </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <h6> @lang('location name') :
                                                            <span class="badge font-13 badge-primary" data-toggle="modal"
                                                                data-target=".bs-example-modal-lg">
                                                                {!! Str::limit($Unit->location, 13, ' .') !!}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Type use') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->PropertyUsageData->name }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Instrument number') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->instrument_number }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('offered service') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->ServiceTypeData->name ?? '' }}
                                                            </span>
                                                        </h6>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <h6> @lang('Area (square metres)') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->space }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('number rooms') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->rooms }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Number bathrooms') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->bathrooms }}
                                                            </span>
                                                        </h6>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <h6> @lang('selling price') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->price }} <sup>@lang('SAR')</sup>
                                                            </span>
                                                        </h6>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6> @lang('Rental price') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->getRentPriceByType() }}
                                                                <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}
                                                                </sup>
                                                            </span>
                                                        </h6>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <h6> @lang('Show in Gallery') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ $Unit->show_gallery == 1 ? __('Show') : __('hide') }}
                                                            </span>
                                                        </h6>
                                                    </div>



                                                    <div class="col-md-3">
                                                        <h6> @lang('Ad type') :
                                                            <span class="badge font-13 badge-primary">
                                                                {{ __($Unit->type) }}
                                                            </span>
                                                        </h6>
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            <a href="{{ route('Broker.Unit.edit', $Unit->id) }}"
                                                                class="btn btn-warning">@lang('Edit') </a>
                                                        </div>
                                                        @php($types = ['daily', 'monthly', 'quarterly', 'midterm', 'yearly'])


                                                        <div class="form-group col-md-4 mb-3">
                                                            <select class="form-control UpdateRentPriceByType">
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
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            @forelse($Unit->UnitImages as $image)
                                                <div class="col-6 mb-1">
                                                    <img class="rounded" src="{{ url($image->image) }}"
                                                        alt="{{ $Unit->number_unit }}" style="width: 100%;">
                                                </div>
                                            @empty
                                                <img class="d-flex align-self-end rounded mr-3 col"
                                                    src="{{ url('Offices/Projects/default.svg') }}"
                                                    alt="{{ $Unit->number_unit }}" height="200">
                                            @endforelse

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <iframe width="100%" style="border-radius: 10px;" height="200" frameborder="0"
                                            style="border:0"
                                            src="https://www.google.com/maps/embed/v1/place?q={{ $Unit->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>

                                    </div>

                                    <div class="col-md-3">

                                        <div class="alert alert-primary" role="alert">
                                            <strong>@lang('Additional details')</strong>
                                        </div>
                                        <ol class="list-group list-group-numbered">
                                            @foreach ($Unit->UnitFeatureData as $feature)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">{{ $feature->FeatureData->name ?? '' }}</div>
                                                    </div>
                                                    <span style="font-size: 12px;"
                                                        class="badge bg-primary fw-bold text-white  rounded-pill">{{ $feature->qty }}</span>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="alert alert-primary" role="alert">
                                            <strong>@lang('services')</strong>
                                        </div>
                                        <ol class="list-group list-group-numbered">

                                            @foreach ($Unit->UnitServicesData as $service)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">{{ $service->ServiceData->name ?? '' }}</div>
                                                    </div>

                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @if (!empty($unitInterests))
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Requests for interest')</h4>
                                </div>
                                <div class="table-responsive b-0" data-pattern="priority-columns">
                                    <table id="datatable-buttons"
                                        class="table table-striped table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>

                                                    <th>@lang('Client Name')</th>
                                                    <th>@lang('phone')</th>
                                                    <th>@lang('status')</th>
                                                    <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($unitInterests as $index => $client)
                                            <tr>

                                                <td>{{ $index + 1 }}</td>
                                                <td> {{ $client->name }}</td>
                                                <td>{{ $client->whatsapp }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('Broker.Interest.status.update', $client->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $client->id }}">
                                                        <select class="form-control select-input w-auto" name="status" onchange="this.form.submit()">
                                                            @foreach ($interestsTypes as $interestsType)
                                                                <option value="{{ $interestsType->id }}" {{ $client->status == $interestsType->id ? 'selected' : '' }}>
                                                                    {{ __($interestsType->name) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="submit-from" hidden=""></button>
                                                    </form>


                                                </td>

                                                <td>
                                                    <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $client->id }}"
                                                        href="tel:{{ env('COUNTRY_CODE') . $client->whatsapp }}" onclick="document.querySelector('#shareLinkUnit{{ $client->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                        @lang('Call')</a>
                                                    <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $client->whatsapp }}"
                                                        class="btn btn-outline-warning btn-sm waves-effect waves-light">@lang('محادثة(شات)')</a>


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

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
                                src="https://www.google.com/maps/embed/v1/place?q={{ $Unit->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>

    @push('scripts')
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
