<div class="modal fade" id="modalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">انشاء حساب</h3>
                </div>
                <div id="messageContainer" class="mb-3"></div>
                <form id="emailForm" class="row g-3">
                    @csrf
                    <p>لانشاء حسابك علي منصة تاون يرجي ادخال بريدك الالكتروني</p>
                    <div class="col-12">
                        <label for="email" class="form-label">@lang('Email')</label>
                        <input type="email" required class="form-control" id="email" name="email"
                            placeholder="@lang('Email')" required autofocus />
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
                    <div class="col-12">
                        <button type="button" class="btn btn-primary me-sm-3 me-1"
                            id="sendOtpButton">@lang('ارسال')</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">@lang('Cancel')</button>
                    </div>
                </form>
                <div id="otpVerification" class="mt-4 d-none">
                    <input disabled class="form-control mb-2" type="text" id="email_hidden">
                    <p>@lang('Enter OTP received on your email:')</p>
                    <form id="otpForm" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <input type="text" class="form-control" id="otp" name="otp"
                                placeholder="ادخل رمز التحقق" required />
                            <input type="hidden" id="email_hidden" name="email_hidden">
                            <!-- Hidden input for storing the email -->
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary me-sm-3 me-1"
                                id="verifyOtpButton">@lang('Verify OTP')</button>
                            <button type="button" class="btn btn-label-secondary" id="resendOtpButton"
                                disabled>@lang('Resend OTP')</button>
                        </div>
                    </form>
                </div>
                <div id="newPropertyFinderForm" class="mt-4 d-none">
                    <p>@lang('Complete registration')</p>
                    <form id="registerForm" class="row g-3">
                        @csrf
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label" for="name">@lang('Name')<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="basic-default-name" name="name"
                                    placeholder="@lang('Name')" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">@lang('Email')<span
                                        class="text-danger">*</span></label>
                                <input type="email" value="" class="form-control" id="register_email"
                                    name="email" disabled required>
                            </div>
                        </div>
                        <div class="mb-3 row">

                            <div class="col-md-6">
                                {{-- <label for="password"> @lang('password') <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required> --}}
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">@lang('password') <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
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
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <a href="{{ route('welcome') }}" type="button" class="btn btn-secondary"
                                    data-dismiss="modal">@lang('Cancel')</a>
                                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function displayMessage(message, type) {
            $('#messageContainer').html('<div class="alert alert-' + type + '">' + message + '</div>');
        }

        function displayValidationErrors(errors) {
            // Clear previous errors
            $('.invalid-feedback').remove();
            $('.form-control').removeClass('is-invalid');

            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    const errorMessage = errors[key][0];
                    const inputElement = $('[name="' + key + '"]');
                    inputElement.addClass('is-invalid');
                    inputElement.after('<div class="invalid-feedback">' + errorMessage + '</div>');
                }
            }
        }

        function resetModal() {
            $('#emailForm')[0].reset();
            $('#otpForm')[0].reset();
            $('#registerForm')[0].reset();
            $('#emailForm').removeClass('d-none');
            $('#otpVerification').addClass('d-none');
            $('#newPropertyFinderForm').addClass('d-none');
            $('#messageContainer').html('');
        }

        function enableResendButton() {
            clearInterval(countdownTimer); // Stop countdown if still running
            $('#resendOtpButton').prop('disabled', false).text('@lang('Resend OTP')');
        }

        // Function to update countdown message
        function updateCountdownMessage(seconds) {
            $('#resendOtpButton').text(seconds + ' ثانية لاعادة الارسال');
        }

        $('#sendOtpButton').click(function() {
            var email = $('#email').val();
            var termsChecked = $('#terms-conditions').prop('checked');

            if (!email || !termsChecked) {
                displayMessage('الرجاء ادخال البريد والموافقة علي الشروط و الاحكام', 'danger');
                return;
            }
            $.ajax({
                type: 'POST',
                url: '{{ route('send-otp') }}',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#emailForm').addClass('d-none');
                    $('#otpVerification').removeClass('d-none');
                    $('#email_hidden').val(email);
                    displayMessage('تم ارسال رمز التحقق الي هذا البريد.', 'success');
                    var secondsRemaining = 60;
                    updateCountdownMessage(secondsRemaining);
                    $('#resendOtpButton').prop('disabled',
                    true); // Disable button during countdown

                    countdownTimer = setInterval(function() {
                        secondsRemaining--;
                        updateCountdownMessage(secondsRemaining);
                        if (secondsRemaining <= 0) {
                            enableResendButton();
                        }
                    }, 1000); // Update every second (1000 ms)
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 400) {
                        var response = JSON.parse(xhr.responseText);
                        displayMessage(response.message, 'danger');
                    } else {
                        console.error(xhr.responseText);
                        displayMessage('Failed to send OTP. Please try again later.',
                            'danger');
                    }
                }
            });
        });

        $('#verifyOtpButton').click(function() {
            var otp = $('#otp').val();
            var email = $('#email_hidden').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('verify-otp') }}',
                data: {
                    email: email,
                    otp: otp,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#otpVerification').addClass('d-none');
                    $('#newPropertyFinderForm').removeClass('d-none');
                    $('#registerForm #register_email').val(email);
                    displayMessage('تم التأكد من رمز التحقق.', 'success');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    displayMessage('Failed to verify OTP. Please try again.', 'danger');
                }
            });
        });

        $('#resendOtpButton').click(function() {
            var email = $('#email_hidden').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('resend-otp') }}',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    displayMessage('تم اعادة ارسال رمز التحقق الي هذا البريد', 'success');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    displayMessage('Failed to resend OTP. Please try again later.',
                        'danger');
                }
            });
        });

        $('#registerForm').submit(function(e) {
            e.preventDefault();

            // Enable the email field temporarily for submission
            $('#register_email').prop('disabled', false);

            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route('register-property-finder') }}',
                data: formData,
                success: function(response) {
                    displayMessage(response.message, 'success');
                    // toastr.success(response.message);

                    // Redirect to the specified route
                    window.location.replace(response.redirect);
                    resetModal();
                    $('#modalToggle').modal('hide');
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        displayValidationErrors(errors);
                    } else {
                        displayMessage(
                            'Failed to register Property Finder. Please try again.',
                            'danger');
                    }
                    console.error(xhr.responseText);
                },
                complete: function() {
                    // Disable the email field again after submission
                    $('#register_email').prop('disabled', true);
                }
            });
        });


        $('#modalToggle').on('hidden.bs.modal', function() {
            resetModal();
        });
    });
</script>
