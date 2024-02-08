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
                        <div class="col-md-6">
                            <label for="name" class="col-form-label">@lang('Broker name')</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6">
                            <label for="license_number" class="col-form-label">@lang('license number')</label>
                            <input type="text" class="form-control" id="license_number" name="license_number">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="email" class="col-form-label"
                            >@lang('Email')</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="col-md-6">
                            <label for="mobile" class="col-form-label">@lang('Mobile Whats app')</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>
                    </div>
                    <div class="mb-3 row">

                        <div class="col-md-6">
                            <label for="city" class="col-form-label"
                            >@lang('City')</label>
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
                            <div class="col-md-6">
                                <label for="subscription" class="col-form-label"
                                >@lang('Subscription Type')</label>
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

                    <div class="col-md-6">
                        <label for="password" class="col-form-label"
                    >@lang('password')</label>

                    <input type="password" class="form-control" id="password" name="password">
                        </div>

                      <div class="col-md-6">
                        <label for="password_confirmation" class="col-form-label"
                        >@lang('Confirm Password')</label>

                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation">
                        </div>
                    </div>


            <div class="mb-3 row">
               <div class="col-md-6">
                <label for="id_number"
                class="col-form-label">@lang('id number')</label>
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

</body>

</html>
