   <!-- Change Password -->
   <div class="card mb-4">
    <h5 class="card-header">تغير كلمة المرور</h5>
    <div class="card-body">
      <form id="formAccountSettings" method="GET" onsubmit="return false">
        <div class="row">
          <div class="mb-3 col-md-6 form-password-toggle">
            <label class="form-label" for="currentPassword">كلمة المرور الحالية</label>
            <div class="input-group input-group-merge">
              <input
                class="form-control"
                type="password"
                name="currentPassword"
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
                name="newPassword"
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
                name="confirmPassword"
                id="confirmPassword"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
              <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
          </div>
          {{-- <div class="col-12 mb-4">
            <h6>Password Requirements:</h6>
            <ul class="ps-3 mb-0">
              <li class="mb-1">Minimum 8 characters long - the more, the better</li>
              <li class="mb-1">At least one lowercase character</li>
              <li>At least one number, symbol, or whitespace character</li>
            </ul>
          </div> --}}
          <div>
            <button type="submit" class="btn btn-primary me-2">@lang('save')</button>
            <button type="reset" class="btn btn-label-secondary">@lang('Cancel')</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--/ Change Password -->