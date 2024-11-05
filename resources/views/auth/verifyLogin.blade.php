@extends('auth.layouts.app')
@section('title', __('login'))
@section('content')
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
                                <a href="{{ route('welcome') }}" class="logo logo-admin"><img src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}"
                                        alt="" height="100"></a>
                            </span>
                            {{-- <span class="app-brand-text demo text-body fw-bold ms-1">تاون</span> --}}
                    </div>
                    <!-- /Logo -->

                    <p class="mb-2 fw-medium">@lang('Enter OTP received :')</p>
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
                            <label for="user_name" class="form-label">@lang('Email')/@lang('mobile')</label>
                            <input type="text" class="form-control" id="user_name" name="user_name"
                                value="{{ isset($email) ? $email : $fullPhone }}" autofocus disabled />
                            <input type="hidden" id="hidden_user_name" name="user_name"
                                value="{{ isset($email) ? $email : $fullPhone }}" />
                        </div>

                        <div class="mb-2">
                            <label for="otp" class="form-label">@lang('OTP')</label>
                            <input type="text" class="form-control" id="otp" name="otp"
                                placeholder="@lang('OTP')" />
                        </div>
                        <div class="mb-2">
                            <label class="form-label">
                                <a href="{{ route('Home.auth.loginByPassword') }}" type="submit">@lang('Login by Password?')</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100 mb-3">@lang('Verify')</button>
                    </form>
                    <div class="row">
                        <!-- Countdown Timer and Buttons -->
                        <div class="mt-3" id="countdown-timer">
                            <p>@lang('You can resend the OTP in') <span id="countdown">60</span> @lang('second')</p>
                        </div>
                        <div class="col-md-6 col-12 mb-1" id="resend-otp-button" style="display: none;">
                            <form method="POST" action="{{ route('Home.sendOtp') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}" />
                                <button type="submit" class="btn btn-secondary">@lang('Resend OTP')</button>
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
@endsection
