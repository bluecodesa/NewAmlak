
    <!-- Core JS -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E&libraries=places"
    defer></script>
    <!-- build:js assets/vendor/js/core.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ url('HOME_PAGE/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/node-waves/node-waves.js')}}"></script>
    <script src="{{ url('dashboard_files/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <!-- endbuild -->
    <script src="{{ url('dashboard_files/assets/js/dropify.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/js/select2.min.js') }}"></script> --}}
    <script src="{{ url('dashboard_files/assets/js/alertify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.min.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/js/sweetalert2.js') }}"></script> --}}
    {{-- <script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script> --}}
    {{-- <script src="{{ url('assets/js/extended-ui-sweetalert2.js') }}"></script> --}}
    <script src="{{ url('dashboard_files/assets/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/printThis.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/select2/select2.js') }}"></script>


    <!-- Vendors JS -->
    <script src="{{ url('HOME_PAGE/vendor/libs/nouislider/nouislider.js')}}"></script>
    <script src="{{ url('HOME_PAGE/vendor/libs/swiper/swiper.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ url('HOME_PAGE/js/front-main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ url('HOME_PAGE/js/front-page-landing.js')}}"></script>
    <script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $(document).ready(function() {
            // Add click event listener to menu items
            $('.menu-item').click(function() {
                // Remove 'active' class from all menu items
                $('.menu-item').removeClass('active');

                // Add 'active' class to the clicked menu item
                $(this).addClass('active');
            });
        });
    </script>
    <script>
        // $('.dropify').dropify();

        $('.dropify').dropify({
            messages: {
                'default': @json(__('Drop files here or click to upload')),
                'replace': @json(__('Drop files here or click to upload')),
                'remove': @json(__('Delete')),
                'error': 'Ooops, something wrong happended.'
            }
        });

        var success = '{{ Session::has('success') }}';
        var sorry = '{{ Session::has('sorry') }}';

        if (success) {
            var msg = '{{ Session::get('success') }}';
            alertify.success(msg);
        }
        if (sorry) {
            var msg = '{{ Session::get('sorry') }}';
            alertify.error(msg);
        }
        jQuery(document).ready(function() {
            $('.summernote').summernote({
                height: 100, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true, // set focus to editable area after initializing summernote
                toolbar: [
                    // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['misc', ['fullscreen', 'undo', 'redo']],
                    // Any other toolbar groups and options you want to include...
                ],
                // Explicitly remove table and font name options by not including them in the toolbar
            });

        });
    </script>
    {!! $sitting->zoho_salesiq !!}

    @stack('scripts')
