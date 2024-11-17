{{-- <footer class="footer">
    @lang('© Town -') {{ env('APP_VERSION','V1.0') }}<a href="{{ env('COMPANY_URL','https://bluecode.sa') }}" target="_blank">@lang(' By Blue Code')</a>
 <span class="d-none d-sm-inline-block"> </span>
</footer> --}}

<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>

                جميع الحقوق محفوظه © -
                تاون {{ env('APP_VERSION', 'v2.3') }}</p>
                {{-- @lang('© Town -') {{ env('APP_VERSION', 'V1.0') }} @lang(' By Blue Code') ❤️
                <a href="{{ env('COMPANY_URL', 'https://bluecode.sa') }}" target="_blank"
                    class="footer-link text-primary fw-medium">BlueCode</a> --}}
            </div>

        </div>
    </div>
</footer>
