@extends('Admin.layouts.app')
@section('title', __('Edit') . ' ' . __('Notifications'))
@section('content')

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title"> @lang('Edit') @lang('Notifications')</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item">@lang('Settings')</li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('Admin.settings.index') }}">@lang('dashboard')</a></li>
                            </ol>
                        </div>
                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="font-18">
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_owner_name]">@lang('variable_owner_name')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_tenant_name]">@lang('variable_tenant_name')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_building_name]">@lang('variable_building_name')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_flat_no]">@lang('variable_flat_no')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_agreement_id]">@lang('variable_agreement_id')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_agreement_expire_date]">@lang('variable_agreement_expire_date')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_settel_date]">@lang('variable_settel_date')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_date_of_payment]">@lang('variable_date_of_payment')</span>
                                    <span class="badge badge-success"
                                        data-variable="$data[variable_payment_amount]">@lang('variable_payment_amount')</span>
                                </div>
                                <form action="" method="post" class="mt-2">
                                    <div class="form-group">
                                        <label>@lang('templet name')</label>
                                        <input type="text" class="form-control" required=""
                                            placeholder="@lang('templet name')">
                                    </div>
                                    <div class="m-t-20">
                                        <label for="">@lang('Email content')</label>
                                        <textarea id="textarea" class="form-control" name="content" rows="10" placeholder=""></textarea>
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary waves-effect waves-light m-t-20">@lang('save')</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->


            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container-fluid -->

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.card-body .badge').click(function() {
                    var variableValue = $(this).attr('data-variable');
                    var $textarea = $('#textarea');
                    if (document.activeElement === $textarea[0]) {
                        var cursorPos = $textarea.prop('selectionStart');
                        var v = $textarea.val();
                        var textBefore = v.substring(0, cursorPos);
                        var textAfter = v.substring(cursorPos, v.length);
                        $textarea.val(textBefore + variableValue + textAfter);
                    } else {
                        $textarea.val($textarea.val() + variableValue);
                    }
                    $textarea.focus();
                    var valLength = $textarea.val().length;
                    $textarea[0].setSelectionRange(valLength, valLength);
                });
            });
        </script>
    @endpush
@endsection
