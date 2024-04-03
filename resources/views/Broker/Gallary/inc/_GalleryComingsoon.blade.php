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
            <div class="account-pages">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mb-5">
                                    <div class="mb-5">
                                        <img src="{{ url($sitting->icon) }}" height="100" alt="logo">
                                    </div>
                                    <h4 class="mt-4 text-uppercase">@lang('This Gallery is not available now / contact the Broker')</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        {{-- <div class="row">
                            <div class="col-lg-12">
                                <div class="comming-watch text-center mb-5">
                                    <div class="countdown"><div><div class="card card-body p-3"><span class="countdown-num">200</span><span class="text-uppercase">days</span></div><div class="card card-body p-3"><span class="countdown-num">04</span><span class="text-uppercase">hours</span></div></div><div class="lj-countdown-ms "><div class="card card-body p-3"><span class="countdown-num">33</span><span class="text-uppercase">minutes</span></div><div class="card card-body p-3"><span class="countdown-num">09</span><span class="text-uppercase">seconds</span></div></div></div>
                                </div>

                            </div>
                        </div> --}}
                        <!-- end row -->

                        <div class="text-center">
                            {{-- <p>تواصل مع المسوق</p> --}}
                            <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}" class="btn btn-primary" target="_blank">@lang('Connect by whats app')</a>
                            {{-- <button type="submit" class="btn btn-primary">@lang('Connect by whats app')</button> --}}
                                    {{-- <a  href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}>Whatsapp</a> --}}
                            </div>
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
