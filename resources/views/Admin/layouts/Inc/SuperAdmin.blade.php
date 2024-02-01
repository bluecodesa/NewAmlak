<div class="left side-menu">
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
                        <li><a href="{{ route('Admin.SubscriptionTypes.index') }}">@lang('Subscriptions')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i
                            class="mdi mdi-bank-minus
                        "></i><span> @lang('User management')<span
                                class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('Admin.users.index') }}">@lang('User management')</a></li>
                        <li><a href="{{ route('Admin.Sections.index') }}">@lang('sections')</a></li>
                        @can('read-Permissions')
                            <li><a href="{{ route('Admin.Permissions.index') }}">@lang('Permissions')</a></li>
                        @endcan
                        <li><a href="{{ route('Admin.roles.index') }}">@lang('Roles')</a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i
                            class=" icon-setting-2
                        "></i><span> @lang('Settings')<span
                                class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('Admin.settings.index') }}">@lang('Settings')</a></li>

                    </ul>
                </li>
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
