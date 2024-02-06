<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title> {{ $sitting->title }} - @yield ('title')</title>
    <meta content="Responsive admin theme build on top of Bootstrap 4" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!--Morris Chart CSS -->
    <link href="{{ url('dashboard_files/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet" />

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ url('dashboard_files/plugins/morris/morris.css') }}">

    <link href="{{ url('dashboard_files/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('dashboard_files/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ url('dashboard_files/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('dashboard_files/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ url('dashboard_files/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="http://fonts.cdnfonts.com/css/tajawal" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        strong,
        label span,
        * {
            font-family: 'Tajawal';
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

    <!--Morris Chart-->
    <script src="{{ url('dashboard_files/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ url('dashboard_files/plugins/raphael/raphael.min.js') }}"></script>

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
    {{-- <script src="{{ url('dashboard_files/assets/js/main.js') }}"></script> --}}

    <script src="https://cdn.rawgit.com/alertifyjs/alertify.js/v1.0.10/dist/js/alertify.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
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
