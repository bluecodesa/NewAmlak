<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('assets') }}/" data-template="vertical-menu-template-starter">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> {{ $sitting->title }} - @yield ('title')</title>
    <meta content="{{ $sitting->title }}" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ url($sitting->icon) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/fonts/flag-icons.css') }}" />
    @if (app()->getLocale() == 'ar')
        <!-- Core CSS -->
        <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/core.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/vendor/css/rtl/theme-default.css') }}" />
    @else
        <link rel="stylesheet" href="{{ url('assets/vendor/css/core.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/vendor/css/theme-default.css') }}" />
    @endif

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link href="{{ url('dashboard_files/assets/css/alertify.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/semantic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/dropify.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard_files/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
    <link href="{{ url('dashboard_files/assets/fonts/tajawal.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard_files/assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <!-- DataTables -->

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/dropzone/dropzone.css') }}" />
    {{-- <link rel="stylesheet" href="{{ url('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ url('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ url('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}" /> --}}
    <!-- Row Group CSS -->
    <style>
        .required-color {
            color: red;
        }

        /*
        .sub-input {
            position: absolute;
            left: 1px;
            top: 0;
            background-color: #2f419c;
            height: 100%;
            color: white;
            line-height: 2.6;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            padding: 0px 20px;
            border: 1px solid #2f419c;
        }

        .border-info {
            border: 1px solid #28C76F !important;
        }

        .border-success {
            border: 1px solid #28C76F !important
        } */

        body,
        h4,
        h1,
        h2,
        h5,
        h6,
        h3,
        span,
        .dropify-clear,
        small,
        b,
        strong,
        label,

        * {
            font-family: 'Tajawal' !important;
            /* text-transform: capitalize !important; */
        }

        .dropify-message p {
            font-size: 18px !important;
        }

        .dropify-wrapper {
            background-color: transparent !important;
        }


        .text-muted {
            font-family: 'Tajawal' !important;
        }

        .form-check-label {
            margin-right: 15px !important;
        }

        .filters th input {
            border-radius: 8px;
            border: 1px solid silver;
        }

        th.asc::after {
            content: " ↑";
        }

        th.desc::after {
            content: " ↓";
        }
    </style>

</head>

<body>

    <!-- Begin page -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- LOGO -->
            @if (Auth::user()->is_admin)
                @include('Admin.layouts.Inc.SuperAdmin')
            @endif
            @if (Auth::user()->is_office)
                @include('Admin.layouts.Inc.Office')
            @endif
            @if (Auth::user()->is_broker)
                @php
                    $sectionNames = Auth::user()->sectionNames();
                @endphp

                @include('Admin.layouts.Inc.Broker', ['sectionNames' => $sectionNames])
            @endif
            <div class="layout-page">
                @include('Admin.layouts.Inc._nav')

                @yield('content')

                @include('Admin.layouts.footer')

            </div>
        </div>
    </div>
    <!-- END wrapper -->



    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ url('assets/vendor/libs/jquery/jquery.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/pages/dashboard.init.js') }}"></script> --}}
    <!-- App js -->
    <script src="{{ url('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ url('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E&libraries=places"
        defer></script>
    {{-- select2.min.js --}}

    <script src="{{ url('dashboard_files/assets/js/dropify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/select2.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.min.js') }}"></script>
    {{-- <script src="{{ url('dashboard_files/assets/js/sweetalert2.js') }}"></script> --}}
    <script src="{{ url('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    {{-- <script src="{{ url('assets/js/extended-ui-sweetalert2.js') }}"></script> --}}
    <script src="{{ url('dashboard_files/assets/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/printThis.js') }}"></script>

    <script src="{{ url('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    {{-- <script src="{{ url('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ url('assets/js/tables-datatables-basic.js') }}"></script> --}}
    <script src="{{ url('assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ url('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ url('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ url('assets/js/config.js') }}"></script>
    <script src="{{ url('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script src="{{ url('assets/js/form-input-group.js') }}"></script>
    @include('Admin.layouts.Inc.js')
    <script src="{{ url('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ url('assets/js/forms-file-upload.js') }}"></script>

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


    @stack('scripts')

    <script>
        function handleDelete(id) {
            Swal.fire({
                title: "@lang('Are you sure')",
                text: "@lang('You can not be able to revert this!')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "@lang('Yes, delete it!')",
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });

            // Swal.fire({
            //     title: '@lang('Are you sure')',
            //     text: "@lang('You can not be able to revert this!')",
            //     icon: 'warning',
            //     showCancelButton: false,
            //     confirmButtonColor: '#3085d6',
            //     confirmButtonText: "@lang('Yes, delete it!')"
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         document.getElementById('delete-form-' + id).submit();
            //     }
            // });
        }
    </script>

</body>

</html>
