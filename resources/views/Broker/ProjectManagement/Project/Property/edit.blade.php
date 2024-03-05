@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . $Property->name)
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <h4 class="page-title">
                                        @lang('Edit') : {{ $Property->name }} </h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.Property.edit', $Property->id) }}">@lang('Edit')</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">

                                <form action="{{ route('Broker.Property.update', $Property->id) }}" method="POST"
                                    class="row" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-3">

                                        <label class="form-label">
                                            {{ __('property name') }} <span class="required-color">*</span></label>
                                        <input type="text" required value="{{ $Property->name }}" id="modalRoleName"
                                            name="name" class="form-control" placeholder="{{ __('property name') }}">

                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Region') </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled value="">@lang('Region') <span
                                                    class="required-color">*</span></option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    {{ $Region->id == $Property->CityData->RegionData->id ? 'selected' : '' }}
                                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('city') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="city_id" id="CityDiv" required>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}"
                                                    {{ $city->id == $Property->city_id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('district') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="district_id" id="DistrictDiv" required>
                                            @foreach ($Property->CityData->DistrictsCity as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ $district->id == $Property->district_id ? 'selected' : '' }}>
                                                    {{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('location') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="location" id="myAddressBar"
                                            class="form-control" placeholder="@lang('location name')"
                                            value="{{ $Property->location }}" />
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>@lang('Property type') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="property_type_id" required>
                                            <option disabled selected value="">@lang('Property type')</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ $type->id == $Property->property_type_id ? 'selected' : '' }}>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('Type use') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="property_usage_id" required>
                                            <option disabled selected value="">@lang('Type use')</option>
                                            @foreach ($usages as $usage)
                                                <option value="{{ $usage->id }}"
                                                    {{ $usage->id == $Property->property_usage_id ? 'selected' : '' }}>
                                                    {{ $usage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>@lang('owner name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}"
                                                    {{ $owner->id == $Property->owner_id ? 'selected' : '' }}>
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- @php
                                        $typeunits = [1 => 'Divides', 0 => 'Not divided'];
                                    @endphp
                                    <div class="form-group col-md-3">
                                        <label>@lang('Divided into units') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="is_divided" required>
                                            <option disabled selected value="">@lang('Divided into units')</option>
                                            @foreach ($typeunits as $index => $item)
                                                <option value="{{ $index }}">
                                                    {{ __($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Instrument number') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="instrument_number" class="form-control"
                                            placeholder="@lang('Instrument number')" value="{{ $Property->instrument_number }}" />
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>@lang('offered service') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="service_type_id" required>
                                            <option disabled selected value="">@lang('offered service')</option>
                                            @foreach ($servicesTypes as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ $service->id == $Property->service_type_id ? 'selected' : '' }}>
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-12 col-md-12 mb-3">
                                        <label class="form-label">@lang('Pictures property') </label>
                                        <input type="file" name="images[]"
                                            @if ($Property->PropertyImages->count() > 0) data-default-file="{{ url($Property->PropertyImages[0]->image) }}" @endif
                                            multiple class="dropify" accept="image/jpeg, image/png" />
                                    </div>

                                    {{-- $Property->PropertyImages --}}

                                    <div class="col-sm-12 col-md-6 mb-3" hidden>
                                        <label class="form-label">@lang('lat&long')</label>
                                        <input type="text" required readonly name="lat_long" id="location_tag"
                                            class="form-control" placeholder="@lang('lat&long')"
                                            value="{{ $Property->lat_long }}" />
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    @push('scripts')
        <script>
            $('#Region_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#CityDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#CityDiv').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            });

            $('#CityDiv').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#DistrictDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#DistrictDiv').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            });
            //
            $("#myAddressBar").on("keyup", function() {
                // This function will be called every time a key is pressed in the input field
                var input = document.getElementById("myAddressBar");
                var autocomplete = new google.maps.places.Autocomplete(input);
                var place = autocomplete.getPlace();

                // Listen for the place_changed event
                google.maps.event.addListener(autocomplete, "place_changed", function() {
                    // Get the selected place
                    var place = autocomplete.getPlace();

                    // Get the details of the selected place
                    var address = place.formatted_address;
                    var lat = place.geometry.location.lat();
                    var long = place.geometry.location.lng();
                    // $("#address").val(address);
                    $("#location_tag").val(lat + "," + long);
                    // Log the details to the console (or do something else with them)
                });
            });
        </script>
    @endpush
@endsection
