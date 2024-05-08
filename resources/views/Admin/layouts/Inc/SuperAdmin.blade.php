{{-- <div class="left side-menu" id="left-side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">@lang('dashboard')</li>
                <li>
                    <a href="{{ route('Admin.home') }}" class="waves-effect">
                        <i class="icon-accelerator"></i><span
                            class="badge badge-success badge-pill float-right">9+</span> <span> @lang('dashboard')
                        </span>
                    </a>
                </li>

                @if (Auth::user()->hasAnyOfPermissions(['read-subscribers', 'read-SubscriptionTypes', 'read-SystemInvoice']))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bank-minus"></i><span>
                                @lang('Subscriber management')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            @if (Auth::user()->hasPermission('read-subscribers'))
                                <li><a href="{{ route('Admin.Subscribers.index') }}">@lang('Subscribers')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-SubscriptionTypes'))
                                <li><a href="{{ route('Admin.SubscriptionTypes.index') }}">@lang('Subscriptions')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-SystemInvoice'))
                                <li><a href="{{ route('Admin.SystemInvoice.index') }}">@lang('Clients Bills')</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->hasAnyOfPermissions(['read-users', 'read-role', 'read-permission', 'read-sections']))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bank-minus "></i><span>
                                @lang('User management')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            @if (Auth::user()->hasPermission('read-users'))
                                <li><a href="{{ route('Admin.users.index') }}">@lang('Users')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-role'))
                                <li><a href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-permission'))
                                <li><a href="{{ route('Admin.Permissions.index') }}">@lang('Permissions')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-sections'))
                                <li><a href="{{ route('Admin.Sections.index') }}">@lang('sections')</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (Auth::user()->hasPermission('read-support-ticket-admin'))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="icon-setting-2"></i><span>
                                @lang('technical support')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            @if (Auth::user()->hasPermission('read-support-ticket-admin'))
                                <li><a href="{{ route('Admin.SupportTickets.index') }}">@lang('Tickets Support')</a></li>
                            @endif
                        </ul>
                    </li>

                @endif
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-setting-2"></i><span>
                            @lang('Settings')<span class="float-right menu-arrow"><i
                                    class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">


                        <li><a href="{{ route('Admin.settings.index') }}">@lang('General Settings')</a></li>

                        <li>
                            <a href="javascript:void(0);" class="waves-effect"><span>
                                    @lang('technical support')<span class="float-right menu-arrow"><i
                                            class="mdi mdi-chevron-right"></i></span> </span></a>
                            <ul class="submenu mm-collapse">
                                @if (Auth::user()->hasPermission('update-support-contact'))
                                    <li><a href="{{ route('Admin.Support.showInfoSupport') }}">@lang('Support contact information')</a>
                                    </li>
                                @endif
                                <li><a href="{{ route('Admin.SupportTickets.tickets-type') }}">@lang('Ticket Type')</a>
                                </li>
                            </ul>
                        </li>

                        @if (Auth::user()->hasPermission('read-regions-cities-districts'))
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><span>
                                        @lang('Cities') & @lang('districts') <span class="float-right menu-arrow"><i
                                                class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="submenu mm-collapse">
                                    <li><a href="{{ route('Admin.Region.index') }}">@lang('Regions')</a></li>
                                    <li><a href="{{ route('Admin.City.index') }}">@lang('Cities')</a></li>
                                    <li><a href="{{ route('Admin.District.index') }}">@lang('districts')</a></li>

                                </ul>
                            </li>
                        @endif

                        @if (Auth::user()->hasPermission('read-real-estate-settings'))
                            <li>
                                <a href="javascript:void(0);" class="waves-effect"><span>
                                        @lang('Real estate settings') <span class="float-right menu-arrow"><i
                                                class="mdi mdi-chevron-right"></i></span> </span></a>
                                <ul class="submenu mm-collapse">
                                    <li><a href="{{ route('Admin.PropertyType.index') }}">@lang('Property Types')</a></li>
                                    <li><a href="{{ route('Admin.PropertyUsage.index') }}">@lang('property usages')</a></li>
                                    <li><a href="{{ route('Admin.ServiceType.index') }}">@lang('services types')</a></li>
                                    <li><a href="{{ route('Admin.Service.index') }}">@lang('services')</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>



            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div> --}}


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('Admin.home') }}" class="app-brand-link">
            <img src="{{ url($sitting->icon) }}" alt="" width="60">
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $sitting->title }}</span> --}}
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item ">
            <a href="{{ route('Admin.home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Page 1">@lang('dashboard')</div>
            </a>
        </li>
        @if (Auth::user()->hasAnyOfPermissions(['read-subscribers', 'read-SubscriptionTypes', 'read-SystemInvoice']))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Subscriber management')">@lang('Subscriber management')</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::user()->hasPermission('read-subscribers'))
                        <li class="menu-item">
                            <a href="{{ route('Admin.Subscribers.index') }}" class="menu-link">
                                <div data-i18n="@lang('Subscribers')">@lang('Subscribers')</div>
                            </a>
                        </li>
                        @if (Auth::user()->hasPermission('read-SubscriptionTypes'))
                            <li class="menu-item">
                                <a href="{{ route('Admin.SubscriptionTypes.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Subscriptions')">@lang('Subscriptions')</div>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('read-SystemInvoice'))
                            <li class="menu-item">
                                <a href="{{ route('Admin.SystemInvoice.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Clients Bills')">@lang('Clients Bills')</div>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>
        @endif

        @if (Auth::user()->hasAnyOfPermissions(['read-users', 'read-role', 'read-permission', 'read-sections']))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="@lang('User management')">@lang('User management')</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::user()->hasPermission('read-users'))
                        <li class="menu-item">
                            <a href="{{ route('Admin.users.index') }}" class="menu-link">
                                <div data-i18n="@lang('Users')">@lang('Users')</div>
                            </a>
                        </li>
                        @if (Auth::user()->hasPermission('read-role'))
                            <li class="menu-item">
                                <a href="{{ route('Admin.roles.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Roles')">@lang('Roles')</div>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('read-permission'))
                            <li class="menu-item">
                                <a href="{{ route('Admin.Permissions.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Permissions')">@lang('Permissions')</div>
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasPermission('read-sections'))
                            <li class="menu-item">
                                <a href="{{ route('Admin.Sections.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Sections')">@lang('sections')</div>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </li>


        @endif


        <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li>
    </ul>
</aside>
