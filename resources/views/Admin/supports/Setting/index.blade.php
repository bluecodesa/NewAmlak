@extends('Admin.layouts.app')
@section('title', __('Support contact information'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Support contact information')</h4>

                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="{{ route('Admin.Support.showInfoSupport') }}">@lang('Support contact information')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('Broker.home') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>

                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            @include('Admin.layouts.Inc._errors')
                            <div class="card-body">
                                <form action="{{ route('Admin.InfoSupport.update') }}" method="POST" class="row">
                                    @csrf
                                    @method('put')
                                            <div class="form-group col-md-4">
                                                <label class="form-label">
                                                    @lang('Email content')<span
                                                        class="required-color">*</span></label>
                                                <input type="text" required id="modalRoleName"
                                                    name="support_email" class="form-control"
                                                    placeholder="email" value="{{ old('support_email', $settings->support_email) }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="mobile">@lang('phone')<span
                                                    class="text-danger">*</span></label>
                                            <div style="position:relative">

                                                <input type="tel" class="form-control" id="mobile" minlength="9"
                                                    maxlength="9" pattern="[0-9]*"
                                                    oninvalid="setCustomValidity('Please enter 9 numbers.')"
                                                    onchange="try{setCustomValidity('')}catch(e){}" placeholder="599123456"
                                                    name="support_phone" required="" value="{{ old('support_phone', $settings->support_phone) }}">

                                            </div>
                                            </div>
                                        </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1">

                                            {{ __('save') }}
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>

    {{-- @if($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif
 --}}


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

@endsection
