<div class="col-md-12 ArFont">
    <div class="card timeline shadow">
        <div class="card-header">
            <strong class="card-title">
                @lang('Notifications Management')
            </strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table datatables dataTable no-footer" id="dataTable-1" role="grid"
                        aria-describedby="dataTable-1_info">
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
