
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ url('HOME_PAGE/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/node-waves/node-waves.js')}}"></script>

    <!-- endbuild -->
    <script src="{{ url('dashboard_files/assets/js/dropify.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/js/select2.min.js') }}"></script> --}}
    <script src="{{ url('dashboard_files/assets/js/alertify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.min.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/js/sweetalert2.js') }}"></script> --}}
    <script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    {{-- <script src="{{ url('assets/js/extended-ui-sweetalert2.js') }}"></script> --}}
    <script src="{{ url('dashboard_files/assets/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/printThis.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ url('HOME_PAGE/vendor/libs/nouislider/nouislider.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/swiper/swiper.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ url('HOME_PAGE/js/front-main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ url('HOME_PAGE/js/front-page-landing.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @stack('scripts')
