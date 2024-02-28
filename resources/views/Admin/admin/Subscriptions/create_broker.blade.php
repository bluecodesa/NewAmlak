@extends('Admin.layouts.app')
@section('title', __('Add New Subscriber'))
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
                                    @lang('Add New Subscriber')</h4>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-right">
                                    <li class="breadcrumb-item"><a href="{{ route('Admin.Subscribers.create') }}">@lang('Add New Subscriber')</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('Admin.Subscribers.index') }}">@lang('Subscribers')</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('Admin.home') }}">@lang('dashboard')</a></li>
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

<form action="{{ route('Admin.Subscribers.CreateBroker') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="name"> @lang('Broker name')<span class="text-danger">*</span></label>

            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6">
            <label for="license_number"> @lang('license number')<span class="text-danger">*</span></label>

            <input type="text" class="form-control" id="license_number" name="license_number" required>
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="email">@lang('Email')<span class="text-danger">*</span></label>

            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="col-md-6">

            <label for="mobile">@lang('Mobile Whats app')<span
                    class="text-danger">*</span></label>
            <div style="position:relative">

                <input type="tel" class="form-control" id="mobile" minlength="9"
                    maxlength="9" pattern="[0-9]*"
                    oninvalid="setCustomValidity('Please enter 9 numbers.')"
                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                    name="mobile" required="" value="">

            </div>
        </div>

    </div>
    <div class="mb-3 row">

        <div class="form-group col-md-4">
            <label>@lang('Region') <span
                class="text-danger">*</span></label>
            <select class="form-control" id="Region_id" required>
                <option disabled selected value="">@lang('Region')</option>
                @foreach ($Regions as $Region)
                    <option value="{{ $Region->id }}"
                        data-url="{{ route('Admin.Region.show', $Region->id) }}">
                        {{ $Region->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label>@lang('city') <span
                class="text-danger">*</span></label>
            <select class="form-control" name="city_id" id="CityDiv" required>
            </select>
        </div>

        <div class="col-md-4 mb-2">
            <label for="package"> @lang('Subscription Type') <span class="text-danger">*</span></label>
            <select type="package" class="form-control" name="subscription_type_id"
                required="">
                <option value="" selected disabled> @lang('Subscription Type') </option>
                @foreach ($subscriptionTypes as $subscriptionType)
                    <option value="{{ $subscriptionType->id }}">
                        {{ $subscriptionType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row">
            <div class="col-md-4 mb-4">
                <label for="broker_logo">@lang('Broker logo')</label>
                <span class="not_required">(@lang('optional'))</span>
                <input type="file" class="form-control d-none" id="broker_logo"
                    name="company_logo" accept="image/png, image/jpg, image/jpeg">
                <img id="broker_logo_preview" src="https://www.svgrepo.com/show/29852/user.svg"
                    class="d-flex mr-3 rounded-circle" height="64" style="cursor: pointer;" />
            </div>

        <div class="col-md-4 mb-4">
            <label for="password"> @lang('password') <span
                class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="col-md-4 mb-4">
            <label for="password_confirmation"> @lang('Confirm Password') <span
                class="text-danger">*</span></label>            <input type="password" class="form-control" id="password_confirmation"
                name="password_confirmation" required>
        </div>
    </div>


    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="id_number" class="col-form-label">@lang('id number')</label>
            <input type="text" class="form-control" id="id_number" name="id_number">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4"></div>
        <div class="col-md-8">
            <button type="submit" class="btn btn-primary">@lang('save')</button>
        </div>
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
            $('#company_logo_preview').click(function() {
                $('#company_logo').click(); // Trigger file input click on image click
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#company_logo_preview').attr('src', e.target.result); // Update the preview image
                    };

                    reader.readAsDataURL(input.files[0]); // Convert image to base64 string
                }
            }

            $("#company_logo").change(function() {
                readURL(this); // Call readURL function when a file is selected
            });
        </script>
    @endpush
@endsection
