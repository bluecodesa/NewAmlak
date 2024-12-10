<!-- Change Password -->
<div class="card mb-4 card shadow-none bg-transparent">
    <h5 class="card-header">@lang('Set new password')</h5>
    <div class="card-body">
        @if($office->userData->password)
        <form id="formChangePassword" method="POST" action="{{ route('Office.Setting.updatePassword', $office->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 col-12 mb-3">
                    <div class="form-password-toggle">
                        <label class="form-label" for="current_password">@lang('Current Password') <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="current_password" class="form-control" name="current_password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="current_password" required />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password">@lang('New Password') <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" required />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password_confirmation">@lang('Confirm Password') <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password_confirmation" required />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary me-2">@lang('save')</button>
                <button type="reset" class="btn btn-label-secondary">@lang('Cancel')</button>
            </div>
        </form>
        @else
        <form id="formChangePassword" method="POST" action="{{ route('Office.Setting.createPassword', $office->id) }}">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="col-md-4 col-12 mb-3">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password">@lang('New Password') <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" required />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12 mb-3">
                    <div class="form-password-toggle">
                        <label class="form-label" for="password_confirmation">@lang('Confirm Password') <span
                                class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation" class="form-control"
                                name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password_confirmation" required />
                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary me-2">@lang('save')</button>
                <button type="reset" class="btn btn-label-secondary">@lang('Cancel')</button>
            </div>
        </form>
        @endif
    </div>
</div>
<!--/ Change Password -->
