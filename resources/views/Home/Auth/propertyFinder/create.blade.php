<!-- slider modal -->
<div class="modal-onboarding modal fade animate__animated" id="onboardingSlideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content text-center">
        <div class="modal-header border-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="modalCarouselControls" class="carousel slide pb-4 mb-2" data-bs-interval="false">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="onboarding-content">
                <h4 class="onboarding-title text-body">تسجيل باحث عن عقار</h4>
                <h4 class="onboarding-title text-body">ادخال الايميل لارسال كود</h4>
                <form method="POST" action="{{ route('send-code-finder') }}">
                  @csrf
                  <div class="row justify-content-center">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label for="email" class="form-label">البريد الالكتروني</label>
                        <input class="form-control" name="email" required placeholder="ادخل بريدك الالكتروني" type="email" id="email" />
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="nextSlide()">
                    <span>المتابعة</span>
                  </button>
                </form>
              </div>
            </div>
            <div class="carousel-item">
              <div class="onboarding-content">
                <h4 class="onboarding-title text-body">لمتابعه التسجيل</h4>
                <div class="onboarding-info">الرجاء ادخال الرمز المكون من 6 ارقام</div>
                <form method="POST" action="{{ route('verify-code') }}">
                  @csrf
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <label for="code" class="form-label">الكود</label>
                        <input class="form-control" name="code" required placeholder="ادخل الرمز المكون من 6 ارقام" type="text" id="code" />
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="nextSlide()">
                    <span>المتابعة</span>
                  </button>
                </form>
              </div>
            </div>
            <div class="carousel-item">
              <div class="onboarding-content">
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
                  <button type="button" class="btn btn-primary" onclick="nextSlide()">
                    <span>المتابعة</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ slider modal -->

  <script>
    // JavaScript function to move to the next slide without closing the modal
    function nextSlide() {
      $('#modalCarouselControls').carousel('next');
    }
  </script>
