<form action="{{ route('Office.Setting.updateProfileSetting', $office->UserData->id) }}" class="row" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Admin.layouts.Inc._errors')

    <input type="text" name="key_phone" hidden id="key_phone2" value="{{ $office->UserData->key_phone ?? '966' }}">
    <input type="text" hidden name="full_phone" id="full_phone2"
    value="{{ $office->UserData->full_phone ?? ($office->UserData->key_phone ?? '966') }}">

    <div class="col-md-6 col-12 mb-3">
        <label for="name">@lang('Name of company representative')</label>
        <input type="text" class="form-control" id="name" name="name"
        value="{{ $office->UserData->name }}" placeholder="@lang('Name of company representative')">
    </div>

    <div class="col-md-6 col-12 mb-3">
        <label for="email">@lang('Email representative number')<span class="text-danger">*</span></label>

        <input type="email" class="form-control" id="email" name="email" value="{{ $office->UserData->email }}">
    </div>


    <div class="col-12 mb-3 col-md-6">
        <label for="phone" class="form-label">@lang('Company representative number') (@lang('WhatsApp'))</label>
        <div class="input-group">
            <input type="text" placeholder="123456789" id="phone1" name="phone" value="{{ $office->UserData->phone }}"
                class="form-control" maxlength="9" pattern="\d{1,9}"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                oninput="updateFullPhone2(this)" aria-label="Text input with dropdown button">
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

        <label for="id_number" class="form-label">@lang('id number')</label>
        <input type="text" class="form-control" id="id_number" name="id_number"
            value="{{ $office->UserData->id_number }}">
    </div>



    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>
