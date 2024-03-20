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


                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i
                            class="mdi mdi-bank-minus
                        "></i><span> @lang('Subscriber management')<span
                                class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('Admin.Subscribers.index') }}">@lang('Subscribers')</a></li>
                        <li><a href="{{ route('Admin.SubscriptionTypes.index') }}">@lang('Subscriptions')</a></li>
                        <li><a href="{{ route('Admin.SystemInvoice.index') }}">@lang('Clients Bills')</a></li>
                    </ul>
                </li>
                @canany(['read-users', 'read-role', 'read-permission', 'read-sections', 'read-SupportTickets'])
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-bank-minus "></i><span>
                                @lang('User management')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            @can('read-users')
                                <li><a href="{{ route('Admin.users.index') }}">@lang('Users')</a></li>
                            @endcan
                            @can('read-role')
                                <li><a href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>
                            @endcan
                            @can('read-permission')
                                <li><a href="{{ route('Admin.Permissions.index') }}">@lang('Permissions')</a></li>
                            @endcan
                            @can('read-sections')
                                <li><a href="{{ route('Admin.Sections.index') }}">@lang('sections')</a></li>
                            @endcan
                            @can('read-SupportTickets')
                                <li><a href="{{ route('Admin.SupportTickets.index') }}">@lang('Technical Support Orders')</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="icon-setting-2"></i><span>
                            @lang('Settings')<span class="float-right menu-arrow"><i
                                    class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        @can('read-settings-admin')
                            <li><a href="{{ route('Admin.settings.index') }}">@lang('General Settings')</a></li>
                        @endcan
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
