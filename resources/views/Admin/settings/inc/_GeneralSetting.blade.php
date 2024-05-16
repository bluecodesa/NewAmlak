<form action="{{ route('Admin.settings.update', $settings->id) }}" method="POST" enctype="multipart/form-data"
    class="row p-2">
    @csrf
    @method('PUT')
    <input type="text" name="key_phone" hidden value="{{ $settings->key_phone ?? '996' }}" id="key_phone">

    @foreach (config('translatable.locales') as $locale)
        <div class="col-12 mb-3 col-md-6">
            <label for="title_ar" class="form-label">{{ __('Website Name') }}
                {{ __($locale) }} </label>
            <input name="{{ $locale }}[title]" class="form-control" type="text" id="title_{{ $locale }}"
                value="{{ $settings->translate($locale)->title ?? '' }}"
                placeholder="{{ __('Website Name') }} {{ __($locale) }}">
        </div>
    @endforeach

    <div class="col-12 mb-3 col-md-6">
        <label for="url" class="form-label">@lang('Email')</label>
        <input name="email" class="form-control" type="email" value="{{ $settings->email ?? '' }}" id="url">

    </div>



    {{--  --}}
    <div class="col-12 mb-3 col-md-6">
        <label for="logo" class="form-label">@lang('Logo')
        </label>
        <input name="icon" class="form-control" type="file" id="logo"
            accept="image/png, image/jpg, image/jpeg">
        <div class="form-text">
            @if (isset($settings) && $settings->icon)
                {{-- {{ $settings->icon }} --}}
                <div class="avatar avatar-md me-2">
                    <img src="{{ asset($settings->icon) }}" alt="Avatar" class="rounded-circle">
                </div>
            @else
                @lang('No logo uploaded yet.')
            @endif
        </div>
    </div>
    {{--  --}}

    <div class="col-12 mb-3 col-md-6">
        <label for="url" class="form-label">@lang('Facebook')</label>

        <input name="facebook" class="form-control" type="url" value="{{ $settings->facebook ?? '' }}"
            id="url">

    </div>
    <div class="col-12 mb-3 col-md-6">
        <label for="url" class="form-label">@lang('twitter')</label>

        <input name="twitter" class="form-control" type="url" value="{{ $settings->twitter ?? '' }}"
            id="url">

    </div>



    <div class="col-12 mb-3 col-md-6">
        <label for="privacy_pdf" class="form-label">@lang('our privacy policy')
        </label>
        <input name="privacy_pdf" class="form-control" type="file" id="privacy_pdf" accept=".pdf">
        <div class="form-text">
            @if (isset($settings) && $settings->privacy_pdf)
                {{ $settings->privacy_pdf }}
            @else
                @lang('No pdf uploaded yet.')
            @endif
        </div>
    </div>



    <div class="col-12 mb-3 col-md-6">
        <label for="formFile" class="form-label">@lang('Conditions')
            @lang('and') @lang('Terms')</label>
        <input name="terms_pdf" class="form-control" id="formFile" type="file" accept=".pdf">
        <div class="form-text">
            @if (isset($settings) && $settings->terms_pdf)
                {{ $settings->terms_pdf }}
            @else
                @lang('No pdf uploaded yet.')
            @endif
        </div>
    </div>


    <div class="col-12 mb-3 col-md-4">
        <label for="color" class="form-label">@lang('Color')</label>
        <input name="color" class="form-control" type="color" value="{{ $settings->color ?? '#30419b' }}"
            id="color">
    </div>

    {{-- <div class="col-12 mb-3 col-md-4">
        <label for="color">@lang('phone')</label>
        <input name="phone" class="form-control" type="number" placeholder="@lang('phone')"
            value="{{ $settings->phone }}" id="number">
    </div> --}}

    <div class="col-12 mb-3 col-md-4">
        <label for="color" class="form-label">@lang('phone')</label>
        <div class="input-group">
            <input type="text" placeholder="123456789" value="{{ $settings->phone }}" class="form-control"
                maxlength="9" pattern="\d{1,9}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 9);"
                aria-label="Text input with dropdown button">
            <button class="btn btn-outline-primary dropdown-toggle waves-effect" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ $settings->key_phone ?? '996' }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="">
                <li><a class="dropdown-item" data-key="971" href="javascript:void(0);">971</a></li>
                <li><a class="dropdown-item" data-key="996" href="javascript:void(0);">996</a></li>
            </ul>
        </div>
    </div>

    {{-- <div class="col-12 mb-3 col-md-4">
        <label class="form-label" for="basic-icon-default-phone">@lang('phone')</label>
        <div class="input-group input-group-merge">
            <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-phone"></i></span>
            <input type="tel" id="basic-icon-default-phone" value="{{ $settings->phone }}"
                class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941"
                aria-describedby="basic-icon-default-phone2">
        </div>
    </div> --}}

    <div class="col-12 mb-3 col-md-4">
        <label for="crn" class="form-label">@lang('crn')</label>
        <input name="crn" class="form-control" type="number" placeholder="@lang('crn')"
            value="{{ $settings->crn }}" id="crn">
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('save')</button>
        <button type="reset" class="btn btn-secondary waves-effect m-l-5">@lang('Cancel')</button>

    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                $('#key_phone').val(key);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });
    </script>
@endpush
