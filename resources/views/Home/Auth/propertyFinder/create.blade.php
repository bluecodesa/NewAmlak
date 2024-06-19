<div class="modal fade" id="modalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="mb-2">تسجيل الدخول</h3>
                </div>
                <p>للتواصل مع املاك للتطوير العقاري, يرجى إدخال ايميلك</p>
                <form id="emailForm" class="row g-3">
                    @csrf
                    <div class="col-12">
                        <label for="email" class="form-label">@lang('Email')</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="@lang('Email')" required autofocus />
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary me-sm-3 me-1" id="sendOtpButton">@lang('ارسال')</button>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">@lang('Cancel')</button>
                    </div>
                </form>
                <div id="otpVerification" class="mt-4 d-none">
                    <p>Enter OTP received on your email:</p>
                    <form id="otpForm" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required />
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary me-sm-3 me-1" id="verifyOtpButton">Verify OTP</button>
                            <button type="button" class="btn btn-label-secondary" id="resendOtpButton">Resend OTP</button>
                        </div>
                    </form>
                </div>
                <div id="newPropertyFinderForm" class="mt-4 d-none">
                    <p>Complete registration:</p>
                    <form id="registerForm" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required />
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                        </div>
                        <input type="hidden" id="email_hidden" name="email_hidden" />
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1" id="registerButton">Register</button>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#sendOtpButton').click(function() {
            var email = $('#email').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("send-otp") }}',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#emailForm').addClass('d-none');
                    $('#otpVerification').removeClass('d-none');
                    $('#email_hidden').val(email);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to send OTP. Please try again later.');
                }
            });
        });

        // Verify OTP Button
        $('#verifyOtpButton').click(function() {
            var otp = $('#otp').val();
            var email = $('#email_hidden').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("verify-otp") }}',
                data: {
                    email: email,
                    otp: otp,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#otpVerification').addClass('d-none');
                    $('#newPropertyFinderForm').removeClass('d-none');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to verify OTP. Please try again.');
                }
            });
        });

        // Resend OTP Button
        $('#resendOtpButton').click(function() {
            var email = $('#email_hidden').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("resend-otp") }}',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('OTP has been resent to your email.');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to resend OTP. Please try again later.');
                }
            });
        });

        // Register Form Submission
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("register-property-finder") }}',
                data: formData,
                success: function(response) {
                    alert('Property Finder registered successfully.');
                    $('#modalToggle').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Failed to register Property Finder. Please try again.');
                }
            });
        });
    });
</script>
