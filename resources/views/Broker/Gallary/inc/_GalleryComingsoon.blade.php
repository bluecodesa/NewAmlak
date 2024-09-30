<!doctype html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('assets') }}/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> {{ $sitting->title }}</title>

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
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ url('assets/vendor/css/pages/page-misc.css') }}" />

    <!-- Helpers -->
    <script src="{{ url('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('assets/js/config.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Noto Kufi Arabic", sans-serif !important;
            /* font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal; */
            /* text-transform: capitalize !important; */
        }
    </style>
</head>

<body>
    <!-- Content -->

    <!--Under Maintenance -->
    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-1 mx-2">@lang('This Gallery is not available now / contact the Broker')!</h2>
            <br>
            @php
                $phoneNumber = null;
                if ($gallery && $gallery->BrokerData && $gallery->BrokerData->userData) {
                    $phoneNumber = $gallery->BrokerData->userData->full_phone;
                }
                elseif ($gallery && $gallery->OfficeData && $gallery->OfficeData->userData) {
                    $phoneNumber = $gallery->OfficeData->userData->full_phone;
                }
            @endphp
            @if($phoneNumber)
            <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $phoneNumber }}"
            class="btn btn-primary mb-4" target="_blank">@lang('Connect by whats app')</a>
            @endif
            {{-- <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile }}"
                class="btn btn-primary mb-4" target="_blank">@lang('Connect by whats app')</a> --}}
            <div class="mt-4">
                <img src="{{ url('assets/img/illustrations/page-misc-under-maintenance.png') }}"
                    alt="page-misc-under-maintenance" width="550" class="img-fluid" />
            </div>
        </div>
    </div>
    <div class="container-fluid misc-bg-wrapper misc-under-maintenance-bg-wrapper">
        <img src="{{ url('assets/img/illustrations/bg-shape-image-light.png') }}" alt="page-misc-under-maintenance"
            data-app-light-img="illustrations/bg-shape-image-light.png"
            data-app-dark-img="illustrations/bg-shape-image-dark.png" />
    </div>
    <!-- /Under Maintenance -->

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ url('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ url('assets/js/main.js') }}"></script>

    <!-- Page JS -->
</body>

</html>
