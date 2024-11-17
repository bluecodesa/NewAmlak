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
                                @lang('التوثيق عن طريق نفاذ الوطني')
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ route('welcome') }}" class="logo logo-admin"><img
                                    src="{{ url('HOME_PAGE/svg/icons/nafath_logo.svg') }}" alt="" height="100"></a>
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
                                <label class="id_number" for="id_number"> @lang('id number')<span
                                        class="text-danger">*</span></label>
                                    <input type="text" class="form-control" minlength="1" maxlength="10"
                                        id="id_number" name="id_number" required>
                            </div>

                            <div class="mb-3">
                                <button
                                    class="btn btn-primary d-grid w-100"
                                    type="button"
                                    data-account-type="{{ $accountType }}"
                                    onclick="redirectToIdNumber(this)">
                                    @lang('Next')
                                </button>
                            </div>
                        {{-- </form> --}}


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
    function redirectToIdNumber(button) {
    const accountType = button.getAttribute('data-account-type');
    const url = "{{ route('Home.createAccount') }}";
    window.location.href = `${url}?accountType=${encodeURIComponent(accountType)}`;
}

    </script>
{{-- <script>
window.$zoho=window.$zoho || {};$zoho.salesiq=$zoho.salesiq||{ready:function(){}}
</script>
<script id="zsiqscript" src="https://salesiq.zohopublic.com/widget?wc=siq1d83b8cbfb60b3119713dd68fd1635735f23b20cfb5907da94a25b9d4e5c6911" defer>
</script> --}}

    <!-- / Content -->
@endsection


