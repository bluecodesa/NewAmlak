@extends('Admin.layouts.app')
@section('title', __('Edit FalLicense'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Broker.Setting.index') }}" class="text-muted fw-light">@lang('Settings')
                        </a> /
                        @lang('Edit')
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <form action="{{ route('Broker.Setting.updateFalLicense', $falLicense->id) }}" method="POST" class="row">
                        @csrf
                        @method('PUT')

                           <div class="col-md-4 mb-3 col-12">
                                <label class="form-label">@lang('FalLicense type') <span
                                        class="required-color">*</span></label>
                                <select class="form-select" name="fal_id" required>
                                    <option disabled selected value="">@lang('FalLicense type')</option>
                                    @foreach ($Faltypes as $Faltype)
                                        <option value="{{ $Faltype->id }}"
                                            {{ $Faltype->id == $falLicense->fal_id ? 'selected' : '' }}>
                                            {{ $Faltype->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('Ad License Number')<span
                                    class="required-color">*</span></label>
                                <input type="number" name="ad_license_number" class="form-control"
                                value="{{ $falLicense->ad_license_number }}"  id="ad_license_number" required />
                            </div>
                            @php
                            $licenseDate = Auth::user()->UserBrokerData->license_date;
                            @endphp
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label class="form-label">@lang('Ad License Expiry')<span
                                    class="required-color">*</span></label>
                                <input type="date" name="ad_license_expiry" class="form-control"
                                value="{{ $falLicense->ad_license_expiry }}" id="ad_license_expiry" required />
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

<script>
    document.getElementById('ad_license_expiry').addEventListener('change', function () {
        const expiryDate = new Date(this.value);
        const licenseDate = new Date('{{ $licenseDate }}'); // License date from the backend

        if (expiryDate > licenseDate) {
            document.getElementById('date_error_message').style.display = 'block';
        } else {
            document.getElementById('date_error_message').style.display = 'none';
        }
    });
</script>
