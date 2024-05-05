{{-- <footer class="footer">
    @lang('© Amlak -') {{ env('APP_VERSION','V1.0') }}<a href="{{ env('COMPANY_URL','https://bluecode.sa') }}" target="_blank">@lang(' By Blue Code')</a>
 <span class="d-none d-sm-inline-block"> </span>
</footer> --}}

<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://pixinvent.com" target="_blank" class="footer-link text-primary fw-medium">Pixinvent</a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/" target="_blank"
                    class="footer-link me-4">Documentation</a>
            </div>
        </div>
    </div>
</footer>
