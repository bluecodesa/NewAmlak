@extends('auth.layouts.app')
@section('title', __('login'))
@section('content')
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Forgot Password -->
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
                        <div class="col-12" style="text-align: center;">
                            <h4 class="mb-1 pt-2">@lang('دخول / تسجيل') 🔒</h4>
                        </div>
                        @include('Admin.layouts.Inc._errors')

                        <p class="mb-4"></p>
                        <form id="formAuthentication" class="mb-3" method="POST"
                            action="{{ route('Home.sendOtp') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">@lang('Email')</label>
                                <input type="text" class="form-control" id="email" name="user_name"
                                    placeholder="@lang('Email')" autofocus />
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100">@lang('دخول / تسجيل')</button>
                        </form>
                        {{-- <div class="text-center">
                            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                @lang('Back to login')
                            </a>
                        </div> --}}
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    @endsection
