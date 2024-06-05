{{--
<div class="modal fade" id="modalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">تسجيل الدخول</h3>
          </div>
          <p>للتواصل مع املاك للتطوير العقاري, يرجى إدخال ايميلك</p>
          <form id="enableOTPForm" class="row g-3" onsubmit="return false">
            <div class="col-12">
                <label for="email" class="form-label">@lang('Email')</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="@lang('Email')" autofocus />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-sm-3 me-1">@lang('ارسال')</button>
              <button
                type="reset"
                class="btn btn-label-secondary"
                data-bs-dismiss="modal"
                aria-label="Close">
                @lang('Cancel')
              </button>
            </div>
            <div class="col-12 m-t-10 text-center">
                @lang('By registering') @lang('you accept our')
                <a href="" target="_blank" download>
                    @lang('Conditions') &amp; @lang('Terms')
                </a>
                <a href="" target="_blank" download>
                    @lang('and') @lang('our privacy policy')
                </a>
        </div>
          </form>
        </div>
      </div>
    </div>
  </div>


<!-- Modal 2 -->
<div class="modal fade" id="modalToggle2" style="display: none;" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel2">Modal 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-start mb-4">@lang('تم ارسال رمز التحقق الي هذا البريد الالكتروني')</p>
                <form id="verifyCodeForm" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="code" required autocomplete="current-code" maxlength="6" autofocus placeholder="@lang('Type your 6 digit security code')" />
                    </div>
                    <button class="btn btn-primary d-grid w-100 mb-3" type="submit">@lang('Verify')</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3 -->
<div class="modal fade" id="modalToggle3" style="display: none;" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel3">Modal 3</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="onboarding-title text-body">لمتابعه التسجيل</h4>
                <div class="onboarding-info">الرجاء ادخال البيانات التالية</div>
                <form id="registerForm" method="POST">
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
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password_confirmation">@lang('Confirm Password') <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 --}}






 <div class="modal fade" id="modalToggle" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="mb-2">تسجيل الدخول</h3>
          </div>
          <p>للتواصل مع املاك للتطوير العقاري, يرجى إدخال ايميلك</p>
          <form action="{{ route('send-otp') }}" class="row g-3" method="POST">
            @csrf
            <!-- Initial email input form -->
            <div class="col-12" id="emailInput">
              <label for="email" class="form-label">@lang('Email')</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="@lang('Email')" autofocus />
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-sm-3 me-1" id="submitButton">@lang('ارسال')</button>
              <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">@lang('Cancel')</button>
            </div>
            <div class="col-12 m-t-10 text-center">
              @lang('By registering') @lang('you accept our')
              <a href="" target="_blank" download>@lang('Conditions') &amp; @lang('Terms')</a>
              <a href="" target="_blank" download>@lang('and') @lang('our privacy policy')</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


{{--
  <script>

    document.getElementById('dynamicForm').addEventListener('submit', function() {
     const email = document.getElementById('email').value;

     // Send email to server
     fetch('/send-otp', {
       method: 'POST',
       headers: {
         'Content-Type': 'application/json',
         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token for Laravel
       },
       body: JSON.stringify({ email }),
     })
     .then(response => {
       if (!response.ok) {
         throw new Error('Network response was not ok');
       }
       return response.text();
     })
     .then(data => {
       if (data.success) {
         // Replace form content with OTP input
         document.getElementById('dynamicForm').innerHTML = `
           <div class="col-12">
             <label for="otp" class="form-label">OTP</label>
             <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" autofocus />
           </div>
           <div class="col-12">
             <button type="submit" class="btn btn-primary me-sm-3 me-1" id="verifyOtpButton">Verify OTP</button>
           </div>
         `;

         setTimeout(() => {
           document.getElementById('verifyOtpButton').addEventListener('click', function() {
             const otp = document.getElementById('otp').value;

             // Verify OTP with server
             fetch('/PropertyFinder/verify-otp', {
               method: 'POST',
               headers: {
                 'Content-Type': 'application/json',
                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token for Laravel
               },
               body: JSON.stringify({ email, otp }),
             })
             .then(response => {
               if (!response.ok) {
                 throw new Error('Network response was not ok');
               }
               return response.json();
             })
             .then(data => {
               if (data.success) {
                 // Replace form content with registration fields
                 document.getElementById('dynamicForm').innerHTML = `
                   <div class="col-12">
                     <label for="name" class="form-label">Name</label>
                     <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" />
                   </div>
                   <div class="col-12">
                     <label for="phone" class="form-label">Phone</label>
                     <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" />
                   </div>
                   <div class="col-12">
                     <label for="password" class="form-label">Password</label>
                     <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
                   </div>
                   <div class="col-12">
                     <button type="submit" class="btn btn-primary me-sm-3 me-1" id="registerButton">Register</button>
                   </div>
                 `;

                 setTimeout(() => {
                   document.getElementById('registerButton').addEventListener('click', function() {
                     const name = document.getElementById('name').value;
                     const phone = document.getElementById('phone').value;
                     const password = document.getElementById('password').value;

                     // Complete registration with server
                     fetch('/PropertyFinder/complete-registration', {
                       method: 'POST',
                       headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Include CSRF token for Laravel
                       },
                       body: JSON.stringify({ email, name, phone, password }),
                     })
                     .then(response => {
                       if (!response.ok) {
                         throw new Error('Network response was not ok');
                       }
                       return response.json();
                     })
                     .then(data => {
                       if (data.success) {
                         // Registration successful, you can redirect or show a success message
                         alert('Registration successful!');
                       } else {
                         // Handle registration error
                         alert('Registration failed: ' + data.message);
                       }
                     });
                   });
                 }, 0);
               } else {
                 // Handle OTP verification error
                 alert('OTP verification failed: ' + data.message);
               }
             });
           });
         }, 0);
       } else {
         // Handle email sending error
         alert('Failed to send OTP: ' + data.message);
       }
     })
     .catch(error => {
       console.error('Error:', error);
       alert('An error occurred: ' + error.message);
     });
   });

</script> --}}
