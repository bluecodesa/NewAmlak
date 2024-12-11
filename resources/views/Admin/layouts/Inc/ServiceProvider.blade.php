
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

    <a href="{{ route('ServiceProvider.home') }}" class="app-brand-link">
                <img src="{{ url(LaravelLocalization::getCurrentLocale() === 'ar' ? $sitting->icon_ar : $sitting->icon_en) }}" width="80" alt="">
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
            <a href="{{ route('ServiceProvider.home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Page 1">@lang('dashboard')</div>
            </a>
        </li>


            <li class="menu-item" data-tour="customer-management">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Customer Management')">@lang('Customer Management')</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('Office.Renter.index') }}" class="menu-link">
                            <div data-i18n="@lang('Renter Management')">@lang('Renter Management')</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('Office.Owner.index') }}" class="menu-link">
                            <div data-i18n="@lang('Owners Management')">@lang('Owners Management')</div>
                        </a>
                    </li>
                </ul>
            </li>



            <li class="menu-item" data-tour="maintenance-operation-managment">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    {{-- <i class="menu-icon tf-icons ti ti-smart-home"></i> --}}
                    <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                    <div data-i18n="@lang('Maintenance and operation management')">@lang('Maintenance and operation management')</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="@lang('Requests dashboard')">@lang('Requests dashboard')</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('ServiceProvider.ProviderService.index') }}" class="menu-link">
                            <div data-i18n="@lang('Requests List')">@lang('Services')</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="@lang('Requests List')">@lang('Requests List')</div>
                        </a>
                    </li>

                </ul>
            </li>

        <li class="menu-item">
            <a href="javascript:void(0);"  data-tour="technical-support" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-layout-kanban"></i>
                <div data-i18n="@lang('technical support')">@lang('technical support')</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" data-tour="technical-support">
                    <a href="{{ route('Office.Tickets.index') }}" class="menu-link">
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


            <li class="menu-item" data-tour="settings">
                <a href="{{ route('ServiceProvider.Setting.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-app-window"></i>
                    <div data-i18n="@lang('Settings')">@lang('Settings')</div>
                </a>
            </li>

        {{-- <li class="menu-item">
            <a href="page-2.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div data-i18n="Page 2">Page 2</div>
            </a>
        </li> --}}
    </ul>
</aside>
