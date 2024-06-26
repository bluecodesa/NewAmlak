<form action="{{ route('Broker.Setting.updateBroker', $broker->id) }}" class="row" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Admin.layouts.Inc._errors')

    <input type="text" name="key_phone" hidden id="key_phone" value="{{ $broker->key_phone ?? '966' }}">

    <div class="col-md-4 col-12 mb-3">
        <label for="name">
            @lang('Broker name')<span class="text-danger">*</span></label>

        <input type="text" class="form-control" id="name" name="name" value="{{ $broker->UserData->name }}"
            required>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <label for="license_number">
            @lang('license number')<span class="text-danger">*</span></label>

        <input type="text" class="form-control" id="license_number" name="broker_license"
            value="{{ $broker->broker_license }}" required>
    </div>


    <div class="col-md-4 col-12 mb-3">
        <label for="license_number">
            @lang('License expiration date')<span class="text-danger">*</span></label>
        <input type="date" class="form-control" id="license_number" name="license_date"
            value="{{ $broker->license_date }}" required>
    </div>


    <div class="col-md-6 col-12 mb-3">
        <label for="email">@lang('Email')<span class="text-danger">*</span></label>

        <input type="email" class="form-control" id="email" name="email" value="{{ $broker->UserData->email }}">
    </div>



    <div class="col-12 mb-3 col-md-6">
        <label for="color" class="form-label">@lang('Mobile Whats app') <span class="required-color">*</span></label>
        <div class="input-group">
            <input type="text" placeholder="123456789" name="mobile" value="{{ $broker->mobile }}"
                class="form-control" maxlength="9" pattern="\d{1,9}"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                aria-label="Text input with dropdown button">
            <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $broker->key_phone ?? '966' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="">
                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
            </ul>
        </div>
    </div>



    <div class="col-md-4 col-12 mb-3">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ $broker->broker_logo ? asset($broker->broker_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                    <span class="d-none d-sm-block">اختر صورة شخصيه</span>
                    <i class="ti ti-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" name="broker_logo" hidden
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

    <div class="col-md-4 col-12 mb-3">
        <div class=" form-password-toggle">
            <label class="form-label" for="password">@lang('password') <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
        </div>

    </div>

    <div class="col-md-4 col-12 mb-3">
        <div class="form-password-toggle">
            <label class="form-label" for="password">@lang('Confirm Password') <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" required />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
        </div>
    </div>




    <div class="col-md-4 col-12 mb-3">

        <label for="id_number" class="form-label">@lang('id number')</label>
        <input type="text" class="form-control" id="id_number" name="id_number"
            value="{{ $broker->id_number }}">
    </div>



    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>
