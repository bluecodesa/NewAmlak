@extends('auth.layouts.app')
@section('title', __('Register By Id Number'))
@section('content')
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

    <!-- Content -->

    <div class="container-xxl">

        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        @if($accountType)
                            <div class="alert alert-info">
                                @lang('You are registering as a') {{ __($accountType) }}
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                    src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" alt="" height="100"></a>
                        </div>
                        <!-- /Logo -->
                        @include('Admin.layouts.Inc._errors')

                        <form id="formAuthentication" class="mb-3" method="POST"
                            onsubmit="return validateForm()" action="{{ route('Home.storeAccount') }}">
                            @csrf

                            <input type="text" name="key_phone" hidden id="key_phone" value="{{ $key_phone ?? '' }}">
                            <input type="text" name="phone" hidden id="phone" value="{{ $phone ?? '' }}">
                            <input type="text" name="full_phone" hidden id="full_phone" value="{{ $fullPhone ?? '' }}" >

                            <div class="mb-3">
                                <label class="id_number" for="id_number"> @lang('id number')<span
                                        class="text-danger">*</span></label>
                                    <input type="text" class="form-control" minlength="1" maxlength="10"
                                        id="id_number" name="id_number" required>
                                </div>

                            <div class="mb-3">

                                <label for="email" class="form-label">@lang('Email') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" required
                                  value="{{ $email }}"  placeholder="@lang('Email')" autofocus />

                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">@lang('Name') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="@lang('Name')" autofocus />

                            </div>

                            <div class="mb-3">
                                    <div class="form-check mb-0 ms-2">
                                        <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                                        <label class="form-check-label" for="terms-conditions">
                                            @lang('By registering') @lang('you accept our')
                                            <a href="{{ route('Terms') }}" target="_blank">
                                                @lang('Conditions') @lang('and') @lang('Terms')
                                            </a> &amp;
                                            <a href="{{ route('Privacy') }}" target="_blank">
                                                @lang('privacy policy')
                                            </a>
                                        </label>
                                    </div>
                            </div>
                            <input type="hidden" name="account_type" value="{{ $accountType }}">
                            <input type="text" hidden class="form-control" minlength="1" maxlength="10"
                            id="subscription_type_id" name="subscription_type_id" value="{{ $subscriptionType->id ?? '' }}">

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">@lang('Sign up')</button>
                            </div>
                        </form>


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formAuthentication').addEventListener('submit', function(event) {
            var checkBox = document.getElementById('terms-conditions');
            if (!checkBox.checked) {
                event.preventDefault();
                alert("@lang('You must accept the terms and conditions before registering.')");
            }
        });
    </script>


{{-- <script>
window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}
</script>
<script id="zsiqscript" src="https://salesiq.zohopublic.com/widget?wc=siq1d83b8cbfb60b3119713dd68fd1635735f23b20cfb5907da94a25b9d4e5c6911" defer>
</script> --}}

    <!-- / Content -->
@endsection



{{-- @extends('auth.layouts.app')
@section('title', __('Register By Id Number'))
@section('content')
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

    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        @if($accountType)
                            <div class="alert alert-info">
                                @lang('You are registering as a') {{ __($accountType) }}
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                    src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" alt="" height="100"></a>
                        </div>
                        <!-- /Logo -->
                        @include('Admin.layouts.Inc._errors')

                        <form id="formAuthentication" class="mb-3" method="POST"
                            onsubmit="return validateForm()" action="{{ route('Home.storeAccount') }}">
                            @csrf

                            <input type="text" name="key_phone" hidden id="key_phone" value="{{ $key_phone ?? '' }}">
                            <input type="text" name="phone" hidden id="phone" value="{{ $phone ?? '' }}">
                            <input type="text" name="full_phone" hidden id="full_phone" value="{{ $fullPhone ?? '' }}" >

                            <div class="mb-3">
                                <label class="id_number" for="id_number"> @lang('id number')<span
                                        class="text-danger">*</span></label>
                                    <input type="text" class="form-control" minlength="1" maxlength="10"
                                        id="id_number" name="id_number" required>
                                </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">@lang('Email') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" name="email" required
                                  value="{{ $email }}"  placeholder="@lang('Email')" autofocus />
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">@lang('Name') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="@lang('Name')" autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">@lang('City') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" required
                                    placeholder="@lang('City')" autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="account_name" class="form-label">@lang('Account Name') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="account_name" name="account_name" required
                                    placeholder="@lang('Account Name')" autofocus />
                            </div>

                            <div class="mb-3">
                                <label for="account_type" class="form-label">@lang('Account Type') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="account_type" name="account_type" required
                                    placeholder="@lang('Account Type')" autofocus />
                            </div>

                            <div class="mb-3">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                                    <label class="form-check-label" for="terms-conditions">
                                        @lang('By registering') @lang('you accept our')
                                        <a href="{{ route('Terms') }}" target="_blank">
                                            @lang('Conditions') @lang('and') @lang('Terms')
                                        </a> &
                                        <a href="{{ route('Privacy') }}" target="_blank">
                                            @lang('privacy policy')
                                        </a>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="account_type" value="{{ $accountType }}">
                            <input type="text" hidden class="form-control" minlength="1" maxlength="10"
                            id="subscription_type_id" name="subscription_type_id" value="{{ $subscriptionType->id ?? '' }}">

                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">@lang('Sign up')</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <script>
        document.getElementById('formAuthentication').addEventListener('submit', function(event) {
            var checkBox = document.getElementById('terms-conditions');
            if (!checkBox.checked) {
                event.preventDefault();
                alert("@lang('You must accept the terms and conditions before registering.')");
            }
        });
    </script>

    <script>
        document.getElementById("formAuthentication").addEventListener("submit", function (e) {
            // Prevent default form submission to process visitor data first
            e.preventDefault();

            // Capture form values
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;

            // Fetch user details from the server
            fetch(`/get-user-details?email=${email}&phone=${phone}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        var user = data.user;
                        console.log(user);
                        // Log values for debugging
                        console.log("Name:", user.name);
                        console.log("Email:", user.email);
                        console.log("Phone:", user.phone);
                        console.log("ID Number:", user.id_number);
                        console.log("City:", user.city);
                        console.log("Account Name:", user.account_name);
                        console.log("Account Type:", user.account_type);

                        // Check if Zoho SalesIQ is loaded
                        if (window.$zoho && $zoho.salesiq) {
                            // Set visitor name and email
                            $zoho.salesiq.visitor.name(user.name);
                            $zoho.salesiq.visitor.email(user.email);

                            // Set other custom fields
                            $zoho.salesiq.visitor.phone(user.phone); // Add phone number
                            $zoho.salesiq.visitor.customfield("ID Number", user.id_number); // Custom field for ID Number
                            $zoho.salesiq.visitor.customfield("City", user.city); // Custom field for City
                            $zoho.salesiq.visitor.customfield("Account Name", user.account_name); // Custom field for Account Name
                            $zoho.salesiq.visitor.customfield("Account Type", user.account_type); // Custom field for Account Type

                            // Track multiple fields
                            $zoho.salesiq.visitor.info({
                                "Name": user.name,
                                "Email": user.email,
                                "Phone": user.phone,
                                "ID Number": user.id_number,
                                "City": user.city,
                                "Account Name": user.account_name,
                                "Account Type": user.account_type
                            });
                        }

                        // Submit the form after processing visitor information
                        document.getElementById("formAuthentication").submit();
                    } else {
                        alert("User not found");
                    }
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                    alert("Error fetching user details");
                });
        });
    </script>

    <!-- / Content -->
@endsection --}}

