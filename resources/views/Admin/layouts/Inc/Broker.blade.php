@php
    $sectionsIds = Auth::user()
        ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
        ->toArray();
@endphp
{{-- <div class="left side-menu" id="left-side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">@lang('dashboard')</li>
                <li>
                    <a href="{{ route('Broker.home') }}" class="waves-effect">
                        <i class="icon-accelerator"></i><span
                            class="badge badge-success badge-pill float-right">9+</span> <span> @lang('dashboard')
                        </span>
                    </a>
                </li>
                @if (in_array(15, $sectionsIds))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class=" icon-setting-2"></i><span>
                                @lang('project management')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">

                            @if (Auth::user()->hasPermission('read-project'))
                                <li><a href="{{ route('Broker.Project.index') }}">@lang('Projects')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-building'))
                                <li><a href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                            @endif
                            @if (Auth::user()->hasPermission('read-all-units'))
                                <li><a href="{{ route('Broker.Unit.index') }}">@lang('Units')</a></li>
                            @endif

                            <li><a href="{{ route('Broker.Developer.index') }}">@lang('developers')</a></li>
                            <li><a href="{{ route('Broker.Advisor.index') }}">@lang('advisors')</a></li>
                        </ul>
                    </li>
                @endif
                @if (in_array(18, $sectionsIds))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect">
                            <i class="icon-setting-2"></i><span>@lang('Gallary Mange')
                                <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span>
                            </span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('Broker.Gallery.index') }}">@lang('Properties Gallary')</a></li>
                            @if (Auth::user()->hasPermission('read-requests-interest'))
                                <li><a href="{{ route('Broker.Gallary.showInterests') }}">@lang('Requests for interest')</a></li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (in_array(16, $sectionsIds))
                    <li>
                        <a href="{{ route('Broker.Owner.index') }}" class="waves-effect"><i
                                class=" icon-setting-2"></i><span>
                                @lang('Owners Management')<span class="float-right menu-arrow"></span> </span></a>
                    </li>
                @endif
                @if (in_array(12, $sectionsIds))
                    <li>
                        <a href="{{ route('Broker.ShowSubscription') }}" class="waves-effect"><i
                                class=" icon-setting-2"></i><span>
                                @lang('Subscription Management')<span class="float-right menu-arrow"></span> </span></a>
                    </li>
                @endif

                @if (in_array(11, $sectionsIds))
                    <li>
                        <a href="{{ route('Broker.Tickets.index') }}" class="waves-effect"><i
                                class=" icon-setting-2"></i><span>
                                @lang('technical support')<span class="float-right menu-arrow"></span> </span></a>

                    </li>
                @endif


                @if (in_array(9, $sectionsIds))
                    <li>
                        <a href="{{ route('Broker.Setting.index') }}" class="waves-effect"><i
                                class=" icon-setting-2"></i><span>
                                @lang('Settings')<span class="float-right menu-arrow"></a>

                    </li>
                @endif

            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div> --}}


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- <a href="{{ route('Admin.home') }}" class="app-brand-link">
            <img src="{{ url($sitting->icon) }}" alt="" width="60">
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $sitting->title }}</span> --}}
        {{-- </a> --}}

        <a href="{{ route('Broker.home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                        fill="#7367F0" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                        fill="#161616" />
                    <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                        d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                        fill="#161616" />
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                        fill="#7367F0" />
                </svg>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ $sitting->title }}</span>
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
        @if (in_array(15, $sectionsIds))
        <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('project management')">@lang('project management')</div>
                </a>
                <ul class="menu-sub">
                    @if (Auth::user()->hasPermission('read-project'))
                        <li class="menu-item">
                            <a href="{{ route('Broker.Project.index') }}" class="menu-link">
                                <div data-i18n="@lang('Projects')">@lang('Projects')</div>
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('read-building'))
                        <li class="menu-item">
                                <a href="{{ route('Broker.Property.index') }}" class="menu-link">
                                    <div data-i18n="@lang('properties')">@lang('properties')</div>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasPermission('read-all-units'))
                        <li class="menu-item">
                                <a href="{{ route('Broker.Unit.index') }}" class="menu-link">
                                    <div data-i18n="@lang('Units')">@lang('Units')</div>
                                </a>
                            </li>
                        @endif
                        <li class="menu-item">
                                <a href="{{ route('Broker.Developer.index') }}" class="menu-link">
                                    <div data-i18n="@lang('developers')">@lang('developers')</div>
                                </a>
                            </li>
                        <li class="menu-item">
                            <a href="{{ route('Broker.Advisor.index') }}" class="menu-link">
                                <div data-i18n="@lang('advisors')">@lang('advisors')</div>
                            </a>
                        </li>
                </ul>
            </li>
        @endif

        @if (in_array(18, $sectionsIds))
        <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Gallary Mange')">@lang('Gallary Mange')</div>
                </a>
                <ul class="menu-sub">
                        <li class="menu-item">
                            <a href="{{ route('Broker.Gallery.index') }}" class="menu-link">
                                <div data-i18n="@lang('Properties Gallary')">@lang('Properties Gallary')</div>
                            </a>
                        </li>

                        @if (Auth::user()->hasPermission('read-requests-interest'))                        <li class="menu-item">
                                <a href="{{ route('Broker.Gallary.showInterests') }}" class="menu-link">
                                    <div data-i18n="@lang('Requests for interest')">@lang('Requests for interest')</div>
                                </a>
                            </li>
                        @endif

                </ul>
            </li>
        @endif

        @if (in_array(16, $sectionsIds))
        <li class="menu-item">
                <a href="{{ route('Broker.Owner.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Owners Management')">@lang('Owners Management')</div>
                </a>
            </li>
        @endif

        @if (in_array(12, $sectionsIds))
        <li class="menu-item">
                <a href="{{ route('Broker.ShowSubscription') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Subscription Management')">@lang('Subscription Management')</div>
                </a>
            </li>
        @endif
        @if (in_array(11, $sectionsIds))
        <li class="menu-item">
                <a href="{{ route('Broker.Tickets.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('technical support')">@lang('technical support')</div>
                </a>
            </li>
        @endif
        @if (in_array(9, $sectionsIds))
        <li class="menu-item">
            <a href="{{ route('Broker.Setting.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div data-i18n="@lang('Settings')">@lang('Settings')</div>
            </a>
        </li>
        @endif

        {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li> --}}
    </ul>
</aside>
