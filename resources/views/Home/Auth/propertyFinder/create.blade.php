<!doctype html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $sitting->title }} @lang('register')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('HOME_PAGE/img/favicon/favicon.ico') }}" />

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

                        <form id="formAuthentication" class="mb-3" action="{{ route('Home.PropertyFinders.CreatePropertyFinder') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">@lang('Name')<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="basic-default-name" name="name" placeholder="@lang('Name')" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">@lang('Email')<span class="text-danger">*</span></label>
                                        <input type="email" value="" class="form-control" id="register_email" name="email" placeholder="@lang('Email')" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">

                                    <div class="col-md-6">
                                        {{-- <label for="password"> @lang('password') <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required> --}}
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">@lang('password') <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        {{-- <label for="password_confirmation"> @lang('Confirm Password') <span
                                        class="text-danger">*</span></label> <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required> --}}

                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">@lang('Confirm Password') <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirmation" class="form-control"
                                                    name="password_confirmation"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
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
                                <div class="row mb-3">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <a href="{{ route('welcome') }}" type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</a>
                                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                                    </div>
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
</script>

</body>

</html>
