@extends('auth.layouts.app')
@section('title', __('login'))
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                            src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" alt="" height="100"></a>
                                </span>
                                {{-- <span class="app-brand-text demo text-body fw-bold ms-1">تاون</span> --}}
                            </a>
                        </div>
                        <div class="col-12 mb-2" style="text-align: center;">
                            <h4 class="mb-1 pt-2">@lang('دخول / تسجيل') 🔒</h4>
                        </div>
                        @include('Admin.layouts.Inc._errors')

                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                                        aria-selected="false">@lang('mobile')</button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                                        aria-selected="true">@lang('Email')</button>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade " id="navs-pills-top-home" role="tabpanel">
                                    <form id="emailAuthentication" class="mb-3" method="POST"
                                        action="{{ route('Home.sendOtp') }}">
                                        @csrf
                                        <input type="hidden" name="otp_type" value="email">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">
                                                @lang('Email')<span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" id="email" name="user_name"
                                                placeholder="@lang('Email')" required autofocus />
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary d-grid w-100">@lang('دخول / تسجيل')</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade show active" id="navs-pills-top-profile" role="tabpanel">
                                    <form id="phoneAuthentication" class="mb-3" method="POST"
                                        action="{{ route('Home.sendOtp') }}">
                                        @csrf
                                        <input type="hidden" name="otp_type" value="phone">
                                        <input type="hidden" id="full_phone" name="full_phone">
                                        <input type="hidden" id="key_phone" name="key_phone" value="966">
                                        <!-- Default country code -->
                                        <div class="mb-3">
                                            <label class="form-label" for="mobile">@lang('Mobile Whats app')<span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="5********" id="phone" name="mobile"
                                                    class="form-control" required maxlength="9" pattern="\d{1,9}"
                                                    oninput="updateFullPhone(this)"
                                                    aria-label="Text input with dropdown button">
                                                <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    966
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" data-key="971"
                                                            href="javascript:void(0);">971</a></li>
                                                    <li><a class="dropdown-item" data-key="966"
                                                            href="javascript:void(0);">966</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary d-grid w-100">@lang('دخول / تسجيل')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
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
    </script> --}}
@endsection
