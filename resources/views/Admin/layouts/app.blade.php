<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> {{ $sitting->title }} - @yield ('title')</title>
    <meta content="{{ $sitting->title }}" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ url($sitting->icon) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Morris Chart CSS -->
    @if (app()->getLocale() == 'ar')
        <link href="{{ url('dashboard_files/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('dashboard_files/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">

        <link href="{{ url('dashboard_files/assets/css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('dashboard_files/assets/css/default.min.css') }}" rel="stylesheet" type="text/css">
    @else
        <link rel="stylesheet" href="{{ url('dashboard_files/plugins/morris/morris.css') }}">
        <link href="{{ url('dashboard_files/LtrAssets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('dashboard_files/LtrAssets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('dashboard_files/LtrAssets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('dashboard_files/LtrAssets/css/style.css') }}" rel="stylesheet" type="text/css">
    @endif
    <link href="{{ url('dashboard_files/assets/css/alertify.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/semantic.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/dropify.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard_files/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />
    <link href="{{ url('dashboard_files/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/fonts/tajawal.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard_files/assets/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ url('dashboard_files/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('dashboard_files/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('dashboard_files/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <style>
        .required-color {
            color: red;
        }

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

        body,
        h4,
        h5,
        h6,
        h3,
        span,
        small,
        b,
        strong,
        label,

        * {
            font-family: 'Tajawal';
            /* text-transform: capitalize !important; */
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
    </style>

</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- LOGO -->
        @include('Admin.layouts.navbar')

        @yield('content')

        @include('Admin.layouts.footer')


    </div>
    <!-- END wrapper -->

    <script src="{{ url('dashboard_files/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/waves.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/dropify.js') }}"></script>
    <!--Morris Chart-->
    <script src="{{ url('dashboard_files/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/raphael/raphael.min.js') }}"></script>
    {{--  --}}
    <script src="{{ url('dashboard_files/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ url('dashboard_files/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ url('dashboard_files/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ url('dashboard_files/assets/pages/datatables.init.js') }}"></script>

    {{-- <script src="{{ url('dashboard_files/assets/pages/dashboard.init.js') }}"></script> --}}
    <!-- App js -->
    <script src="{{ url('dashboard_files/assets/js/app.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E&libraries=places"
        defer></script>
    {{-- select2.min.js --}}
    <script src="{{ url('dashboard_files/assets/js/select2.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/alertify.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/sweetalert2.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ url('dashboard_files/assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    @include('Admin.layouts.Inc.js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $('.dropify').dropify();
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
                focus: true // set focus to editable area after initializing summernote
            });
        });

        function handleDelete(id) {
            Swal.fire({
                title: '@lang('Are you sure')',
                text: "@lang('You can not be able to revert this!')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('Yes, delete it!')'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @stack('scripts')



</body>

</html>
