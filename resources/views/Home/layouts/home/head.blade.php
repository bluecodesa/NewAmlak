<head>
    {{-- {!! $sitting->google_tag !!} --}}

    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ $sitting->title }} - @yield ('title')</title>

    <meta name="description" content="" />
    <link rel="shortcut icon" href="{{ url($sitting->icon) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url($sitting->icon) }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet"
        href="{{ url('HOME_PAGE/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ url('HOME_PAGE/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/css/pages/front-page.css') }}" />
    <link href="{{ url('dashboard_files/assets/css/alertify.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/semantic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/dropify.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard_files/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
    <link href="{{ url('dashboard_files/assets/fonts/tajawal.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/select2/select2.css') }}" />
    <link href="{{ url('dashboard_files/assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/libs/nouislider/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/libs/swiper/swiper.css') }}" />
    <link href="{{ url('dashboard_files/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ url('HOME_PAGE/vendor/css/pages/front-page-landing.css') }}" />

    <!-- Helpers -->
    <script src="{{ url('HOME_PAGE/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ url('HOME_PAGE/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ url('HOME_PAGE/js/front-config.js') }}"></script>

    <!-- Bootstrap CSS -->
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    {{-- <link href="{{ url('dashboard_files/assets/fonts/tajawal.css') }}" rel="stylesheet"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">

    <style>
        .template-customizer-open-btn {
            display: none !important;
        }

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
