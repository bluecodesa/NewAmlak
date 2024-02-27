<div class="left side-menu" id="left-side-menu">
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



                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class=" icon-setting-2"></i><span>
                            @lang('project management')<span class="float-right menu-arrow"><i
                                    class="mdi mdi-chevron-right"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('Broker.Project.index') }}">@lang('Projects')</a></li>
                        <li><a href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                        <li><a href="{{ route('Broker.Developer.index') }}">@lang('developers')</a></li>
                        <li><a href="{{ route('Broker.Advisor.index') }}">@lang('advisors')</a></li>
                        <li><a href="{{ route('Broker.Owner.index') }}">@lang('owners')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class=" icon-setting-2"></i><span>
                            @lang('Settings')<span class="float-right menu-arrow"></a>

                </li>

            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
