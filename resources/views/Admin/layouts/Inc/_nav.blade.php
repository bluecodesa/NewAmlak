<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center" data-tour="search-wrapper">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2"></i>
                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->

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



            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1" data-tour="notifications">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    {{-- <i class="ti ti-bell ti-md"></i> --}}
                    <i class="ti ti-bell ti-md"></i>
                    {{-- <i class="fa-solid fa-bell"></i> --}}
                    <span
                        class="badge bg-danger rounded-pill badge-notifications text-with-numbers">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">@lang('Notifications')</h5>
                            {{-- <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                    class="ti ti-mail-opened fs-4"></i></a> --}}
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            @foreach (Auth::user()->notifications as $noty)
                                <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded-circle bg-label-primary"><i
                                                        class="ti ti-mail{{ $noty->read_at ? '-opened' : '' }} fs-4"></i></span>
                                            </div>
                                        </div>
                                        <a href="{{ $noty->data['url'] }}" class="flex-grow-1">
                                            <h6 class="mb-1">{{ __($noty->data['type_noty']) }}</h6>
                                            <p class="mb-0">
                                                {{ \Illuminate\Support\Str::limit($noty->data['msg'], 50, $end = '...') }}
                                            </p>
                                        </a>
                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                            <a href="{{ $noty->data['url'] }}" class="dropdown-notifications-read">
                                                @if ($noty->read_at == null)
                                                    <span class="badge badge-dot"></span>
                                                @endif
                                            </a>
                                            <a href="{{ $noty->data['url'] }}"
                                                class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="dropdown-menu-footer border-top">
                        <a href="{{ route('Notification.index') }}"
                            class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                            @lang('View all')
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown" data-tour="avatar-online" >
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (Auth::user()->is_broker)
                        <img src="{{ Auth::user()->UserBrokerData->broker_logo != null ? url(Auth::user()->UserBrokerData->broker_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                        alt class="h-auto rounded-circle" />
                        @elseif(Auth::user()->is_office)
                        <img src="{{ auth()->user()->UserOfficeData->company_logo != null ? url(Auth::user()->UserOfficeData->company_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                        alt class="h-auto rounded-circle" />
                        @elseif (Auth::user()->is_employee)
                            @php
                                $employee = Auth::user()->UserEmployeeData;
                                $office_avatar = $employee->OfficeData->company_logo;
                            @endphp
                            <img src="{{ $office_avatar != null ? url($office_avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                alt class="h-auto rounded-circle" />
                        @else
                            <img src="{{ Auth::user()->avatar != null ? url(Auth::user()->avatar) : url('HOME_PAGE/img/avatars/14.png') }}"
                                alt class="h-auto rounded-circle" />
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @if (Auth::user()->is_broker)
                            <a class="dropdown-item" href="{{ route('Broker.Setting.index') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->UserBrokerData->broker_logo != null ? url(Auth::user()->UserBrokerData->broker_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                                alt class="h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">{{ __(Auth::user()->roles[0]->name ?? '') }}</small>
                                    </div>
                                </div>
                            </a>
                        @elseif(Auth::user()->is_admin)
                            <a class="dropdown-item" href="{{ route('Admin.settings.index') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ Auth::user()->avatar != null ? url(Auth::user()->avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                                alt class="h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">{{__(Auth::user()->roles[0]->name ?? '') }}</small>
                                    </div>
                                </div>
                            </a>
                        @elseif(Auth::user()->is_office)
                            <a class="dropdown-item" href="{{ route('Office.Setting.index') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ auth()->user()->UserOfficeData->company_logo != null ? url(Auth::user()->UserOfficeData->company_logo) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                                alt class="h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block">{{ Auth::user()->UserOfficeData->company_name }}</span>
                                        <small class="text-muted">{{ __(Auth::user()->roles[0]->name ?? '') }}</small>
                                    </div>
                                </div>
                            </a>
                        @elseif(Auth::user()->is_employee)
                            <a class="dropdown-item" href="{{ route('Employee.Setting.index') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            @php
                                                $employee = Auth::user()->UserEmployeeData;
                                                $office = $employee->OfficeData->company_logo;
                                            @endphp
                                            <img src="{{ $office != null ? url($office) : url('HOME_PAGE/img/avatars/14.png') }}"
                                                alt class="h-auto rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                        <small class="text-muted">{{ __(Auth::user()->roles[0]->name ?? '') }}</small>
                                    </div>
                                </div>
                            </a>
                        @endif

                    </li>


                     <!-- Account Switching -->
                     @php
                        $user = auth()->user();
                        $roles = App\Models\Role::all();
                        $activeRole = session('active_role') ?? 'Switch Account';
                        $availableRoles = $roles->filter(function ($role) use ($user, $activeRole) {
                            return $user->hasRole($role->name) && $role->name !== $activeRole;
                        });
                        if(auth()->user()->is_office){
                            $specificRoles = collect(['Owner','Renter']);

                        }else{
                            $specificRoles = collect(['Owner']);

                        }
                        // Get the roles that the user does not have yet
                        $Roles = $specificRoles->diff($availableRoles->pluck('name'));
                        $accountRoute = ($activeRole == 'Office-Admin' || $activeRole == 'RS-Broker')
                                    ? route('Admin.home')
                                    : route('PropertyFinder.home');
                    @endphp

                        @if($availableRoles->isNotEmpty())
                            @foreach ($availableRoles as $role)
                                <a class="dropdown-item" href="{{ route('switch.role', $role->name) }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-offline">
                                                <img src="{{ Auth::user()->avatar != null ? url(Auth::user()->avatar) : asset('HOME_PAGE/img/avatars/14.png') }}"
                                                    alt class="h-auto rounded-circle" />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                                            <small class="text-muted">@lang($role->name)</small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                        @if ($Roles->isNotEmpty())
                        <li><hr class="dropdown-divider"></li> <!-- Divider between roles and add new account -->
                        <li>
                            <button class="dropdown-item" id="addAccountButton">@lang('Add New Account')</button>
                        </li>
                        @endif


                        <script>
                            // Show modal when "Add New Account" is clicked
                            document.getElementById('addAccountButton').addEventListener('click', function() {
                                var addAccountModal = new bootstrap.Modal(document.getElementById('addAccountModal'), {});
                                addAccountModal.show();
                            });
                            function handleRoleRedirect(role) {
                                console.log(`Redirect to add new account for role: ${role}`);
                                // Example: window.location.href = `/add-account/${role}`;
                            }

                        </script>




                        {{-- <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="ti ti-exchange-vertical me-2 ti-sm"></i> @lang('Switch Account')
                        </a>
                        @foreach ($roles as $role)
                        @if ($userRoles->contains('name', $role->name) && $role->name !== $activeRole)
                            <li><a class="dropdown-item" href="{{ route('switch.role', $role->name) }}">@lang($role->name)</a></li>
                        @endif
                    @endforeach
                    </li>
                @endif --}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">@lang('Log Out')</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>

    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
            aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>



<div class="modal fade" id="addAccountModal" tabindex="-1" aria-labelledby="addAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <div class="text-center mb-4">
                    <h3 class="address-title mb-2">@lang('Create an account')</h3>
                </div>
                <div class="row justify-content-center">
                    <form id="roleForm" action="{{ route('Home.addAccount') }}" method="POST">
                        @csrf
                        <input type="hidden" name="key_phone"  value="{{ auth()->user()->key_phone }}">
                        <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">
                        <input type="hidden" name="full_phone" value="{{ auth()->user()->full_phone }}">

                            <input type="text" hidden class="form-control" minlength="1" maxlength="10" id="id_number" name="id_number" value="{{ auth()->user()->id_number }}"  required>

                            <input type="text" hidden class="form-control" id="email" name="email" required value="{{ auth()->user()->email }}" placeholder="@lang('Email')" autofocus>

                            <input type="text" hidden class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required placeholder="@lang('Name')" autofocus>
                            <input type="text" hidden name="account_type" id='account_type'>
                            <input type="text" hidden class="form-control" minlength="1" maxlength="10"
                            id="subscription_type_id" name="subscription_type_id" value="{{ $subscriptionType->id ?? '' }}">

                        @foreach ($Roles as $role)
                            <div class="col-md mb-md-0 mb-3">
                                <div class="form-check custom-option custom-option-icon"
                                    onclick="submitRoleForm('{{ $role }}')">
                                    <label class="form-check-label custom-option-content" for="customRadio{{ $role }}">
                                        <span class="custom-option-body">
                                            <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M24.25 33.75V23.75H16.75V33.75H6.75002V18.0469C6.7491 17.8733 6.78481 17.7015 6.85482 17.5426C6.92482 17.3838 7.02754 17.2415 7.15627 17.125L19.6563 5.76562C19.8841 5.5559 20.1825 5.43948 20.4922 5.43948C20.8019 5.43948 21.1003 5.5559 21.3281 5.76562L33.8438 17.125C33.9696 17.2438 34.0703 17.3866 34.1401 17.5449C34.2098 17.7032 34.2472 17.8739 34.25 18.0469V33.75H24.25Z" fill="currentColor" opacity="0.2"/>
                                                <path d="..." fill="currentColor"/>
                                            </svg>
                                            <span class="custom-option-title">{{ __($role) }}</span>
                                        </span>
                                        <input name="role_id" type="radio" class="form-check-input" id="customRadio{{ $role }}" value="{{ $role }}">
                                    </label>
                                </div>
                            </div>
                        @endforeach
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
