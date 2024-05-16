@extends('Admin.layouts.app')

@section('title', __('Add'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / <a class="text-muted fw-light"
                                href="{{ route('Admin.settings.index') }}">@lang('General Settings')</a> / @lang('Notifications Management') /
                        </span>
                        @lang('Add')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->

            <div class="card">

                <div class="card-body">
                    <form action="{{ route('Admin.StoreNewNotification') }}" method="post" class="row">
                        @csrf
                        <div class="col-md-6 col-12 mb-3">
                            <label>@lang('notification_name') {{ __('ar') }} </label>
                            <input type="text" required name="notification_name_ar" class="form-control" value=""
                                placeholder="@lang('notification_name')">
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label>@lang('notification_name') {{ __('en') }}</label>
                            <input type="text" required name="notification_name" class="form-control" value=""
                                placeholder="@lang('notification_name')">
                        </div>

                        <div class="col-12">

                            <button type="submit"
                                class="btn btn-primary waves-effect waves-light m-t-20">@lang('save')</button>
                        </div>
                    </form>
                </div>


            </div>
            <!-- Modal to add new record -->

            <!--/ DataTable with Buttons -->


        </div>

        <div class="content-backdrop fade"></div>
    </div>




    @push('scripts')
        <script>
            $('.NotificationSetting').change(function() {
                var url = $(this).data('url');
                var type = $(this).data('type');
                if (this.checked) {
                    var valu = 1
                } else {
                    var valu = 0
                }
                $.ajax({
                    url: url,
                    method: "get",
                    data: {
                        type: type,
                        valu: valu,
                    },
                    success: function(data) {
                        if (valu == 0) {
                            alertify.success(@json(__('Notification has been stopped')));
                        } else {
                            alertify.success(@json(__('Notification has been activated')));
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        </script>
    @endpush


    @push('scripts')
        <script>
            function exportToExcel() {
                // Get the table by ID
                var table = document.getElementById('table');

                // Remove the last <td> from each row

                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
            }
        </script>
    @endpush
@endsection
