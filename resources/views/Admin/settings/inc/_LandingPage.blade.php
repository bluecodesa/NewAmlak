<div class="page-title-box row">


    <div class="col">
        <h6>
            @lang('Enable Landing Page')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveHomePage') }}"
                class="toggleHomePage form-check-input" {{ $settings->active_home_page == 1 ? 'checked' : '' }}>
        </div>
    </div>


    <div class="col">
        <h6>
            @lang('Enable Gallery Page')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveGalleryPage') }}"
                class="toggleGalleryPage form-check-input" {{ $settings->active_gallery == 1 ? 'checked' : '' }}>
        </div>
    </div>




    <div class="col">
        <h6>
            @lang('Enable Office Register')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveRegisterUsers') }}"
                data-failed="active_office" class="toggleRegister form-check-input"
                {{ $settings->active_office == 1 ? 'checked' : '' }}>
        </div>
    </div>




    <div class="col">
        <h6>
            @lang('Enable Broker Register')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveRegisterUsers') }}"
                data-failed="active_broker" class="toggleRegister form-check-input"
                {{ $settings->active_broker == 1 ? 'checked' : '' }}>
        </div>
    </div>


    <div class="col">
        <h6>
            @lang('Enable Property Finder Register')
        </h6>

        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveRegisterUsers') }}"
                data-failed="active_property_finder" class="toggleRegister form-check-input"
                {{ $settings->active_property_finder == 1 ? 'checked' : '' }}>
        </div>
    </div>


</div>
