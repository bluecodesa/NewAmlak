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
            margin-top: 0;
            /* Adjusts the dropdown position */
        }
    </style>
    <script src="{{ url('HOME_PAGE/vendor/js/dropdown-hover.js') }}"></script>
    <script src="{{ url('HOME_PAGE/vendor/js/mega-dropdown.js') }}"></script>

    <!-- Navbar: Start -->
    <nav class="layout-navbar shadow-none py-0">
        <div class="container">
            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4 py-0">
                <!-- Menu logo wrapper: Start -->
                <div class="navbar-brand app-brand demo d-flex py-0 me-4">
                    <!-- Mobile menu toggle: Start-->
                    <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-menu-2 ti-sm align-middle"></i>
                    </button>
                    <!-- Mobile menu toggle: End-->
                    <a href="{{ route('welcome') }}" class="app-brand-link">
                        <img src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" width="80" alt="">
                        {{-- <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">تاون</span> --}}
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
                                href="{{ route('welcome') }}#landingHero">@lang('About Town')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingFeatures">@lang('Features')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingPricing">@lang('Packages')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  fw-medium" href="{{ route('gallery.showAllGalleries') }}">@lang('Gallary')</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link  fw-medium" href="{{ route('Home.showAllProjects') }}">المشاريع</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('brokers') }}">@lang('Real Estate Brokers')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('welcome') }}#landingContact">@lang('Contact us')</a>
                        </li>


                    </ul>
                </div>
                <div class="landing-menu-overlay d-lg-none"></div>
                <!-- Menu wrapper: End -->
                <!-- Toolbar: Start -->
                <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Language -->
          <li class="nav-item dropdown-language dropdown me-2 me-xl-0" data-tour="language">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="ti ti-language rounded-circle ti-md"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li>
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <span class="align-middle">{{ $properties['native'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <!--/ Language -->

        <!-- Style Switcher -->
        <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0" data-tour="style-switcher">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <i class="ti ti-md"></i>
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
                        @php
                            $availableRoles = null;
                        @endphp

                        @auth
                            <div class="dropdown">
                                @php
                                    $availableRoles = null;

                                    // Get the authenticated user
                                    $user = auth()->user();

                                    // Fetch all roles
                                    $roles = App\Models\Role::all();

                                    // Get the roles assigned to the user
                                    $userRoles = $roles->filter(function ($role) use ($user) {
                                        return $user->hasRole($role->name);
                                    });

                                    // Set the active role from the session or default to "Switch Account"
                                    $activeRole = session('active_role') ?? 'Switch Account';

                                    // Define specific roles
                                    // $specificRoles = collect(['Owner', 'Office-Admin', 'RS-Broker', 'Property-Finder','Renter']);
                                    $specificRoles = collect(['Owner', 'Office-Admin', 'RS-Broker', 'Property-Finder']);


                                    // Filter available roles based on current user roles
                                    $availableRoles = $specificRoles->diff($userRoles->pluck('name'));

                                    // Check the current role to exclude conflicting roles
                                    // if ($user->hasRole('Renter')) {
                                    //     $availableRoles = $availableRoles->filter(function ($role) {
                                    //         return $role !== 'Property-Finder';
                                    //     });
                                    // }
                                    if ($user->hasRole('Owner')) {
                                        $availableRoles = $availableRoles->filter(function ($role) {
                                            return $role !== 'Property-Finder';
                                        });
                                    }

                                    if ($user->hasRole('RS-Broker')) {
                                        $availableRoles = $availableRoles->filter(function ($role) {
                                            return $role !== 'Office-Admin' && $role !== 'Property-Finder';
                                        });
                                    }

                                    if ($user->hasRole('Office-Admin')) {
                                        $availableRoles = $availableRoles->filter(function ($role) {
                                            return $role !== 'RS-Broker' && $role !== 'Property-Finder';
                                        });
                                    }

                                    // Determine the correct route
                                    $accountRoute =
                                        $activeRole == 'Owner' ||
                                        $activeRole == 'Renter' ||
                                        $activeRole == 'Property-Finder'
                                            ? route('PropertyFinder.home')
                                            : route('Admin.home');
                                @endphp

                                <!-- "My Account" Dropdown Toggle -->
                                <a href="{{ $accountRoute }}" class="btn btn-primary btn-sm dropdown-toggle"
                                    id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="tf-icons ti ti-dashboard scaleX-n1-rtl me-md-1"></span>
                                    <span class="d-none d-md-block">@lang('My Account') (@lang($activeRole))</span>
                                </a>

                                <!-- Dropdown Menu -->
                                <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                                    @foreach ($roles as $role)
                                        @if ($userRoles->contains('name', $role->name) && $role->name !== $activeRole)
                                            <li><a class="dropdown-item"
                                                    href="{{ route('switch.role', $role->name) }}">@lang($role->name)</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    <!-- Add New Account Button -->
                                    @if ($availableRoles->isNotEmpty())
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li> <!-- Divider between roles and add new account -->
                                        <li>
                                            <button class="dropdown-item" id="addAccountButton">@lang('Add New Account')</button>
                                        </li>
                                    @endif
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li> <!-- Divider between roles and add new account -->
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                            class="dropdown-item" target="_blank"><i
                                                class="tf-icons ti ti-logout scaleX-n1-rtl me-md-1"></i> @lang('Log Out')</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
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

                        {{--
                        @auth


                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="btn btn-primary btn-sm" target="_blank"><span
                                    class="tf-icons ti ti-logout scaleX-n1-rtl me-md-1"></span><span
                                    class="d-none d-md-block">تسجيل خروج</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth --}}

                    </li>
                    <!-- navbar button: End -->
                </ul>
                <!-- Toolbar: End -->
            </div>
        </div>
    </nav>
    <!-- Navbar: End -->

    <!-- Modal for Adding New Account -->
    {{-- <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">@lang('Add New Account')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if (!$availableRoles == null)
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
                        @endif

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('close')</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h3 class="address-title mb-2">@lang('Create an account')</h3>
                    </div>
                    <div class="row justify-content-around">
                        <form id="roleForm" action="{{ route('Home.addAccount') }}" method="POST">
                            @csrf
                            <input type="hidden" name="key_phone"
                                value="{{ auth()->user()->key_phone ?? '' }}">
                            <input type="hidden" name="phone"
                                value="{{ auth()->user()->phone ?? '' }}">
                            <input type="hidden" name="full_phone"
                                value="{{ auth()->user()->full_phone ?? '' }}">

                            <input type="text" hidden class="form-control" minlength="1" maxlength="10"
                                id="id_number" name="id_number" value="{{ auth()->user()->id_number ?? '' }}"
                                required>

                            <input type="text" hidden class="form-control" id="email" name="email" required
                                value="{{ auth()->user()->email ?? '' }}" placeholder="@lang('Email')" autofocus>

                            <input type="text" hidden class="form-control" id="name" name="name"
                                value="{{ auth()->user()->name ?? '' }}" required placeholder="@lang('Name')"
                                autofocus>
                            <input type="text" hidden id="account_type" name="account_type" value="">
                            <input type="text" hidden class="form-control" minlength="1" maxlength="10"
                                id="subscription_type_id" name="subscription_type_id"
                                value="{{ $subscriptionType->id ?? '' }}">

                            <div class="row">
                                @if (!$availableRoles == null)

                                    @foreach ($availableRoles as $role)
                                        <div class="col-md-4 mb-md-0 mb-3">
                                            <div class="form-check custom-option custom-option-icon"
                                                onclick="submitRoleForm('{{ $role }}')">
                                                <label class="form-check-label custom-option-content"
                                                    for="customRadio{{ $role }}">
                                                    <span class="custom-option-body">
                                                        <svg width="41" height="40" viewBox="0 0 41 40"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M24.25 33.75V23.75H16.75V33.75H6.75002V18.0469C6.7491 17.8733 6.78481 17.7015 6.85482 17.5426C6.92482 17.3838 7.02754 17.2415 7.15627 17.125L19.6563 5.76562C19.8841 5.5559 20.1825 5.43948 20.4922 5.43948C20.8019 5.43948 21.1003 5.5559 21.3281 5.76562L33.8438 17.125C33.9696 17.2438 34.0703 17.3866 34.1401 17.5449C34.2098 17.7032 34.2472 17.8739 34.25 18.0469V33.75H24.25Z"
                                                                fill="currentColor" opacity="0.2" />
                                                            <path d="..." fill="currentColor" />
                                                        </svg>
                                                        <span class="custom-option-title">{{ __($role) }}</span>
                                                    </span>
                                                    <input name="role_id" type="radio" class="form-check-input"
                                                        id="customRadio{{ $role }}"
                                                        value="{{ $role }}">
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </form>

                        <script>
                            function submitRoleForm(roleId) {
                                const roleToAccountTypeMap = {
                                    'RS-Broker': 'broker',
                                    'Office-Admin': 'office',
                                    'Owner': 'owner',
                                    'Renter':'renter'
                                };

                                const accountType = roleToAccountTypeMap[roleId] || 'owner';
                                document.querySelector('input[name="role_id"][value="' + roleId + '"]').checked = true;
                                document.getElementById('account_type').value = accountType;

                                // Submit the form
                                document.getElementById('roleForm').submit();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>




    @yield('content')









    @include('Home.layouts.home.footer')


    @include('Home.layouts.home.footer-scripts')


</body>

</html>
