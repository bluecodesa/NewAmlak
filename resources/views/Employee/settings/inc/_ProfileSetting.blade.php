<form action="{{ route('Employee.Setting.updateProfileSetting', $employee->id) }}" class="row" method="POST"
  enctype="multipart/form-data">
    @csrf
    @method('PUT')

<input type="text" name="key_phone" hidden value="{{ $employee->UserData->key_phone }}" id="key_phone">
<input type="text" name="full_phone" hidden id="full_phone" value="{{ $employee->UserData->full_phone }}">
<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label">
            {{ __('Name') }} <span class="required-color">*</span></label>
        <input type="text" required id="modalRoleName" name="name" value="{{ $employee->UserData->name }}"
            class="form-control" placeholder="{{ __('Name') }}">
    </div>
</div>


<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label"> @lang('Email') <span
                class="required-color">*</span></label>
        <input type="email" required name="email" class="form-control" value="{{ $employee->UserData->email }}"
            placeholder="@lang('Email')">
    </div>
</div>


<div class="col-md-6">
    <div class="mb-3">
        <label class="form-label"> @lang('phone') <span
                class="required-color">*</span></label>

                <div class="input-group">
                    <input type="text" placeholder="123456789" id="phone" name="phone"
                    value="{{ $employee->UserData->phone }}" class="form-control" maxlength="9" pattern="\d{1,9}"
                        oninput="updateFullPhone(this)"
                        aria-label="Text input with dropdown button">
                    <button class="btn btn-outline-primary dropdown-toggle waves-effect"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{  $employee->UserData->key_phone}}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="">
                        <li><a class="dropdown-item" data-key="971"
                                href="javascript:void(0);">971</a></li>
                        <li><a class="dropdown-item" data-key="966"
                                href="javascript:void(0);">966</a></li>
                    </ul>

                </div>
    </div>
</div>
<div class="col-md-6 col-12 mb-3">

    <label for="id_number" class="form-label">@lang('id number')
        <span
                class="required-color">*</span></label>
    <input type="text" class="form-control" id="id_number" name="id_number"
        value="{{ $employee->UserData->id_number }}">
</div>


    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>
