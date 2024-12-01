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

        .wrapper-page {
            width: 70%;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('welcome') }}" class="text-white"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="wrapper-page">
        <div class="card card-pages shadow-none">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url($sitting->icon) }}"
                            alt="" height="24"></a>
                </div>
                <h5 class="font-18 text-center">@lang('sign in') </h5>
                <form action="{{ route('Home.Offices.CreateOffice') }}" method="POST" class="row"
                    enctype="multipart/form-data">
                    @csrf
                    @method('post')

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="CR_number">@lang('Commercial Registration No') <span
                                    class="not_required">(@lang('optional'))</span></label>
                            <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')" id="CR_number"
                                required="hhhh" name="CRN" value="">
                        </div>
                        <div class="form-group">
                            <label for="Company_name">@lang('Company Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="@lang('Company Name')" id="company_name"
                                name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="presenter_email">@lang('Company email') <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="presenter_email" value=""
                                name="email" required="" placeholder="@lang('Company email')">
                        </div>
                        <div class="form-group">
                            <label for="contract">@lang('Company logo')</label>
                            <span class="not_required">(@lang('optional'))</span>
                            <input type="file" class="form-control" id="company_logo" name="company_logo"
                                accept="image/png, image/jpg, image/jpeg">
                        </div>
                        <div class="form-group">
                            <label for="presenter_name">@lang('Name of company representative')<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="presenter_name" name="presenter_name"
                                value="" required="" placeholder="@lang('Name of company representative')">
                        </div>
                        <div class="form-group">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">@lang('Region') </label>
                            <select class="form-control" id="Region_id" name="region_id" required>
                                <option disabled selected value="">@lang('Region')</option>
                                @foreach ($Regions as $Region)
                                    <option value="{{ $Region->id }}"
                                        data-url="{{ route('Home.Region.show', $Region->id) }}">
                                        {{ $Region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('city')</label>
                            <select class="form-control" name="city_id" id="CityDiv" required>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="package">@lang('Subscription Type') <span class="text-danger">*</span></label>
                            <select type="package" class="form-control" name="subscription_type_id" required="">
                                <option value="" selected disabled>@lang('Subscription Type')</option>
                                @foreach ($subscriptionTypes as $subscriptionType)
                                    <option value="{{ $subscriptionType->id }}">
                                        {{ $subscriptionType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('password') <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password"
                                required="" placeholder="@lang('password')">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">@lang('Confirm Password') <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required="" placeholder="@lang('Confirm Password') ">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit"
                            class="btn btn-primary waves-effect waves-light">@lang('save')</button>
                    </div>
                    <div class="form-group mb-0 row">
                        <div class="col-12 m-t-10 text-center">
                            @lang('By registering') @lang('you accept our')
                            <a href="{{ asset($termsAndConditionsUrl) }}" target="_blank" download>
                                @lang('Conditions') &amp; @lang('Terms')
                            </a>
                            <a href="{{ asset($privacyPolicyUrl) }}" target="_blank" download>
                                @lang('and') @lang('our privacy policy')
                            </a>
                        </div>
                    </div>
                </form>

            </div>


        </div>
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

    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="{{ url('dashboard_files/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('dashboard_files/assets/js/app.js') }}"></script>


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
