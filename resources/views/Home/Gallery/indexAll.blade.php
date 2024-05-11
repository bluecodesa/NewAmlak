@extends('Home.layouts.home.app')
@section('content')


    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/ </span>المعرض</h4>

<div class="row">
    <div class="col-12">
      <div class="card mb-4">

        <div class="user-profile-header-banner">
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4"
        style="background-image: url({{ $gallery->gallery_cover ? asset($gallery->gallery_cover) : asset('dashboard/assets/new-icons/cover1.png') }}); height: 200px; width: 100%; background-size: cover;">
          {{-- <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img
              src="../../assets/img/avatars/14.png"
              alt="user image"
              class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div
              class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4>John Doe</h4>
                <ul
                  class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item d-flex gap-1">
                    <i class="ti ti-color-swatch"></i> UX Designer
                  </li>
                  <li class="list-inline-item d-flex gap-1"><i class="ti ti-map-pin"></i> Vatican City</li>
                  <li class="list-inline-item d-flex gap-1">
                    <i class="ti ti-calendar"></i> Joined April 2021
                  </li>
                </ul>
              </div>
              <a href="javascript:void(0)" class="btn btn-primary">
                <i class="ti ti-check me-1"></i>Connected
              </a>
            </div>
          </div> --}}
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
          <a class="nav-link" href="pages-profile-user.html"
            ><i class="ti ti-user-check ti-xs me-1"></i> Profile</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages-profile-teams.html"
            ><i class="ti ti-users ti-xs me-1"></i> Teams</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pages-profile-projects.html"
            ><i class="ti ti-layout-grid ti-xs me-1"></i> Projects</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="javascript:void(0);"
            ><i class="ti ti-link ti-xs me-1"></i> Connections</a
          >
        </li>
      </ul>
    </div>
  </div>
  <!--/ Navbar pills -->

  <!-- Connection Cards -->
  <div class="row g-4">
    @foreach ($units as $unit)

    <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
        <div class="card-body text-center">
          <div class="dropdown btn-pinned">
            {{-- <button
              type="button"
              class="btn dropdown-toggle hide-arrow p-0"
              data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="ti ti-dots-vertical text-muted"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="javascript:void(0);">Share connection</a></li>
              <li><a class="dropdown-item" href="javascript:void(0);">Block connection</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li><a class="dropdown-item text-danger" href="javascript:void(0);">Delete</a></li>
            </ul> --}}
            <span class="pb-1">@lang('SAR') / {{ __($unit->rent_type_show) }}</span>

          </div>
          <div class="d-flex align-items-center justify-content-start">
            <a  class="share btn btn-secondary btn-icon d-flex align-items-center me-3"
            data-bs-toggle="modal"
            data-bs-target="#twoFactorAuth"><i class="ti ti-share ti-sm"></i></a
            >
            <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
              ><i class="ti ti-heart ti-sm"></i
            ></a>
          </div>
          <div class="mx-auto my-3">
            <a href="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" class="card-hover-border-default">
            @if ($unit->UnitImages->isNotEmpty())
            <img src="{{ url($unit->UnitImages->first()->image) }}" alt="Avatar Image" class="rounded-circle w-px-100" />
            @else
            <img src="{{ url('Offices/Projects/default.svg') }}" alt="Avatar Image" class="rounded-circle w-px-200" />

            @endif
            </a>
        </div>
          <h4 class="mb-1 card-title">{{ $unit->number_unit ?? '' }}</h4>
          <div class="d-flex align-items-center justify-content-center my-3 gap-2">

          <span class="pb-1"><i class="ti ti-map-pin"></i>{{ $unit->CityData->name ?? '' }}</span>
          </div>
          <div class="d-flex align-items-center justify-content-center my-3 gap-2">

            <a href="javascript:;"><span class="badge bg-label-primary"> {{ __($unit->PropertyTypeData->name) ?? '' }}</span></a>
            @if ($unit->type == 'rent')
            <a href="javascript:;"><span class="badge bg-label-warning">@lang('rent')</span></a>
            @endif
            @if ($unit->type == 'sale')
            <a href="javascript:;"><span class="badge bg-label-success">@lang('sale')</span></a>
            @endif

            @if ($unit->type == 'rent and sale')
            <a href="javascript:;"><span class="badge bg-label-info">@lang('rent and sale')</span></a>
            @endif
            <a href="javascript:;" class="me-1"
            style="
             @if (!$unit->daily_rent ) visibility:hidden @endif">
             <span class="badge bg-label-secondary">متاح @lang('Daily Rent')</span></a>
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
              <span>@lang('Area (square metres)')</span>
            </div>
            <div>
                <h4 class="mb-0">{{ $unitVisitorsCount[$unit->id] ?? 0 }}</h4>
                <span>@lang('Views')</span>
              </div>
          </div>

          <div class="d-flex align-items-center justify-content-center">
            <a href="tel:{{ env('COUNTRY_CODE') . $broker->moblie }}" class="btn btn-primary d-flex align-items-center me-3"
              ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a
            >
            <a href="https://web.whatsapp.com/send?phone={{ env('COUNTRY_CODE') . $broker->mobile}}" class="btn btn-label-secondary btn-icon"
              ><i class="ti ti-message ti-sm"></i
            ></a>
          </div>
        </div>
      </div>
    </div>

@include('Home.Gallery.inc.share')
   @endforeach

  </div>

</div>
</section>



@endsection
