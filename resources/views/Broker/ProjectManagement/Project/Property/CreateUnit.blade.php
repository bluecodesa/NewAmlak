@extends('Admin.layouts.app')
@section('title', __('Add unit'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                        <a href="{{ route('Broker.Property.show', $Property->id) }}" class="text-muted fw-light">
                            {{ $Property->name }} </a> /
                        @lang('Add unit')
                    </h4>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    @include('Admin.layouts.Inc._errors')
                    <div class="col-xl-12">
                        <div class="nav-align-top nav-tabs-shadow mb-4">
                            <ul class="nav nav-tabs nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                                        aria-selected="true">
                                        <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Basic Details')
                                        <span
                                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">3</span>
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-gallery" aria-controls="navs-justified-gallery"
                                        aria-selected="false">
                                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Gallery')
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                                        aria-selected="false">
                                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('price')
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-justified-messages" aria-controls="navs-justified-messages"
                                        aria-selected="false">
                                        <i class="tf-icons ti ti-file ti-xs me-1"></i> @lang('Attachments')
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">


                                    {{-- الوصف --}}


                                    <form action="{{ route('Broker.Property.StoreUnit', $id) }}" method="POST"
                                        class="row" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <input type="text" hidden name="lat_long" value="{{ $Property->lat_long }}">
                                        <div class="col-md-3 col-12 mb-3">

                                            <label class="form-label">
                                                {{ __('Residential number') }} <span class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="number_unit"
                                                class="form-control" placeholder="{{ __('Residential number') }}">

                                        </div>

                                        <div class="col-md-3 col-12 mb-3">
                                            <label class="form-label">@lang('Region') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" id="Region_id" required>
                                                <option disabled value="">@lang('Region') </option>
                                                @foreach ($Regions as $Region)
                                                    <option value="{{ $Region->id }}"
                                                        {{ $Property->CityData->RegionData->id == $Region->id ? 'selected' : '' }}
                                                        data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                                        {{ $Region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-12 mb-3">
                                            <label class="form-label">@lang('city') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="city_id" id="CityDiv" required>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}"
                                                        {{ $Property->CityData->id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 col-12 mb-3">
                                            <label class="form-label">@lang('district') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="district_id" id="DistrictDiv" required>
                                                @foreach ($Property->CityData->DistrictsCity as $district)
                                                    <option value="{{ $district->id }}"
                                                        {{ $district->id == $Property->district_id ? 'selected' : '' }}>
                                                        {{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('location') <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required name="location" id="myAddressBar"
                                                class="form-control" placeholder="@lang('location name')"
                                                value="{{ $Property->location }}" />
                                        </div>



                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('Property type') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="property_type_id" required>
                                                <option disabled value="">@lang('Property type')</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ $Property->property_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('Type use') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="property_usage_id" required>
                                                <option disabled selected value="">@lang('Type use')</option>
                                                @foreach ($usages as $usage)
                                                    <option value="{{ $usage->id }}"
                                                        {{ $Property->property_usage_id == $usage->id ? 'selected' : '' }}>
                                                        {{ $usage->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('owner name') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="owner_id" required>
                                                <option disabled selected value="">@lang('owner name')</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{ $owner->id }}"
                                                        {{ $Property->owner_id == $owner->id ? 'selected' : '' }}>
                                                        {{ $owner->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('Instrument number')</label>
                                            <input type="number" name="instrument_number" class="form-control"
                                                placeholder="@lang('Instrument number')"
                                                value="{{ old('Instrument number') }}" />
                                        </div>


                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('offered service') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="service_type_id" required>
                                                <option disabled selected value="">@lang('offered service')</option>
                                                @foreach ($servicesTypes as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ $Property->service_type_id == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('Area (square metres)')
                                            </label>
                                            <input type="number" name="space" class="form-control"
                                                placeholder="@lang('Area (square metres)')"
                                                value="{{ old('Area (square metres)') }}" />
                                        </div>


                                        <div class="col-md-4 col-12 mb-3">
                                            <label class="form-label">@lang('number rooms')</label>
                                            <input type="number" name="rooms" class="form-control"
                                                placeholder="@lang('number rooms')" value="{{ old('number rooms') }}" />
                                        </div>



                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="form-label">@lang('Number bathrooms')</label>
                                            <input type="number" name="bathrooms" class="form-control"
                                                placeholder="@lang('Number bathrooms')" value="{{ old('Number bathrooms') }}" />
                                        </div>

                                        <div class="col-12 mb-2 col-md-4">
                                            <label class="form-label">@lang('Status of Unit') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="status" id="type" required>
                                                <option disabled value="">@lang('Status of Unit') </option>
                                                @foreach (['vacant', 'rented'] as $type)
                                                    <option value="{{ $type }}">
                                                        {{ __($type) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4 mb-3">
                                            <label>@lang('Amenities') </label>
                                            <select class="select2 form-select" id="exampleFormControlSelect1"
                                                name="service_id[]" multiple="multiple">
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
                                                value="{{ $Property->lat_long }}" />
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">@lang('Additional details')</label>
                                            <div id="features" class="row">
                                                <div class="mb-3 col-4">
                                                    <input type="text" name="name[]" class="form-control search"
                                                        placeholder="@lang('Field name')" value="{{ old('name*') }}" />
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <input type="text" name="qty[]" class="form-control"
                                                        placeholder="@lang('value')" value="{{ old('qty*') }}" />
                                                </div>
                                                <div class="col">
                                                    <button type="button" class="btn btn-outline-primary w-100"
                                                        onclick="addFeature()"><i
                                                            class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                            class="d-none d-sm-inline-block">@lang('Add details')</span></button>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-12" style="text-align: center;">
                                            <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-gallery">
                                                {{ __('Next') }}
                                            </button>
                                        </div>




                                </div>
                                <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                                    <div class="row">

                                        <div class="col-md-4 col-12 mb-3">

                                            <label class="form-label">
                                                {{ __('ad name') }} <span class="required-color">*</span></label>
                                            <input type="text" required name="ad_name" class="form-control"
                                                placeholder="{{ __('ad name') }}">

                                        </div>

                                        <div class="col-12 mb-2 col-md-4">
                                            <label class="form-label">@lang('Ad type') <span
                                                    class="required-color">*</span>
                                            </label>
                                            <select class="form-select" name="type" id="type" required>
                                                <option disabled value="">@lang('Ad type') </option>
                                                @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                                    <option value="{{ $type }}">
                                                        {{ __($type) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="form-label"
                                                style="display: block !important;">@lang('Show in Gallery')
                                            </label>
                                            {{-- <input type="checkbox" checked name="show_gallery" class="toggleHomePage"
                                        data-toggle="toggle" data-onstyle="primary"> --}}

                                            <label class="switch switch-lg">
                                                <input type="checkbox" name="show_gallery" class="switch-input"
                                                    checked />
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

                                        <div class="col-12 mb-3">
                                            <label class="form-label mb-2">@lang('Description')</label>
                                            <div>
                                                {{-- <textarea name="note" class="form-control" rows="5"></textarea> --}}
                                                <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder="">

                                                    </textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-3">
                                            <label class="form-label mb-2">@lang('Pictures property') </label>
                                            <input type="file" name="images[]" multiple class="dropify"
                                                accept="image/jpeg, image/png" />
                                        </div>

                                    </div>

                                    <div class="col-12" style="text-align: center;">
                                        <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-profile">
                                            {{ __('Next') }}
                                        </button>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 mb-3">
                                            <label class="form-label"
                                                style="display: block !important;">@lang('Daily Rent')
                                            </label>

                                            <label class="switch switch-lg">
                                                <input type="checkbox" name="daily_rent" class="switch-input" />
                                                <span class="switch-toggle-slider">
                                                    <span class="switch-on">
                                                        <i class="ti ti-check"></i>
                                                    </span>
                                                    <span class="switch-off">
                                                        <i class="ti ti-x"></i>
                                                    </span>
                                                </span>
                                        </div>


                                        <div class="col-sm-12 col-md-4 mb-3">

                                            <label for="price" class="form-label">@lang('selling price')</label>
                                            <div class="input-group">
                                                <input type="text" name="price" value="{{ old('price') }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                                    class="form-control" placeholder="@lang('selling price')"
                                                    aria-label="@lang('selling price')" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary waves-effect" type="button"
                                                    id="button-addon2">@lang('SAR')</button>
                                            </div>

                                        </div>


                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label for="monthly" class="form-label">@lang('Monthly rental price')</label>
                                            <div class="input-group">
                                                <input type="text" name="monthly" value="{{ old('price') }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);"
                                                    class="form-control" placeholder="@lang('Monthly rental price')"
                                                    aria-label="@lang('Monthly rental price')" aria-describedby="button-addon2">
                                                <button class="btn btn-outline-primary waves-effect" type="button"
                                                    id="button-addon2">@lang('SAR')</button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-12" style="text-align: center;">
                                        <button type="button" class="btn btn-primary col-4 me-1 next-tab" data-next="#navs-justified-messages">
                                            {{ __('Next') }}
                                        </button>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                                    <div class="row">
                                        <div class=" col-6 mb-3">
                                            <label for="formFileMultiple" class="form-label">@lang('Unit Masterplan')</label>
                                            <input class="form-control" type="file" name="unit_masterplan"
                                                id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                        </div>

                                    </div>
                                    <div class="col-12" style="text-align: center;" >
                                        <button class="btn btn-primary col-4 waves-effect waves-light"
                                            type="submit">@lang('save')</button>
                                        </div>
                                </div>



                                </form>
                            </div>

                        </div>

                    </div>




                </div> <!-- end row -->

            </div>
            <!-- container-fluid -->

        </div>
    </div>
    @include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')

    {{-- نهايه الوصف --}}
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

            var path = "{{ route('Broker.Project.autocompleteProject') }}";

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
        <div class="col-4">
            <input type="text" required name="name[]" class="form-control search" placeholder="@lang('Field name')" value="" />
        </div>
        <div class="col-4">
            <input type="text" required name="qty[]" class="form-control" placeholder="@lang('value')" value="" />
        </div>
        <div class="col-4">
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
                    <script>
                        document.querySelectorAll('.next-tab').forEach(button => {
                            button.addEventListener('click', function() {
                                const nextTab = this.getAttribute('data-next');
                                const nextTabButton = document.querySelector(`[data-bs-target="${nextTab}"]`);
                                nextTabButton.click();
                            });
                        });
                    </script>
    @endpush
@endsection
