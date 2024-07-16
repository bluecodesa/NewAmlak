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
    <hr>
    <form action="{{ route('Admin.Setting.updateAds') }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="row">
            <div class="mb-3 col-6">
                <h6>@lang('Google Tag')</h6>
                <div>
                    <textarea class="form-control" name="google_tag" cols="30" rows="10">{{ $settings->google_tag ?? '' }}</textarea>
                </div>
            </div>
    
            <div class="mb-3 col-6">
                <h6>@lang('Zoho SalesIQ')</h6>
                <div>
                    <textarea  class="form-control" name="zoho_salesiq" cols="30" rows="10">{{ $settings->zoho_salesiq ?? '' }}</textarea>
                </div>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">@lang('save')</button>
    </form>
    

</div>


