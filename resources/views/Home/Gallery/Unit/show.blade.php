@extends('Home.layouts.home.app')
@section('title', __('Unit') . ' ' . $Unit->ad_name ?? ($Unit->number_unit ?? ''))
@section('content')


    <!-- Content wrapper -->
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                    <span class="text-muted fw-light"> <a href="{{ route('gallery.showAllGalleries') }}">المعرض</a>/</span>
                    وحدة : {{ $Unit->ad_name ?? ($Unit->number_unit ?? '') }}</h4>
            <input hidden type="text" name="unit_idd" value="{{ $Unit->id }}" />
            <!-- Header -->

            <!--/ Header -->

            <!-- Navbar pills -->

            <!--/ Navbar pills -->

            <!-- User Profile Content -->
            <div class="row">

                <div class="col-xl-8 col-lg-8 col-md-8">


                    <!-- Image Slider -->
                    <div class="card mb-4">
                        <div id="carouselExampleIndicators" class="carousel slide shadow-sm" data-ride="carousel">
                            <div class="carousel-inner">
                                @php $i = 0; @endphp

                                @if($Unit->UnitImages->isEmpty() && !$Unit->video)
                                    <div class="carousel-item active">
                                        <img class="d-block w-100" src="{{ asset('Offices/Projects/default.svg') }}" alt="Default slide" style="height: 350px; object-fit: contain">
                                    </div>
                                @else
                                    @foreach ($Unit->UnitImages as $media)
                                        <div class="carousel-item @if ($i == 0) active @endif">
                                            <!-- Image -->
                                            <img class="d-block w-100" data-bs-toggle="modal" data-bs-target="#mediaModal"
                                                 src="{{ asset($media->image) }}"
                                                 alt="Slide {{ $i + 1 }}"
                                                 style="height: 350px; object-fit: contain">
                                        </div>
                                        @php $i++; @endphp
                                    @endforeach
                                @endif
                            </div>

                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        {{-- Button for Download (displayed below the carousel) --}}
                        <div class="row">
                                @if($Unit->unit_masterplan)
                                <div class="col-4 btn-group mt-3">
                                    <a href="{{ $Unit->unit_masterplan }}" target="_blank" class="btn btn-primary" aria-expanded="false">
                                        <span>
                                            <i class="ti ti-download me-0 me-sm-1 ti-xs"></i>
                                            <span class="d-none d-sm-inline-block">@lang('Download') @lang('Unit Masterplan')</span>
                                        </span>
                                    </a>
                                </div>
                            @endif

                            {{-- Button to Show Video in Modal --}}
                            @if($Unit->video)
                                <div class="col-4 btn-group mt-3">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#videoModal">
                                        <span>
                                            <i class="ti ti-video me-0 me-sm-1 ti-xs"></i>
                                            <span class="d-none d-sm-inline-block">@lang('Show Video')</span>
                                        </span>
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- Modal for Showing the Video --}}
                    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="videoModalLabel">@lang('Unit Video')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <video id="modalVideo" class="d-block w-100" controls>
                                        <source src="{{ asset($Unit->video) }}" type="video/mp4">
                                        @lang('Your browser does not support the video tag.')
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Script to Play Video when Modal is Opened --}}
                    <script>
                        var videoModal = document.getElementById('videoModal');
                        var modalVideo = document.getElementById('modalVideo');

                        videoModal.addEventListener('shown.bs.modal', function () {
                            modalVideo.play();
                        });

                        videoModal.addEventListener('hidden.bs.modal', function () {
                            modalVideo.pause();
                            modalVideo.currentTime = 0; // Reset video to start
                        });
                    </script>




                    <!-- Modal -->
                    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="carouselModal" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @php $i = 0; @endphp

                                            @if($Unit->UnitImages->isEmpty() && !$Unit->video)
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100" src="{{ asset('Offices/Projects/default.svg') }}" alt="Default slide" style="height: 350px; object-fit: contain">
                                                </div>
                                            @else
                                                @foreach ($Unit->UnitImages as $media)
                                                    <div class="carousel-item @if ($i == 0) active @endif">
                                                        <!-- Image -->
                                                        <img class="d-block w-100" data-bs-toggle="modal" data-bs-target="#mediaModal"
                                                             src="{{ asset($media->image) }}"
                                                             alt="Slide {{ $i + 1 }}"
                                                             style="height: 350px; object-fit: contain">
                                                    </div>
                                                    @php $i++; @endphp
                                                @endforeach

                                                {{-- @if ($Unit->video)
                                                    <div class="carousel-item @if ($i == 0) active @endif">
                                                        <video controls class="d-block w-100" style="height: 350px; object-fit: contain">
                                                            <source src="{{ asset($Unit->video) }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                    </div>
                                                    @php $i++; @endphp
                                                @endif --}}
                                            @endif
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselModal" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselModal" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /Image Slider -->


                    <!--/ Activity Timeline -->
                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">تفاصيل الوحدة</h5>

                        </div>
                        @if($Unit->note)

                        <div class="card-body pb-0">
                            <div id="project-description-short">
                                {!! Str::limit(strip_tags($Unit->note ?? ''), 500, '...') !!}
                                <a href="javascript:void(0);" id="read-more-btn" onclick="toggleReadMore()">Read More</a>
                            </div>
                            <div id="project-description-full" style="display: none;">
                                {!! $Unit->note ?? '' !!}
                                <a href="javascript:void(0);" id="read-less-btn" onclick="toggleReadMore()">Read Less</a>
                            </div>
                        </div>
                        @endif
                        <div class="card-body pb-0">


                            <div class="align-items-center justify-content-start my-3 gap-2">
                                @if ($Unit->rooms)
                                    <a href="javascript:;"><span class="badge bg-label-primary">@lang('number rooms') :
                                            {{ $Unit->rooms }}</span></a>
                                @endif
                                @if ($Unit->bathrooms)
                                    <a href="javascript:;"><span class="badge bg-label-warning">@lang('Number bathrooms') :
                                            {{ $Unit->bathrooms }}</span></a>
                                @endif
                                @if ($Unit->space)
                                    <a href="javascript:;"><span class="badge bg-label-success">@lang('Area (square metres)') :
                                            {{ $Unit->space }}</span></a>
                                @endif


                                <a href="javascript:;"><span class="badge bg-label-info"><i class="ti ti-eye"></i>
                                        {{ $unitVisitorsCount ?? 0 }}</span></a>

                                <a href="javascript:;" class="me-1"
                                    style="
                         @if (!$Unit->daily_rent) visibility:hidden @endif">
                                    <span class="badge bg-label-secondary">متاح @lang('Daily Rent')</span></a>
                            </div>

                            @if ($Unit->UnitFeatureData->isNotEmpty() && $Unit->UnitFeatureData->whereNotNull('qty')->isNotEmpty())
                                <ul class="list-unstyled mb-4 mt-3">
                                    <h5 class="card-action-title mb-0">@lang('Additional details')</h5>
                                    <div class="d-flex align-items-center justify-content-start my-3 gap-2">
                                        <ol class="list-group list-group-numbered">
                                            @foreach ($Unit->UnitFeatureData as $feature)
                                                @if ($feature->qty)
                                                    <span>{{ $feature->FeatureData->name ?? '' }} :
                                                        {{ $feature->qty }}</span>
                                                @endif
                                            @endforeach
                                        </ol>
                                    </div>

                                </ul>
                            @endif


                            @if ($Unit->UnitServicesData->isNotEmpty())
                                <ul class="list-unstyled mb-4 mt-3">
                                    <h5 class="card-action-title mb-0">@lang('Amenities')</h5>
                                    <div class="demo-inline-spacing">
                                        @foreach ($Unit->UnitServicesData as $service)
                                            <span
                                                class="badge rounded-pill bg-primary">{{ $service->ServiceData->name ?? '' }}</span>
                                        @endforeach
                                    </div>
                                </ul>
                            @endif
                        </div>
                    </div>
                    {{-- @if($Unit->unit_masterplan)

                    <div class="card card-action mb-4">
                        <div class="card-header align-items-center">
                            <h5 class="card-action-title mb-0">مخطط الوحدة</h5>
                        </div>

                        <div class="card-body pb-0">
                            @if (Str::endsWith($Unit->unit_masterplan, '.pdf'))
                                <embed src="{{ $Unit->unit_masterplan }}" type="application/pdf" width="100%" height="500px" />
                            @else
                                <img src="{{ $Unit->unit_masterplan }}" class="img-fluid" alt="Unit Masterplan">
                            @endif
                        </div>
                    </div>
                    @endif --}}

                </div>

                <div class="col-xl-4 col-lg-4 col-md-4">
                    <!-- About User -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <small class="card-text text-uppercase">@lang('عن المسوق العقاري')</small>
                            <ul class="list-unstyled mb-4 mt-3">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="ti ti-check text-heading"></i><span class="fw-medium mx-2 text-heading">
                                    </span> <span>{{ $brokers->name }}</span>
                                </li>
                                @if ($brokers->is_broker)
                                    <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i>
                                        @lang('Broker')</li>
                                @else
                                    <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i>
                                        @lang('Office')</li>
                                @endif
                                <li class="list-inline-item d-flex gap-1">
                                    <i class="ti ti-color-swatch"></i>رقم رخصة فال : {{ $broker->broker_license }}
                                </li>

                                <li class="list-inline-item d-flex gap-1">
                                    @php
                                        $createdAt = new DateTime($brokers->created_at);

                                        // Get the month name
                                        $monthName = $createdAt->format('F');

                                        // Get the number of days in the month
                                        $numDay = $createdAt->format('d');
                                        $yearName = $createdAt->format('Y');

                                    @endphp
                                    <i class="ti ti-calendar"></i> عضو منذ {{ $monthName }} {{ $numDay }}
                                    {{ $yearName }}
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!--/ About User -->
                    <!-- Profile Overview -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <small class="card-text text-uppercase">@lang('عن الوحدة')</small>
                            <ul class="list-unstyled mb-4 mt-3">
                                <li class="d-flex align-items-center mb-3">
                                    <i class="ti ti-check text-heading"></i><span
                                        class="fw-medium mx-2 text-heading">@lang('Residential number') :
                                    </span> <span>{{ $Unit->number_unit }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <i class="ti ti-droplet-dollar text-heading"></i>
                                    @if ($Unit->type == 'rent')
                                        <span class="fw-medium mx-2 text-heading">{{ __($Unit->type) }} - </span>
                                        <span>{{ $Unit->getRentPriceByType() }}
                                            <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}</span>
                                    @endif
                                    @if ($Unit->type == 'sale')
                                        <span class="fw-medium mx-2 text-heading">{{ __($Unit->type) }} - </span>
                                        <span>{{ $Unit->price }}
                                            <sup>@lang('SAR') </span>
                                    @endif
                                    @if ($Unit->type == 'rent and sale')
                                        <span class="fw-medium mx-2 text-heading">{{ __($Unit->type) }} - </span>
                                        <span>{{ $Unit->getRentPriceByType() }}
                                            <sup>@lang('SAR') / {{ __($Unit->rent_type_show) }}</span>
                                    @endif
                                </li>

                                <li class="d-flex align-items-center mb-3">
                                    <i class="ti ti-building text-heading"></i><span
                                        class="fw-medium mx-2 text-heading">@lang('Property type') : </span>
                                    <span>{{ $Unit->PropertyTypeData->name ?? '' }}</span>
                                </li>

                                <div class="d-flex justify-content-center">
                                    <a href="javascript:;" class="btn btn-outline-primary btn-sm waves-effect me-2"
                                        data-bs-toggle="modal" data-bs-target="#twoFactorAuth">@lang('Share')</a>


                                    {{-- intrest unit --}}
                                    @auth

                                        <form action="{{ route('unit_interests.store') }}" method="POST">
                                            @csrf

                                            <input hidden name="unit_id" value="{{ $Unit->id }}" />
                                            <input hidden name="user_id" value="{{ $Unit->BrokerData->user_id }}" />
                                            <input hidden name="finder_id" value="{{ auth()->user()->id }}" />
                                            <input hidden name="interested_id" value="{{ auth()->user()->id }}" />
                                            <input hidden type="text" name="key_phone" hidden
                                                value="{{ auth()->user()->key_phone }}" id="key_phone">
                                            <input hidden type="text" name="full_phone" hidden id="full_phone"
                                                value="{{ auth()->user()->full_phone }}">
                                            <input hidden name="name" value="{{ auth()->user()->name }}" />
                                            <input hidden name="whatsapp" value="{{ auth()->user()->phone }}" />


                                            <button type="submit" {{ $CheckUnitExist == false ? '' : 'disabled' }}
                                                class="btn btn-primary">
                                                {{ $CheckUnitExist == false ? ' تسجيل اهتمام' : 'تم تسجيل اهتمام' }}
                                            </button>
                                        </form>

                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}" type="submit" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalToggle">
                                            تسجيل اهتمام
                                        </a>

                                    @endguest

                                    <!-- Modal -->

                                    <!-- Modal -->
                                    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('unit_interests.store') }}" method="POST">
                                                @csrf
                                                <input type="text" name="key_phone" hidden value="966"
                                                    id="key_phone">
                                                <input type="text" name="full_phone" hidden id="full_phone"
                                                    value="966">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel1">تسجيل اهتمام</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <input hidden name="unit_id" value="{{ $unit_id }}" />
                                                        <input hidden name="user_id" value="{{ $user_id }}" />
                                                        <div class="row">
                                                            <div class="col mb-3">
                                                                <label for="nameBasic"
                                                                    class="form-label">@lang('Name')<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="nameBasic" name="name"
                                                                    required class="form-control"
                                                                    placeholder="ادخل اسمك" />
                                                            </div>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col mb-0">
                                                                <label for="emailBasic"
                                                                    class="form-label">@lang('mobile')<span
                                                                        class="text-danger">*</span></label>

                                                                <div class="input-group">
                                                                    <input type="text" placeholder="123456789"
                                                                        id="phone" name="whatsapp" value=""
                                                                        class="form-control" maxlength="9"
                                                                        pattern="\d{1,9}" oninput="updateFullPhone(this)"
                                                                        aria-label="Text input with dropdown button">
                                                                    <button
                                                                        class="btn btn-outline-primary dropdown-toggle waves-effect"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        966
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                                        style="">
                                                                        <li><a class="dropdown-item" data-key="971"
                                                                                href="javascript:void(0);">971</a></li>
                                                                        <li><a class="dropdown-item" data-key="966"
                                                                                href="javascript:void(0);">966</a></li>
                                                                    </ul>

                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-label-secondary"
                                                            data-bs-dismiss="modal">
                                                            @lang('close')
                                                        </button>
                                                        <button type="submit"
                                                            class="btn btn-primary">@lang('save')</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    {{-- .Modal --}}

                                </div>
                            </ul>
                        </div>
                    </div>
                    @if ($Unit->ad_license_number)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-action-title mb-0">@lang('Ad License Information')</h5>
                                    <div class="demo-inline-spacing mt-3">
                                        <ul class="list-group">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    @lang('Ad License Number')
                                                    <span>{{ __($Unit->ad_license_number ?? '' ) }}</span>
                                                </li>
                                                <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                @lang(' صلاحية الاعلان')
                                                <span class="badge bg-primary">
                                                    {{ __($Unit->ad_license_status) }}
                                                </span>
                                                </li>
                                                @auth
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a class=" d-flex align-items-center me-3"
                                                     href="" data-bs-toggle="modal"
                                                     data-bs-target="#modalReport" >
                                                    <i class="ti ti-report ti-sm"></i>
                                                        @lang('الابلاغ عن الاعلان')
                                                    </a>
                                                  </li>
                                                @endauth
                                                @guest
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a class=" d-flex align-items-center me-3"
                                                    href="{{ route('login') }}">
                                                   <i class="ti ti-report ti-sm"></i>
                                                       @lang('الابلاغ عن الاعلان')
                                                   </a>
                                                  </li>
                                                @endguest


                                        </ul>
                                    </div>
                                </div>
                    </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="leaflet-map" id="userLocation"></div>
                            <iframe width="100%" style="border-radius: 10px;" height="200" frameborder="0"
                                style="border:0"
                                src="https://www.google.com/maps/embed/v1/place?q={{ $Unit->lat_long }}&amp;key=AIzaSyAzFIgHaU5mzPcf16Qf3sdi0ioKqOKoy6E"></iframe>
                        </div>
                    </div>
                    <!--/ Profile Overview -->
                </div>
            </div>
            <!--/ User Profile Content -->
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <hr>
        <div class="container">
            <h4>المزيد من الوحدات</h4>
            <div class="row g-4">
                    @foreach ($moreUnits as $unit)
                    @if ($unit->BrokerData->license_validity == 'valid' && $unit->ad_license_status == 'Valid')
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card h-200">
                                <div class="card-body text-center">
                                    <div class="dropdown btn-pinned">
                                            <span class="pb-1">
                                                {{ $unit->getRentPriceByType() }} @lang('SAR') / {{ __($unit->rent_type_show) }}
                                            </span>

                                    </div>

                                    <div class="d-flex align-items-center justify-content-start">
                                        <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#onboardHorizontalImageModal{{ $unit->id }}"><i
                                                class="ti ti-share ti-sm"></i></a>
                                        @guest

                                            {{-- <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                data-bs-toggle="modal" data-bs-target="#modalToggle">
                                                <i class="ti ti-heart ti-sm"></i>

                                            </a> --}}

                                            <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                             href="{{ route('login') }}">
                                            <i class="ti ti-heart ti-sm"></i>

                                            </a>
                                            {{-- <a class=" d-flex align-items-center me-3"
                                             href="{{ route('login') }}">
                                            <i class="ti ti-report ti-sm"></i>
                                                @lang('الابلاغ عن الاعلان')
                                            </a> --}}

                                        @endguest


                                        @auth
                                        @if (auth()->user())
                                            @php
                                                $isFavorite = App\Models\FavoriteUnit::where('unit_id', $unit->id)->orwhere('property_id', $unit->id)->orwhere('project_id', $unit->id)
                                                    ->where('finder_id', auth()->user()->id)
                                                    ->exists();

                                                // Determine the type (unit, property, or project)
                                                $type =  'unit' ;
                                            @endphp
                                                @if (Auth::user()->hasPermission('Add-property-as-favorite') ||
                                                        Auth::user()->hasPermission('Add-property-as-favorite-admin'))
                                                    @if ($isFavorite)
                                         <form method="POST" action="{{ route('remove-from-favorites') }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-label-danger btn-icon d-flex align-items-center me-3">
                                                        <i class="ti ti-heart ti-sm"></i>
                                                    </button>
                                                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                                    <!-- Send the type as hidden input -->
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                </form>
                                            @else
                                            <form method="POST" action="{{ route('add-to-favorites') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                                                    <i class="ti ti-heart ti-sm"></i>
                                                </button>
                                                <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                                <input type="hidden" name="owner_id" value="{{ $unit->BrokerData->user_id }}">

                                                <!-- Send type as hidden input -->
                                                <input type="hidden" name="type" value="{{ $type }}">
                                            </form>
                                            @endif
                                        @endif
                                    @else
                                        <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                            data-bs-toggle="modal" data-bs-target="#basicModal"
                                            data-unit-id="{{ $unit->id }}"
                                            data-user-id="{{ $unit->BrokerData->user_id }}">
                                            <i class="ti ti-heart ti-sm"></i>
                                        </a>
                                    @endif
                                    {{-- <a class=" d-flex align-items-center me-3"
                                        href="" data-bs-toggle="modal"
                                    data-bs-target="#modalReport" >
                                    <i class="ti ti-report ti-sm"></i>
                                        @lang('الابلاغ عن الاعلان')
                                    </a> --}}
                                @endauth

                            </div>

                            <div class="mx-auto my-3">

                                    <a href="{{ route('gallery.showUnitPublic', [
                                            'gallery_name' => optional($unit->BrokerData->GalleryData)->gallery_name,
                                            'id' => $unit->id
                                        ]) }}" class="card-hover-border-default">


                                <div class="image-container" style="position: relative; width: 100%; height: 200px;">
                                    @if ($unit->UnitImages && $unit->UnitImages->isNotEmpty())
                                        <img src="{{ url($unit->UnitImages->first()->image) }}"
                                                alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                                     @else
                                        <img src="{{ url('Offices/Projects/default.svg') }}"
                                                alt="Avatar Image" class="rounded-square" style="width: 100%; height: 100%;" />
                                    @endif
                                    <div class="lable bg-label-primary" style="position: absolute; top: 10px; left: 10px; background: rgba(0, 0, 0, 0.5); color: white; padding: 5px; border-radius: 5px;">
                                            @lang('Unit')
                                    </div>
                                </div>
                                </a>
                            </div>
                            <h4 class="mb-1 card-title">

                                    <a  class="card-hover-border-default">{{ $unit->ad_name ?? ($unit->name ?? '') }}</a>

                        </h4>

                            <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                                <span class="pb-1"><i
                                        class="ti ti-map-pin"></i>{{ $unit->CityData->name ?? '' }}</span>
                            </div>


                            <div class="d-flex align-items-center justify-content-center my-3 gap-2">

                                <a href="javascript:;"><span class="badge bg-label-primary">
                                        {{ __($unit->PropertyTypeData->name) ?? '' }}</span></a>
                                @if ($unit->type == 'rent')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-warning">@lang('rent')</span></a>
                                @endif
                                @if ($unit->type == 'sale')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-success">@lang('sale')</span></a>
                                @endif

                                @if ($unit->type == 'rent and sale')
                                    <a href="javascript:;"><span
                                            class="badge bg-label-info">@lang('rent and sale')</span></a>
                                @endif
                                @if ($unit->daily_rent)
                                <a href="javascript:;" class="me-1">
                                    <span class="badge bg-label-secondary">متاح @lang('Daily Rent')</span></a>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-around my-3 py-1">
                                <div>
                                    <h4 class="mb-0">{{ $unit->rooms }}</h4>
                                    <span>@lang('number rooms')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unit->bathrooms }}</h4>
                                    <span>@lang('Number bathrooms')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unit->space }}</h4>
                                    <span>@lang('Area (m²)')</span>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                                    <span class="ti ti-eye"></span>
                                </div>
                            </div>


                            @auth
                                <div class="d-flex align-items-center justify-content-center">
                                    @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                                        <a href="tel:+{{ $broker->key_phone }} {{ $broker->mobile }}" target="_blank"
                                            class="btn btn-primary d-flex align-items-center me-3"
                                            style="color: white;"><i
                                                class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                    @else
                                        <a @disabled(true) target="_blank"
                                            class="btn btn-primary d-flex align-items-center me-3"
                                            style="color: white;"><i
                                                class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                    @endif
                                    @if (Auth::user()->hasPermission('Send-message-to-broker') ||
                                            Auth::user()->hasPermission('Send-message-to-broker-admin'))
                                        <a href="https://web.whatsapp.com/send?phone=tel:+{{ $broker->key_phone }} {{ $broker->mobile }}"
                                            target="_blank" class="btn btn-label-secondary btn-icon"><i
                                                class="ti ti-message ti-sm"></i></a>
                                    @else
                                        <a @disabled(true) target="_blank"
                                            class="btn btn-label-secondary btn-icon"><i
                                                class="ti ti-message ti-sm"></i></a>
                                    @endif
                                </div>
                            @endauth
                            @guest
                                <div class="d-flex align-items-center justify-content-center">
                                    {{-- <a target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                                        style="color: white;" data-bs-toggle="modal" data-bs-target="#modalToggle"><i
                                            class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                    <a target="_blank" class="btn btn-label-secondary btn-icon" data-bs-toggle="modal"
                                        data-bs-target="#modalToggle"><i class="ti ti-message ti-sm"></i></a> --}}
                                        <a target="_blank" class="btn btn-primary d-flex align-items-center me-3"
                                        style="color: white;" href="{{ route('login') }}"><i
                                            class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                    <a target="_blank" class="btn btn-label-secondary btn-icon" href="{{ route('login') }}"><i class="ti ti-message ti-sm"></i></a>
                                </div>
                            @endguest

                        </div>
                    </div>
                </div>

                @include('Home.Gallery.inc.share')
                @include('Home.Gallery.inc.unitInterest')
                        {{-- @include('Home.Gallery.inc._ad-report') --}}

                        @endif
                    @endforeach

                {{ $moreUnits->links() }}

            </div>

        </div>


    </section>



    @include('Home.layouts.inc.__addSubscriberModal')
    @include('Home.Gallery.inc._ad-report')



    @include('Home.Gallery.Unit.share')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function copyUrl() {
            var id = $(this).data("url");
            var input = $("<input>").val(id).appendTo("body").select();
            document.execCommand("copy");
            input.remove();
            Swal.fire({
                icon: "success",
                text: @json(__('copy done')),
                timer: 1000,
            });
        }
    </script>



    <script>
        function updateFullPhone(input) {
            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 9);
            var key_phone = $('#key_phone').val();
            var fullPhone = key_phone + input.value;
            document.getElementById('full_phone').value = fullPhone;
        }
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                var key = $(this).data('key');
                var phone = $('#phone').val();
                $('#key_phone').val(key);
                $('#full_phone').val(key + phone);
                $(this).closest('.input-group').find('.btn.dropdown-toggle').text(key);
            });
        });
    </script>

<script>
    function toggleReadMore() {
        var shortDesc = document.getElementById('project-description-short');
        var fullDesc = document.getElementById('project-description-full');

        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'block';
            fullDesc.style.display = 'none';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'block';
        }
    }
</script>
    <!-- Content wrapper -->
@endsection
