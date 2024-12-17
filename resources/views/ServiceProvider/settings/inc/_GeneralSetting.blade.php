<form action="{{ route('ServiceProvider.Setting.update', $serviceProvider->UserData->id) }}" class="row" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('Admin.layouts.Inc._errors')

    <input type="text" name="key_phone" hidden id="key_phone1" value="{{ $serviceProvider->UserData->key_phone ?? '966' }}">
    <input type="text" hidden name="full_phone" id="full_phone1"
    value="{{ $serviceProvider->UserData->full_phone ?? ($serviceProvider->UserData->key_phone ?? '966') }}">
    <div class="col-md-4 col-12 mb-3">
        <label class="form-label" for="company_name"> @lang('Company Name')<span
            class="text-danger">*</span></label>

        <input type="text" class="form-control" id="company_name" name="name" value="{{ $serviceProvider->UserData->name }}"
            required>
    </div>



    <div class="col-md-4 col-12 mb-3">
        <label for="company_email">@lang('Email')<span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="company_email" name="email" value="{{ $serviceProvider->UserData->email }}">
    </div>
    <div class="col-md-4 col-12 mb-3">
        <label for="id_number" class="form-label">@lang('National number') <span class="text-danger">*</span></label>
        <input type="text" value="{{ $serviceProvider->UserData->id_number }}"
               class="form-control"
               id="id_number"
               name="id_number"
               oninput="validateIdNumber(this)">
    </div>

    <script>
        function validateIdNumber(input) {
            // Ensure only digits are allowed
            input.value = input.value.replace(/[^0-9]/g, '');

            // Enforce max length of 10
            input.value = input.value.slice(0, 10);

            // Check if the first digit is 7; if not, clear the input
            if (input.value.length > 0 && input.value[0] !== '7') {
                input.value = '';
            }
        }
    </script>


    <div class="col-12 mb-3 col-md-4">
        <label for="color" class="form-label">@lang('Company Mobile')<span class="required-color">*</span></label>
        <div class="input-group">
            <input type="text" placeholder="123456789" name="phone" id="company_number"
            value="{{ $serviceProvider->UserData->phone }}" class="form-control" maxlength="9" pattern="\d{1,9}"
                oninput="updateFullPhone1(this)" aria-label="Text input with dropdown button">
            {{-- <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{$serviceProvider->key_phone ?? '966' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                <li><a class="dropdown-item" data-key="966" href="javascript:void(0);">966</a></li>
            </ul> --}}
            <button class="btn btn-outline-primary dropdown-toggle waves-effect"
            type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{$serviceProvider->UserData->key_phone ?? config('translatable.phones')[0] }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach (config('translatable.phones') as $phone)
                <li>
                <a class="dropdown-item" data-key="{{ $phone }}" href="javascript:void(0);">
                    {{ $phone }}+
                </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <label class="form-label" for="name"> @lang('Commercial Registration No')<span
            class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="@lang('Commercial Registration No')" id="CR_number"
                 name="CRN"  value="{{ $serviceProvider->CRN }}" required>

    </div>


    <div class="col-md-4 col-12 mb-3">
        <label>@lang('Region') <span class="text-danger">*</span></label>
        <select type="package" class="form-select" id="Region_id" required>
            <option selected value="{{ $region->id ?? '' }}">
                {{ $region->name ?? '' }}</option>
            @foreach ($Regions as $Region)
                <option value="{{ $Region->id }}" data-url="{{ route('Home.Region.show', $Region->id) }}">
                    {{ $Region->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <label>@lang('city') <span class="text-danger">*</span></label>
        <select type="package" class="form-select" name="city_id" id="CityDiv" value="" required>
            <option selected value="{{ $city->id ?? '' }}">
                {{ $city->name ?? '' }}</option>
        </select>
    </div>

    <div class="col-md-4 col-12 mb-3">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ $serviceProvider->UserData->avatar ? asset($serviceProvider->UserData->avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                    <span class="d-none d-sm-block">اختر صورة الشركة</span>
                    <i class="ti ti-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" name="avatar" hidden
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


    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </div>
</form>


