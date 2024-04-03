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
    </style>
</head>

<body>


    <div class="accountbg"></div>
    <div class="home-btn d-none d-sm-block">
            <a href="{{ route('welcome') }}" class="text-white"><i class="fas fa-home h2"></i></a>
        </div>
    <div class="wrapper-page">
            <div class="card card-pages shadow-none">

                <div class="card m-b-30 card-body">
                    <div class="text-center">
                            <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url($sitting->icon) }}" alt=""
                                    height="100"></a>
                        </div>
                        {{-- <h5 class="font-18 text-center">@lang('تم ارسال رمز التحقق الي هذا الايميل') </h5> --}}
                        <h5 class="font-18 text-center">@lang('تم ارسال رمز التحقق الي هذا الايميل') {{ $email }}</h5>

                        {{-- <p id="countdown" class="font-16 text-center">Time remaining: <span id="countdown-value">{{ gmdate("H:i:s", $remainingTime) }}</span></p> --}}
                        <p id="countdown" class="font-16 text-center">@lang('Time remaining'): <span id="countdown-value">5</span></p>

                        <!-- New link button -->
                        <div class="form-group text-center m-t-10">
                            <div class="col-12">
                                <a href="{{ route('forget.password.post') }}" id="new-code-button" class="col-12 text-primary" style="display: none;">@lang('Send New Code?')</a>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('reset.password.code') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <div class="col-12">
                                        <label>@lang('Verification Code')</label>
                                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="current-code">
                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                            </div>

                            <div class="form-group text-center m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">@lang('Verify')</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        <!-- END wrapper -->

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/waves.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>


<!-- jQuery  -->
<script src="{{ url('dashboard_files/assets/js/jquery.min.js') }}"></script>

<script>
    var countdownValue = 5;
    var countdownElement = document.getElementById("countdown-value");
    var countdownInterval;

    function updateCountdown() {
        if (countdownValue <= 0) {
            clearInterval(countdownInterval);
            document.getElementById("new-code-button").style.display = "block";
            document.getElementById("countdown").style.display = "none";
        } else {
            countdownValue--;
            countdownElement.textContent = countdownValue;
        }
    }

    function startCountdown() {
        updateCountdown();
        countdownInterval = setInterval(updateCountdown, 1000);
    }

    function sendNewCode() {
        // alert("New code sent!"); // Placeholder alert, replace with actual code
        countdownValue = 5;
        document.getElementById("new-code-button").style.display = "none";
        document.getElementById("countdown").style.display = "block";
        startCountdown();
    }

    // Call the startCountdown function when the page is loaded
    $(document).ready(function() {
        startCountdown();
    });
</script>

    </body>

</html>
