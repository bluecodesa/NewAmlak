@extends('Admin.layouts.app')
@section('title', __('Add New'))
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
                                <form action="{{ route('Office.Project.store') }}" method="POST" class="row"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                {{ __('project name') }} <span class="required-color">*</span></label>
                                            <input type="text" required id="modalRoleName" name="name"
                                                class="form-control" placeholder="{{ __('project name') }}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">@lang('Region') </label>
                                        <select class="form-control" id="Region_id" required>
                                            <option disabled selected value="">@lang('Region') <span
                                                    class="required-color">*</span></option>
                                            @foreach ($Regions as $Region)
                                                <option value="{{ $Region->id }}"
                                                    data-url="{{ route('Office.Office.GetCitiesByRegion', $Region->id) }}">
                                                    {{ $Region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">@lang('city') <span class="required-color">*</span>
                                        </label>
                                        <select class="form-control" name="city_id" id="CityDiv" required>

                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-3 mb-3">
                                        <label class="form-label">@lang('location name') <span
                                                class="required-color">*</span></label>
                                        <input type="text" required name="location" id="myAddressBar"
                                            class="form-control" placeholder="@lang('location name')"
                                            value="{{ old('location name') }}" />
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Developer name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="developer_id" required>
                                            <option disabled selected value="">@lang('Developer name')</option>
                                            @foreach ($developers as $developer)
                                                <option value="{{ $developer->id }}">
                                                    {{ $developer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label>@lang('Advisor name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="advisor_id" required>
                                            <option disabled selected value="">@lang('Advisor name')</option>
                                            @foreach ($advisors as $advisor)
                                                <option value="{{ $advisor->id }}">
                                                    {{ $advisor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>@lang('Employee Name') <span class="required-color">*</span> </label>
                                        <select class="form-control" name="employee_id" required>
                                            <option disabled selected value="">@lang('Employee Name')</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">
                                                    {{ $employee->UserData->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-md-3">
                                        <label class="form-label">@lang('owner name') <span class="required-color">*</span>
                                        </label>
                                        <select class="form-control" name="owner_id" required>
                                            <option disabled selected value="">@lang('owner name')</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}">
                                                    {{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-12 col-md-12 mb-3">
                                        <label class="form-label">@lang('Project photo') </label>
                                        <input type="file" name="image" class="dropify" data-default-file="" />
                                    </div>

                                    <div class="col-sm-12 col-md-6 mb-3" hidden>
                                        <label class="form-label">@lang('lat&long')</label>
                                        <input type="text" required readonly name="lat_long" id="location_tag"
                                            class="form-control" placeholder="@lang('lat&long')"
                                            value="{{ old('location_tag') }}" />
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
                    $("#address").val(address);
                    $("#location_tag").val(lat + "," + long);
                    // Log the details to the console (or do something else with them)
                });
            });
        </script>
    @endpush
@endsection
