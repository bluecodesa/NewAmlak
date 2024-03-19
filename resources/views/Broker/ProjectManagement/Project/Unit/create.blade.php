@extends('Admin.layouts.app')
@section('title', __('Add unit'))
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
                                        @lang('Add unit')</h4>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item active" style="margin-top: 2px;"><a
                                                href="#">@lang('Add unit')</a></li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('Broker.Unit.index') }}">@lang('Units')</a></li>
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
                                <form action="{{ route('Broker.Unit.store') }}" method="POST" class="row"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('Residential number') }} <span class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="number_unit"
                                                class="form-control" placeholder="{{ __('Residential number') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Region') <span class="required-color">*</span> </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled value="">@lang('Region') </option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('city') <span class="required-color">*</span> </label>
                                        <select class="form-control CityDiv" name="city_id" required>
                                            <option disabled value="" selected>@lang('city') </option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}">
                                                    {{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="form-group col-md-3">
                                        <label>@lang('district') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="district_id" id="DistrictDiv" required>

                                        </select>
                                    </div>


                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('location') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="location" id="myAddressBar"
                                            class="form-control" placeholder="@lang('Enter an address')"
                                            value="{{ old('location') }}" />
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>@lang('Property type') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="property_type_id" required>
                                            <option disabled selected value="">@lang('Property type')</option>
                                            @foreach ($types as $type)
                                                <option value="{{ $type->id }}">
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>@lang('Type use') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="property_usage_id" required>
                                            <option disabled selected value="">@lang('Type use')</option>
                                            @foreach ($usages as $usage)
                                                <option value="{{ $usage->id }}">
                                                    {{ $usage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-4 mb-3">
                                        <div class="row">
                                            <label class="col-md-6">@lang('owner name') <span class="required-color">*</span>
                                            </label>
                                            <label class="text-right col-md-6">
                                                <button type="button" data-toggle="modal"
                                                    data-target=".bs-example-modal-center"
                                                    class="btn btn-primary btn-sm waves-effect waves-light btn-sm">
                                                    @lang('Add New Owner')
                                                </button>
                                            </label>
                                        </div>

                                        <select class="form-control" id="OwnersDiv" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Instrument number')</label>
                                        <input type="number" name="instrument_number" class="form-control"
                                            placeholder="@lang('Instrument number')" value="{{ old('Instrument number') }}" />
                                    </div>


                                    <div class="form-group col-md-4 mb-3">
                                        <label>@lang('offered service') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="service_type_id" required>
                                            <option disabled selected value="">@lang('offered service')</option>
                                            @foreach ($servicesTypes as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Area (square metres)')</label>
                                        <input type="number" required name="space" class="form-control"
                                            placeholder="@lang('Area (square metres)')" value="{{ old('Area (square metres)') }}" />
                                    </div>


                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('number rooms') </label>
                                        <input type="number" name="rooms" class="form-control"
                                            placeholder="@lang('number rooms')" value="{{ old('number rooms') }}" />
                                    </div>



                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Number bathrooms') </label>
                                        <input type="number" name="bathrooms" class="form-control"
                                            placeholder="@lang('Number bathrooms')" value="{{ old('Number bathrooms') }}" />
                                    </div>

                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <label class="form-label" style="display: block !important;">@lang('Show in Gallery')
                                            <span class="required-color">*</span></label>
                                        <input type="checkbox" required name="show_gallery" class="toggleHomePage"
                                            data-toggle="toggle" data-onstyle="primary">
                                    </div>



                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <label class="form-label">@lang('price') <span
                                                class="required-color">*</span></label>
                                        <input type="number" required name="price" class="form-control"
                                            placeholder="@lang('price')" value="{{ old('price') }}" />
                                    </div>


                                    <div class="form-group mb-3 col-md-3">
                                        <label>@lang('Ad type') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="type" id="type" required>
                                            <option disabled value="">@lang('Ad type') </option>
                                            @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                                <option value="{{ $type }}">
                                                    {{ __($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3 mb-3">
                                        <label>@lang('services')</label>
                                        <select class="select2 form-control" name="service_id[]" multiple="multiple">
                                            <option disabled value="">@lang('services')</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3" hidden>
                                        <label class="form-label">@lang('lat&long')</label>
                                        <input type="text" required readonly name="lat_long" id="location_tag"
                                            class="form-control" placeholder="@lang('lat&long')"
                                            value="{{ old('location_tag') }}" />
                                    </div>


                                    <div class="form-group col-12 mb-3">
                                        <label class="form-label">@lang('Additional details') </label>
                                        <div id="features" class="row">
                                            <div class="col">
                                                <input type="text" name="name[]" class="form-control search"
                                                    placeholder="@lang('Field name')" value="{{ old('name*') }}" />
                                            </div>
                                            <div class="col">
                                                <input type="text" name="qty[]" class="form-control"
                                                    placeholder="@lang('value')" value="{{ old('qty*') }}" />
                                            </div>
                                            <div class="col">
                                                <button type="button" class="btn btn-primary w-100"
                                                    onclick="addFeature()">@lang('Add details')</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 mb-3">
                                        <label class="form-label">@lang('Pictures property') </label>
                                        <input type="file" name="images[]" multiple class="dropify"
                                            accept="image/jpeg, image/png" />
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
        @include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Intercept form submission
                $('#OwnerForm').submit(function(event) {
                    event.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'), // Form action URL
                        data: formData, // Form data
                        success: function(data) {
                            $('#OwnersDiv').empty();
                            $('#OwnersDiv').append(data);
                            $('.bs-example-modal-center').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response here
                            console.error(xhr.responseText);
                        }
                    });
                });
            });

            $('#Region_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('.CityDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('.CityDiv').fadeOut('fast', function() {
                            $(this).empty().append(data);
                            $(this).fadeIn('fast');
                        });
                    },
                });
            });

            $('.CityDiv').on('change', function() {
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


            $('.Region_id').on('change', function() {
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

            var path = "{{ route('Broker.Property.autocomplete') }}";

            $(document).on("focus", ".search", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: path,
                            type: 'GET',
                            dataType: "json",
                            data: {
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).val(ui.item.label);
                        console.log(ui.item);
                        return false;
                    }
                });
            });

            function addFeature() {
                const featuresContainer = document.getElementById('features');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'mb-3'); // Add any additional classes that your grid system requires

                // Use the exact same class names and structure as your existing rows
                newRow.innerHTML = `
    <div class="col">
        <input type="text" required name="name[]" class="form-control search" placeholder="@lang('Field name')" value="" />
    </div>
    <div class="col">
        <input type="text" required name="qty[]" class="form-control" placeholder="@lang('value')" value="" />
    </div>
    <div class="col">
        <button type="button" class="btn btn-danger w-100" onclick="removeFeature(this)">@lang('Remove')</button>
    </div>
`;

                featuresContainer.appendChild(newRow);
            }

            function removeFeature(button) {
                const rowToRemove = button.parentNode.parentNode;
                rowToRemove.remove();
            }
        </script>
    @endpush
@endsection
