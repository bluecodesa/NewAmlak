<div class="col-md-12 ArFont">
    <div class="card timeline shadow">
        <div class="card-header">
            <strong class="card-title">
                @lang('Notifications Management')
            </strong>
            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="modal"
                data-target=".bs-example-modal-lg"> @lang('Settings') </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">

                    <table class="table no-footer" id="dataTable-1" role="grid" aria-describedby="dataTable-1_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable-1" rowspan="1"
                                    colspan="1" aria-sort="ascending"
                                    aria-label="الاشعار: activate to sort column descending">
                                    الاشعار</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1"
                                    colspan="1" aria-label="Whatsapp: activate to sort column ascending">
                                    @lang('Whatsapp')</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1"
                                    colspan="1" aria-label="Email: activate to sort column ascending">
                                    @lang('Email')</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable-1" rowspan="1"
                                    colspan="1" aria-label="SMS: activate to sort column ascending">
                                    @lang('SMS')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($NotificationSetting as $Notification)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">
                                        {{ __($Notification->notification_name) }}
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                            data-type="whatsapp" {{ $Notification->whatsapp == 1 ? 'checked' : '' }}
                                            required name="whatsapp" class="NotificationSetting" data-toggle="toggle"
                                            data-onstyle="success">
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                            data-type="email" {{ $Notification->email == 1 ? 'checked' : '' }} required
                                            name="email" class="NotificationSetting" data-toggle="toggle"
                                            data-onstyle="success">
                                    </td>
                                    <td>
                                        <input type="checkbox"
                                            data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                            data-type="sms" {{ $Notification->sms == 1 ? 'checked' : '' }} required
                                            name="sms" class="NotificationSetting" data-toggle="toggle"
                                            data-onstyle="success">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div> <!-- / .card-body -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">@lang('Alerts settings')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs row" role="tablist">
                    <li class="nav-item col-md-4">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-selected="true">
                            <span class="d-none d-md-block">@lang('Email')</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-home-variant h5"></i></span>
                        </a>
                    </li>
                    <li class="nav-item  col-md-4" disabled>
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false">
                            <span class="d-none d-md-block">@lang('WhatsApp')</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-account h5"></i></span>
                        </a>
                    </li>
                    <li class="nav-item  col-md-4" disabled>
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab"
                            aria-selected="false">
                            <span class="d-none d-md-block">@lang('SMS')</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-email h5"></i></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="home" role="tabpanel">
                        <form action="">
                            <div class="form-group">
                                <label>@lang('host')</label>
                                <input type="text" class="form-control" required=""
                                    placeholder="smtp.titan.email">
                            </div>
                            <div class="form-group">
                                <label>@lang('port')</label>
                                <input type="text" class="form-control" required="" placeholder="465">
                            </div>
                            <div class="form-group">
                                <label>@lang('user name')</label>
                                <input type="text" class="form-control" required=""
                                    placeholder="info@tryamlak.com">
                            </div>

                            <div class="form-group">
                                <label>@lang('name')</label>
                                <input type="text" class="form-control" required=""
                                    placeholder="tryamlak system">
                            </div>

                            <div class="form-group">
                                <label>@lang('Password')</label>
                                <input type="password" class="form-control" required="" placeholder="********">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    @lang('save')
                                </button>

                            </div>
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="profile" role="tabpanel">

                        <div class="alert alert-primary" role="alert">
                            <strong>@lang('soon')!</strong>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="messages" role="tabpanel">
                        <div class="alert alert-primary" role="alert">
                            <strong>@lang('soon')!</strong>
                        </div>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
