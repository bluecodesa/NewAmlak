<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('assets') }}/" data-template="vertical-menu-template-starter">

<head>
    {!! $sitting->google_tag !!}

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ $sitting->title }} @lang('login')</title>

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
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="authentication-wrapper authentication-basic px-4">
        <div class="authentication-inner py-4">
            <!--  Two Steps Verification -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4 mt-2">
                                <a href="index.html" class="app-brand-link gap-2">
                                    <span class="app-brand-logo demo">
                                        <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                                src="{{ url($sitting->icon) }}" alt="" height="50"></a>
                                    </span>
                            <span class="app-brand-text demo text-body fw-bold ms-1">أملاك</span>
                    </div>
                    <!-- /Logo -->

                    <p class="mb-0 fw-medium">@lang('Enter OTP received on your email:')</p>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-1">
                            <label for="user_name" class="form-label">@lang('Email')</label>
                            <input type="text" class="form-control" id="user_name" name="user_name"
                            value="{{ $email }}" autofocus disabled />
                            <input type="hidden" id="hidden_email" name="user_name" value="{{ $email }}" />
                        </div>

                        <div class="mb-3">
                            <label for="otp" class="form-label">@lang('OTP')</label>
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="@lang('OTP')" />
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">@lang('Verify')</button>
                    </form>
                    <div class="row">
                        <!-- Countdown Timer and Buttons -->
                <div class="mt-3" id="countdown-timer">
                    <p>@lang('You can resend the OTP in') <span id="countdown">60</span> @lang('seconds')</p>
                </div>
                <div class="col-md-6 col-12 mb-1" id="resend-otp-button" style="display: none;">
                    <form method="POST" action="{{ route('Home.sendOtp') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}" />
                        <button type="submit" class="btn btn-secondary">@lang('Resend OTP')</button>
                    </form>
                </div>
                <div class="col-md-6 col-12 mb-1" id="login-by-password-button" style="display: none;">
                    <form action="{{ route('Home.auth.loginByPassword') }}" method="GET">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}" />
                        <button type="submit" class="btn btn-secondary">@lang('Login by Password')</button>
                    </form>
                </div>
            </div>
                </div>

            </div>
            <!-- / Two Steps Verification -->
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {!! $sitting->zoho_salesiq !!}

    <script>
        $(document).ready(function() {
            var countdown = 60;
            var countdownTimer = setInterval(function() {
                countdown--;
                $("#countdown").text(countdown);
                if (countdown <= 0) {
                    clearInterval(countdownTimer);
                    $("#countdown-timer").hide();
                    $("#resend-otp-button").show();
                    $("#login-by-password-button").show();
                }
            }, 1000);
        });
    </script>

</body>

</html>
