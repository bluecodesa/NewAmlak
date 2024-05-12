@extends('Admin.layouts.app')
@section('title', __('Add New Advisor'))
@section('content')

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">

                <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    <a href="{{ route('Broker.Advisor.index') }}" class="text-muted fw-light">@lang('advisors') </a> /
                    @lang('Add New Advisor')
                </h4>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    @include('Admin.layouts.Inc._errors')
                    <div class="card-body">
                        <form action="{{ route('Broker.Advisor.store') }}" method="POST" class="row">
                            @csrf
                            @method('post')

                            <div class="col-md-6 col-12 mb-3">

                                <label class="form-label">
                                    {{ __('Name') }} <span class="required-color">*</span></label>
                                <input type="text" required id="modalRoleName" name="name" class="form-control"
                                    placeholder="{{ __('Name') }}">

                            </div>


                            <div class="col-md-6 col-12 mb-3">
                                <label class="form-label"> @lang('Email') <span
                                        class="required-color">*</span></label>
                                <input type="email" required name="email" class="form-control"
                                    placeholder="@lang('Email')">

                            </div>


                            <div class="col-md-4 col-12 mb-3">

                                <label for="phone">@lang('phone')<span class="text-danger">*</span></label>
                                <div style="position:relative">

                                    <input type="tel" class="form-control" id="phone" minlength="9"
                                        maxlength="9" pattern="[0-9]*"
                                        oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                        onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                        name="phone" required="" value="">


                                </div>
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <label>@lang('Region') <span class="required-color">*</span> </label>
                                <select class="form-select" id="Region_id" required>
                                    <option disabled selected value="">@lang('Region')</option>
                                    @foreach ($Regions as $Region)
                                        <option value="{{ $Region->id }}"
                                            data-url="{{ route('Broker.Broker.GetCitiesByRegion', $Region->id) }}">
                                            {{ $Region->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <label>@lang('city') <span class="required-color">*</span> </label>
                                <select class="form-select" name="city_id" id="CityDiv" required>

                                </select>
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
    @include('Broker.ProjectManagement.Project.Unit.inc._model_new_owners')




</div>
<!-- container-fluid -->

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
