<div class="page-title-box">

    <h6>
        @lang('Enable Landing Page')
    </h6>
    <div class="col-12">
        <div class="form-check form-switch mb-2">
            <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveHomePage') }}"
                class="toggleHomePage form-check-input" {{ $settings->active_home_page == 1 ? 'checked' : '' }}>
        </div>
    </div>


</div>
