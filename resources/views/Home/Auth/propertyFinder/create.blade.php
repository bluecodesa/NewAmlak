
<div
class="modal fade"
id="modalToggle"
aria-labelledby="modalToggleLabel"
tabindex="-1"
style="display: none"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalToggleLabel">لمتابعه الاشتراك الرجاء ادخال الايميل</h5>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="modal"
        aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formAuthentication" class="mb-3"  method="POST" action="{{ route('forget.password.post') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">@lang('Email')</label>
              <input
                type="text"
                class="form-control"
                id="email"
                name="email"
                placeholder="@lang('Email')"
                autofocus />
            </div>
            <button type="submit"  data-bs-target="#modalToggle2"
            data-bs-toggle="modal"
            data-bs-dismiss="modal" class="btn btn-primary d-grid w-100">ارسال كود</button>
          </form>
    </div>
    <div class="modal-footer">
      <button
        class="btn btn-primary"
        data-bs-target="#modalToggle2"
        data-bs-toggle="modal"
        data-bs-dismiss="modal">
متابعه              </button>
    </div>
  </div>
</div>
</div>
<!-- Modal 2-->
<div
class="modal fade"
id="modalToggle2"
aria-hidden="true"
aria-labelledby="modalToggleLabel2"
tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalToggleLabel2">Modal 2</h5>
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="modal"
        aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <p class="text-start mb-4">
            @lang('تم ارسال رمز التحقق الي هذا البريد الالكتروني')
        </p>

        <form id="twoStepsForm" method="POST" action="{{ route('reset.password.code') }}">
            @csrf
            {{-- <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $token }}"> --}}
            <div class="mb-3">
                <input type="text" class="form-control" name="code" required autocomplete="current-code" maxlength="6" autofocus @error('code') is-invalid @enderror placeholder="@lang('Type your 6 digit security code')" />
                @if (isset($code))
                    <div class="alert alert-danger" role="alert">
                        {{ $code }}
                    </div>
                @endif
            </div>
            <button class="btn btn-primary d-grid w-100 mb-3"  data-bs-target="#modalToggle3"
            data-bs-toggle="modal"
            data-bs-dismiss="modal" type="submit">@lang('Verify')</button>
        </form>
    </div>
    <div class="modal-footer">
      <button
        class="btn btn-primary"
        data-bs-target="#modalToggle3"
        data-bs-toggle="modal"
        data-bs-dismiss="modal">
متابعه              </button>
    </div>
  </div>
</div>
</div>

 <!-- Modal 3-->
 <div
 class="modal fade"
 id="modalToggle3"
 aria-hidden="true"
 aria-labelledby="modalToggleLabel3"
 tabindex="-1">
 <div class="modal-dialog modal-dialog-centered">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title" id="modalToggleLabel2">Modal 2</h5>
       <button
         type="button"
         class="btn-close"
         data-bs-dismiss="modal"
         aria-label="Close"></button>
     </div>
     <div class="modal-body">
        <h4 class="onboarding-title text-body">لمتابعه التسجيل</h4>
                <div class="onboarding-info">الرجاء ادخال البيانات التالية</div>
                <form method="POST" action="{{ route('complete-registration') }}">
                  @csrf
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input class="form-control" placeholder="Enter your full name..." name="name" required type="text" id="name" />
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="mb-3">
                          <label for="phone" class="form-label">رقم الجوال</label>
                          <input class="form-control" placeholder="Enter your phone number..." name="phone" required type="text" id="phone" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">@lang('password') <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                          <input type="password" id="password" class="form-control"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" required />
                          <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">@lang('Confirm Password') <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                          <input type="password" id="password_confirmation" class="form-control"
                            name="password_confirmation"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password" required />
                          <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button
                      class="btn btn-primary"
                      data-bs-target="#modalToggle"
                      data-bs-toggle="modal"
                      data-bs-dismiss="modal">
             حفظ               </button>
                  </div>
                </form>
     </div>

   </div>
 </div>
</div>
