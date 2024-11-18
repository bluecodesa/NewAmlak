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
                            <div class="alert alert-info" style="text-align: center;">
                                @lang('التوثيق عن طريق نفاذ الوطني')
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                    src="{{ url('HOME_PAGE/svg/icons/nafath_logo.png') }}" alt="" height="50"></a>
                        </div>
                        <!-- /Logo -->
                        @include('Admin.layouts.Inc._errors')

                        {{-- <form id="formAuthentication" class="mb-3" method="POST" --}}
                            {{-- onsubmit="return validateForm()" action="{{ route('Home.storeAccount') }}">
                            @csrf --}}

                            <input type="text" name="key_phone" hidden id="key_phone" value="{{ $key_phone ?? '' }}">
                            <input type="text" name="phone" hidden id="phone" value="{{ $phone ?? '' }}">
                            <input type="text" name="full_phone" hidden id="full_phone" value="{{ $fullPhone ?? '' }}" >

                            <div class="mb-3">
                                <label for="name" class="form-label">@lang('Name') <span
                                    class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="@lang('Name')" autofocus />

                            </div>

                            <div class="mb-3">
                                <label class="id_number" for="id_number"> @lang('id number')<span
                                        class="text-danger">*</span></label>
                                    <input type="text" class="form-control" minlength="1" maxlength="10"
                                        id="id_number" name="id_number" required>
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

                            <div class="mb-3">
                                {{-- <button
                                    class="btn btn-primary d-grid w-100"
                                    type="button"
                                    data-account-type="{{ $accountType }}"
                                    onclick="redirectToIdNumber(this)">
                                    @lang('register')
                                </button> --}}
                                <button
                                class="btn btn-primary d-grid w-100"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#otpModal">
                                @lang('Verify')
                            </button>

                            </div>
                        {{-- </form> --}}


                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>

<!-- OTP Verification Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="otpModalLabel">التحقق</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <!-- OTP Display -->
                <div id="otpDisplay" class="display-3 my-3 text-success"></div>
                <p>الرجاء فتح تطبيق نفاذ وتأكيد الطلب بإختيار الرقم أعلاه</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
            </div>
        </div>
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
    function redirectToIdNumber(button) {
    const accountType = button.getAttribute('data-account-type');
    const url = "{{ route('Home.createAccount') }}";
    window.location.href = `${url}?accountType=${encodeURIComponent(accountType)}`;
   }

    </script>

<script>
    // Function to generate a random OTP
    function generateOtp() {
        const otp = Math.floor( + Math.random() * 99); // Generates a random 4-digit OTP
        document.getElementById('otpDisplay').textContent = otp;
    }

    // Generate OTP when the modal is shown
    const otpModal = document.getElementById('otpModal');
    otpModal.addEventListener('show.bs.modal', generateOtp);
</script>

{{-- <script>
    function verifyOtp() {
        const otp1 = document.getElementById('otp1').value;
        const otp2 = document.getElementById('otp2').value;

        // Simple validation for demo purposes
        if (otp1 === '' || otp2 === '') {
            alert('Please enter both OTPs.');
            return;
        }

        // Make an AJAX request to verify OTPs (example)
        fetch('{{ route('otp.verify') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp1, otp2 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('OTP Verified Successfully!');
                // Optionally, redirect the user
                window.location.href = "{{ route('dashboard') }}";
            } else {
                alert('Invalid OTP. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script> --}}


{{-- <script>
window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}
</script>
<script id="zsiqscript" src="https://salesiq.zohopublic.com/widget?wc=siq1d83b8cbfb60b3119713dd68fd1635735f23b20cfb5907da94a25b9d4e5c6911" defer>
</script> --}}

    <!-- / Content -->
@endsection


