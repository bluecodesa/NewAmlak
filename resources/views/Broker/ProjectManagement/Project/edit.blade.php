@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Project') . ' ' . $project->name)
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">

                    <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Project.index') }}" class="text-muted fw-light">@lang('Projects') </a> /
                        @lang('Edit') : {{ $project->name }}
                    </h4>
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        @include('Admin.layouts.Inc._errors')
                        <div class="card-body">
                            <form action="{{ route('Broker.Project.update', $project->id) }}" method="POST" class="row"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col-md-3 col-12 mb-3">

                                    <label class="form-label">
                                        {{ __('project name') }} <span class="required-color">*</span></label>
                                    <input type="text" value="{{ $project->name }}" required id="modalRoleName"
                                        name="name" class="form-control" placeholder="{{ __('project name') }}">

                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('Region') </label>
                                    <select class="form-select" id="Region_id" required>
                                        <option disabled value="">@lang('Region') <span
                                                class="required-color">*</span></option>
                                        @foreach ($Regions as $Region)
                                            <option value="{{ $Region->id }}"
                                                {{ $Region->id == $project->Region_id ? 'selected' : '' }}
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
                                                {{ $city->id == $project->city_id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-3 col-12 mb-3">
                                    <label class="form-label">@lang('district') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="district_id" id="DistrictDiv" required>
                                        @foreach ($project->CityData->DistrictsCity as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $project->district_id ? 'selected' : '' }}>
                                                {{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4 mb-3">
                                    <label class="form-label">@lang('location name') <span
                                            class="required-color">*</span></label>
                                    <input type="text" required name="location" id="myAddressBar" class="form-control"
                                        placeholder="@lang('Address')" value="{{ $project->location }}" />
                                </div>

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Developer name') </label>
                                    <select class="form-select" name="developer_id">
                                        <option value="">@lang('Developer name')</option>
                                        @foreach ($developers as $developer)
                                            <option value="{{ $developer->id }}"
                                                {{ $developer->id == $project->developer_id ? 'selected' : '' }}>
                                                {{ $developer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label">@lang('Advisor name') </label>
                                    <select class="form-select" name="advisor_id">
                                        <option selected value="">@lang('Advisor name')</option>
                                        @foreach ($advisors as $advisor)
                                            <option value="{{ $advisor->id }}"
                                                {{ $advisor->id == $project->advisor_id ? 'selected' : '' }}>
                                                {{ $advisor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="col-md-6 col-12 mb-3">
                                    <label class="col-md-6 form-label">@lang('owner name') <span
                                            class="required-color">*</span>
                                    </label>
                                    <div class="input-group">
                                        <select class="form-select" id="OwnersDiv"
                                            aria-label="Example select with button addon" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}"
                                                    {{ $owner->id == $project->owner_id ? 'selected' : '' }}>
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addNewCCModal" type="button">@lang('Add New Owner')</button>
                                    </div>
                                </div>


                                <div class="col-md-6 col-12 mb-3">
                                    <label class="form-label">@lang('service type') <span class="required-color">*</span>
                                    </label>
                                    <select class="form-select" name="service_type_id" required>
                                        <option disabled value="">@lang('service type')</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ $service->id == $project->service_type_id ? 'selected' : '' }}>
                                                {{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-12 mb-3">
                                    <label class="form-label">@lang('Project photo') </label>
                                    <input type="file" name="image" class="dropify"
                                        data-url="{{ route('Broker.Project.deleteImage', $project->id) }}"
                                        data-default-file="{{ url($project->image) }}" />
                                </div>



                                {{-- <div class="col-sm-12 col-md-6 mb-3">
                                        <label class="form-label">@lang('address')</label>
                                        <input type="text" required name="address" id="address" class="form-control"
                                            placeholder="@lang('address')" value="{{ old('address') }}" />
                                    </div> --}}

                                <div class="col-sm-12 col-md-6 mb-3" hidden>
                                    <label class="form-label">@lang('lat&long')</label>
                                    <input type="text" required readonly name="lat_long" id="location_tag"
                                        class="form-control" placeholder="@lang('lat&long')"
                                        value="{{ $project->lat_long }}" />
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-primary waves-effect waves-light"
                                        type="submit">@lang('save')</button>
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
