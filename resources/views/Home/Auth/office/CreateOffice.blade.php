<!doctype html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">

<head>
    {!! $sitting->google_tag !!}

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>{{ $sitting->title }} @lang('register')/ @lang('Office')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url($sitting->icon) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet"
        href="{{ asset('HOME_PAGE/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet"
        href="{{ asset('HOME_PAGE/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/@form-validation/form-validation.css') }}" />
    <link href="{{ url('dashboard_files/assets/css/alertify.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('HOME_PAGE/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('HOME_PAGE/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('HOME_PAGE/js/config.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">

    <style>
        .template-customizer-open-btn {
            display: none !important;
        }
    </style>

    <style>
        body,
        h4,
        h1,
        h2,
        h5,
        h6,
        h3,
        span,
        .dropify-clear,
        small,
        b,
        strong,
        label,

        * {
            font-family: "Noto Kufi Arabic", sans-serif !important;
        }
    </style>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="text-left mb-2">
                    <button class="btn btn-secondary" onclick="history.back()">عودة</button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                            src="{{ url($sitting->icon) }}" alt="" height="50"></a>
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2 text-center">سجل الأن</h4>

                        <form id="formAuthentication" class="mb-3" action="{{ route('Home.Offices.CreateNewOffice') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="text" name="key_phone" hidden value="966" id="key_phone">
                            <input type="text" name="full_phone" hidden id="full_phone" value="966">
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
                                <div class="d-flex align-items-start align-items-sm-center justify-content-center gap-4">
                                    <img src="{{ asset('HOME_PAGE/img/avatars/14.png') }}" alt="user-avatar"
                                        class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">@lang('Company logo')</span>
                                            <i class="ti ti-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input"
                                                name="company_logo" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <button type="button" id="account-image-reset"
                                            class="btn btn-label-secondary account-image-reset mb-3">
                                            <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">@lang('إعادة تعيين الصورة')</span>
                                        </button>

                                        <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3 row">

                                <div class="col-md-6">
                                    <label class="form-label" for="company_name"> @lang('Company Name')<span
                                            class="text-danger">*</span></label>

                                    <input type="text" class="form-control" placeholder="@lang('Company Name')"
                                        id="company_name" name="name" value="{{ $newOffice->name }}" readonly>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="name"> @lang('Commercial Registration No')<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')"
                                        id="CR_number" required name="CRN" value="">
                                </div>

                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">@lang('Company email')<span
                                            class="text-danger">*</span></label>

                                    <input type="email"  class="form-control" id="email" name="email" value="{{ $email }}"
                                    value="{{ $newOffice->email }}" readonly    required>

                                </div>
                                {{-- <div class="col-md-4">
                                    <label class="form-label" for="email">@lang('Name of company representative')<span
                                            class="text-danger">*</span></label>

                                            <input type="text" id="presenter_name" name="presenter_name" class="form-control" placeholder="@lang('Commercial Registration No')" id="CR_number"
                                            required >

                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label" for="mobile">@lang('Company Mobile')<span
                                            class="text-danger">*</span></label>

                                    <div class="input-group">
                                        <input type="text" placeholder="123456789" id="phone" name="phone"
                                        value="{{ $newOffice->phone }}" readonly class="form-control" maxlength="9" pattern="\d{1,9}"
                                            oninput="updateFullPhone(this)"
                                            aria-label="Text input with dropdown button">
                                        <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            {{ $newOffice->key_phone ?? 966}}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="">
                                            <li><a class="dropdown-item" data-key="971"
                                                    href="javascript:void(0);">971</a></li>
                                            <li><a class="dropdown-item" data-key="966"
                                                    href="javascript:void(0);">966</a></li>
                                        </ul>

                                    </div>

                                </div>
                            </div>
                            <div class="mb-3 row">

                                <div class="form-group col-md-4">
                                    <label class="form-label">@lang('Region') <span
                                            class="text-danger">*</span></label>
                                    <select type="package" class="form-select" id="Region_id" name="region_id"
                                        required>
                                        <option disabled selected value="">@lang('Region')</option>
                                        @foreach ($Regions as $Region)
                                            <option value="{{ $Region->id }}"
                                                data-url="{{ route('Home.Region.show', $Region->id) }}">
                                                {{ $Region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="form-label">@lang('city') <span class="text-danger">*</span>
                                    </label>
                                    <select type="package" class="form-select" name="city_id" id="CityDiv"
                                        required>
                                    </select>
                                </div>

                                <div class="col-md-4 col-12 mb-3">
                                    <label class="form-label" for="package"> @lang('Subscription Type') <span
                                            class="text-danger">*</span></label>
                                    <select type="package" class="form-select" name="subscription_type_id" required>
                                        <option value="" selected disabled> @lang('Subscription Type') </option>
                                        @foreach ($subscriptionTypes as $subscriptionType)
                                            <option value="{{ $subscriptionType->id }}">
                                                {{ $subscriptionType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                            <div class="col-12 mb-3">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" required checked type="checkbox" id="terms-conditions">
                                    <label class="form-check-label" for="terms-conditions"> @lang('By registering')
                                        @lang('you accept our')
                                        <a href="{{ route('Terms') }}" target="_blank">
                                            @lang('Conditions') @lang('and') @lang('Terms')
                                        </a>
                                        &amp;
                                        <a href="{{ route('Privacy') }}" target="_blank">
                                            @lang('privacy policy')
                                        </a>
                                    </label>
                                </div>
                            </div>


                            <div class="col-12" style="text-align: center;">
                                <a href="{{ route('welcome') }}" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">@lang('Cancel')</a>

                                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                                </div>

                        </form>

                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('HOME_PAGE/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('HOME_PAGE/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('HOME_PAGE/js/pages-auth.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/js/pages-account-settings-account.js') }}"></script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ url('dashboard_files/assets/js/alertify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.min.js') }}"></script>
    <script>
        var success = '{{ Session::has('success') }}';
        var sorry = '{{ Session::has('sorry') }}';

        if (success) {
            var msg = '{{ Session::get('success') }}';
            alertify.success(msg);
        }
        if (sorry) {
            var msg = '{{ Session::get('sorry') }}';
            alertify.error(msg);
        }



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

        // $('#broker_logo_preview').click(function() {
        //     $('#broker_logo').click(); // Trigger file input click on image click
        // });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#uploadedAvatar').attr('src', e.target.result); // Update the preview image
                };

                reader.readAsDataURL(input.files[0]); // Convert image to base64 string
            }
        }

        $("#upload").change(function() {
            readURL(this); // Call readURL function when a file is selected
        });
    </script>
    <script>
        // JavaScript to handle the reset button functionality
        $('#account-image-reset').click(function() {
            // Reset the file input by clearing its value
            $('#upload').val('');

            // Reset the preview image to the default avatar
            $('#uploadedAvatar').attr('src', '{{ asset('HOME_PAGE/img/avatars/14.png') }}');
        });
    </script>

    <script>
        function updateFullPhone(input) {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
            var key_phone = $('#key_phone').val();
            var fullPhone = key_phone + input.value;
            document.getElementById('full_phone').value = fullPhone;
        }
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                var phone = $('#phone').val();
                $('#key_phone').val(key);
                $('#full_phone').val(key + phone);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });


        $(document).ready(function() {
    // Initialize key_phone and full_phone fields with session or default values
    var keyPhone = '{{ $KeyPhone ?? 966 }}';
    var phone = '{{ $phone ?? '' }}';

    $('#key_phone').val(keyPhone);
    $('#full_phone').val(keyPhone + phone);

    // Set the dropdown text to the current key phone value
    $('.btn.dropdown-toggle').text(keyPhone);

    // Event listener for dropdown items
    $('.dropdown-item').on('click', function() {
        var key = $(this).data('key');
        var phone = $('#phone').val();
        $('#key_phone').val(key);
        $('#full_phone').val(key + phone);
        $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
    });

    // Event listener for phone input changes
    $('#phone').on('input', function() {
        updateFullPhone(this);
    });
});

    </script>
    {!! $sitting->zoho_salesiq !!}

</body>

</html>