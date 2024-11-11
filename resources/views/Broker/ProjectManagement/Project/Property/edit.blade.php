@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . $Property->name)

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
        font-size: 35px !important; /* Adjust the size of the icon here */
        transition: transform 0.2s; /* Smooth scale effect on hover */
    }

    .icon-large:hover {
        transform: scale(1.5); /* Enlarge the icon slightly on hover */
    }
</style>
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Property.index') }}" class="text-muted fw-light">@lang('properties') </a> /
                        @lang('Edit') : {{ $Property->name }}
                    </h4>
                </div>

            </div>

            <div class="row">
                <div class="card">
                    @include('Admin.layouts.Inc._errors')
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
                        <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Description')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">9</span>
                      </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-justified-gallery"
                            aria-controls="navs-justified-gallery"
                            aria-selected="false">

                            @if ($Property->show_in_gallery != 1)
                                <i class="tf-icons ti ti-alarm me-1 text-danger animate-alarm icon-large" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة غير منشورة في المعرض اضغط هنا للنشر')">

                                </i>
                                <span class=" text-danger">@lang('Gallery')</span>
                            @else
                                <i class="tf-icons ti ti-alarm ti-xs me-1 text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="@lang('هذه الوحدة منشوره في المعرض')"></i>
                                <span class="text-success">@lang('Gallery')</span>
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
                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Attachments')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                      </button>
                    </li>

                  </ul>

                            <form action="{{ route('Broker.Property.update', $Property->id) }}" method="POST"
                                class="row" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                            <div class="tab-content">

                                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                                        <div class="row">
                                <div class="col-md-3 col-12 mb-3">

                                    <label class="form-label">
                                        {{ __('property name') }} <span class="required-color">*</span></label>
                                    <input type="text" required value="{{ $Property->name }}" id="modalRoleName"
                                        name="name" class="form-control" placeholder="{{ __('property name') }}">

                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('Region') <span
                                            class="required-color">*</span></label>
                                    <select class="form-select" id="Region_id" required>
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

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('city') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="city_id" id="CityDiv" required>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                data-url="{{ route('Broker.Broker.GetDistrictsByCity', $city->id) }}"
                                                {{ $city->id == $Property->city_id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('district') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="district_id" id="DistrictDiv" required>
                                        @foreach ($Property->CityData->DistrictsCity as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $Property->district_id ? 'selected' : '' }}>
                                                {{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('location') <span class="required-color">*</span></label>
                                    <input type="text" required name="location" id="myAddressBar" class="form-control"
                                        placeholder="@lang('Address')"  value="{{ $Property->location }}" />
                                    <span id="addressError" style="color: red;"></span> <!-- Error message placeholder -->
                                </div>

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Property type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_type_id" required>
                                        <option disabled selected value="">@lang('Property type')</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $type->id == $Property->property_type_id ? 'selected' : '' }}>
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Type use') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="property_usage_id" required>
                                        <option disabled selected value="">@lang('Type use')</option>
                                        @foreach ($usages as $usage)
                                            <option value="{{ $usage->id }}"
                                                {{ $usage->id == $Property->property_usage_id ? 'selected' : '' }}>
                                                {{ $usage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>




                                <div class="col-md-4 col-12 mb-3">
                                    <label class="col-md-6 form-label">@lang('owner name') <span
                                            class="required-color">*</span>
                                    </label>
                                    <div class="input-group">
                                        <select class="form-select" id="OwnersDiv"
                                            aria-label="Example select with button addon" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}"
                                                    {{ $owner->id == $Property->owner_id ? 'selected' : '' }}>
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addNewCCModal" type="button">@lang('Add New Owner')</button>
                                    </div>


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

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Instrument number')</label>
                                    <input type="text" name="instrument_number" class="form-control"
                                        placeholder="@lang('Instrument number')" value="{{ $Property->instrument_number }}" />
                                </div>


                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('offered service') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="service_type_id" required>
                                        <option disabled selected value="">@lang('offered service')</option>
                                        @foreach ($servicesTypes as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $Property->service_type_id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">@lang('Additional details')</label>
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="addFeature()">@lang('Add details')</button>
                                    @foreach ($Property->UnitFeatureData as $feature)
                                        <div class="row p-1">
                                            <div class="col">
                                                <input type="text" name="features_name[]" class="form-control search"
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

                                <div class="col-12" style="text-align: center;">
                                    <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                        data-next="#navs-justified-gallery">
                                        {{ __('Next') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                            <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                                @if($falLicense)
                                <!-- Show the "Show in Gallery" switch if the user has a valid license -->
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                    <label class="switch switch-lg">
                                        <input type="checkbox" name="show_in_gallery" class="switch-input" id="show_in_gallery"
                                        {{ $Property->show_in_gallery == 1 ? 'checked' : '' }}
                                        @if($falLicense->ad_license_status != 'valid') disabled @endif />

                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"><i class="ti ti-check"></i></span>
                                            <span class="switch-off"><i class="ti ti-x"></i></span>
                                        </span>
                                    </label>
                                </div>

                                <!-- Show gallery fields only if the license status is "valid" -->
                                <div class="row" id="gallery-fields"  style="@if($falLicense->ad_license_status != 'valid') display: none; @endif">
                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Ad License Number')<span class="required-color">*</span></label>
                                        <input type="number" name="ad_license_number" class="form-control" id="ad_license_number" value="{{ $Property->ad_license_number }}"
                                            @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                    </div>

                                    <div class="col-sm-12 col-md-4 mb-3">
                                        <label class="form-label">@lang('Ad License Expiry')<span class="required-color">*</span></label>
                                        <input type="date" name="ad_license_expiry" class="form-control" id="ad_license_expiry" value="{{ $Property->ad_license_expiry }}"
                                            @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                        <div id="date_error_message" style="color: red; display: none;">The selected date cannot be later than the license date.</div>
                                    </div>
                                </div>
                            @else
                                <!-- Display a message if the license is not valid or doesn't exist -->
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                    <label class="switch switch-lg">
                                        <input type="checkbox" name="show_in_gallery" class="switch-input" id="show_in_gallery" disabled />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-off"><i class="ti ti-x"></i></span>
                                        </span>
                                    </label>
                                    <!-- Add a message to indicate the license has expired -->
                                    <div class="alert alert-warning mt-2">
                                        @lang('Show in Gallery is not available because your license has expired or is not valid.')
                                    </div>
                                </div>
                            @endif

                                <div class="mb-3 col-12">
                                    <label class="form-label mb-2">@lang('Description')</label>
                                    <div>
                                        {{-- <textarea name="note" class="form-control" rows="5"></textarea> --}}
                                        <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder=""
                                        >{{ !!$Property->note }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">@lang('Pictures property') </label>
                                    <input type="file" name="images[]"
                                        data-url="{{ route('Broker.Property.deleteImage', $Property->id) }}"
                                        @if ($Property->PropertyImages->count() > 0) data-default-file="{{ url($Property->PropertyImages[0]->image) }}" @endif
                                        multiple class="dropify" accept="image/jpeg, image/png" />
                                </div>

                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" required readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ $Property->lat_long }}" />
                                </div>




                                <div class="col-12" style="text-align: center;">
                                    <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                        data-next="#navs-justified-profile">
                                        {{ __('Next') }}
                                    </button>
                                </div>
                    </div>

                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Property Masterplan')</label>
                                <input class="form-control" type="file" name="property_masterplan" id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                @if($Property->property_masterplan)
                                    <div class="mt-2">
                                        <label>@lang('Project Masterplan'):</label>
                                        <a href="{{ url($Property->property_masterplan) }}" target="_blank">@lang('View')</a>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Property Brochure')</label>
                                <input class="form-control" type="file" name="property_brochure" id="projectBrochure" accept="image/*,application/pdf" multiple>
                                @if($Property->property_brochure)
                                    <div class="mt-2">
                                        <label>@lang('Project Brochure'):</label>
                                        <a href="{{ url($Property->property_brochure) }}" target="_blank">@lang('View')</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button class="btn btn-primary col-4 waves-effect waves-light"
                                type="submit">@lang('save')</button>
                        </div>

                    </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end col -->
        </div> <!-- end row -->
        @include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')

    <!-- container-fluid -->

    @push('scripts')
        <script>
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
                            $('#addNewCCModal').modal('hide');
                            alertify.success(@json(__('added successfully')));
                        },
                        error: function(xhr, status, error) {
                            // Handle error response here
                            console.error(xhr.responseText);
                        }
                    });
                });
            });

            $('.Region_id').on('change', function() {
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
            // $("#myAddressBar").on("keyup", function() {
            //     // This function will be called every time a key is pressed in the input field
            //     var input = document.getElementById("myAddressBar");
            //     var autocomplete = new google.maps.places.Autocomplete(input);
            //     var place = autocomplete.getPlace();

            //     // Listen for the place_changed event
            //     google.maps.event.addListener(autocomplete, "place_changed", function() {
            //         // Get the selected place
            //         var place = autocomplete.getPlace();

            //         // Get the details of the selected place
            //         var address = place.formatted_address;
            //         var lat = place.geometry.location.lat();
            //         var long = place.geometry.location.lng();
            //         // $("#address").val(address);
            //         $("#location_tag").val(lat + "," + long);
            //         // Log the details to the console (or do something else with them)
            //     });
            // });

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

{{-- <script>
    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', function() {
            const nextTab = this.getAttribute('data-next');
            const nextTabButton = document.querySelector(`[data-bs-target="${nextTab}"]`);
            nextTabButton.click();
        });
    });
</script> --}}

<script>
    document.getElementById('show_in_gallery').addEventListener('change', function () {
        var galleryFields = document.getElementById('gallery-fields');
        if (this.checked) {
            galleryFields.style.display = 'block';
            document.getElementById('ad_license_number').required = true;
            document.getElementById('ad_license_expiry').required = true;
        } else {
            galleryFields.style.display = 'none';
            document.getElementById('ad_license_number').required = false;
            document.getElementById('ad_license_expiry').required = false;
        }
    });

    // Initial state based on the checkbox value
    document.addEventListener('DOMContentLoaded', function () {
        var showInGalleryCheckbox = document.getElementById('show_in_gallery');
        var galleryFields = document.getElementById('gallery-fields');

        // Set initial visibility based on the checkbox state
        if (showInGalleryCheckbox.checked) {
            galleryFields.style.display = 'block';
        } else {
            galleryFields.style.display = 'none';
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var adLicenseExpiryInput = document.getElementById('ad_license_expiry');
        var errorMessage = document.getElementById('date_error_message');
        adLicenseExpiryInput.addEventListener('change', function() {
            var selectedDate = new Date(this.value);
            if (selectedDate > licenseDate) {
                errorMessage.style.display = 'block';
                adLicenseExpiryInput.setCustomValidity('');
            } else {
                errorMessage.style.display = 'none';
                adLicenseExpiryInput.setCustomValidity(''); /
            }
        });

        adLicenseExpiryInput.addEventListener('focus', function() {
            errorMessage.style.display = 'none';
        });
    });
</script>

<script>
    var licenseDate = new Date("{{ $licenseDate }}");
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var adLicenseExpiryInput = document.getElementById('ad_license_expiry');
        var errorMessage = document.getElementById('date_error_message');
        var submitButton = document.getElementById('submit_button');
        var form = document.getElementById('unit-form');

        function validateDate() {
            var selectedDate = new Date(adLicenseExpiryInput.value);
            if (selectedDate > licenseDate) {
                // Show error message if the selected date is after the license date
                errorMessage.style.display = 'block';
                submitButton.disabled = true; // Disable submit button
            } else {
                // Hide error message if the date is valid
                errorMessage.style.display = 'none';
                submitButton.disabled = false; // Enable submit button
            }
        }

        adLicenseExpiryInput.addEventListener('change', validateDate);

        form.addEventListener('submit', function(event) {
            var selectedDate = new Date(adLicenseExpiryInput.value);
            if (selectedDate > licenseDate) {
                // Prevent form submission if the selected date is invalid
                event.preventDefault();
                errorMessage.style.display = 'block';
            } else {
                // Allow form submission if the date is valid
                errorMessage.style.display = 'none';
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
</script>

<script>
    $(document).ready(function() {
        // Initialize Google Places Autocomplete for the address input once
        var input = document.getElementById("myAddressBar");
        var autocomplete = new google.maps.places.Autocomplete(input);

        // To track if a place was selected from Google Places
        var placeSelected = false;

        // Listen for the place_changed event when a place is selected
        google.maps.event.addListener(autocomplete, "place_changed", function() {
            // Get the selected place
            var place = autocomplete.getPlace();

            // Check if the place contains geometry (lat, lng)
            if (place.geometry) {
                var lat = place.geometry.location.lat();
                var long = place.geometry.location.lng();

                // Set the lat, long values into the hidden input field
                $("#location_tag").val(lat + "," + long);

                // Mark that a valid place was selected
                placeSelected = true;

                // Clear any previous error messages
                $("#addressError").text('');
                $("#myAddressBar").removeClass("is-invalid");
            }
        });

        // When user types manually, reset placeSelected flag
        $("#myAddressBar").on("input", function() {
            placeSelected = false; // Reset place selection
            $("#location_tag").val(''); // Clear hidden input
            $("#addressError").text(''); // Clear any previous error
            $("#myAddressBar").removeClass("is-invalid");
        });

        // On blur, check if a valid place was selected from Google Places
        $("#myAddressBar").on("blur", function() {
            var addressValue = $("#myAddressBar").val().trim(); // Get the input value

            // If no place was selected from Google Places
            if (!placeSelected) {
                // Show an error message indicating that the address must be selected from the suggestions
                $("#addressError").text("Please select a valid address from the suggestions.");
                $("#myAddressBar").addClass("is-invalid");
            } else {
                // If a valid place was selected, clear the error message
                $("#addressError").text('');
                $("#myAddressBar").removeClass("is-invalid");
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nextButtons = document.querySelectorAll('.next-tab');
        const navButtons = document.querySelectorAll('.link');

        function validateAndProceed(nextTabId) {
            // Get the current tab content
            const currentTab = document.querySelector('.tab-pane.active');
            // Get all required fields in the current tab
            const requiredFields = currentTab.querySelectorAll('[required]');
            let allFilled = true;

            // Reset red border styles
            requiredFields.forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Check if all required fields are filled
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    allFilled = false;
                    field.classList.add('is-invalid'); // Add red border
                }
            });

            // If all required fields are filled, proceed to the next tab
            if (allFilled) {
                // Hide current tab
                currentTab.classList.remove('show', 'active');

                // Show next tab
                const nextTab = document.querySelector(nextTabId);
                nextTab.classList.add('show', 'active');

                // Update the active tab button in the navigation
                const currentNavButton = document.querySelector('.nav-link.active');
                const nextNavButton = document.querySelector(`button[data-bs-target="${nextTabId}"]`);

                // Remove active class from current tab button
                if (currentNavButton) {
                    currentNavButton.classList.remove('active');
                }

                // Add active class to next tab button
                if (nextNavButton) {
                    nextNavButton.classList.add('active');
                }
            }
        }

        // Event listener for next buttons
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const nextTabId = button.getAttribute('data-next');
                validateAndProceed(nextTabId);
            });
        });

        // Event listener for nav buttons
        navButtons.forEach(navButton => {
            navButton.addEventListener('click', function() {
                const nextTabId = navButton.getAttribute('data-bs-target');
                // Call validateAndProceed with the target tab
                validateAndProceed(nextTabId);
            });
        });
    });
</script>


@endpush
@endsection
