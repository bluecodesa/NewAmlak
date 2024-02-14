<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ $sitting->title }} @lang('register')</title>
    <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="{{ url('dashboard_files/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <link href="http://fonts.cdnfonts.com/css/tajawal" rel="stylesheet">
    <style>
        body,
        h4,
        h5,
        strong,
        label span,
        * {
            font-family: 'Tajawal';
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('welcome') }}" class="text-white"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="wrapper-page" style="width: 50%;">
        <div class="card card-pages shadow-none">
            <div class="card-body px-5"> <!-- Adjusted width -->
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url($sitting->icon) }}" alt="" height="24"></a>
                </div>
                <h5 class="font-18 text-center">@lang('register') </h5>
                <form action="{{ route('Home.Brokers.CreateBroker') }}" method="POST">
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

                        </div></div>
                    </div>
                    <div class="mb-3 row">

                        <div class="form-group col-md-4">
                            <label>@lang('Region') </label>
                            <select class="form-control" id="Region_id" name="region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Home.Region.show', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>@lang('city') </label>
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

                        <div class="col-md-6">
                            <label for="password"> @lang('password') <span
                                class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="col-md-6">
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
    </div>
    <!-- END wrapper -->


    <!-- jQuery  -->
    <script src="{{ url('dashboard_files/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('dashboard_files/assets/js/app.js') }}"></script>


    <!-- Custom  js -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
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
                    // Empty the city select element
                    $(this).empty();
                    // Append the new options based on the received data
                    $.each(data, function(key, city) {
                        $('#CityDiv').append($('<option>', {
                            value: city.id,
                            text: city.name
                        }));
                    });
                    // Fade in the city select element with new options
                    $(this).fadeIn('fast');
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

    </script>


</body>

</html>
