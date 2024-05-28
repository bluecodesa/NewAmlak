@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Edit') . ' ' . $Unit->number_unit)
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Unit.index') }}" class="text-muted fw-light">@lang('Units') </a> /
                        @lang('Edit') : {{ $Unit->number_unit }}
                    </h4>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <form action="{{ route('Broker.Unit.update', $Unit->id) }}" method="POST" class="row"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">
                                        {{ __('Residential number') }} <span class="required-color">*</span></label>
                                    <input type="text" value="{{ $Unit->number_unit }}" required id="modalRoleName"
                                        name="number_unit" class="form-control"
                                        placeholder="{{ __('Residential number') }}">

                                </div>

                                <div class="col-12 mb-3 col-md-3">
                                    <label class="form-label">@lang('Region') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" id="Region_id" required>
                                        <option disabled value="">@lang('Region') </option>
                                        @foreach ($Regions as $Region)
                                            <option value="{{ $Region->id }}"
                                                {{ $Region->id == $Unit->CityData->RegionData->id ? 'selected' : '' }}
                                                data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                {{ $Region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3 col-md-3">
                                    <label class="form-label">@lang('city') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="CityDiv" required>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}"
                                                {{ $city->id == $Unit->city_id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-12 mb-3 col-md-3">
                                    <label class="form-label">@lang('district') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="district_id" id="DistrictDiv" required>
                                        @foreach ($Unit->CityData->DistrictsCity as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $Unit->district_id ? 'selected' : '' }}>
                                                {{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('location') <span
                                            class="required-color">*</span></label>
                                    <input type="text" required name="location" id="myAddressBar" class="form-control"
                                        placeholder="@lang('location name')" value="{{ $Unit->location }}" />
                                </div>


                                <div class="col-12 mb-3 col-md-4">
                                    <label class="form-label">@lang('Property type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_type_id" required>
                                        <option disabled value="">@lang('Property type')</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $type->id == $Unit->property_type_id ? 'selected' : '' }}>
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3 col-md-4">
                                    <label class="form-label">@lang('Type use') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_usage_id" required>
                                        <option disabled value="">@lang('Type use')</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}"
                                                {{ $usage->id == $Unit->property_usage_id ? 'selected' : '' }}>
                                                {{ $usage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('owner name') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="owner_id" required>
                                        <option disabled value="">@lang('owner name')</option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}"
                                                {{ $owner->id == $Unit->owner_id ? 'selected' : '' }}>
                                                {{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Instrument number')</label>
                                    <input type="number" name="instrument_number" class="form-control"
                                        placeholder="@lang('Instrument number')" value="{{ $Unit->instrument_number }}" />
                                </div>


                                <div class="col-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('offered service') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="service_type_id" required>
                                        <option disabled selected value="">@lang('offered service')</option>
                                        @foreach ($servicesTypes as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $Unit->service_type_id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Area (square metres)') </label>
                                    <input type="number" name="space" class="form-control"
                                        placeholder="@lang('Area (square metres)')" value="{{ $Unit->space }}" />
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('number rooms') </label>
                                    <input type="number" name="rooms" class="form-control"
                                        placeholder="@lang('number rooms')" value="{{ $Unit->rooms }}" />
                                </div>



                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Number bathrooms') </label>
                                    <input type="number" name="bathrooms" class="form-control"
                                        placeholder="@lang('Number bathrooms')" value="{{ $Unit->bathrooms }}" />
                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">
                                    <div class="small fw-medium mb-3">@lang('Show in Gallery')</div>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" name="show_gallery" class="switch-input toggleHomePage"
                                            {{ $Unit->show_gallery == 1 ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </span>

                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">
                                    <div class="small fw-medium mb-3">@lang('Daily Rent')</div>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" name="daily_rent" class="switch-input toggleHomePage"
                                            {{ $Unit->daily_rent == 1 ? 'checked' : '' }}>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </span>

                                    </label>
                                </div>



                                <div class="col-12 mb-3 col-md-4">
                                    <label class="form-label">@lang('Ad type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="type" id="type" required>
                                        <option disabled value="">@lang('Ad type') </option>
                                        @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                            <option value="{{ $type }}"
                                                {{ $Unit->type == $type ? 'selected' : '' }}>
                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('services')</label>
                                    <select class="select2 form-select" name="service_id[]" multiple="multiple">
                                        <option disabled value="">@lang('services')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ in_array($service->id, $Unit->UnitServicesData->pluck('service_id')->toArray()) == true ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{--  --}}
                                <div class="col-sm-12 col-md-2 mb-3">

                                    <label for="price" class="form-label">@lang('selling price')</label>
                                    <div class="input-group">
                                        <input type="text" name="price" value="{{ $Unit->price }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('selling price')"
                                            aria-label="@lang('selling price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>


                                </div>


                                <div class="col-sm-12 col-md-2 mb-3">
                                    <label for="daily" class="form-label">@lang('daily rental price')</label>
                                    <div class="input-group">
                                        <input type="text" name="daily" value="{{ $Unit->UnitRentPrice->daily }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('daily rental price')"
                                            aria-label="@lang('daily rental price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">
                                    <label for="monthly" class="form-label">@lang('Monthly rental price')</label>
                                    <div class="input-group">
                                        <input type="text" name="monthly" value="{{ $Unit->UnitRentPrice->monthly }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('Monthly rental price')"
                                            aria-label="@lang('Monthly rental price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">

                                    <label for="quarterly" class="form-label">@lang('quarterly rental price')</label>
                                    <div class="input-group">
                                        <input type="text" name="quarterly"
                                            value="{{ $Unit->UnitRentPrice->quarterly }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('quarterly rental price')"
                                            aria-label="@lang('quarterly rental price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">

                                    <label for="midterm" class="form-label">@lang('midterm rental price')</label>
                                    <div class="input-group">
                                        <input type="text" name="midterm" value="{{ $Unit->UnitRentPrice->midterm }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('midterm rental price')"
                                            aria-label="@lang('midterm rental price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>

                                </div>

                                <div class="col-sm-12 col-md-2 mb-3">

                                    <label for="yearly" class="form-label">@lang('yearly rental price')</label>
                                    <div class="input-group">
                                        <input type="text" name="yearly" value="{{ $Unit->UnitRentPrice->yearly }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                            class="form-control" placeholder="@lang('yearly rental price')"
                                            aria-label="@lang('yearly rental price')" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary waves-effect" type="button"
                                            id="button-addon2">@lang('SAR')</button>
                                    </div>
                                </div>




                                {{--  --}}

                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" required readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ $Unit->lat_long }}" />
                                </div>



                                <div class="col-12 mb-3">
                                    <label class="form-label">@lang('Additional details')</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="addFeature()">@lang('Add details')</button>
                                    @foreach ($Unit->UnitFeatureData as $feature)
                                        <div class="row p-1">
                                            <div class="col">
                                                <input type="text" name="name[]" class="form-control search"
                                                    placeholder="@lang('Field name')"
                                                    value="{{ $feature->FeatureData->name }}" />
                                            </div>
                                            <div class="col">
                                                <input type="text" name="qty[]" value="{{ $feature->qty }}"
                                                    class="form-control" placeholder="@lang('value')"
                                                    value="" />
                                            </div>
                                            <div class="col">
                                                <button type="button"
                                                    class="btn btn-outline-danger w-100 remove-feature">@lang('Remove')</button>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div id="features" class="row p-2">

                                    </div>
                                </div>

                                <div class="mb-3 col-12">
                                    <label class="form-label mb-2">@lang('Description')</label>
                                    <div>
                                        {{-- <textarea name="note" class="form-control" rows="5">{{ $Unit->note }}</textarea> --}}
                                        <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder=""
                                        >{!! $Unit->note !!}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label class="form-label mb-2">@lang('Pictures property') </label>
                                    <input type="file" name="images[]"
                                        data-url="{{ route('Broker.Unit.deleteImage', $Unit->id) }}"
                                        @if ($Unit->UnitImages->count() > 0) data-default-file="{{ url($Unit->UnitImages[0]->image) }}" @endif
                                        multiple class="dropify" accept="image/jpeg, image/png" />
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.remove-feature', function() {
                    $(this).closest('.row').remove();
                });
            });

            $('.dropify-clear').click(function() {
                var url = $('.dropify').data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    success: function(data) {
                        alertify.success(@json(__('The image has been successfully deleted')));
                    },
                });
            });

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
            //
            //
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
<div class="col mr-2">
    <button type="button" class="btn btn-danger w-100" onclick="removeFeature(this)">@lang('Remove')</button>
</div>
`;

                featuresContainer.appendChild(newRow);
            }

            function removeFeature(button) {
                const rowToRemove = button.parentNode.parentNode;
                rowToRemove.remove();
            }


            $(document).ready(function() {
                $('#textarea').summernote({
                    height: 100, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                        ['style', ['bold', 'underline']],
                        ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                        ['para', ['ul', 'ol']],
                        ['misc', ['fullscreen', 'undo', 'redo']],
                        // Any other toolbar groups and options you want to include...
                    ],
                    // Explicitly remove table and font name options by not including them in the toolbar
                });
                $('.card-body .badge').click(function() {
                    var variableValue = $(this).attr('data-variable');
                    var $textarea = $('#textarea');
                    var summernoteEditor = $textarea.summernote('code');

                    // Check if Summernote editor is focused
                    if ($('.note-editable').is(':focus')) {
                        var node = document.createElement("span");
                        node.innerHTML = variableValue;
                        $('.note-editable').append(
                            node); // This line appends the variable as a new node to the editor
                        var range = document.createRange();
                        var sel = window.getSelection();
                        range.setStartAfter(node);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else {
                        var currentContent = $textarea.summernote('code');
                        $textarea.summernote('code', currentContent + variableValue);
                    }
                });
            });

        </script>
    @endpush
@endsection
