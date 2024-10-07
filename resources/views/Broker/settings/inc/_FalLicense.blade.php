
<div class="row justify-content-center">

    <form action="{{ route('Broker.Setting.updateFalLicense',$broker->id) }}" method="post" class="row">
        @csrf
        @method('PUT')

        <div class="col-md-4 mb-3 col-12">
            <label class="form-label">@lang('FalLicense type') <span
                    class="required-color">*</span></label>
            <select class="form-select" name="fal_id" required>
                <option disabled selected value="">@lang('FalLicense type')</option>
                @foreach ($Faltypes as $Faltype)
                    <option value="{{ $Faltype->id }}">{{ $Faltype->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-4 mb-3">
            <label class="form-label">@lang('Ad License Number')<span
                class="required-color">*</span></label>
            <input type="number" name="ad_license_number" class="form-control" id="ad_license_number" required />
        </div>
        @php
        $licenseDate = Auth::user()->UserBrokerData->license_date;
        @endphp
        <div class="col-sm-12 col-md-4 mb-3">
            <label class="form-label">@lang('Ad License Expiry')<span
                class="required-color">*</span></label>
            <input type="date" name="ad_license_expiry" class="form-control" id="ad_license_expiry" required />
            <div id="date_error_message" style="color: red; display: none;">The selected date cannot be later than the license date.</div>
        </div>
        <div div class="col-sm-12 col-md-4 mb-3">
            <button class="btn btn-primary" type="submit" name="submit">@lang('save')</button>
        </div>

    </form>



</div>


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


