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
        h3,
        label span,
        * {

            font-family: 'Tajawal';
        }
    </style>
</head>

<body>


    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('Admin.home') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>

    <div class="mt-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center mb-5">
                        <div class="mb-5">
                            <img src="{{ url($sitting->icon) }}" height="100" style="    border-radius: 50%;"
                                alt="logo">
                        </div>
                        <div class="maintenance-img mb-5">
                            <img src="{{ url('dashboard_files/assets/images/maintenance-img.png') }}" alt=""
                                class="img-fluid mx-auto d-block">
                        </div>
                        <h1>404</h1>
                        <h3>@lang('Sorry, page not found')</h3>
                        <a class="btn btn-primary mb-4 waves-effect waves-light" href="{{ route('Admin.home') }}"><i
                                class="mdi mdi-home"></i> @lang('Back to Dashboard')</a>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
    <!-- jQuery  -->
    <script src="{{ url('dashboard_files/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/waves.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ url('dashboard_files/assets/js/app.js') }}"></script>

</body>

</html>
