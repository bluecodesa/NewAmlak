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
    <div class="wrapper-page">
        <div class="card card-pages shadow-none">

            <div class="card-body">
                <div class="text-center m-t-0 m-b-15">
                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url($sitting->icon) }}" alt=""
                            height="24"></a>
                </div>
                <h5 class="font-18 text-center">@lang('register') </h5>
                <form action="{{ route('Admin.create-broker-subscribers') }}" method="POST">
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
                        <label for="name"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('Broker name')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="license_number"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('license number')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="license_number" name="license_number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('Email')</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="mobile"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('Mobile Whats app')</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="city"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('City')</label>
                        <div class="col-md-6">
                            <select class="form-control" id="city" required name="city">
                                <option value="">إختر</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->name }}"
                                        @if (old('city') == $city->name) {{ 'selected' }} @endif>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('password')</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password_confirmation"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('Confirm Password')</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="subscription"
                            class="col-md-4 col-form-label text-md-end text-start">@lang('Subscription Type')</label>
                        <div class="col-md-6">
                            <select class="form-control" id="subscription_type" name="subscription_type">
                                <option value="">إختر</option>
                                @foreach ($subscriptionTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->period }} {{ $type->period_type }}
                                        - {{ $type->price }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="mb-3 row">
                <label for="id_number"
                    class="col-md-4 col-form-label text-md-end text-start">@lang('id number')</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="id_number" name="id_number">
                </div>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">@lang('save')</button>
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

</body>

</html>
