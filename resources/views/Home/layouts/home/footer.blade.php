<footer class="landing-footer bg-body footer-text">
    <div class="footer-top position-relative overflow-hidden z-1">
      <img
        src="{{ url('HOME_PAGE/img/front-pages/backgrounds/footer-bg-light.png')}}"
        alt="footer bg"
        class="footer-bg banner-bg-img z-n1"
        data-app-light-img="front-pages/backgrounds/footer-bg-light.png"
        data-app-dark-img="front-pages/backgrounds/footer-bg-dark.png" />
      <div class="container">
        <div class="row gx-0 gy-4 g-md-5">
          <div class="col-lg-5">
            <a href="landing-page.html" class="app-brand-link mb-4">
              <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                    fill="#7367F0" />
                  <path
                    opacity="0.06"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                    fill="#161616" />
                  <path
                    opacity="0.06"
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                    fill="#161616" />
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                    fill="#7367F0" />
                </svg>
              </span>
              <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">أملاك</span>
            </a>
            <p class="footer-text footer-logo-description mb-4">
                خيارك الأول لإدارة العقارات عبر منصة متكاملة تخدم مدراء العقارات، والملاك والمستأجرين
            </p>
            <form class="footer-form">
              <label for="footer-email" class="small">سجل معنا ليصلك كل جديد
            </label>
              <div class="d-flex mt-1">
                <input
                  type="email"
                  class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                  id="footer-email"
                  placeholder="بريدك الالكتروني" />
                <a href="#" data-bs-toggle="modal"
                data-bs-target="#addSubscriberModal"
                  type="submit"
                  class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                  سجل
                </a>
              </div>
            </form>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <h6 class="footer-title mb-4">عن بلوكود</h6>
            <ul class="list-unstyled">

                <li class="mb-3"><a href="https://bluecode.sa/about" target="_blank" class="footer-link">من نحن</a></li>
                <li class="mb-3"><a href="https://bluecode.sa/services" target="_blank" class="footer-link">خدماتنا</a></li>
                <li class="mb-3"><a href="https://bluecode.sa/products" target="_blank" class="footer-link">منتجاتنا</a></li>
                <li class="mb-3"><a href="https://bluecode.sa/projects" target="_blank" class="footer-link">مشاريعنا</a></li>

            </ul>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <h6 class="footer-title mb-4">روابط مهمة</h6>
            <ul class="list-unstyled">

                <li class="mb-3"><a href="#" class="footer-link">الشروط
                    والاحكام
                </a></li>
            <li class="mb-3"><a href="#" class="footer-link">
                    سياسة الخصوصية</a></li>
            <li class="mb-3"><a href="#" class="footer-link">
                    ملفات التوثيق</a></li>



            </ul>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6">
            <h6 class="footer-title mb-4">تواصل معنا</h6>
            <ul class="list-unstyled">
              <li class="mb-3">
                <a href="payment-page.html" class="footer-link"
                ><span class="ti ti-location"></span>   المملكة العربية السعودية
                <br />
                (الرياض - جدة - الدمام)</a
              >              </li>
              <li class="mb-3">
                <a href="mailto:{{ $sitting->email }}" class="footer-link"
                  ><span class="ti ti-mail"></span>  {{ $sitting->email }}</a
                >
              </li>
              <li class="mb-3">
                <a href="tel:+966{{ $sitting->phone }}" class="footer-link"
                ><span class="ti ti-phone"></span> +966 {{ $sitting->phone }}</a
              >              </li>

            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom py-3">
      <div
        class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
        <div class="mb-2 mb-md-0">
          <span class="footer-text"
            >©
            <script>
              document.write(new Date().getFullYear());
            </script>
          </span>
          جميع الحقوق محفوظه  ©
          <a href="{{ env('COMPANY_URL','https://bluecode.sa') }}" target="_blank" class="text-reset"> لشركة بلوكود</a> -
          أملاك {{ env('APP_VERSION','V1.0') }}</p>
        </div>
        <div>
          <a href="https://github.com/pixinvent" class="footer-link me-3" target="_blank">
            <img
              src="{{ url('HOME_PAGE/img/front-pages/icons/github-light.png')}}"
              alt="github icon"
              data-app-light-img="front-pages/icons/github-light.png"
              data-app-dark-img="front-pages/icons/github-dark.png" />
          </a>
          <a href="{{ $sitting->facebook }}" class="footer-link me-3" target="_blank">
            <img
              src="{{ url('HOME_PAGE/img/front-pages/icons/facebook-light.png')}}"
              alt="facebook icon"
              data-app-light-img="front-pages/icons/facebook-light.png"
              data-app-dark-img="front-pages/icons/facebook-dark.png" />
          </a>
          <a href="{{ $sitting->twitter }}" class="footer-link me-3" target="_blank">
            <img
              src="{{ url('HOME_PAGE/img/front-pages/icons/twitter-light.png')}}"
              alt="twitter icon"
              data-app-light-img="front-pages/icons/twitter-light.png"
              data-app-dark-img="front-pages/icons/twitter-dark.png" />
          </a>
          <a href="{{ $sitting->instgram }}" class="footer-link" target="_blank">
            <img
              src="{{ url('HOME_PAGE/img/front-pages/icons/instagram-light.png')}}"
              alt="google icon"
              data-app-light-img="front-pages/icons/instagram-light.png"
              data-app-dark-img="front-pages/icons/instagram-dark.png" />
          </a>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer: End -->
