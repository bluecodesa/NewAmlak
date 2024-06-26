<div class="page-title-box row">


    <div class="col-6">
        <h6>
            @lang('Enable Landing Page')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveHomePage') }}"
                class="toggleHomePage form-check-input" {{ $settings->active_home_page == 1 ? 'checked' : '' }}>
        </div>
    </div>


    <div class="col-6">
        <h6>
            @lang('Enable Gallery Page')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveGalleryPage') }}"
                class="toggleGalleryPage form-check-input" {{ $settings->active_gallery == 1 ? 'checked' : '' }}>
        </div>
    </div>


</div>
