<div class="col-md-12 ArFont">

    <div class="card-header col-12">
        <div class="row">

            <div class="col-6">

                <strong class="card-title">
                    @lang('Notifications Management')
                </strong>
                @if (Auth::user()->hasPermission('update-notify-settings'))
                    <a href="{{ route('Admin.UpdateNotificationsManagement') }}"
                        class="btn btn-primary btn-sm waves-effect waves-light">
                        @lang('Settings')
                    </a>
                @endif
                @if (Auth::user()->hasPermission('create-notify'))
                    <a href="{{ route('Admin.AddNotificationsManagement') }}"
                        class="btn btn-dark btn-sm waves-effect waves-light">
                        @lang('Add')
                    </a>
                @endif

            </div>



        </div>

    </div>


    <div class="row">
        <div class="col-sm-12">

            <table class="table no-footer">
                <thead>
                    <tr>
                        <th>الاشعار</th>
                        <th> @lang('Whatsapp')</th>
                        <th> @lang('Email')</th>
                        <th> @lang('SMS')</th>
                        <th> @lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($NotificationSetting as $Notification)
                        {{-- @if ($Notification->id != 4) --}}
                        <tr>
                            <td class="sorting_1">
                                {{ $Notification->EmailTemplateData->subject ?? __($Notification->notification_name) }}
                            </td>
                            <td>
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox"
                                        data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                        data-type="whatsapp" {{ $Notification->whatsapp == 1 ? 'checked' : '' }}
                                        required name="whatsapp"
                                        class="form-check-input {{ Auth::user()->hasPermission('update-notify-settings') == true ? 'NotificationSetting' : '' }}">
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox"
                                        data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                        data-type="email" {{ $Notification->email == 1 ? 'checked' : '' }} required
                                        name="email"
                                        class="form-check-input {{ Auth::user()->hasPermission('update-notify-settings') == true ? 'NotificationSetting' : '' }}">
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-switch mb-2">
                                    <input type="checkbox"
                                        data-url="{{ route('Admin.update.NotificationSetting', $Notification->id) }}"
                                        data-type="sms" {{ $Notification->sms == 1 ? 'checked' : '' }} required
                                        name="sms"
                                        class="form-check-input {{ Auth::user()->hasPermission('update-notify-settings') == true ? 'NotificationSetting' : '' }}">
                                </div>
                            </td>

                            <td>
                                @if (Auth::user()->hasPermission('update-notify-content'))
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">

                                            <a class="dropdown-item"
                                                href="{{ route('Admin.update.EditEmailTemplate', $Notification->id) }}">@lang('Email')</a>



                                            <a class="dropdown-item" href="#">@lang('SMS')</a>



                                            <a class="dropdown-item" href="#">@lang('Whatsapp')</a>




                                        </div>
                                    </div>
                                @endif


                            </td>
                        </tr>
                        {{-- @endif --}}
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>



</div> <!-- / .card-body -->

{{-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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
                        <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-selected="false">
                            <span class="d-none d-md-block">@lang('SMS')</span><span class="d-block d-md-none"><i
                                    class="mdi mdi-email h5"></i></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="home" role="tabpanel">
                        <form action="{{ route('Admin.update.UpdateEmailSetting') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>@lang('host')</label>
                                <input type="text" name="host" value="{{ $EmailSettingService->host }}"
                                    required class="form-control" required="" placeholder="smtp.titan.email">
                            </div>
                            <div class="form-group">
                                <label>@lang('port')</label>
                                <input type="number" name="port" value="{{ $EmailSettingService->port }}"
                                    class="form-control" required="" placeholder="465">
                            </div>
                            <div class="form-group">
                                <label>@lang('user name')</label>
                                <input type="text" name="user_name" value="{{ $EmailSettingService->user_name }}"
                                    class="form-control" required="" placeholder="info@tryamlak.com">
                            </div>

                            <div class="form-group">
                                <label>@lang('name')</label>
                                <input type="text" name="name" value="{{ $EmailSettingService->name }}"
                                    class="form-control" required="" placeholder="tryamlak system">
                            </div>

                            <div class="form-group">
                                <label>@lang('Password')</label>
                                <input type="password" name="password" value="{{ $EmailSettingService->password }}"
                                    class="form-control" required="" placeholder="********">
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

<div class="modal fade bs-example-modal-add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">@lang('Add')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Admin.StoreNewNotification') }}" method="post" class="mt-2">
                    @csrf
                    <div class="form-group">
                        <label>@lang('notification_name')</label>
                        <input type="text" required name="notification_name" class="form-control" value=""
                            placeholder="@lang('notification_name')">
                    </div>

                    <div class="form-group">
                        <label>@lang('notification_name') {{ __('ar ') }} </label>
                        <input type="text" required name="notification_name_ar" class="form-control"
                            value="" placeholder="@lang('notification_name')">
                    </div>

                    <button type="submit"
                        class="btn btn-primary waves-effect waves-light m-t-20">@lang('save')</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div> --}}

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
