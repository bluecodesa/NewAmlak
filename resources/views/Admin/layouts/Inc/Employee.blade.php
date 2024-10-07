@php
    $sectionsIds = Auth::user()
        ->UserEmployeeData?->OfficeData->UserSubscription?->SubscriptionTypeData?->sections()
        ->pluck('section_id')
        ->toArray();
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- <a href="{{ route('Admin.home') }}" class="app-brand-link">
            <img src="{{ url($sitting->icon) }}" alt="" width="60">
            {{-- <span class="app-brand-text demo menu-text fw-bold">{{ $sitting->title }}</span> --}}
        {{-- </a> --}}

        <a href="{{ route('Office.home') }}" class="app-brand-link">
            <img src="{{ url($sitting->icon) }}" width="80" alt="">
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
                            <a href="{{ route('Employee.Project.index') }}" class="menu-link">
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
                            <a href="{{ route('Employee.Unit.index') }}" class="menu-link">
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

        @if (in_array(14, $sectionsIds))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Users management')">@lang('Users management')</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('Employee.Employee.index') }}" class="menu-link">
                            <div data-i18n="@lang('Employees')">@lang('Employees')</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (in_array(19, $sectionsIds))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Renter Management')">@lang('Renter Management')</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('Office.Renter.index') }}" class="menu-link">
                            <div data-i18n="@lang('Renters')">@lang('Renters')</div>
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

                    @if (Auth::user()->hasPermission('read-requests-interest'))
                        <li class="menu-item">
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
                <a href="{{ route('Employee.Setting.index') }}" class="menu-link">
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
