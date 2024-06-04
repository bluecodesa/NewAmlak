<!-- Change Password -->
<div class="card mb-4">
    <h5 class="card-header">تغير كلمة المرور</h5>
    <div class="card-body">
        <form id="formAccountSettings" method="POST" action="{{ route('PropertyFinder.updatePassword', $finder->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="currentPassword">كلمة المرور الحالية</label>
                    <div class="input-group input-group-merge">
                        <input
                            class="form-control"
                            type="password"
                            name="password"
                            id="currentPassword"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="newPassword">كلمة المرور الجديدة</label>
                    <div class="input-group input-group-merge">
                        <input
                            class="form-control"
                            type="password"
                            id="newPassword"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>

                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="confirmPassword">تأكيد كلمة المرور</label>
                    <div class="input-group input-group-merge">
                        <input
                            class="form-control"
                            type="password"
                            name="password_confirmation"
                            id="confirmPassword"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary me-2">@lang('save')</button>
                <button type="reset" class="btn btn-label-secondary">@lang('Cancel')</button>
            </div>
        </form>
    </div>
</div>
<!--/ Change Password -->
