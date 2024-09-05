<!doctype html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <title>{{ $sitting->title }} @lang('register')/ @lang('Property Finder')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('HOME_PAGE/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet"
        href="{{ asset('HOME_PAGE/vendor/css/rtl/core.css" class="template-customizer-core-css') }}" />
    <link rel="stylesheet"
        href="{{ asset('HOME_PAGE/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/libs/@form-validation/form-validation.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('HOME_PAGE/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('HOME_PAGE/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('HOME_PAGE/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('HOME_PAGE/js/config.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">

    <style>
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
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Register Card -->
                <div class="text-left mb-2">
                    <button class="btn btn-secondary" onclick="history.back()">عودة</button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                            src="{{ url($sitting->icon) }}" alt="" height="50"></a>
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2 text-center">سجل الأن</h4>

                    <form id="formAuthentication" class="mb-3" action="{{ route('Home.PropertyFinders.CreatePropertyFinder') }}"
                            method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="key_phone" hidden id="key_phone" value="{{ $KeyPhone }}">
                        <input type="text" name="phone" hidden id="phone" value="{{ $phone }}">
                        <input type="text" name="full_phone" hidden id="full_phone" value="{{ $fullPhone }}" >
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">@lang('Name')<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="basic-default-name" name="name" placeholder="@lang('Name')" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="email">@lang('Email')<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="register_email" name="email" value="{{ $email }}" placeholder="@lang('Email')" required>
                                    </div>

                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="id_number" class="form-label">@lang('id number')<span
                                            class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="id_number" name="id_number" required>
                                    </div>

                                <div class="col-md-6">
                                    <label for="id_number" class="form-label">@lang('Account Type')<span
                                        class="text-danger">*</span></label>
                                        <select id="adTypeFilter" class="form-select" name="account_type" required>
                                            <option value="is_property_finder">@lang('Property Finder')</option>
                                            <option value="is_owner">@lang('owner')</option>
                                        </select>
                                </div>

                                    <div class="col-md-6">
                                        {{-- <label for="password"> @lang('password') <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required> --}}
                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">@lang('password') <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" class="form-control"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        {{-- <label for="password_confirmation"> @lang('Confirm Password') <span
                                        class="text-danger">*</span></label> <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" required> --}}

                                        <div class="mb-3 form-password-toggle">
                                            <label class="form-label" for="password">@lang('Confirm Password') <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirmation" class="form-control"
                                                    name="password_confirmation"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="ti ti-eye-off"></i></span>
                                            </div>
                                        </div>
                                    </div>

                        <div class="col-12 mb-3">
                            <div class="form-check mb-0 ms-2">
                                <input class="form-check-input" required checked type="checkbox" id="terms-conditions">
                                <label class="form-check-label" for="terms-conditions"> @lang('By registering')
                                    @lang('you accept our')
                                    <a href="{{ route('Terms') }}" target="_blank">
                                        @lang('Conditions') @lang('and') @lang('Terms')
                                    </a>
                                    &amp;
                                    <a href="{{ route('Privacy') }}" target="_blank">
                                        @lang('privacy policy')
                                    </a>
                                </label>
                            </div>
                        </div>
                                <div class="row mb-3">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <a href="{{ route('welcome') }}" type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</a>
                                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                                    </div>
                                </div>
                    </form>



                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>


      <!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
                <ul id="modalDetails" class="list-unstyled"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmButton">Add Owner Profile</button>
            </div>
        </div>
    </div>
</div>

<form id="addOwnerProfileForm" method="POST" action="">
    @csrf <!-- Laravel CSRF token for security -->
    <!-- Add your form fields here -->

    <!-- Hidden input for confirming owner addition, which will be added dynamically -->
    <input type="hidden" name="confirm_owner" value="0">

    <!-- Additional fields required for adding an owner -->
    <input type="hidden" name="id_number" value="{{ session('modal_data.id_number') }}">
    <input type="hidden" name="name" value="{{ session('modal_data.name') }}">
    <input type="hidden" name="email" value="{{ session('modal_data.email') }}">
    <input type="hidden" name="account_type" value="{{ session('modal_data.account_type') }}">

    <!-- The action will be set dynamically in the JavaScript function -->
</form>

    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('HOME_PAGE/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('HOME_PAGE/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('HOME_PAGE/js/pages-auth.js') }}"></script>
    <script src="{{ asset('HOME_PAGE/js/pages-account-settings-account.js') }}"></script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#Region_id').on('change', function() {
                var selectedOption = $(this).find(':selected');
                var url = selectedOption.data('url');
                $.ajax({
                    type: "get",
                    url: url,
                    beforeSend: function() {
                        $('#CityDiv').fadeOut('fast');
                    },
                    success: function(data) {
                        $('#CityDiv').fadeOut('fast', function() {
                            $(this).empty();
                            $.each(data, function(key, city) {
                                $('#CityDiv').append($('<option>', {
                                    value: city.id,
                                    text: city.name
                                }));
                            });
                            $(this).fadeIn('fast');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });



        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#uploadedAvatar').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload").change(function() {
            readURL(this);
        });
    </script>
    <script>
        $('#account-image-reset').click(function() {
            $('#upload').val('');
            $('#uploadedAvatar').attr('src', '{{ asset('HOME_PAGE/img/avatars/14.png') }}');
        });
    </script>

<script>
    function updateFullPhone(input) {
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
        var key_phone = $('#key_phone').val();
        var fullPhone = key_phone + input.value;
        document.getElementById('full_phone').value = fullPhone;
    }
    $(document).ready(function() {
        $('.dropdown-item').on('click', function() {
            var key = $(this).data('key');
            var phone = $('#phone').val();
            $('#key_phone').val(key);
            $('#full_phone').val(key + phone);
            $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modalData = @json(session('modal_data'));

    if (modalData) {
        // Display the modal with the user's information
        const modalContent = `
            <div class="modal" id="confirmOwnerModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Owner Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>This account is already registered as a ${modalData.account_type}.</p>
                            <p>Name: ${modalData.name}</p>
                            <p>Email: ${modalData.email}</p>
                            <p>ID Number: ${modalData.id_number}</p>
                            <p>Do you want to add them as an owner?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirmAddOwner">Yes, Add as Owner</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Append the modal to the body
        document.body.insertAdjacentHTML('beforeend', modalContent);

        // Show the modal
        $('#confirmOwnerModal').modal('show');

        // Handle the confirmation button click
        document.getElementById('confirmAddOwner').addEventListener('click', function () {
            // Append hidden input to the form to confirm owner addition
            const form = document.querySelector('form'); // Adjust the selector if necessary
            const confirmInput = document.createElement('input');
            confirmInput.type = 'hidden';
            confirmInput.name = 'confirm_owner';
            confirmInput.value = '1';
            form.appendChild(confirmInput);

            // Call the addOwnerProfile function (Submit the form to the controller method)
            addOwnerProfile();
        });
    }
});

// Function to handle the owner profile addition
function addOwnerProfile() {
    // Get the form
    const form = document.getElementById('addOwnerProfileForm');

    form.action = '{{ route("Home.add-owner-profile") }}';

    form.submit();
}

</script>

</body>

</html>
