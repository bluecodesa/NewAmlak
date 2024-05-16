@extends('Admin.layouts.app')

@section('title', __('Support contact information'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / @lang('technical support') /</span>
                        @lang('Support contact information')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Admin.InfoSupport.update') }}" method="POST" class="row">
                        @csrf
                        @method('put')
                        <div class="col-md-6 col-12 mb-3">
                            <label class="form-label">
                                @lang('Email content')<span class="required-color">*</span></label>
                            <input type="text" required id="modalRoleName" name="support_email" class="form-control"
                                placeholder="email" value="{{ old('support_email', $settings->support_email) }}">
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <label for="mobile">@lang('phone')<span class="text-danger">*</span></label>
                            <div style="position:relative">

                                <input type="tel" class="form-control" id="mobile" minlength="9" maxlength="9"
                                    pattern="[0-9]*" oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                    name="support_phone" required=""
                                    value="{{ old('support_phone', $settings->support_phone) }}">

                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                {{ __('save') }}
                            </button>

                        </div>
                    </form>
                </div>


            </div>
        </div>
        <!-- Modal to add new record -->

        <!--/ DataTable with Buttons -->
    </div>

    <div class="content-backdrop fade"></div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show the modal when the page is fully loaded
                var modal = document.getElementById('pendingPaymentModal');
                if (modal) {
                    modal.classList.add('show');
                    modal.style.display = 'block';
                    modal.removeAttribute('aria-hidden');
                }
            });
        </script>
    @endpush
@endsection
