<!DOCTYPE html>
<html lang="en">
@include('Home.layouts.home.head')




<body>



    <!-- Navbar STart -->
    <header id="topnav" class="defaultscroll sticky">
        <div class="header-nav">
            <nav class="navbar navbar-expand-lg navbar-light bg-light container">
                <div class="navbar-nav align-items-start ">

                    <a class="navbar-brand" href="">
                        <img src="{{ asset('HOME_PAGE/images/amlak1.svg') }}" height="50" class="logo-light-mode"
                            alt="">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#home">عن أملاك <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">المميزات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">الباقات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">تواصل معنا</a>
                        </li>
                        @auth

                            @if (Session::has('gallery_name') && Session::has('gallery'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('galleryOffice', Session::get('gallery_name')) }}">المعرض</a>
                                </li>
                            @endif

                        @endauth
                    </ul>

                    <div class="buyh-button col-4" style="display: flex;
                    justify-content: end;">
                        @guest
                            <a href="{{ route('login') }}">
                                <div class="btn btn-new-b ArFont" style="margin-right: 9px;"> تسجيل الدخول</div>
                            </a>
                            <a href="" data-toggle="modal" data-target="#addSubscriberModal"
                                style="margin-right: 9px;" onclick="tabsFunc()">


                                <div class="btn btn-new ArFont"> سجل معنا الآن </div>
                            </a>
                        @endguest
                        @auth
                            <a href="/">
                                <div class="btn btn-new-b ArFont" style="margin-right: 9px;">لوحة التحكم</div>
                            </a>

                            <a class="btn btn-new ArFont" style="margin-right: 9px;" href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fe-log-out"></i><span style="margin-left:10px">تسجيل
                                    خروج</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>


                        @endauth
                    </div>
                </div>
        </div>

        </nav>

        </div>
        <!--end container-->
    </header>




    @yield('content')









    @include('Home.layouts.home.footer')


    @include('Home.layouts.home.footer-scripts')

    @stack('home-scripts')

    <script>
        function tabsFunc() {
            $('.nav-tabs > li a[title]').tooltip();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {

                var target = $(e.target);

                if (target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function(e) {

                var active = $('.wizard .nav-tabs li.active');
                active.next().removeClass('disabled');
                nextTab(active);

            });
            $(".prev-step").click(function(e) {
                if (document.querySelector('.alert.alert-danger'))
                    document.querySelector('.alert.alert-danger').style.display = "none"

                var active = $('.wizard .nav-tabs li.active');
                prevTab(active);

            });
        }


        function nextTab(elem) {
            $(elem).next().find('a[data-toggle="tab"]').click();
        }

        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }


        $('.nav-tabs').on('click', 'li', function() {
            $('.nav-tabs li.active').removeClass('active');
            $(this).addClass('active');
        });
    </script>

</body>

</html>
