<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ $sitting->title }} @lang('login')</title>
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

        .hover-zoom:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}
.pointer {
    cursor: pointer;
}


.disabled {
    pointer-events: none;
    opacity: 0.5; /* Adjust the opacity to your preference */
}

.disabled .disabled-overlay {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent white background */
}

.disabled .disabled-overlay span {
    font-size: 18px;
    font-weight: bold;
    color: rgb(137, 4, 4); /* Adjust the color to your preference */
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
                <h5 class="font-18 text-center">@lang('sign in') </h5>

                @include('Admin.layouts.Inc._errors')

                <form class="form-horizontal m-t-30" method="POST" id="register" action="{{ route('login') }}">
                    @csrf
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}

                    {{-- <form class="form-horizontal m-t-30" method="POST"  id="register" action="{{ route('login') }}">
                                @csrf --}}
                    <div class="form-group">
                        <div class="col-12">
                            <label>@lang('Email')</label>
                            <input class="form-control @error('user_name') is-invalid @enderror" type="text" required
                                placeholder="الايميل" name="user_name">
                                {{-- @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <label>@lang('password')</label>
                            <input class="form-control" type="password" required="" placeholder="الرقم السري"
                                name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-12">
                            <div class="checkbox checkbox-primary">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1"> @lang('Remember me')</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light"
                                type="submit">@lang('sign in') </button>
                        </div>
                    </div>

                    <div class="form-group row m-t-30 m-b-0">
                        <div class="col-sm-7">
                            <a href="{{ route('forget.password.get') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> @lang('Forgot your password?')</a>
                        </div>
                        <div class="col-sm-5 text-right">
                        <a class="text-muted" href="#" data-toggle="modal" data-target="#addSubscriberModal">@lang('Create an account')</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!--add new subscribers-->
    <div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog"
    aria-labelledby="addSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="addSubscriberModalLabel"></h5> --}}
                <p style="text-align: center;font-weight: 900; margin-bottom: 25px;">
                    نوع الحساب</p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-deck">
                    <!-- Add New Office Card -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="card shadow-sm hover-zoom disabled" onclick="redirectToCreateOffice()">
                                        <div class="card-body pointer">
                                            <div class="fas fa-building">
                                                <p class="mt-2">مكتب </p>
                                                <div class="disabled-overlay">
                                                    <span>قريبا</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-6 pointer" onclick="redirectToCreateBroker()">
                                    <div class="card shadow-sm hover-zoom">
                                        <div class="card-body pointer">
                                            <div class="fas fa-home">
                                                <p class="mt-2 ">مسوق عقاري</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Add New Broker Card -->

                </div>
            </div>


        </div>

    </div>
</div>


<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }
    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>
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
