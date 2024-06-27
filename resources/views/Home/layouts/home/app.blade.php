<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">

@include('Home.layouts.home.head')

<body>
    <script src="{{ url('HOME_PAGE/vendor/js/dropdown-hover.js') }}"></script>
    <script src="{{ url('HOME_PAGE/vendor/js/mega-dropdown.js') }}"></script>

    <!-- Navbar: Start -->
    <nav class="layout-navbar shadow-none py-0">
        <div class="container">
            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4">
                <!-- Menu logo wrapper: Start -->
                <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4">
                    <!-- Mobile menu toggle: Start-->
                    <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-menu-2 ti-sm align-middle"></i>
                    </button>
                    <!-- Mobile menu toggle: End-->
                    <a href="{{ route('welcome') }}" class="app-brand-link">
                        <img src="{{ url($sitting->icon) }}" width="30" alt="">
                        <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">أملاك</span>
                    </a>
                </div>
                <!-- Menu logo wrapper: End -->
                <!-- Menu wrapper: Start -->
                <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                    <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
                        type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-x ti-sm"></i>
                    </button>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-medium" aria-current="page"
                                href="{{ route('welcome') }}#landingHero">عن أملاك</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingFeatures">المميزات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingPricing">الباقات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  fw-medium" href="{{ route('gallery.showAllGalleries') }}">المعرض</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('brokers') }}">المسوقين العقاريين</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingContact">تواصل معنا</a>
                        </li>


                    </ul>
                </div>
                <div class="landing-menu-overlay d-lg-none"></div>
                <!-- Menu wrapper: End -->
                <!-- Toolbar: Start -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <!-- Style Switcher -->
                    <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-sm"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                    <span class="align-middle"><i class="ti ti-sun me-2"></i>Light</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                    <span class="align-middle"><i class="ti ti-moon me-2"></i>Dark</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                    <span class="align-middle"><i class="ti ti-device-desktop me-2"></i>System</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- / Style Switcher-->

                    <!-- navbar button: Start -->
                    <li class="me-1">

                        @guest
                            <a href="" class="btn btn-primary btn-sm" target="_blank" data-bs-toggle="modal"
                                data-bs-target="#addSubscriberModal"><span
                                    class="tf-icons ti ti-registered scaleX-n1-rtl me-md-1"></span>
                                <span class="d-none d-md-block">سجل معنا الأن</span></a>
                        @endguest
                        @auth
                            <a href="{{ route('Admin.home') }}" class="btn btn-primary btn-sm"><span
                                    class="tf-icons ti ti-dashboard scaleX-n1-rtl me-md-1"></span><span
                                    class="d-none d-md-block">حسابى</span></a>

                        @endauth


                    </li>
                    <li>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><span
                                    class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span><span
                                    class="d-none d-md-block">تسجيل</span></a>


                        @endguest


                        @auth


                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="btn btn-primary btn-sm" target="_blank"><span
                                    class="tf-icons ti ti-logout scaleX-n1-rtl me-md-1"></span><span
                                    class="d-none d-md-block">تسجيل خروج</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth

                    </li>
                    <!-- navbar button: End -->
                </ul>
                <!-- Toolbar: End -->
            </div>
        </div>
    </nav>
    <!-- Navbar: End -->




    @yield('content')









    @include('Home.layouts.home.footer')


    @include('Home.layouts.home.footer-scripts')


</body>

</html>
