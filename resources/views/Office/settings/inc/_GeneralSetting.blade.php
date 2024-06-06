<form action="{{ route('Office.Setting.update', $office->id) }}" class="row" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Admin.layouts.Inc._errors')

    <input type="text" name="key_phone" hidden id="key_phone" value="{{ $office->key_phone ?? '996' }}">

    <div class="col-md-6 col-12 mb-3">
        <label class="form-label" for="company_name"> @lang('Company Name')<span
            class="text-danger">*</span></label>

        <input type="text" class="form-control" id="name" name="name" value="{{ $office->UserData->name }}"
            required>
    </div>

    <div class="col-md-6 col-12 mb-3">
        <label class="form-label" for="name"> @lang('Commercial Registration No')<span
            class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')" id="CR_number"
                 name="CRN"  value="{{ $office->CRN }}" required>

    </div>


    <div class="col-md-6 col-12 mb-3">
        <label for="email">@lang('Email')<span class="text-danger">*</span></label>

        <input type="email" class="form-control" id="email" name="email" value="{{ $office->UserData->email }}">
    </div>



    <div class="col-12 mb-3 col-md-6">
        <label for="color" class="form-label">@lang('Company Mobile') <span class="required-color">*</span></label>
        <div class="input-group">
            <input type="text" placeholder="123456789" name="phone" value="{{ $office->UserData->phone }}"
                class="form-control" maxlength="9" pattern="\d{1,9}"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                aria-label="Text input with dropdown button">
            <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $office->UserData->key_phone ?? '996' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="">
                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
            </ul>
        </div>
    </div>



    <div class="col-md-4 col-12 mb-3">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ $office->company_logo ? asset($office->company_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                    <span class="d-none d-sm-block">اختر صورة شخصيه</span>
                    <i class="ti ti-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" name="company_logo" hidden
                        accept="image/png, image/jpeg" />
                </label>
                <button type="button" id="account-image-reset"
                    class="btn btn-label-secondary account-image-reset mb-3">
                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">@lang('إعادة تعيين الصورة')</span>
                </button>

                <div class="text-muted">Allowed JPG,PNG. Max size 800K</div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <label>@lang('Region') <span class="text-danger">*</span></label>
        <select type="package" class="form-select" id="Region_id" required>
            <option selected value="{{ $region->id }}">
                {{ $region->name }}</option>
            @foreach ($Regions as $Region)
                <option value="{{ $Region->id }}" data-url="{{ route('Home.Region.show', $Region->id) }}">
                    {{ $Region->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <label>@lang('city') <span class="text-danger">*</span></label>
        <select type="package" class="form-select" name="city_id" id="CityDiv" value="" required>
            <option selected value="{{ $city->id }}">
                {{ $city->name }}</option>
        </select>
    </div>


    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>
