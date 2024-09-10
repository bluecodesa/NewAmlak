@extends('Admin.layouts.app')
@section('title', __('Add New'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Setting.index') }}" class="text-muted fw-light">@lang('Settings')
                        </a> /
                        @lang('Add New')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">


                <form action="{{ route('Broker.Setting.createFalLicense') }}" method="post" class="row">
                    @csrf

                    <div class="col-md-4 mb-3 col-12">
                        <label class="form-label">@lang('REGA Type') <span
                                class="required-color">*</span></label>
                        <select class="form-select" name="fal_id" required>
                            <option disabled selected value="">@lang('REGA License Type')</option>
                            @foreach ($Faltypes as $Faltype)
                                <option value="{{ $Faltype->id }}">{{ $Faltype->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="ad_license_number"> @lang('license number')<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" minlength="1" maxlength="10"
                            pattern="1\d{9}" title="يجب أن يكون الرقم مكونًا من 10 أرقام ويبدأ برقم 1."
                            id="ad_license_number" name="ad_license_number" required>
                    </div>

                    {{-- @php
                    $licenseDate = Auth::user()->UserBrokerData->license_date;
                    @endphp --}}
                    <div class="col-sm-12 col-md-4 mb-3">
                        <label class="form-label">@lang('License Expiry')<span
                            class="required-color">*</span></label>
                        <input type="date" name="ad_license_expiry" class="form-control" id="ad_license_expiry" required />
                        <div id="date_error_message" style="color: red; display: none;">The selected date cannot be later than the license date.</div>
                    </div>
                    <div div class="col-sm-12 col-md-4 mb-3">
                        <button class="btn btn-primary" type="submit" name="submit">@lang('save')</button>
                    </div>

                </form>



                </div>
            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>


@endsection

@push('scripts')
<script>

    $(document).ready(function() {
    $('#ad_license_number').on('change', function(event) {
        var licenseNumber = $('#ad_license_number').val();
        var pattern = /^1\d{9}$/;
        if (!pattern.test(licenseNumber)) {
            alertify.error('The license number must be 10 digits long and start with 1.');
            event.preventDefault(); // Prevent form submission
            $('#ad_license_number').val('');
        }
    });
});

</script>
@endpush
