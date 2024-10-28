
@extends('Admin.layouts.app')
@section('title', __('Add unit'))
@section('content')



    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Office.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Office.Unit.index') }}" class="text-muted fw-light">@lang('Units') </a> /
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
                      <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home"
                        aria-controls="navs-justified-home"
                        aria-selected="true">
                        <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('Description')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">10</span>
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
                          <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('Gallery')
                          <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">2</span>
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
                        <i class="tf-icons ti ti-bell-dollar ti-xs me-1"></i> @lang('price')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-justified-messages"
                        aria-controls="navs-justified-messages"
                        aria-selected="false">
                        <i class="tf-icons ti ti-file ti-xs me-1"></i> @lang('Attachments')
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">0</span>
                      </button>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">


                        {{-- الوصف --}}


                        <form action="{{ route('Office.Property.StoreUnit',$Property->id) }}" method="POST" class="row"
                        enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="text" hidden name="lat_long" value="{{ $Property->lat_long }}">
                        {{-- <input type="text" hidden name="project_id" value="{{ $Property->project_id }}">
                        <input type="text" hidden name="property_id" value="{{ $Property->id }}"> --}}

                        <div class="col-md-3 col-12 mb-3">

                            <label class="form-label">
                                {{ __('Residential number') }} <span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="number_unit" value="{{ old('number_unit') }}"
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
                                        data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}">
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
                                        data-url="{{ route('Office.Office.GetDistrictsByCity', $city->id) }}"
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
                                <span id="addressError" style="color: red;"></span> <!-- Error message placeholder -->

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
                            <input type="number" name="instrument_number" class="form-control" value="{{ old('instrument_number') }}"
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



                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Area (square metres)')</label>
                                    <input type="number" name="space" class="form-control"
                                        placeholder="@lang('Area (square metres)')" value="{{ old('space') }}" />
                                </div>


                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('number rooms') </label>
                                    <input type="number" name="rooms" class="form-control"
                                        placeholder="@lang('number rooms')" value="{{ old('rooms') }}" />
                                </div>



                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Number bathrooms') </label>
                                    <input type="number" name="bathrooms" class="form-control"
                                        placeholder="@lang('Number bathrooms')" value="{{ old('bathrooms') }}" />
                                </div>
                                <div class="col-12 mb-2 col-md-4">
                                    <label class="form-label">@lang('Status of Unit') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="status" id="type" required>
                                        <option disabled value="" {{ old('status') == '' ? 'selected' : '' }}>@lang('Status of Unit') </option>
                                        @foreach (['vacant', 'rented'] as $type)
                                            <option value="{{ $type }}" {{ old('status') == $type ? 'selected' : '' }}>
                                                {{ __($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                            <div class="col-12 col-md-4 mb-3">
                                                <label>@lang('services') </label>
                                                <select class="select2 form-select" id="exampleFormControlSelect1"
                                                    name="service_id[]" multiple="multiple">
                                                    <option disabled value="">@lang('services')</option>
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" {{ (collect(old('service_id'))->contains($service->id)) ? 'selected' : '' }}>
                                                        {{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 mb-2 col-md-4">
                                                <label class="form-label">@lang('The Responsible Employee')
                                                </label>
                                                <select class="form-select" name="employee_id" id="type">
                                                    <option disabled selected value="" {{ old('employee_id') == '' ? 'selected' : '' }}>@lang('The Responsible Employee') </option>
                                                    @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee ? 'selected' : '' }}>
                                                        {{ $employee->UserData->name }}</option>
                                                @endforeach
                                                </select>
                                            </div>


                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ old('location_tag') }}" />
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
                                                            onclick="addFeature()"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                                                class="d-none d-sm-inline-block">@lang('Add details')</span></button>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="col-12" style="text-align: center;">
                                            <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                                data-next="#navs-justified-gallery">
                                                {{ __('Next') }}
                                            </button>
                                        </div>


                    </div>
                    <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                        <div class="row">

                            <div class="col-md-3 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('ad name') }} <span class="required-color">*</span></label>
                                <input type="text" required name="ad_name" class="form-control"  value="{{ old('ad_name') }}"
                                    placeholder="{{ __('ad name') }}">

                            </div>



                            <div class="col-12 mb-2 col-md-4">
                                <label class="form-label">@lang('Ad type') <span
                                        class="required-color">*</span>
                                </label>
                                <select class="form-select" name="type" id="type" required>
                                    <option disabled value="" {{ old('type') == '' ? 'selected' : '' }}>@lang('Ad type') </option>
                                    @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                            {{ __($type) }}</option>
                                    @endforeachh
                                </select>
                            </div>

                            @if($falLicense)
                            <!-- Show the "Show in Gallery" switch if the user has a valid license -->
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label" style="display: block !important;">@lang('Show in Gallery')</label>
                                <label class="switch switch-lg">
                                    <input type="checkbox" name="show_in_gallery" class="switch-input" id="show_in_gallery" value="{{ old('show_in_gallery') }}"
                                        @if($falLicense->ad_license_status != 'valid') disabled @endif
                                        @if($falLicense->ad_license_status == 'valid') checked @endif />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="ti ti-check"></i></span>
                                        <span class="switch-off"><i class="ti ti-x"></i></span>
                                    </span>
                                </label>
                            </div>

                            <!-- Show gallery fields only if the license status is "valid" -->
                            <div class="row" id="gallery-fields" style="@if($falLicense->ad_license_status != 'valid') display: none; @endif">
                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Ad License Number')<span class="required-color">*</span></label>
                                    <input type="number" name="ad_license_number" class="form-control" id="ad_license_number" value="{{ old('ad_license_number') }}"
                                        @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('Ad License Expiry')<span class="required-color">*</span></label>
                                    <input type="date" name="ad_license_expiry" class="form-control" id="ad_license_expiry" value="{{ old('ad_license_expiry') }}"
                                        @if($falLicense->ad_license_status != 'valid') disabled @endif required />
                                    <div id="date_error_message" style="color: red; display: none;">@lang('Fal license  date can not be exceeded')</div>
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

                            <div class="col-12 mb-3">
                                <label class="form-label mb-2">@lang('Description')</label>
                                <div>
                                    {{-- <textarea name="note" class="form-control" rows="5"></textarea> --}}
                                    <textarea id="textarea" class="form-control" name="note" cols="30" rows="30" placeholder="">
                                        {!! old('note') !!}
                                    </textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Unit Images') </label>
                                <div class="input-group">
                                <input class="form-control" id="upload" type="file" name="images[]" multiple accept="image/jpeg, image/png" />
                                <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon1"><i class="ti ti-refresh"></i></button>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label mb-2">@lang('Unit Video')</label>
                                <div class="input-group">
                                <input class="form-control" id="uploadVideo" type="file" name="video"  accept="video/mp4, video/webm, video/ogg" />
                                <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon2"><i class="ti ti-refresh"></i></button>
                                </div>
                            </div>


                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                data-next="#navs-justified-profile">
                                {{ __('Next') }}
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                        <div class="row">

                            <div class="col-12 mb-2 col-md-4">
                                <label class="form-label">@lang('Ad type') <span class="required-color">*</span>
                                </label>
                                <select class="form-select" name="type" id="type" required>
                                    <option disabled value="">@lang('Ad type') </option>
                                    @foreach (['rent', 'sale', 'rent and sale'] as $type)
                                        <option value="{{ $type }}">
                                            {{ __($type) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-2 mb-3">
                                <label class="form-label" style="display: block !important;">@lang('Show in Gallery')
                                </label>
                                {{-- <input type="checkbox" checked name="show_in_gallery" class="toggleHomePage"
                                        data-toggle="toggle" data-onstyle="primary"> --}}

                                <label class="switch switch-lg">
                                    <input type="checkbox" name="show_in_gallery" class="switch-input" checked />
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


                        </div>

                    </div>
                    <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-12 col-md-2 mb-3">
                                <label class="form-label" style="display: block !important;">@lang('Daily Rent')
                                </label>
                                {{-- <input type="checkbox"  name="daily_rent" class="toggleHomePage"
                                        data-toggle="toggle" data-onstyle="primary"> --}}
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
                            <label class="form-label">@lang('selling price')</label>
                            <input type="number" name="price" class="form-control"
                                placeholder="@lang('selling price')" value="{{ old('price') }}" />
                        </div>


                        <div class="col-sm-12 col-md-4 mb-3">
                            <label class="form-label">@lang('Monthly rental price')</label>
                            <input type="number" name="monthly" class="form-control"
                                placeholder="@lang('Monthly rental price')" value="{{ old('monthly') }}" />
                        </div>

                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button type="button" class="btn btn-primary col-4 me-1 next-tab"
                                data-next="#navs-justified-messages">
                                {{ __('Next') }}
                            </button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-justified-messages" role="tabpanel">
                        <div class="row">
                            <div class=" col-6 mb-3">
                                <label for="formFileMultiple" class="form-label">@lang('Unit Masterplan')</label>
                                <div class="input-group">
                                <input class="form-control" type="file" name="unit_masterplan"
                                    id="projectMasterplan" accept="image/*,application/pdf" multiple>
                                    <button class="btn btn-outline-primary waves-effect" type="button" id="button-addon3"><i class="ti ti-refresh"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-12" style="text-align: center;">
                            <button class="btn btn-primary col-4 waves-effect waves-light" id="submit_button"
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
@include('Office.ProjectManagement.Project.Unit.inc._model_new_owners')

{{-- نهايه الوصف --}}
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


    </script>
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

            var path = "{{ route('Office.Project.autocompleteProject') }}";

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
            $('#button-addon1').click(function() {
                $('#upload').val('');

            });
        </script>
         <script>
            $('#button-addon2').click(function() {
                $('#uploadVideo').val('');
            });
        </script>
          <script>
            $('#button-addon3').click(function() {
                $('#projectMasterplan').val('');
            });
        </script>
{{--
<script>
    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', function() {
            const nextTab = this.getAttribute('data-next');
            const nextTabButton = document.querySelector(`[data-bs-target="${nextTab}"]`);
            nextTabButton.click();
        });
    });
</script> --}}




<script>
    $(document).ready(function() {
        function populateFields(data) {
            // Populate region select
            $('#Region_id').val(data.city_data.region_data.id).change();

            // Populate city select
            $('#CityDiv').empty();
            // $('#CityDiv').append('<option disabled value="">@lang('city')</option>');
            // $('#CityDiv').append('<option value="' + data.city_data.id + '">' + data.city_data.name + '</option>');

            // Populate district select
            $('#DistrictDiv').empty();
            // $.each(data.city_data.districts_city, function(index, district) {
            //     $('#DistrictDiv').append('<option value="' + district.id + '">' + district.name + '</option>');
            // });
        }

        function resetFields() {
            // $('#Region_id').val('').change();
            $('#CityDiv').empty();
            $('#DistrictDiv').empty();
            $('#myAddressBar').val('');
            $('select[name="property_type_id"]').val('').change();
            $('select[name="property_usage_id"]').val('').change();
            $('select[name="owner_id"]').val('').change();
            // $('input[name="instrument_number"]').val('');
            $('select[name="service_type_id"]').val('').change();
        }

        $('#projectSelect').on('change', function() {
            var projectId = $(this).val();
            if (projectId) {
                $.ajax({
                    url: '{{ route('Office.GetProjectDetails', '') }}/' + projectId,
                    type: 'GET',
                    success: function(response) {
                        populateFields(response.project);
                        $('#myAddressBar').val(response.project.location);
                        $('select[name="property_type_id"]').val(response.project.property_type_id).change();
                        $('select[name="property_usage_id"]').val(response.project.property_usage_id).change();
                        $('select[name="owner_id"]').val(response.project.owner_id).change();
                        // $('input[name="instrument_number"]').val(response.project.instrument_number);
                        $('select[name="service_type_id"]').val(response.project.service_type_id).change();
                    },
                    error: function(error) {
                        console.error('Error fetching project details:', error);
                    }
                });
            } else {
                resetFields();
            }
        });

        $('#propertySelect').on('change', function() {
            var propertyId = $(this).val();
            if (propertyId) {
                $.ajax({
                    url: '{{ route('Office.GetPropertyDetails', '') }}/' + propertyId,
                    type: 'GET',
                    success: function(response) {
                        populateFields(response.property);
                        $('#myAddressBar').val(response.property.location);
                        $('select[name="property_type_id"]').val(response.property.property_type_id).change();
                        $('select[name="property_usage_id"]').val(response.property.property_usage_id).change();
                        $('select[name="owner_id"]').val(response.property.owner_id).change();
                        // $('input[name="instrument_number"]').val(response.property.instrument_number);
                        $('select[name="service_type_id"]').val(response.property.service_type_id).change();
                    },
                    error: function(error) {
                        console.error('Error fetching property details:', error);
                    }
                });
            } else {
                resetFields();
            }
        });
    });
</script>

<script>
    document.getElementById('show_in_gallery').addEventListener('change', function () {
        var galleryFields = document.getElementById('gallery-fields');
        if (this.checked) {
            galleryFields.style.display = 'block';
            document.getElementById('ad_license_number').disabled = false;
            document.getElementById('ad_license_expiry').disabled = false;
        } else {
            galleryFields.style.display = 'none';
            document.getElementById('ad_license_number').disabled = true;
            document.getElementById('ad_license_expiry').disabled = true;
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
