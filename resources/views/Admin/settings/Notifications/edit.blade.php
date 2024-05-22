@extends('Admin.layouts.app')

@section('title', __('Notifications Management'))

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <span class="text-muted fw-light"> @lang('Settings') / <a class="text-muted fw-light"
                                href="{{ route('Admin.settings.index') }}">@lang('General Settings')</a> / @lang('Notifications Management') /
                        </span>
                        @lang('Settings')
                    </h4>
                </div>
            </div>
            <!-- DataTable with Buttons -->


            <!-- Modal to add new record -->
            <div class="col-md-12">
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                                @lang('Email')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"
                                tabindex="-1">
                                @lang('WhatsApp')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false"
                                tabindex="-1">
                                @lang('SMS')
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                            <form action="{{ route('Admin.update.UpdateEmailSetting') }}" method="POST" class="row">
                                @csrf
                                <div class="col-12 mb-3">
                                    <label>@lang('host')</label>
                                    <input type="text" name="host" value="{{ $EmailSettingService->host }}" required
                                        class="form-control" required="" placeholder="smtp.titan.email">
                                </div>
                                <div class=" col-12 mb-3">
                                    <label>@lang('port')</label>
                                    <input type="number" name="port" value="{{ $EmailSettingService->port }}"
                                        class="form-control" required="" placeholder="465">
                                </div>
                                <div class=" col-12 mb-3">
                                    <label>@lang('user name')</label>
                                    <input type="text" name="user_name" value="{{ $EmailSettingService->user_name }}"
                                        class="form-control" required="" placeholder="info@tryamlak.com">
                                </div>

                                <div class=" col-12 mb-3">
                                    <label>@lang('name')</label>
                                    <input type="text" name="name" value="{{ $EmailSettingService->name }}"
                                        class="form-control" required="" placeholder="tryamlak system">
                                </div>

                                <div class=" col-12 mb-3">
                                    <label>@lang('Password')</label>
                                    <input type="password" name="password" value="{{ $EmailSettingService->password }}"
                                        class="form-control" required="" placeholder="********">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        @lang('save')
                                    </button>

                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                            <div class="alert alert-primary" role="alert">
                                <strong>@lang('soon')!</strong>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                            <div class="alert alert-primary" role="alert">
                                <strong>@lang('soon')!</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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



                // Convert the modified table to a workbook
                var wb = XLSX.utils.table_to_book(table, {
                    sheet: "Sheet1"
                });

                // Save the workbook as an Excel file
                XLSX.writeFile(wb, @json(__('Roles')) + '.xlsx');
                alertify.success(@json(__('Download done')));
            }
        </script>
    @endpush
@endsection
