@extends('Admin.layouts.app')
@section('title', __('Add new property'))
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
                                        @lang('Add New')</h4>
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
                                <div class="card-body">
                                    <form action="{{ route('Office.Project.StoreProperty', $project->id) }}" method="POST"
                                        class="row" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{ __('property name') }} <span class="required-color">*</span></label>
                                                <input type="text" required id="modalRoleName" name="name"
                                                    class="form-control" placeholder="{{ __('property name') }}">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>@lang('Region') </label>
                                            <select class="form-control" id="Region_id" required>
                                                <option disabled value="">@lang('Region') <span
                                                        class="required-color">*</span></option>
                                                @foreach ($Regions as $Region)
                                                    <option value="{{ $Region->id }}"
                                                        data-url="{{ route('Admin.Region.show', $Region->id) }}"
                                                        {{ $project->CityData->RegionData->id == $Region->id ? 'selected' : '' }}>
                                                        {{ $Region->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>@lang('city') <span class="required-color">*</span> </label>
                                            <select class="form-control" name="city_id" id="CityDiv" required>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $project->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-4 mb-3">
                                            <label class="form-label">@lang('location') <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required name="location" id="myAddressBar"
                                                class="form-control" placeholder="@lang('location name')"
                                                value="{{ old('location name') }}" />
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



                                        <div class="form-group col-md-3">
                                            <label>@lang('Employee Name') <span class="required-color">*</span> </label>
                                            <select class="form-control" name="employee_id" required>
                                                <option disabled value="">@lang('Employee Name')</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $project->employee_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->UserData->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label>@lang('owner name') <span class="required-color">*</span> </label>
                                            <select class="form-control" name="owner_id" required>
                                                <option disabled selected value="">@lang('owner name')</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{ $owner->id }}"
                                                        {{ $project->owner_id == $owner->id ? 'selected' : '' }}>
                                                        {{ $owner->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                            $typeunits = [1 => 'Unit', 0 => 'property'];
                                        @endphp
                                        <div class="form-group col-md-3">
                                            <label>@lang('Unit or property') <span class="required-color">*</span> </label>
                                            <select class="form-control" name="is_rs" required>
                                                <option disabled selected value="">@lang('Unit or property')</option>
                                                @foreach ($typeunits as $index => $item)
                                                    <option value="{{ $index }}">
                                                        {{ __($item) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-3 mb-3">
                                            <label class="form-label">@lang('Instrument number') <span
                                                    class="required-color">*</span></label>
                                            <input type="text" required name="instrument_number" class="form-control"
                                                placeholder="@lang('Instrument number')" value="{{ old('Instrument number') }}" />
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
                    // $("#location_tag").val(lat + "," + long);
                    // Log the details to the console (or do something else with them)
                });
            });
        </script>
    @endpush
@endsection
