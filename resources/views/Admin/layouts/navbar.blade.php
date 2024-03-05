@auth

    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="{{ route('welcome') }}" class="logo">
                <span class="logo-light">
                    <img src="{{ url($sitting->icon) }}" width="80px" height="80px" alt="{{ $sitting->title }}"
                        style="border: 1px solid;
           border-radius: 50%;"> {{ $sitting->title }}

                </span>
                <span class="logo-sm">
                    <img src="{{ url($sitting->icon) }}" width="80px" height="80px" alt="{{ $sitting->title }}"
                        style="border: 1px solid;
           border-radius: 50%;">
                </span>
            </a>
        </div>
        <nav class="navbar-custom">
            <ul class="navbar-right list-inline float-right mb-0">

                <!-- language-->
                <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        {{ LaravelLocalization::getCurrentLocaleName() }} <span class="mdi mdi-chevron-down"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated language-switch">

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item"rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"><span>
                                    {{ $properties['native'] }} </span></a>
                        @endforeach
                    </div>
                </li>

                <!-- full screen -->
                <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                        <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                    </a>
                </li>

                <!-- notification -->
                <li class="dropdown notification-list list-inline-item">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell-outline noti-icon"></i>
                        <span
                            class="badge badge-pill badge-danger noti-icon-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg px-1">
                        <!-- item-->
                        <h6 class="dropdown-item-text">
                            @lang('Notifications')
                        </h6>
                        <div class="slimscroll notification-item-list">
                            <!-- item-->
                            @foreach (Auth::user()->notifications as $noty)
                                <a href="{{ $noty->data['url'] }}"
                                    class="dropdown-item notify-item {{ $noty->read_at ? '' : 'active' }} ">
                                    <div class="notify-icon bg-success"><i class="far fa-circle"></i></div>
                                    <p class="notify-details"><b> {{ __($noty->data['type_noty']) }} </b><span
                                            class="text-muted">
                                            {{ \Illuminate\Support\Str::limit($noty->data['msg'], 50, $end = '...') }}
                                        </span></p>
                                    <small class="text-muted">{{ $noty->created_at->diffForHumans() }}</small>
                                </a>
                            @endforeach
                        </div>
                        <!-- All-->
                        <a href="{{ route('Notification.index') }}"
                            class="dropdown-item text-center notify-all text-primary">
                            @lang('View all') <i class="fi-arrow-right"></i>
                        </a>
                    </div>
                </li>

                <li class="dropdown notification-list list-inline-item">
                    <div class="dropdown notification-list nav-pro-img">
                        <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="https://www.svgrepo.com/show/29852/user.svg" alt="user" class="rounded-circle">

                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle"></i>
                                {{ Auth::user()->name }} </a>
                            {{-- <a class="dropdown-item" href="#"><i class="mdi mdi-wallet"></i> Wallet</a> --}}
                            <a class="dropdown-item d-block" href="#"><span
                                    class="badge badge-success float-right">11</span><i class="mdi mdi-settings"></i>
                                Settings</a>
                            {{-- <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline"></i> Lock
                                screen</a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">

                                <i class="mdi mdi-power text-danger"></i>
                                تسحيل الخروج</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>

            </ul>

            <ul class="list-inline menu-left mb-0">
                <li class="float-left">
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
                <li class="d-none d-md-inline-block">
                    <form role="search" class="app-search">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" placeholder="Search..">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </li>
            </ul>

        </nav>

    </div>
    <!-- Top Bar End -->
    @if (Auth::user()->is_admin)
        @include('Admin.layouts.Inc.SuperAdmin')
    @endif
    @if (Auth::user()->is_office)
        @include('Admin.layouts.Inc.Office')
    @endif
    @if (Auth::user()->is_broker)
        @include('Admin.layouts.Inc.Broker')
    @endif
@endauth
