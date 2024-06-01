@extends('Home.layouts.home.app')
@section('content')

    <!-- Sections:Start -->

    <div data-bs-spy="scroll" class="scrollspy-example">
      <!-- Hero: Start -->
      <section id="hero-animation">
        <div id="landingHero" class="section-py landing-hero position-relative">
          <img
            src="{{ url('HOME_PAGE/img/front-pages/backgrounds/hero-bg.png')}}"
            alt="hero background"
            class="position-absolute top-0 start-50 translate-middle-x object-fit-contain w-100 h-100"
            data-speed="1" />
          <div class="container">
            <div class="hero-text-box text-center">
              <h1 class="text-primary hero-title display-6 fw-bold">أملاك خيارك الأول لإدارة الأملاك العقارية
            </h1>
              <h2 class="hero-sub-title h6 mb-4 pb-1">
                منصة متكاملة تخدم مدراء العقارات، والملاك، والمستأجرين<br class="d-none d-lg-block" />
              </h2>
              <div class="landing-hero-btn d-inline-block position-relative">
                <span class="hero-btn-item position-absolute d-none d-md-flex text-heading"
                  >للتسجيل
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/icons/Join-community-arrow.png')}}"
                    alt="Join community arrow"
                    class="scaleX-n1-rtl"
                /></span>
                <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                data-bs-target="#addSubscriberModal">سجل معنا الأن</a>
              </div>
            </div>
            <div id="heroDashboardAnimation" class="hero-animation-img">

                <div id="heroAnimationImg" class="position-relative hero-dashboard-img">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/hero-dashboard-light.png')}}"
                    alt="hero dashboard"
                    class="animation-img"
                    data-app-light-img="front-pages/landing-page/hero-dashboard-light.png"
                    data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" />
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/hero-elements-light.png')}}"
                    alt="hero elements"
                    class="position-absolute hero-elements-img animation-img top-0 start-0"
                    data-app-light-img="front-pages/landing-page/hero-elements-light.png"
                    data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" />
                </div>
              </a>
            </div>
          </div>
        </div>
        <div class="landing-hero-blank"></div>
      </section>
      <!-- Hero: End -->

      <!-- Useful features: Start -->
      <section id="landingFeatures" class="section-py landing-features">
        <div class="container">
          <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">أملاك نظام إدارة متطور
            </span>
          </div>
          <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1"
              >أملاك نظام إدارة متطور

              <img
                src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
          </h3>
          <p class="text-center mb-3 mb-md-5 pb-3">
            حلول تقنية متطورة تلبي جميع أعمالك

        </p>
          <div class="features-icon-wrapper row gx-0 gy-4 g-sm-5">
            <div class="col-lg-3 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-3">
                <img src="{{ url('HOME_PAGE/img/front-pages/icons/laptop.png')}}" alt="laptop charging" />
              </div>
              <h5 class="mb-3">علاقات العملاء
            </h5>
              <p class="features-icon-description">
                من خلال منصة مخصصة لعملائك تستطيع استقبال طلبات الصيانة والشكاوى              </p>
            </div>
            <div class="col-lg-3 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-3">
                <img src="{{ url('HOME_PAGE/img/front-pages/icons/rocket.png')}}" alt="transition up" />
              </div>
              <h5 class="mb-3">التنبيهات للعقود
            </h5>
              <p class="features-icon-description">
                من خلال لوحة التحكم الخاصة بك يمكنك متابعة جميع عقود عملائك ومعرفة عدد الأيام المتبقية لانتهاء العقد              </p>
            </div>
            <div class="col-lg-3 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-3">
                <img src="{{ url('HOME_PAGE/img/front-pages/icons/paper.png')}}" alt="edit" />
              </div>
              <h5 class="mb-3">ملفات مشتركة
            </h5>
              <p class="features-icon-description">
                من خلال النظام يمكنكم مشاركة وتبادل الملفات وحفظها واسترجاعها عند الحاجة.

            </p>
            </div>
            <div class="col-lg-3 col-sm-6 text-center features-icon-box">
              <div class="text-center mb-3">
                <img src="{{ url('HOME_PAGE/img/front-pages/icons/check.png')}}" alt="3d select solid" />
              </div>
              <h5 class="mb-3">دعم فني متقدم 24/7
            </h5>
              <p class="features-icon-description">
                تقدم أملاك دعم فني متقدم خلال 24/7 لجميع التحديات التقنية التي تواجه أعمالك.

            </p>
            </div>

          </div>
        </div>
      </section>
      <!-- Useful features: End -->

      <!-- Real customers reviews: Start -->
      <section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
        <!-- What people say slider: Start -->
        <div class="container">
          <div class="row align-items-center gx-0 gy-4 g-lg-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
              <div class="mb-3 pb-1">
                <span class="badge bg-label-primary">شركاء النجاح
                </span>
              </div>
              <h3 class="mb-1">
                <span class="position-relative fw-bold z-1"
                  >شركاء النجاح

                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                    alt="laptop charging"
                    class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
                </span>
              </h3>
              <p class="mb-3 mb-md-5">
                نتشرف بثقة و دعم العديد من المؤسسات حول المملكة

<br class="d-none d-xl-block" />

              </p>
              <div class="landing-reviews-btns">
                <button
                  id="reviews-previous-btn"
                  class="btn btn-label-primary reviews-btn me-3 scaleX-n1-rtl"
                  type="button">
                  <i class="ti ti-chevron-left ti-sm"></i>
                </button>
                <button id="reviews-next-btn" class="btn btn-label-primary reviews-btn scaleX-n1-rtl" type="button">
                  <i class="ti ti-chevron-right ti-sm"></i>
                </button>
              </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-9">
              <div class="swiper-reviews-carousel overflow-hidden mb-5 pb-md-2 pb-md-3">
                <div class="swiper" id="swiper-reviews">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                            <img
                            src="{{ url('HOME_PAGE/images/new/partners/1.png')}}"
                            alt="client logo"
                             />
                        </div>
                      </div>
                    </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/2.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/3.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/4.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/5.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/6.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="card h-100">
                          <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                              <img
                              src="{{ url('HOME_PAGE/images/new/partners/7.png')}}"
                              alt="client logo"
                               />
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- What people say slider: End -->

        <!-- Logo slider: End -->
      </section>


      {{-- <section id="landingReviews" class="section-py bg-body landing-reviews pb-0">
        <!-- What people say slider: Start -->
        <div class="container">
          <div class="row align-items-center gx-0 gy-4 g-lg-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
              <div class="mb-3 pb-1">
                <span class="badge bg-label-primary">Real Customers Reviews</span>
              </div>
              <h3 class="mb-1">
                <span class="position-relative fw-bold z-1"
                  >What people say
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                    alt="laptop charging"
                    class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
                </span>
              </h3>
              <p class="mb-3 mb-md-5">
                See what our customers have to<br class="d-none d-xl-block" />
                say about their experience.
              </p>
              <div class="landing-reviews-btns">
                <button
                  id="reviews-previous-btn"
                  class="btn btn-label-primary reviews-btn me-3 scaleX-n1-rtl"
                  type="button">
                  <i class="ti ti-chevron-left ti-sm"></i>
                </button>
                <button id="reviews-next-btn" class="btn btn-label-primary reviews-btn scaleX-n1-rtl" type="button">
                  <i class="ti ti-chevron-right ti-sm"></i>
                </button>
              </div>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-9">
              <div class="swiper-reviews-carousel overflow-hidden mb-5 pb-md-2 pb-md-3">
                <div class="swiper" id="swiper-reviews">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-1.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “Vuexy is hands down the most useful front end Bootstrap theme I've ever used. I can't wait
                            to use it again for my next project.”
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Cecilia Payne</h6>
                              <p class="small text-muted mb-0">CEO of Airbnb</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-2.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “I've never used a theme as versatile and flexible as Vuexy. It's my go to for building
                            dashboard sites on almost any project.”
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/2.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Eugenia Moore</h6>
                              <p class="small text-muted mb-0">Founder of Hubspot</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-3.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            This template is really clean & well documented. The docs are really easy to understand and
                            it's always easy to find a screenshot from their website.
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/3.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Curtis Fletcher</h6>
                              <p class="small text-muted mb-0">Design Lead at Dribbble</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-4.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            All the requirements for developers have been taken into consideration, so I’m able to build
                            any interface I want.
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/4.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Sara Smith</h6>
                              <p class="small text-muted mb-0">Founder of Continental</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-5.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            “I've never used a theme as versatile and flexible as Vuexy. It's my go to for building
                            dashboard sites on almost any project.”
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/5.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Eugenia Moore</h6>
                              <p class="small text-muted mb-0">Founder of Hubspot</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="card h-100">
                        <div class="card-body text-body d-flex flex-column justify-content-between h-100">
                          <div class="mb-3">
                            <img
                              src="{{ url('HOME_PAGE/img/front-pages/branding/logo-6.png')}}"
                              alt="client logo"
                              class="client-logo img-fluid" />
                          </div>
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam nemo mollitia, ad eum
                            officia numquam nostrum repellendus consequuntur!
                          </p>
                          <div class="text-warning mb-3">
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star-filled ti-sm"></i>
                            <i class="ti ti-star ti-sm"></i>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="avatar me-2 avatar-sm">
                              <img src="{{ url('HOME_PAGE/img/avatars/1.png')}}" alt="Avatar" class="rounded-circle" />
                            </div>
                            <div>
                              <h6 class="mb-0">Sara Smith</h6>
                              <p class="small text-muted mb-0">Founder of Continental</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-button-next"></div>
                  <div class="swiper-button-prev"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- What people say slider: End -->
        <hr class="m-0" />
        <!-- Logo slider: Start -->
        <div class="container">
          <div class="swiper-logo-carousel py-4 my-lg-2">
            <div class="swiper" id="swiper-clients-logos">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/branding/logo_1-light.png')}}"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_1-light.png"
                    data-app-dark-img="front-pages/branding/logo_1-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/branding/logo_2-light.png')}}"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_2-light.png"
                    data-app-dark-img="front-pages/branding/logo_2-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/branding/logo_3-light.png')}}"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_3-light.png"
                    data-app-dark-img="front-pages/branding/logo_3-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/branding/logo_4-light.png')}}"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_4-light.png"
                    data-app-dark-img="front-pages/branding/logo_4-dark.png" />
                </div>
                <div class="swiper-slide">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/branding/logo_5-light.png')}}"
                    alt="client logo"
                    class="client-logo"
                    data-app-light-img="front-pages/branding/logo_5-light.png"
                    data-app-dark-img="front-pages/branding/logo_5-dark.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Logo slider: End -->
      </section> --}}
      <!-- Real customers reviews: End -->

      <section id="landingTeam" class="section-py landing-team">
        <div class="container">
          <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">Our Great Team</span>
          </div>
          <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1"
              >Supported
              <img
                src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
            by Real People
          </h3>
          <p class="text-center mb-md-5 pb-3">Who is behind these great-looking interfaces?</p>
          <div class="row gy-5 mt-2">
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div class="bg-label-primary position-relative team-image-box">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/team-member-1.png')}}"
                    class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-primary text-center">
                  <h5 class="card-title mb-0">Sophie Gilbert</h5>
                  <p class="text-muted mb-0">Project Manager</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div class="bg-label-info position-relative team-image-box">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/team-member-2.png')}}"
                    class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-info text-center">
                  <h5 class="card-title mb-0">Paul Miles</h5>
                  <p class="text-muted mb-0">UI Designer</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div class="bg-label-danger position-relative team-image-box">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/team-member-3.png')}}"
                    class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-danger text-center">
                  <h5 class="card-title mb-0">Nannie Ford</h5>
                  <p class="text-muted mb-0">Development Lead</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="card mt-3 mt-lg-0 shadow-none">
                <div class="bg-label-success position-relative team-image-box">
                  <img
                    src="{{ url('HOME_PAGE/img/front-pages/landing-page/team-member-4.png')}}"
                    class="position-absolute card-img-position bottom-0 start-50 scaleX-n1-rtl"
                    alt="human image" />
                </div>
                <div class="card-body border border-top-0 border-label-success text-center">
                  <h5 class="card-title mb-0">Chris Watkins</h5>
                  <p class="text-muted mb-0">Marketing Manager</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Our great team: Start -->

      <!-- Our great team: End -->

      <!-- Pricing plans: Start -->
      <section id="landingPricing" class="section-py bg-body landing-pricing">
        <div class="container">
          <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">باقات وأسعار أملاك
            </span>
          </div>
          <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1"
              >توفر لكم منصة أملاك باقات مميزة تمكنك من إدارة المستأجرين بكل سهولة

              <img
                src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
          </h3>
          <p class="text-center mb-4 pb-3">

          </p>
          {{-- <div class="text-center mb-5">
            <div class="position-relative d-inline-block pt-3 pt-md-0">
              <label class="switch switch-primary me-0">
                <span class="switch-label">ادفع شهري</span>
                <input type="checkbox" class="switch-input price-duration-toggler" checked />
                <span class="switch-toggle-slider">
                  <span class="switch-on"></span>
                  <span class="switch-off"></span>
                </span>
                <span class="switch-label">ادفع سنوي</span>
              </label>
              <div class="pricing-plans-item position-absolute d-flex">
                <img
                  src="{{ url('HOME_PAGE/img/front-pages/icons/pricing-plans-arrow.png')}}"
                  alt="pricing plans arrow"
                  class="scaleX-n1-rtl" />
                <span class="fw-medium mt-2 ms-1"> وفر 25%</span>
              </div>
            </div>
          </div> --}}
          @guest

          <div class="row gy-4 pt-lg-3 d-flex justify-content-center">
            <!-- Basic Plan: Start -->
            @foreach ($subscriptionTypes as $subscriptionType)

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-header">
                  <div class="text-center">
                    <img
                      src="{{ url('HOME_PAGE/img/front-pages/icons/paper-airplane.png')}}"
                      alt="paper airplane icon"
                      class="mb-4 pb-2" />
                    <h4 class="mb-1">{{ $subscriptionType->name }}</h4>
                    <div class="d-flex align-items-center justify-content-center">
                        <p>
                            @foreach ($subscriptionType->roles as $role)
                                <span> اشتراك   {{ $role->name_ar }}</span>
                            @endforeach
                        </p>
                    </div>
                    {{-- <div class="d-flex align-items-center justify-content-center">
                      <span class="price-monthly h1 text-primary fw-bold mb-0">{{ $subscriptionType->price }}</span>
                      <span class="price-yearly h1 text-primary fw-bold mb-0 d-none">$14</span>
                      <sub class="h6 text-muted mb-0 ms-1">/رس</sub>
                    </div>
                    <div class="position-relative pt-2">
                      <div class="price-yearly text-muted price-yearly-toggle d-none">$ 168 / year</div>
                    </div> --}}

                    <div class="d-flex align-items-center justify-content-center">
                        <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">@lang('SAR')</sup>
                        <span class="price-monthly h1 text-primary fw-bold mb-0">{{ $subscriptionType->price }} </span>
                        <sub class="h6 text-muted mb-0 ms-1">/{{ $subscriptionType->period }} {{ __($subscriptionType->period_type) }}</sub>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled">
                    @foreach ($sections as $section)
                    <li>
                      <h5>

                          @if ($subscriptionType->SectionData->contains('section_id', $section->id))
                          <span class="badge badge-center rounded-pill bg-label-primary p-0 me-2"
                          >
                          <i class="ti ti-check ti-xs"></i>
                        </span>
                        @else
                        <span class="badge badge-center rounded-pill bg-label-danger p-0 me-2"
                        >
                        <i class="ti ti-minus ti-xs"></i>
                        @endif
                        </span>
                        {{ $section->name }}
                      </h5>
                    </li>
                    @endforeach

                  </ul>
                  <div class="d-grid mt-4 pt-3">
                    @if ($subscriptionType && $subscriptionType->roles->count() == 2)

                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    data-bs-target="#addSubscriberModal">ابدأ الأن</a>
                    @elseif ($role->name == "RS-Broker")
                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    onclick="redirectToCreateBroker()">ابدأ الأن</a>
                    @elseif ($role->name == "Office-Admin")
                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    onclick="redirectToCreateOffice()">ابدأ الأن</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @endforeach
            <!-- Basic Plan: End -->

          </div>
          @endguest

          @auth

          <div class="row gy-4 pt-lg-3 d-flex justify-content-center">
            <!-- Basic Plan: Start -->
            @foreach ($subscriptionTypesRoles as $subscriptionType)

            <div class="col-xl-3 col-lg-6">
              <div class="card">
                <div class="card-header">
                  <div class="text-center">
                    <img
                      src="{{ url('HOME_PAGE/img/front-pages/icons/paper-airplane.png')}}"
                      alt="paper airplane icon"
                      class="mb-4 pb-2" />
                    <h4 class="mb-1">{{ $subscriptionType->name }}</h4>
                    <div class="d-flex align-items-center justify-content-center">
                        <p>
                            @foreach ($subscriptionType->roles as $role)
                                <span> اشتراك   {{ $role->name_ar }}</span>
                            @endforeach
                        </p>
                    </div>
                    {{-- <div class="d-flex align-items-center justify-content-center">
                      <span class="price-monthly h1 text-primary fw-bold mb-0">{{ $subscriptionType->price }}</span>
                      <span class="price-yearly h1 text-primary fw-bold mb-0 d-none">$14</span>
                      <sub class="h6 text-muted mb-0 ms-1">/رس</sub>
                    </div> --}}
                    <div class="d-flex align-items-center justify-content-center">
                        <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">@lang('SAR')</sup>
                        <span class="price-monthly h1 text-primary fw-bold mb-0">{{ $subscriptionType->price }} </span>
                        <sub class="h6 text-muted mb-0 ms-1">/{{ $subscriptionType->period }} {{ __($subscriptionType->period_type) }}</sub>
                    </div>


                  </div>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled">
                    @foreach ($sections as $section)
                    <li>
                      <h5>

                          @if ($subscriptionType->SectionData->contains('section_id', $section->id))
                          <span class="badge badge-center rounded-pill bg-label-primary p-0 me-2"
                          >
                          <i class="ti ti-check ti-xs"></i>
                        </span>
                        @else
                        <span class="badge badge-center rounded-pill bg-label-danger p-0 me-2"
                        >
                        <i class="ti ti-minus ti-xs"></i>
                        @endif
                        </span>
                        {{ $section->name }}
                      </h5>
                    </li>
                    @endforeach

                  </ul>
                  <div class="d-grid mt-4 pt-3">
                    @if ($subscriptionType && $subscriptionType->roles->count() == 2)

                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    data-bs-target="#addSubscriberModal">ابدأ الأن</a>
                    @elseif ($role->name == "RS-Broker")
                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    onclick="redirectToCreateBroker()">ابدأ الأن</a>
                    @elseif ($role->name == "Office-Admin")
                    <a href="" class="btn btn-label-primary" data-bs-toggle="modal"
                    onclick="redirectToCreateOffice()">ابدأ الأن</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @endforeach
            <!-- Basic Plan: End -->

          </div>
          @endauth

        </div>
      </section>
      <!-- Pricing plans: End -->

      <!-- Fun facts: Start -->
      {{-- <section id="landingFunFacts" class="section-py landing-fun-facts">
        <div class="container">
          <div class="row gy-3">
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-label-primary shadow-none">
                <div class="card-body text-center">
                  <img src="{{ url('HOME_PAGE/img/front-pages/icons/laptop.png')}}" alt="laptop" class="mb-2" />
                  <h5 class="h2 mb-1">7.1k+</h5>
                  <p class="fw-medium mb-0">
                    Support Tickets<br />
                    Resolved
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-label-success shadow-none">
                <div class="card-body text-center">
                  <img src="{{ url('HOME_PAGE/img/front-pages/icons/user-success.png')}}" alt="laptop" class="mb-2" />
                  <h5 class="h2 mb-1">50k+</h5>
                  <p class="fw-medium mb-0">
                    Join creatives<br />
                    community
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-label-info shadow-none">
                <div class="card-body text-center">
                  <img src="{{ url('HOME_PAGE/img/front-pages/icons/diamond-info.png')}}" alt="laptop" class="mb-2" />
                  <h5 class="h2 mb-1">4.8/5</h5>
                  <p class="fw-medium mb-0">
                    Highly Rated<br />
                    Products
                  </p>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-lg-3">
              <div class="card border border-label-warning shadow-none">
                <div class="card-body text-center">
                  <img src="{{ url('HOME_PAGE/img/front-pages/icons/check-warning.png')}}" alt="laptop" class="mb-2" />
                  <h5 class="h2 mb-1">100%</h5>
                  <p class="fw-medium mb-0">
                    Money Back<br />
                    Guarantee
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> --}}
      <!-- Fun facts: End -->

      <!-- FAQ: Start -->
      <section id="landingFAQ" class="section-py bg-body landing-faq">
        <div class="container">
          <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">            الأسئلة الشائعة
            </span>
          </div>
          <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1"
              >            الأسئلة الشائعة

              <img
                src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
          </h3>
          <p class="text-center mb-5 pb-3"></p>
          <div class="row gy-5">
            <div class="col-lg-5">
              <div class="text-center">
                <img
                  src="{{ url('HOME_PAGE/img/front-pages/landing-page/faq-boy-with-logos.png')}}"
                  alt="faq boy with logos"
                  class="faq-image" />
              </div>
            </div>
            <div class="col-lg-7">
              <div class="accordion" id="accordionExample">
                <div class="card accordion-item active">
                  <h2 class="accordion-header" id="headingOne">
                    <button
                      type="button"
                      class="accordion-button"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionOne"
                      aria-expanded="true"
                      aria-controls="accordionOne">
                      ماهي منصة أملاك؟
                    </button>
                  </h2>

                  <div id="accordionOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        هي منصة إلكترونية تم تصميمها بإتقان لتوفير حلول متكاملة لجميع الخدمات العقارية بطريقة سهلة وشاملة لكافة المهام والإجراءات الخاصة بالمكاتب العقارية و إدارة العقارات والوحدات السكنية والتجارية على السواء. تهدف أملاك إلى إدارة جميع مستويات المشروعات العقارية بدءا من الوحدات وصولا إلى المشروعات عبر نظام متطور وحلول تقنية مبتكرة تهدف إلى القيام بجميع الاعمال عن بعد بجودة وموثوقية عالية، عبر استقطاب العديد من الخبرات الإدارية و التسويقية والمحاسبية ذات الكفاءة العالية.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionTwo"
                      aria-expanded="false"
                      aria-controls="accordionTwo">
                      ما هي خطط الأسعار المتاحة للاشتراك في منصة أملاك؟

                    </button>
                  </h2>
                  <div
                    id="accordionTwo"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        توفر منصة أملاك مجموعة متنوعة من خطط الأسعار لتناسب منشأتك بشكل متكامل وتلبي جميع الخدمات
                        التي تحتاجها.
                        <ul style="list-style:none">
                            <li>- اشتراك مجاني (فترة تجريبية)</li>
                            <li>- اشتراك شهري</li>
                            <li>- اشتراك سنوي (قريبا)</li>
                        </ul>
                      </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionThree"
                      aria-expanded="false"
                      aria-controls="accordionThree">
                      ما هي الاجراءات اللازمة للتسجيل على منصة أملاك؟
                    </button>
                  </h2>
                  <div
                    id="accordionThree"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        للتسجيل و الانضمام إلى نظام أملاك يجب مليء فورم التسجيل عبر الضغط على زر "سجل معنا الآن" و
                        ادخال بيانات شركتك:
                        <ul style="list-style:none;">
                            <li>-اسم الشركة</li>
                            <li>-البريد الإلكتروني</li>
                            <li>-شعار الشركة</li>
                            <li>-اسم ورقم هاتف ممثل الشركة</li>
                            <li>-اختيار نوع الاشتراك في النظام</li>
                        </ul>
                        بعد ذلك سوف يكون حسابك جاهزاً لتبدأ تجربة متميزة ومبتكرة لإدارة مشروعك العقاري.
                    </div>
                  </div>
                </div>
                <div class="card accordion-item">
                  <h2 class="accordion-header" id="headingFour">
                    <button
                      type="button"
                      class="accordion-button collapsed"
                      data-bs-toggle="collapse"
                      data-bs-target="#accordionFour"
                      aria-expanded="false"
                      aria-controls="accordionFour">
                      ماذا أفعل عندما تواجهني مشكلة أثناء استخدامي لمنصة أملاك؟
                    </button>
                  </h2>
                  <div
                    id="accordionFour"
                    class="accordion-collapse collapse"
                    aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        عندما تواجهك مشكلة أو إذا كان لديك شكوى أو اقتراحات يمكنك فتح تذكرة دعم فني بسهولة من خلال
                        حسابك على المنصة و سوف يصلك الرد من فريق الدعم في اسرع وقت.
                     </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- FAQ: End -->

      <!-- CTA: Start -->
      <section id="landingCTA" class="section-py landing-cta position-relative p-lg-0 pb-0">
        <img
          src="{{ url('HOME_PAGE/img/front-pages/backgrounds/cta-bg-light.png')}}"
          class="position-absolute bottom-0 end-0 scaleX-n1-rtl h-100 w-100 z-n1"
          alt="cta image"
          data-app-light-img="front-pages/backgrounds/cta-bg-light.png"
          data-app-dark-img="front-pages/backgrounds/cta-bg-dark.png" />
        <div class="container">
          <div class="row align-items-center gy-5 gy-lg-0">
            <div class="col-lg-6 text-center text-lg-start">
              <h6 class="h2 text-primary fw-bold mb-1">ماذا تنتظر !؟
            </h6>
            <h6 class="h2 text-primary fw-bold mb-1">انضم لنا الآن
            </h6>
              <p class="fw-medium mb-4">واجهة سهلة الإستخدام بمميزات متعددة

              </p>
              <a href="#" data-bs-toggle="modal"
              data-bs-target="#addSubscriberModal"  class="btn btn-lg btn-primary">سجل معنا الأن</a>
            </div>
            <div class="col-lg-6 pt-lg-5 text-center text-lg-end">
              {{-- <img
                src="{{ url('HOME_PAGE/img/front-pages/landing-page/cta-dashboard.png')}}"
                alt="cta dashboard"
                class="img-fluid" /> --}}
            </div>
          </div>
        </div>
      </section>
      <!-- CTA: End -->

      <!-- Contact Us: Start -->
      <section id="landingContact" class="section-py bg-body landing-contact">
        <div class="container">
          <div class="text-center mb-3 pb-1">
            <span class="badge bg-label-primary">توصل معنا</span>
          </div>
          <h3 class="text-center mb-1">
            <span class="position-relative fw-bold z-1"
              >دعنا نعمل
              <img
                src="{{ url('HOME_PAGE/img/front-pages/icons/section-title-icon.png')}}"
                alt="laptop charging"
                class="section-title-img position-absolute object-fit-contain bottom-0 z-n1" />
            </span>
            معا
          </h3>
          <p class="text-center mb-4 mb-lg-5 pb-md-3">أي سؤال أو ملاحظة؟ فقط اكتب لنا رسالة</p>
          <div class="row gy-4">
            <div class="col-lg-5">
              <div class="contact-img-box position-relative border p-2 h-100">
                <img
                  src="{{ url('HOME_PAGE/img/front-pages/icons/contact-border.png')}}"
                  alt="contact border"
                  class="contact-border-img position-absolute d-none d-md-block scaleX-n1-rtl" />
                <img
                  src="{{ url('HOME_PAGE/img/front-pages/landing-page/contact-customer-service.png')}}"
                  alt="contact customer service"
                  class="contact-img w-100 scaleX-n1-rtl" />
                <div class="pt-3 px-4 pb-1">
                  <div class="row gy-3 gx-md-4">
                    <div class="col-md-6 col-lg-12 col-xl-6">
                      <div class="d-flex align-items-center">
                        <div class="badge bg-label-primary rounded p-2 me-2"><i class="ti ti-mail ti-sm"></i></div>
                        <div>
                          <p class="mb-0">@lang('Email')</p>
                          <h5 class="mb-0">
                            <a href="mailto:{{ $sitting->support_email }}" class="text-heading">{{ $sitting->support_email }}</a>
                          </h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-12 col-xl-6">
                      <div class="d-flex align-items-center">
                        <div class="badge bg-label-success rounded p-2 me-2">
                          <i class="ti ti-phone-call ti-sm"></i>
                        </div>
                        <div>
                          <p class="mb-0">@lang('phone')</p>
                          <h6 class="mb-0"><a href="tel:+{{ $sitting->full_phone }}" class="text-heading">{{ $sitting->full_phone }}</a></h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="card">
                <div class="card-body">
                  <h4 class="mb-1">ارسال رسالة</h4>
                  <p class="mb-4">
                    إذا كنت ترغب في مناقشة أي شيء متعلق بالدفع والحساب والترخيص<br
                      class="d-none d-lg-block" />
                      الشراكات، أو لديك أسئلة ما قبل البيع، فأنت في المكان الصحيح.                  </p>
                  <form>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label" for="contact-form-fullname">الاسم الرباعي</label>
                        <input type="text" class="form-control" id="contact-form-fullname" placeholder="الاسم الرباعي" />
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="contact-form-email">البريد الالكتروني</label>
                        <input
                          type="text"
                          id="contact-form-email"
                          class="form-control"
                          placeholder="البريد الاكتروني" />
                      </div>
                      <div class="col-12">
                        <label class="form-label" for="contact-form-message">الرسالة</label>
                        <textarea
                          id="contact-form-message"
                          class="form-control"
                          rows="8"
                          placeholder="محتوي الرسالة"></textarea>
                      </div>
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Contact Us: End -->
    </div>

    <!-- / Sections:End -->

    <!-- Footer: Start -->

    @include('Home.layouts.inc.__addSubscriberModal')
<script>
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }
    function redirectToCreatePropertyFinder() {
        window.location.href = "{{ route('Home.PropertyFinders.CreatePropertyFinder') }}";
    }
    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }
</script>

    @endsection

