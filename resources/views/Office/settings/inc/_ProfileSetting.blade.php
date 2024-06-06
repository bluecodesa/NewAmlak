<form action="{{ route('Office.Setting.update', $office->id) }}" class="row" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Admin.layouts.Inc._errors')

    <div class="col-md-6 col-12 mb-3">
        <label for="presenter_name">@lang('Name of company representative')</label>
        <input type="text" class="form-control" id="presenter_name" name="presenter_name"
        value="{{ $office->presenter_name }}" placeholder="@lang('Name of company representative')">
    </div>

    <div class="col-12 mb-3 col-md-6">
        <label for="color" class="form-label">@lang('Company representative number')(@lang('WhatsApp'))</label>
        <div class="input-group">
            <input type="text" placeholder="123456789" name="mobile" value="{{ $office->presenter_number }}"
                class="form-control" maxlength="9" pattern="\d{1,9}"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                aria-label="Text input with dropdown button">
            <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $office->UserData->key_phone ?? '966' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="">
                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
            </ul>
        </div>
    </div>

    <div class="col-md-6 col-12 mb-3">
        <label for="license_number">
            @lang('license number')</label>

        <input type="text" class="form-control" id="license_number" name="broker_license"
            value="" required>
    </div>

    <div class="col-md-6 col-12 mb-3">

        <label for="id_number" class="form-label">@lang('id number')</label>
        <input type="text" class="form-control" id="id_number" name="id_number"
            value="{{ $office->UserData->id_number }}">
    </div>



    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>
