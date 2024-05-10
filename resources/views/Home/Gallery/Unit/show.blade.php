@extends('Home.layouts.home.app')
@section('content')


   <!-- Content wrapper -->
   <section class="section-py first-section-pt">
    <div class="container">
      <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
    <span class="text-muted fw-light"> <a href="{{ route('gallery.showAllGalleries') }}">المعرض</a>/</span> وحدة : {{ $Unit->number_unit }}</h4>
        <input hidden type="text" name="unit_idd" value="{{ $Unit->id }}" />
      <!-- Header -->
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="user-profile-header-banner">
              <img src="{{ asset('/img/pages/profile-banner.png')}}" alt="Banner image" class="rounded-top cover" />
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
              <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">


                  @if (!empty($brokers->avatar))
                            <img
                            src="{{ $brokers->avatar }}"
                            alt="user image"
                            class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                            @else
                        <img
                        src="{{ asset('HOME_PAGE/img/avatars/14.png') }}"
                        alt="user image"
                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                        @endif

                </div>
              <div class="flex-grow-1 mt-3 mt-sm-5">
                <div
                  class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                  <div class="user-profile-info">
                    <h4>{{ $brokers->name}}</h4>
                    <ul
                      class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                      @if( $brokers->is_broker)
                      <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i> @lang('Broker')</li>
                      @else
                      <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i> @lang('Office')</li>
                      @endif
                      <li class="list-inline-item d-flex gap-1">
                        <i class="ti ti-color-swatch"></i>رقم رخصة فال : {{ $broker->broker_license}}
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
                        <i class="ti ti-calendar"></i> عضو منذ {{ $monthName }} {{ $numDay }} {{ $yearName }}
                      </li>
                    </ul>
                  </div>
                  {{-- <a href="javascript:void(0)" class="btn btn-primary">
                    <i class="ti ti-check me-1"></i>Connected
                  </a> --}}
                  <a href="tel:{{ env('COUNTRY_CODE') . $broker->moblie }}" class="btn btn-primary d-flex align-items-center me-3">
                    <i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                  <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}" class="btn btn-secondary d-flex align-items-center me-3"
                    ><i class="ti-xs me-1 ti ti-message me-1">@lang('دردشة')</i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Header -->

      <!-- Navbar pills -->
      <div class="row">
        <div class="col-md-12">
          <ul class="nav nav-pills flex-column flex-sm-row mb-4">
            <li class="nav-item">
              <a class="nav-link active" href="javascript:void(0);"
                ><i class="ti-xs ti ti-user-check me-1"></i> Profile</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-profile-teams.html"
                ><i class="ti-xs ti ti-users me-1"></i> Teams</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-profile-projects.html"
                ><i class="ti-xs ti ti-layout-grid me-1"></i> Projects</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages-profile-connections.html"
                ><i class="ti-xs ti ti-link me-1"></i> Connections</a
              >
            </li>
          </ul>
        </div>
      </div>
      <!--/ Navbar pills -->

      <!-- User Profile Content -->
      <div class="row">

        <div class="col-xl-7 col-lg-7 col-md-7">

          <!-- Activity Timeline -->
          {{-- <div class="card mb-4">
            <div class="card-body">
                    <div class="swiper" id="swiper-with-arrows">
                      <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url('{{ asset('HOME_PAGE/img/backgrounds/1.jpg') }}')">
                            Slide 1
                        </div>
                        <div class="swiper-slide" style="background-image: url(../../assets/img/elements/1.jpg)">
                          Slide 2
                        </div>
                        <div class="swiper-slide" style="background-image: url(../../assets/img/elements/5.jpg)">
                          Slide 3
                        </div>
                        <div class="swiper-slide" style="background-image: url(../../assets/img/elements/9.jpg)">
                          Slide 4
                        </div>
                        <div class="swiper-slide" style="background-image: url(../../assets/img/elements/7.jpg)">
                          Slide 5
                        </div>
                      </div>
                      <div class="swiper-button-next swiper-button-white custom-icon"></div>
                      <div class="swiper-button-prev swiper-button-white custom-icon"></div>
                    </div>
            </div>
          </div> --}}

          <div class="card card-action mb-4">

             <div id="carouselExampleIndicators" class="carousel slide shadow-sm" data-ride="carousel">

                    <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @if ($Unit->UnitImages->isEmpty())
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('Offices/Projects/default.svg') }}" alt="Default slide" style="height: 350px; object-fit: contain">
                        </div>
                    @else
                        @foreach ($Unit->UnitImages as $img)
                            <div class="carousel-item @if ($i == 0) active @endif ">
                                <img class="d-block w-100" src="{{ asset($img['image']) }}" alt="Slide {{ $i + 1 }}" style="height: 350px; object-fit: contain">
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    @endif
                </div>

            </div>

        </div>
          <!--/ Activity Timeline -->
            <div class="card card-action mb-4">
                <div class="card-header align-items-center">
                  <h5 class="card-action-title mb-0">Activity Timeline</h5>
                  <div class="card-action-element">
                    <div class="dropdown">
                      <button
                        type="button"
                        class="btn dropdown-toggle hide-arrow p-0"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="ti ti-dots-vertical text-muted"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="javascript:void(0);">Share timeline</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Suggest edits</a></li>
                        <li>
                          <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Report bug</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body pb-0">
                  <ul class="timeline ms-1 mb-0">
                    <li class="timeline-item timeline-item-transparent">
                      <span class="timeline-point timeline-point-primary"></span>
                      <div class="timeline-event">
                        <div class="timeline-header">
                          <h6 class="mb-0">Client Meeting</h6>
                          <small class="text-muted">Today</small>
                        </div>
                        <p class="mb-2">Project meeting with john @10:15am</p>
                        <div class="d-flex flex-wrap">
                          <div class="avatar me-2">
                            <img src="../../assets/img/avatars/3.png" alt="Avatar" class="rounded-circle" />
                          </div>
                          <div class="ms-1">
                            <h6 class="mb-0">Lester McCarthy (Client)</h6>
                            <span>CEO of Infibeam</span>
                          </div>
                        </div>
                      </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                      <span class="timeline-point timeline-point-success"></span>
                      <div class="timeline-event">
                        <div class="timeline-header">
                          <h6 class="mb-0">Create a new project for client</h6>
                          <small class="text-muted">2 Day Ago</small>
                        </div>
                        <p class="mb-0">Add files to new design folder</p>
                      </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent">
                      <span class="timeline-point timeline-point-danger"></span>
                      <div class="timeline-event">
                        <div class="timeline-header">
                          <h6 class="mb-0">Shared 2 New Project Files</h6>
                          <small class="text-muted">6 Day Ago</small>
                        </div>
                        <p class="mb-2">
                          Sent by Mollie Dixon
                          <img
                            src="../../assets/img/avatars/4.png"
                            class="rounded-circle me-3"
                            alt="avatar"
                            height="24"
                            width="24" />
                        </p>
                        <div class="d-flex flex-wrap gap-2 pt-1">
                          <a href="javascript:void(0)" class="me-3">
                            <img
                              src="../../assets/img/icons/misc/doc.png"
                              alt="Document image"
                              width="15"
                              class="me-2" />
                            <span class="fw-medium text-heading">App Guidelines</span>
                          </a>
                          <a href="javascript:void(0)">
                            <img
                              src="../../assets/img/icons/misc/xls.png"
                              alt="Excel image"
                              width="15"
                              class="me-2" />
                            <span class="fw-medium text-heading">Testing Results</span>
                          </a>
                        </div>
                      </div>
                    </li>
                    <li class="timeline-item timeline-item-transparent border-transparent">
                      <span class="timeline-point timeline-point-info"></span>
                      <div class="timeline-event">
                        <div class="timeline-header">
                          <h6 class="mb-0">Project status updated</h6>
                          <small class="text-muted">10 Day Ago</small>
                        </div>
                        <p class="mb-0">Woocommerce iOS App Completed</p>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>

          <!-- Projects table -->
          <div class="card mb-4">
            <div class="card-datatable table-responsive">
              <table class="datatables-projects table border-top">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>Name</th>
                    <th>Leader</th>
                    <th>Team</th>
                    <th class="w-px-200">Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          <!--/ Projects table -->
        </div>

        <div class="col-xl-5 col-lg-5 col-md-5">
            <!-- About User -->
            <div class="card mb-4">
              <div class="card-body">
                <small class="card-text text-uppercase">About</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-user text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Full Name:</span> <span>John Doe</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-check text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Status:</span> <span>Active</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-crown text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Role:</span> <span>Developer</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-flag text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Country:</span> <span>USA</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-file-description text-heading"></i
                    ><span class="fw-medium mx-2 text-heading">Languages:</span> <span>English</span>
                  </li>
                </ul>
                <small class="card-text text-uppercase">Contacts</small>
                <ul class="list-unstyled mb-4 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">Contact:</span>
                    <span>(123) 456-7890</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-brand-skype"></i><span class="fw-medium mx-2 text-heading">Skype:</span>
                    <span>john.doe</span>
                  </li>
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">Email:</span>
                    <span>john.doe@example.com</span>
                  </li>
                </ul>
                <small class="card-text text-uppercase">Teams</small>
                <ul class="list-unstyled mb-0 mt-3">
                  <li class="d-flex align-items-center mb-3">
                    <i class="ti ti-brand-angular text-danger me-2"></i>
                    <div class="d-flex flex-wrap">
                      <span class="fw-medium me-2 text-heading">Backend Developer</span><span>(126 Members)</span>
                    </div>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="ti ti-brand-react-native text-info me-2"></i>
                    <div class="d-flex flex-wrap">
                      <span class="fw-medium me-2 text-heading">React Developer</span><span>(98 Members)</span>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <!--/ About User -->
            <!-- Profile Overview -->
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

  </div>
   </section>
  <!-- Content wrapper -->
