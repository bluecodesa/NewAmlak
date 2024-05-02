<div class="left side-menu" id="left-side-menu">
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

                {{--
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class=" icon-setting-2"></i><span>
                            @lang('project management')<span class="float-right menu-arrow"><i
                                    class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('Admin.Developer.index') }}">@lang('developers')</a></li>
                        <li><a href="{{ route('Admin.Advisor.index') }}">@lang('advisors')</a></li>
                        <li><a href="{{ route('Admin.Owner.index') }}">@lang('owners')</a></li>
                        <li><a href="{{ route('Admin.Employee.index') }}">@lang('employees')</a></li>
                    </ul>
                </li> --}}


            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
