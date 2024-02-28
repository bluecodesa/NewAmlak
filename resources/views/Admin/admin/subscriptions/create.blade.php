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
                                <form action="{{ route('Admin.Subscribers.store') }}" method="POST" class="row"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('post')

                                    <div class="col-md-4 mb-4">
                                        <label for="CR_number"> @lang('Commercial Registration No') </label>
                                        <span class="not_required">(@lang('optional'))</span>
                                        <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')"
                                            id="CR_number" required="hhhh" name="CRN" value="">
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="Company_name">@lang('Company Name') <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="@lang('Company Name')"
                                            id="company_name" name="name" value="">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="presenter_email">@lang('Company email') <span
                                                class="text-danger">*</span></label>

                                        <input type="email" class="form-control" id="presenter_email" value=""
                                            name="email" required="" placeholder="@lang('Company email')">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="company_logo">@lang('Company logo')</label>
                                        <span class="not_required">(@lang('optional'))</span>
                                        <input type="file" class="form-control d-none" id="company_logo"
                                            name="company_logo" accept="image/png, image/jpg, image/jpeg">
                                        <!-- Image preview with default image -->
                                        <img id="company_logo_preview" src="https://www.svgrepo.com/show/29852/user.svg"
                                            class="d-flex mr-3 rounded-circle" height="64" style="cursor: pointer;" />
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="presenter_name">@lang('Name of company representative')<span
                                                class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="presenter_name" name="presenter_name"
                                            value="" required="" placeholder="@lang('Name of company representative')">
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label for="presenter_number">@lang('Company representative number')(@lang('WhatsApp'))<span
                                                class="text-danger">*</span></label>
                                        <div style="position:relative">

                                            <input type="tel" class="form-control" id="presenter_number" minlength="9"
                                                maxlength="9" pattern="[0-9]*"
                                                oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                                name="presenter_number" required="" value="">

                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>@lang('Region') <span class="text-danger">*</span> </label>
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
                                        <label>@lang('city') <span class="text-danger">*</span> </label>
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
                                    <div class="col-6 mb-4">
                                        <label for="password"> @lang('password') <span
                                                class="text-danger">*</span></label>

                                        <input type="password" class="form-control" id="password" name="password"
                                            required="" placeholder="@lang('password')">
                                    </div>
                                    <div class="col-6 mb-4">
                                        <label for="password_confirmation"> @lang('Confirm Password') <span
                                                class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required=""
                                            placeholder="@lang('Confirm Password') ">
                                    </div>


                                    <div class="col-12">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">@lang('Cancel')</button>
                                            <button type="submit"
                                                class="btn btn-primary waves-effect waves-light">@lang('save')</button>
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
