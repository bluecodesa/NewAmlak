@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Notifications'))
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6 ">
                    <h4 class=""><a href="{{ route('Admin.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                        <a href="{{ route('Admin.settings.index') }}" class="text-muted fw-light">@lang('Notifications')
                        </a> /

                        {{ $notification->EmailTemplateData->subject ?? __($notification->notification_name) }}
                    </h4>
                </div>

            </div>
            <!-- DataTable with Buttons -->
            <div class="card">
                @include('Admin.layouts.Inc._errors')
                <div class="card-body">
                    <div class="font-18">
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_owner_name')"
                            data-variable="$data[variable_owner_name]">@lang('variable_owner_name')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_tenant_name')"
                            data-variable="$data[variable_tenant_name]">@lang('variable_tenant_name')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_building_name')"
                            data-variable="$data[variable_building_name]">@lang('variable_building_name')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_flat_no')"
                            data-variable="$data[variable_flat_no]">@lang('variable_flat_no')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_agreement_id')"
                            data-variable="$data[variable_agreement_id]">@lang('variable_agreement_id')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') :  @lang('variable_agreement_expire_date')"
                            data-variable="$data[variable_agreement_expire_date]">@lang('variable_agreement_expire_date')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_settel_date')"
                            data-variable="$data[variable_settel_date]">@lang('variable_settel_date')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_date_of_payment')"
                            data-variable="$data[variable_date_of_payment]">@lang('variable_date_of_payment')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_payment_amount')"
                            data-variable="$data[variable_payment_amount]">@lang('variable_payment_amount')</span>
                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_broker_name')"
                            data-variable="$data[variable_broker_name]">@lang('variable_broker_name')</span>

                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_subscriber_name')"
                            data-variable="$data[variable_subscriber_name]">@lang('variable_subscriber_name')</span>

                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_current_subscription')"
                            data-variable="$data[variable_current_subscription]">@lang('variable_current_subscription')</span>

                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_subscription_invoice_number')"
                            data-variable="$data[variable_subscription_invoice_number]">@lang('variable_subscription_invoice_number')</span>

                        <span class="badge bg-success m-1" data-toggle="tooltip" data-placement="top"
                            data-original-title="@lang('Click to add it') : @lang('variable_subscription_invoice_download_link')"
                            data-variable="$data[variable_subscription_invoice_download_link]">@lang('variable_subscription_invoice_download_link')</span>
                    </div>
                    <form action="{{ route('Admin.update.StoreEmailTemplate', $notification->id) }}" method="post"
                        class="row">
                        @csrf
                        <div class="col-12 mb-3">
                            <label>@lang('topic')</label>
                            <input type="text" name="subject" class="form-control" value="{{ $template->subject ?? '' }}"
                                placeholder="@lang('topic')">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="">@lang('Email content')</label>
                            {{-- <textarea name="content" id="textarea" class="summernote">{{ $template->content ?? null }}</textarea> --}}
                            <textarea id="textarea" class="form-control" name="content" cols="30" rows="30" placeholder=""> {{ $template->content ?? null }} </textarea>
                        </div>

                        <div class="col-12 mb-3">

                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input toggleHomePage" type="checkbox"
                                    {{ $template->is_login ?? '' == 1 ? 'checked' : '' }} id="flexSwitchCheckChecked"
                                    name="is_login">
                                <label class="form-check-label" for="flexSwitchCheckChecked">@lang('login')</label>
                            </div>

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
            $(document).ready(function() {
                $('#textarea').summernote({
                    height: 100, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        // Include only the options you want in the toolbar, excluding 'fontname', 'video', and 'table'
                        ['style', ['bold', 'underline']],
                        ['insert', ['link', 'picture', 'hr']], // 'video' is deliberately excluded
                        ['para', ['ul', 'ol']],
                        ['misc', ['fullscreen', 'undo', 'redo']],
                        // Any other toolbar groups and options you want to include...
                    ],
                    // Explicitly remove table and font name options by not including them in the toolbar
                });
                $('.card-body .badge').click(function() {
                    var variableValue = $(this).attr('data-variable');
                    var $textarea = $('#textarea');
                    var summernoteEditor = $textarea.summernote('code');

                    // Check if Summernote editor is focused
                    if ($('.note-editable').is(':focus')) {
                        var node = document.createElement("span");
                        node.innerHTML = variableValue;
                        $('.note-editable').append(
                            node); // This line appends the variable as a new node to the editor
                        var range = document.createRange();
                        var sel = window.getSelection();
                        range.setStartAfter(node);
                        range.collapse(true);
                        sel.removeAllRanges();
                        sel.addRange(range);
                    } else {
                        var currentContent = $textarea.summernote('code');
                        $textarea.summernote('code', currentContent + variableValue);
                    }
                });
            });
        </script>
    @endpush
@endsection
