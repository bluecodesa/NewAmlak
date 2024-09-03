<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-default"
    data-assets-path="{{ url('HOME_PAGE') }}/" data-template="vertical-menu-template-starter">

@include('Home.layouts.home.head')


<body>
    <style>
        /* Show dropdown on hover */
.dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0; /* Adjusts the dropdown position */
}

    </style>
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
                        {{-- <li class="nav-item">
                            <a class="nav-link  fw-medium" href="{{ route('Home.showAllProjects') }}">المشاريع</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('brokers') }}">الوسطاء العقاريين</a>
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
{{--
                        @guest
                            <a href="" class="btn btn-primary btn-sm" target="_blank" data-bs-toggle="modal"
                                data-bs-target="#addSubscriberModal"><span
                                    class="tf-icons ti ti-registered scaleX-n1-rtl me-md-1"></span>
                                <span class="d-none d-md-block">سجل معنا الأن</span></a>
                        @endguest --}}
                        @auth
                        <div class="dropdown">
                            @php
                                $user = auth()->user();
                                $roles = App\Models\Role::all();
                                $userRoles = $roles->filter(function ($role) use ($user) {
                                    return $user->hasRole($role->name);
                                });
                                $activeRole = session('active_role') ?? 'Switch Account';
                                $specificRoles = collect(['Owner', 'Office', 'RS-Broker']);
                                $availableRoles = $specificRoles->diff($userRoles->pluck('name'));

                                // Determine the correct route
                                $accountRoute = ($activeRole == 'Office' || $activeRole == 'RS-Broker')
                                    ? route('Admin.home')
                                    : route('PropertyFinder.home');
                            @endphp

                            <!-- "My Account" Dropdown Toggle -->
                            <a href="{{ $accountRoute }}" class="btn btn-primary btn-sm dropdown-toggle" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="tf-icons ti ti-dashboard scaleX-n1-rtl me-md-1"></span>
                                <span class="d-none d-md-block">@lang('My Account') (@lang($activeRole))</span>
                            </a>

                            <!-- Dropdown Menu -->
                            <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                @foreach ($roles as $role)
                                    @if ($userRoles->contains('name', $role->name) && $role->name !== $activeRole)
                                        <li><a class="dropdown-item" href="{{ route('switch.role', $role->name) }}">@lang($role->name)</a></li>
                                    @endif
                                @endforeach

                                <!-- Add New Account Button -->
                                @if ($availableRoles->isNotEmpty())
                                    <li><hr class="dropdown-divider"></li> <!-- Divider between roles and add new account -->
                                    <li>
                                        <button class="dropdown-item" id="addAccountButton">@lang('Add New Account')</button>
                                    </li>
                                @endif
                            </ul>
                        </div>



                        <script>
                            // Show modal when "Add New Account" is clicked
                            document.getElementById('addAccountButton').addEventListener('click', function() {
                                var addAccountModal = new bootstrap.Modal(document.getElementById('addAccountModal'), {});
                                addAccountModal.show();
                            });

                            // Handle role redirection logic (you can modify this according to your needs)
                            function handleRoleRedirect(role) {
                                console.log(`Redirect to add new account for role: ${role}`);
                                // Example: window.location.href = `/add-account/${role}`;
                            }
                        </script>




                        <script>
                            document.getElementById('accountDropdown').addEventListener('click', function() {
                                window.location.href = '{{ $accountRoute }}';
                            });
                        </script>
                    @endauth




                    </li>
                    <li>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><span
                                    class="tf-icons ti ti-login scaleX-n1-rtl me-md-1"></span><span
                                    class="d-none d-md-block">@lang('login')</span></a>


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

     <!-- Modal for Adding New Account -->
     <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">@lang('Add New Account')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($availableRoles as $role)
                            <div class="col-6 mb-3">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">@lang($role)</h6>
                                        <button class="btn btn-primary btn-sm" onclick="handleRoleRedirect('{{ $role }}')">
                                            @lang('Add')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('close')</button>
                </div>
            </div>
        </div>
    </div>


    @yield('content')









    @include('Home.layouts.home.footer')


    @include('Home.layouts.home.footer-scripts')


</body>

</html>
