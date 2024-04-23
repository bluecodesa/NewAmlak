@php
    $sectionsIds = Auth::user()
        ->UserBrokerData->UserSubscription->SubscriptionSectionData->pluck('section_id')
        ->toArray();
@endphp
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
                @if (in_array(15, $sectionsIds))
                    <li>
                        <a href="javascript:void(0);" class="waves-effect"><i class=" icon-setting-2"></i><span>
                                @lang('project management')<span class="float-right menu-arrow"><i
                                        class="mdi mdi-chevron-right"></i></span> </span></a>
                        <ul class="submenu">
                            <li><a href="{{ route('Broker.Project.index') }}">@lang('Projects')</a></li>
                            <li><a href="{{ route('Broker.Property.index') }}">@lang('properties')</a></li>
                            <li><a href="{{ route('Broker.Unit.index') }}">@lang('Units')</a></li>
                            <li><a href="{{ route('Broker.Developer.index') }}">@lang('developers')</a></li>
                            <li><a href="{{ route('Broker.Advisor.index') }}">@lang('advisors')</a></li>
                            {{-- <li><a href="{{ route('Broker.Owner.index') }}">@lang('owners')</a></li> --}}
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
                            @if (auth()->user()->UserBrokerData->GalleryData)
                                <li><a href="{{ route('Broker.Gallery.index') }}">@lang('Properties Gallary')</a></li>
                                <li><a href="{{ route('Broker.Gallary.showInterests') }}">@lang('Requests for interest')</a></li>
                            @else
                                <li>
                                    <a href="#v-pills-gallary" data-toggle="pill">
                                        @lang('Properties Gallary')
                                    </a>
                                </li>
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
                        {{-- <ul class="submenu">
                    <li><a href="{{ route('Broker.Tickets.index') }}">@lang('Tickets List')</a></li>
                </ul> --}}
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

</div>
