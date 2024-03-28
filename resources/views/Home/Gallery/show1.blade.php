@extends('Admin.layouts.app')
@section('title', __('Gallary'))
@section('content')




    <div class="content-page">
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
                                <a href="{{ route('Admin.home') }}">
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
        <!-- Start content -->
        <div class="content">
            <div class="container-fluid">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <h4 class="page-title">
                                @lang('Gallary')</h4>
                        </div>



                    </div> <!-- end row -->
                </div>
                <!-- end page-title -->

                <div class="row">

                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">

                                <div class="first-div">
                                    <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid">
                                </div>

                                                                    <!-- Content of the first div -->



                                                                    <div class="col-xl-12">
                                                                        <div class="card m-b-30">
                                                                            <div class="card-body">


                                                                         <!-- Content of the first div -->
                                                                         <form action="{{ route('Broker.Gallery.index') }}" method="GET" id="subscriptionsForm">
                                                                            <div class="row">
                                                                                <div class="w-auto col-4">
                                                                                    <span>@lang('Ad type')</span>
                                                                                    <select class="form-control form-control-sm" id="ad_type_filter" name="ad_type_filter">
                                                                                        @foreach (['rent', 'sale', 'rent_sale'] as $type)
                                                                                            <option value="{{ $type }}">{{ __($type) }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                {{-- <div class="w-auto col-4">
                                                                                    <span>@lang('Type use')</span>
                                                                                    <select class="form-control form-control-sm" id="type_use_filter" name="type_use_filter">
                                                                                        @foreach (['سكني', 'تجاري'] as $usage)
                                                                                            <option value="{{ $usage }}">{{ $usage}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div> --}}
                                                                                <div class="w-auto col-4">
                                                                                    <span>@lang('city')</span>
                                                                                    <select class="form-control form-control-sm" id="city_filter" name="city_filter">
                                                                                        <option value="">All Cities</option>
                                                                                        @foreach ($units as $unit)
                                                                                        <option value="{{ $unit->CityData->id }}">{{ $unit->CityData->name }}</option>
                                                                                    @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                {{-- <div class="w-auto col-4">
                                                                                    <span>@lang('districts')</span>
                                                                                    <select class="form-control form-control-sm" id="district_filter" name="district_filter">
                                                                                        <option value="">All Districts</option>
                                                                                        @foreach ($units as $unit)
                                                                                    @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="w-auto col-4">
                                                                                    <span>@lang('Project')</span>
                                                                                    <select class="form-control form-control-sm" id="project_filter" name="project_filter">
                                                                                        <option value="">All Projects</option>
                                                                                        @foreach ($projects as $projectId => $projectName)
                                                                                            <option value="{{ $projectId }}">{{ $projectName }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div> --}}
                                                                                <div class="w-auto text-center col-12">
                                                                                    <button type="submit" class="w-auto btn btn-primary mt-2 btn-sm">Filter</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                        <div class="col-xl-12">
                                                                            <div class="card timeline shadow m-b-30">
                                                                                <div class="card-body">

                                                                        <ul class="nav nav-pills nav-justified" role="tablist">
                                                                            <li class="nav-item waves-effect waves-light">
                                                                                <a id="v-pills-menu-tab" class="nav-link active" data-toggle="tab" href="#home-1" role="tab" data-target="#v-pills-menu" aria-controls="v-pills-menu">
                                                                                    <span class="d-none d-md-block">@lang('Menu')</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item waves-effect waves-light">
                                                                                <a id="v-pills-List-tab" class="nav-link" aria-controls="v-pills-List" data-target="#v-pills-List" data-toggle="tab" href="#profile-1" role="tab">
                                                                                    <span class="d-none d-md-block">@lang('List')</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>


                                <div class="col-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-menu" role="tabpanel" aria-labelledby="v-pills-menu-tab">
                                            <div class="row">
                                                @foreach ($units as $index => $unit)
                                                <div class="col-md-6">
                                                    <div class="card timeline shadow mb-4">
                                                        <div class="card-body">
                                                            <h5><i class="fas fa-heart" data-toggle="modal" data-target="#lovePopup{{ $unit->id }}"></i></h5>
                                                            <h5 class="card-title">{{ __('Residential number') }}: {{ $unit->number_unit ?? '' }}</h5>
                                                            <p class="card-text">{{ __('الاشغال') }}: الاشغال</p>
                                                            <p class="card-text">{{ __('Ad type') }}: {{ __($unit->type) ?? '' }}</p>
                                                            <p class="card-text">{{ __('city') }}: {{ $unit->CityData->name ?? '' }}</p>
                                                            <p class="card-text">{{ __('Show in Gallery') }}: {{ $unit->show_gallery == 1 ? __('Show') : __('hide') }}</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="btn-group">
                                                                    <a class="share btn btn-outline-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#shareLinkUnit{{ $unit->id }}"
                                                                        href="" onclick="document.querySelector('#shareLinkUnit{{ $unit->id }} ul.share-tabs.nav.nav-tabs li:first-child a').click()">
                                                                        @lang('Share')</a>
                                                                    <a href="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" class="btn btn-sm btn-outline-warning">@lang('Show')</a>
                                                                    <a href="{{ route('Broker.Unit.edit', $unit->id) }}" class="btn btn-sm btn-outline-info">@lang('Call')</a>
                                                                    <a href="{{ route('Broker.Unit.edit', $unit->id) }}" class="btn btn-sm btn-outline-success">@lang('Whats app')</a>
                                                                </div>
                                                                <small class="text-muted">{{ $index + 1 }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>

                                        </div>


                                        <!-- Love Popup/Modal -->
                                            <div class="modal fade" id="lovePopup{{ $unit->id }}" tabindex="-1" aria-labelledby="lovePopupLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="lovePopupLabel">Record Name and Phone Number</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form to record name and phone number -->
                                                            <form>
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="phone">Phone Number</label>
                                                                    <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                  <!-- Love Popup/Modal -->

                                        @foreach ($units as $index => $unit)

                                        <div class="modal fade" id="shareLinkUnit{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="shareLinkTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="col-6">

                                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-light active">
                                                                <input type="radio" name="options" id="option1" checked=""> مشاركه الرابط
                                                            </label>
                                                            <label class="btn btn-light">
                                                                <input type="radio" name="options" id="option2"> QR Code
                                                            </label>

                                                            </div>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                    <div class="modal-body share-divs">
                                                        <div id="shareLinkUnit{{ $unit->id }}" class="first">
                                                            <h6>مشاركة الرابط</h6>
                                                            <p>مشاركة لينك العقار او انسخه في موقعك</p>

                                                            <div class="row link justify-content-between">
                                                                <div class="w-auto" onclick="copy()" style="cursor: pointer"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="20.782" height="30.633"
                                                                        viewBox="1039.055 450.797 19.891 24.817">
                                                                        <g data-name="copy">
                                                                            <path
                                                                                d="M1044.82 450.851c-.543.204-.941.558-1.18 1.049-.198.422-.237.975-.082 1.233.258.412.923.422 1.194.014.044-.068.093-.228.117-.354.044-.282.121-.418.3-.524.122-.068.685-.078 6.04-.078 6.51 0 6.068-.02 6.257.291.073.127.078.85.078 8.554 0 8.242 0 8.417-.097 8.568-.112.184-.214.242-.49.286-.433.063-.675.33-.675.738 0 .238.16.49.388.607.136.068.233.082.476.058a1.977 1.977 0 0 0 1.728-1.36c.073-.227.077-.96.068-8.98l-.015-8.738-.15-.315a2.059 2.059 0 0 0-.942-.942l-.316-.15-6.262-.01c-5.073-.005-6.296.005-6.437.053Z"
                                                                                fill="#497aac" fill-rule="evenodd" data-name="Path 29137" />
                                                                            <path
                                                                                d="M1040.616 455.152c-.694.141-1.262.65-1.49 1.335-.073.228-.077.961-.068 8.98l.015 8.739.15.315c.194.403.54.748.942.942l.316.15H1053.102l.315-.15c.403-.194.748-.539.942-.942l.15-.315.015-8.748c.01-8.68.01-8.748-.087-9.01-.214-.572-.612-.99-1.15-1.208l-.282-.112-6.092-.01c-3.35 0-6.185.015-6.297.034Zm12.238 1.471c.287.19.272-.335.272 8.777 0 7.505-.01 8.369-.077 8.514-.156.335.237.316-6.258.316-6.47 0-6.087.02-6.257-.306-.078-.146-.083-.781-.068-8.612l.015-8.451.116-.126a.73.73 0 0 1 .267-.17c.087-.03 2.67-.044 6-.039 5.583.01 5.86.015 5.99.097Z"
                                                                                fill="#497aac" fill-rule="evenodd" data-name="Path 29138" />
                                                                        </g>
                                                                    </svg></div>
                                                                    <input readonly class="w-75" style="text-align: left" id="share-url" value="{{ env('APP_URL') }}/ar/gallery/{{ $gallery->gallery_name }}/{{ $unit->id }}" />
                                                            </div>


                                                                {{-- <input readonly class="w-75" style="text-align: left" id="share-url"
                                                                    value="{{ route('Broker.Gallery.index', $gallery->gallery_name.'/'.$unit->id) }}" />
                                                            </div> --}}
                                                        </div>


                                                    </div>

                                                </div><!-- /.modal-content -->

                                            </div><!-- /.modal-dialog -->

                                        </div><!-- /.modal -->
                                        @endforeach
                                        </div>



                                    <div class="tab-pane fade" id="v-pills-List" role="tabpanel" aria-labelledby="v-pills-List-tab">
                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="card m-b-30">
                                                    <div class="card-body">
                                                        <h4 class="card-title font-16 mt-0">الوحده</h4>
                                                        <h6 class="card-subtitle font-14 text-muted">Support card subtitle</h6>
                                                    </div>
                                                    <img class="img-fluid" src="assets/images/small/img-4.jpg" alt="Card image cap">
                                                    <div class="card-body">
                                                        <p class="card-text">Some quick example text to build on the card title and make
                                                            up the bulk of the card's content.</p>
                                                        <a href="#" class="card-link">عرض</a>
                                                        <a href="#" class="card-link">Another link</a>
                                                    </div>
                                                </div>

                                            </div><!-- end col -->
                                    </div>

                                </div>
                                </div>
                            </div>


                                            <!-- share -->




                                        <!--end share -->


                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>


    {{-- @if ($pendingPayment)
        @include('Home.Payments.pending_payment')
@endif --}}



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show the modal when the page is fully loaded
            var modal = document.getElementById('pendingPaymentModal');
            if (modal) {
                modal.classList.add('show');
                modal.style.display = 'block';
                modal.removeAttribute('aria-hidden');
            }
        });
    </script>

@endsection
