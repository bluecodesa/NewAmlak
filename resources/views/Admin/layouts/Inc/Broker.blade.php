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
            <img src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" width="80" alt="">
            {{-- <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">{{ $sitting->title }}</span> --}}
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
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Page 1">@lang('dashboard')</div>
            </a>
        </li>
        @if (in_array(15, $sectionsIds))
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-building"></i>
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
                    <i class="menu-icon tf-icons ti ti-camera"></i>
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

                @if (Auth::user()->hasPermission('read-requests-interest'))
                <li class="menu-item">
                    <a href="{{ route('Broker.RealEstateRequest.index') }}" class="menu-link">
                        <div data-i18n="@lang('Real Estate Requests')">@lang('Real Estate Requests')</div>
                    </a>
                </li>
            @endif

                @if (Auth::user()->hasPermission('read-requests-interest'))
                <li class="menu-item">
                    <a href="{{ route('Broker.Gallery.InteractiveMap') }}" class="menu-link">
                        <div data-i18n="@lang('Interactive Map')">@lang('Interactive Map')</div>
                    </a>
                </li>
            @endif


                </ul>
            </li>
        @endif

        @if (in_array(16, $sectionsIds))
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                <div data-i18n="@lang('Customer Management')">@lang('Customer Management')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('Broker.Owner.index') }}" class="menu-link">
                        <div data-i18n="@lang('Owners Management')">@lang('Owners Management')</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        @if (in_array(34, $sectionsIds))
            <li class="menu-item">
                <a href="{{ route('Broker.ShowSubscription') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Reports and advanced search')">@lang('Reports and advanced search')</div>
                </a>
            </li>
        @endif
        @if (in_array(12, $sectionsIds))
            <li class="menu-item">
                <a href="{{ route('Broker.ShowSubscription') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-invoice"></i>
                    <div data-i18n="@lang('Subscription Management')">@lang('Subscription Management')</div>
                </a>
            </li>
        @endif
        @if (in_array(11, $sectionsIds))
            {{-- <li class="menu-item">
                <a href="{{ route('Broker.Tickets.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-ticket"></i>
                    <div data-i18n="@lang('technical support')">@lang('technical support')</div>
                </a>
            </li> --}}
            <li class="menu-item">
                <a href="javascript:void(0);"  data-tour="technical-support" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('technical support')">@lang('technical support')</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item" data-tour="technical-support">
                        <a href="{{ route('Broker.Tickets.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                            <div data-i18n="@lang('Tickets Support')">@lang('Tickets Support')</div>
                        </a>
                    </li>
                    @if (Auth::user()->hasPermission('service-request'))
                        <li class="menu-item">
                            <a href="tel:+{{ $sitting->full_phone }}" class="menu-link">
                                <div data-i18n="@lang('For help contact')">
                                    <i class="ti ti-phone ti-md"></i>@lang('اتصال')
                                </div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item">
                        <a href="https://wa.me/{{ $sitting->full_phone }}" class="menu-link" target="_blank">
                            <div data-i18n="@lang('For help send to')">
                                <i class="ti ti-brand-whatsapp ti-md"></i> @lang('واتس اب')
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (in_array(9, $sectionsIds))
            <li class="menu-item">
                <a href="{{ route('Broker.Setting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
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
