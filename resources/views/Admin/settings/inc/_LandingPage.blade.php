<div class="page-title-box">
    <div class="card m-b-30">
        <div class="card-body">
            <h6>
                @lang('Enable Landing Page')
            </h6>
            <div class="col-12">
                <input type="checkbox" data-url="{{ route('Admin.Setting.ChangeActiveHomePage') }}" class="toggleHomePage"
                    {{ $settings->active_home_page == 1 ? 'checked' : '' }} data-toggle="toggle" data-onstyle="primary">
            </div>

        </div>

    </div> <!-- end row -->
</div>
