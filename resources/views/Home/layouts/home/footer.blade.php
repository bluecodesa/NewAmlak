<footer class="landing-footer bg-body footer-text" style="absolute: ;
    width: 100%;">
    <div class="footer-top position-relative overflow-hidden z-1">
        <img src="{{ url('HOME_PAGE/img/front-pages/backgrounds/footer-bg-light.png') }}" alt="footer bg"
            class="footer-bg banner-bg-img z-n1" data-app-light-img="front-pages/backgrounds/footer-bg-light.png"
            data-app-dark-img="front-pages/backgrounds/footer-bg-dark.png" />
        <div class="container">
            <div class="row gx-0 gy-4 g-md-5">
                <div class="col-lg-5">
                    <a href="/" class="app-brand-link mb-4">
                        <img src="{{ url($sitting->icon) }}" width="30" alt="">
                        <span class="app-brand-text demo footer-link fw-bold ms-2 ps-1">أملاك</span>
                    </a>
                    <p class="footer-text footer-logo-description mb-4">
                        خيارك الأول لإدارة العقارات عبر منصة متكاملة تخدم مدراء العقارات، والملاك والمستأجرين
                    </p>
                    <form class="footer-form">
                        <label for="footer-email" class="small">سجل معنا ليصلك كل جديد
                        </label>
                        <div class="d-flex mt-1">
                            <input type="email" class="form-control rounded-0 rounded-start-bottom rounded-start-top"
                                id="footer-email" placeholder="بريدك الالكتروني" />
                            <a href="{{ route('login') }}" type="submit"
                                class="btn btn-primary shadow-none rounded-0 rounded-end-bottom rounded-end-top">
                                سجل
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">أملاك</h6>
                    <ul class="list-unstyled">

                        <li class="mb-3"><a href="{{ route('welcome') }}#landingFeatures"  class="footer-link">المميزات</a></li>
                        <li class="mb-3"><a href="{{ route('welcome') }}#landingPricing"
                                class="footer-link">الباقات</a></li>
                        <li class="mb-3"><a href="{{ route('gallery.showAllGalleries') }}"
                                class="footer-link">المعرض</a></li>
                        <li class="mb-3"><a href="{{ route('brokers') }}"
                                class="footer-link">الوسطاء العقاريين</a></li>

                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">روابط مهمة</h6>
                    <ul class="list-unstyled">

                        <li class="mb-3"><a href="{{ route('Terms') }}" class="footer-link">الشروط
                                والاحكام
                            </a></li>
                        <li class="mb-3"><a href="{{ route('Privacy') }}" class="footer-link">
                                سياسة الخصوصية</a></li>
                        {{-- <li class="mb-3"><a href="#" class="footer-link">
                                ملفات التوثيق</a></li> --}}



                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <h6 class="footer-title mb-4">تواصل معنا</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a href="payment-page.html" class="footer-link"><span class="ti ti-location"></span> المملكة
                                العربية السعودية
                                <br />
                                (الرياض - جدة - الدمام)</a>
                        </li>
                        <li class="mb-3">
                            <a href="mailto:{{ $sitting->email }}" class="footer-link"><span class="ti ti-mail"></span>
                                {{ $sitting->email }}</a>
                        </li>
                        <li class="mb-3">
                            <a href="tel:+{{ $sitting->full_phone }}" class="footer-link"><span
                                    class="ti ti-phone"></span> {{ $sitting->full_phone }}</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-3">
        <div
            class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
            <div class="mb-2 mb-md-0 " style="color: white;">
                <span class="footer-text">©
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                </span>
                جميع الحقوق محفوظه ©
                <a href="{{ env('COMPANY_URL', 'https://bluecode.sa') }}" target="_blank" class="text-reset"> لشركة
                    بلوكود</a> -
                أملاك {{ env('APP_VERSION', 'V1.1') }}</p>
            </div>
            <div>
                <a href="https://github.com/pixinvent" class="footer-link me-3" target="_blank">
                    <img src="{{ url('HOME_PAGE/img/front-pages/icons/github-light.png') }}" alt="github icon"
                        data-app-light-img="front-pages/icons/github-light.png"
                        data-app-dark-img="front-pages/icons/github-dark.png" />
                </a>
                <a href="{{ $sitting->facebook }}" class="footer-link me-3" target="_blank">
                    <img src="{{ url('HOME_PAGE/img/front-pages/icons/facebook-light.png') }}" alt="facebook icon"
                        data-app-light-img="front-pages/icons/facebook-light.png"
                        data-app-dark-img="front-pages/icons/facebook-dark.png" />
                </a>
                <a href="{{ $sitting->twitter }}" class="footer-link me-3" target="_blank">
                    <img src="{{ url('HOME_PAGE/img/front-pages/icons/twitter-light.png') }}" alt="twitter icon"
                        data-app-light-img="front-pages/icons/twitter-light.png"
                        data-app-dark-img="front-pages/icons/twitter-dark.png" />
                </a>
                <a href="{{ $sitting->instgram }}" class="footer-link" target="_blank">
                    <img src="{{ url('HOME_PAGE/img/front-pages/icons/instagram-light.png') }}" alt="google icon"
                        data-app-light-img="front-pages/icons/instagram-light.png"
                        data-app-dark-img="front-pages/icons/instagram-dark.png" />
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- Footer: End -->
