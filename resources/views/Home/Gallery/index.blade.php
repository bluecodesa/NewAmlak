@extends('Home.layouts.home.app')
@section('content')


    <section class="section-py first-section-pt">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/ </span>معرض : {{ $broker->UserData->name }}</h4>

            <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    {{-- <div class="user-profile-header-banner">
                      <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
                    </div> --}}
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                      <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img
                          src="../../assets/img/avatars/14.png"
                          alt="user image"
                          class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" />
                      </div>
                      <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                          class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                          <div class="user-profile-info">
                            <h4>{{ $broker->UserData->name }}</h4>
                            <ul
                              class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">

                              @if( $broker->UserData->is_broker)
                              <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i> @lang('Broker')</li>
                              @else
                              <li class="list-inline-item d-flex gap-1"><i class="ti ti-user-check"></i> @lang('Office')</li>
                              @endif
                              <li class="list-inline-item d-flex gap-1">
                                <i class="ti ti-color-swatch"></i>رقم رخصة فال: {{ $broker->broker_license }}
                              </li>

                              <li class="list-inline-item d-flex gap-1">
                                @php
                                $createdAt = new DateTime($broker->UserData->created_at);

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
                          <a href="tel:{{ $broker->mobile }}" class="btn btn-primary">
                            <i class="ti ti-phone me-1"></i>تواصل
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

  <!-- filter  -->
  <div class="row">
    <div class="col-md-12">
        <div class="card m-b-30">

        <div class="card-body">

        <form action="{{ route('gallery.showAllGalleries') }}" method="GET">
            <div class="row">
                <div class="col-4 col-md-1 mb-3">
                    <span>@lang('Ads with images')</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="hasImageFilter"
                            name="has_image_filter" {{ $hasImageFilter ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-4 col-md-1 mb-3">
                    <span>@lang('Ads with price')</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="hasPriceFilter"
                            name="has_price_filter" {{ $hasPriceFilter ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-4 col-md-1 mb-3">
                    <span>@lang('Available For Daily Rent')</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="daily_rent" name="daily_rent"
                                            {{ $daily_rent ? 'checked' : '' }}>
                                    </div>
                </div>
                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('Property type')</span>
                    <select class="form-select" id="property_type_filter" name="property_type_filter">
                    <option value="all" {{ $propertyTypeFilter == 'all' ? 'selected' : '' }}>
                        @lang('All')</option>
                    @foreach ($units as $unit)
                        @if ($unit->PropertyTypeData)
                            <option value="{{ $unit->PropertyTypeData->id }}"
                                {{ $propertyTypeFilter == $unit->PropertyTypeData->id ? 'selected' : '' }}>
                                {{ $unit->PropertyTypeData->name }}
                            </option>
                        @endif
                    @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('City')</span>
                    <select class="form-select" id="city_filter" name="city_filter">

                        <option value="all" {{ $cityFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                            @foreach ($uniqueIds as $index => $id)
                            <option value="{{ $id }}"
                                data-url="{{ route('Broker.Gallary.GetDistrictByCity', $id) }}"
                                {{ $cityFilter == $id ? 'selected' : '' }}>
                                {{ $uniqueNames[$index] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('district')</span>
                    <select class="form-select" id="district_filter" name="district_filter">
                        <option value="all" {{ $districtFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                        @foreach ($districts as $index => $district)
                            <option value="{{ $district->district_id }}"
                                {{ $districtFilter == $district->district_id ? 'selected' : '' }}>
                                {{ $district->DistrictData->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('Project')</span>
                    <select class="form-select"  id="project_filter" name="project_filter">
                        <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                        @foreach ($units as $unit)
                            @if ($unit->PropertyData && $unit->PropertyData->ProjectData)
                                <option value="{{ $unit->PropertyData->ProjectData->id }}"
                                    {{ $projectFilter == $unit->PropertyData->ProjectData->id ? 'selected' : '' }}>
                                    {{ $unit->PropertyData->ProjectData->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('Type use')</span>
                    <select class="form-select"  id="type_use_filter" name="type_use_filter">
                        <option value="all" {{ $typeUseFilter == 'all' ? 'selected' : '' }}>
                        @lang('All')</option>
                    @foreach ($usages as $usage)
                        <option value="{{ $usage->id }}"
                            {{ $typeUseFilter == $usage->id ? 'selected' : '' }}>
                            {{ $usage->name }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-1 mb-3">
                    <span>@lang('Ad type')</span>
                    <select class="form-select"  id="ad_type_filter" name="ad_type_filter">
                        <option value="all" {{ $adTypeFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                        @foreach (['rent', 'sale', 'rent and sale'] as $type)
                            <option value="{{ $type }}"
                                {{ $adTypeFilter == $type ? 'selected' : '' }}>
                                {{ __($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <span>السعر</span>
                                    <div class="row m-0 p-0 gap-3">
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_from" id="price_from" placeholder="من"
                                                value="{{ request()->input('price_from', null) }}"
                                                onchange="reloadUnits()" />
                                        </div>
                                        <div class="col-5 p-0">
                                            <input class="form-control" name="price_to" id="price_to" placeholder="الي"
                                                value="{{ request()->input('price_to', null) }}"
                                                onchange="reloadUnits()" />
                                        </div>
                                    </div>
                </div>
                <div class="text-center col-md-3 mt-3">
                    <button type="submit"
                        class="w-auto btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                        <a href="{{ route('gallery.showAllGalleries') }}"
                        class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                        style="margin-bottom: 0!important;">@lang('Cancel') @lang('Filter')</a>
                    {{-- @php
                        $filter_counter =
                            ($propertyTypeFilter != 'all') +
                            ($cityFilter != 'all') +
                            ($districtFilter != 'all') +
                            ($projectFilter != 'all') +
                            ($typeUseFilter != 'all') +
                            ($typeUseFilter != 'all') +

                            ($adTypeFilter != 'all');
                    @endphp
                    @if ($filter_counter > 0)
                        <a href="{{ route('gallery.showAllGalleries') }}"
                            class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                            style="margin-bottom: 0!important;">@lang('Cancel') @lang('Filter')
                            ({{ $filter_counter }})</a>
                    @endif --}}
                </div>
            </div>
        </form>
      {{-- <ul class="nav nav-pills flex-column flex-sm-row mb-4">
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
      </ul> --}}
        </div>
        </div>
    </div>
  </div>
  <!--/ filter pills -->
  <div class="divider divider-success">
    <div class="divider-text">@lang('Units')</div>
</div>


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
            <span class="pb-1">{{ $unit->getRentPriceByType() }}
                @lang('SAR') / {{ __($unit->rent_type_show) }}</span>

          </div>
          <div class="d-flex align-items-center justify-content-start">
            <a  class="share btn btn-secondary d-flex align-items-center me-3"
            data-bs-toggle="modal"
            data-bs-target="#twoFactorAuth"><i class="ti-xs me-1 ti ti-share me-1"></i></a
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
            <a href="tel:{{ $broker->mobile }}" class="btn btn-primary d-flex align-items-center me-3"
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


<script>
      function reloadUnits() {
            // Get selected filter values
            var city = document.getElementById('city_filter').value;
            var project = document.getElementById('prj_filter').value;
            var type = document.getElementById('type_filter').value;
            var price_from = document.getElementById('price_from').value;
            var price_to = document.getElementById('price_to').value;

            // Make AJAX request to fetch filtered units
            $.ajax({
                url: "{{ route('filtered.units') }}",
                type: "GET",
                data: {
                    city_filter: city,
                    prj_filter: project,
                    type_filter: type,
                    price_from: price_from,
                    price_to: price_to
                },
                success: function(data) {
                    // Handle the received data (update the view with filtered units)
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Attach event listeners to select elements
        $(document).ready(function() {
            $('#city_filter, #prj_filter, #type_filter, #price_from, #price_to').change(function() {
                reloadUnits();
            });
        });

        $('#city_filter').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var url = selectedOption.data('url');
            if (selectedOption.val() === 'all') {
        $('#district_filter').val('all');
    } else {
            $.ajax({
                type: "get",
                url: url,
                beforeSend: function() {
                    $('#district_filter').fadeOut('fast');
                },
                success: function(data) {
                    $('#district_filter').fadeOut('fast', function() {
                        $(this).empty().append(data);
                        $(this).fadeIn('fast');
                    });
                },
            });
        }
        });
    </script>
</script>

@endsection
