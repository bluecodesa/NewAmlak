@extends('Home.layouts.home.app')
@section('content')


    <section class="section-py first-section-pt">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/ </span><span class="text-muted fw-light"><a href="{{ route('gallery.showAllGalleries') }}">المعرض</a>/ </span> {{ $broker->UserData->name }}</h4>

            <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    {{-- <div class="user-profile-header-banner">
                      <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top" />
                    </div> --}}
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                      <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img
                        src="{{ $broker->UserData->avatar ? $broker->UserData->avatar : asset('HOME_PAGE/img/avatars/14.png') }}"
                        alt="user image"
                        height="100" width="100" />

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
                          <a href="tel:+{{ $broker->key_phone }} {{ $broker->mobile }}" target="_blank" class="btn btn-primary">
                            <i class="ti ti-phone me-1"></i>تواصل
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

   <!-- filter  -->
   <a
    class="btn btn-primary me-1"
    data-bs-toggle="collapse"
    href="#collapseExample"
    role="button"
    aria-expanded="false"
    aria-controls="collapseExample">
    @lang('Filter')
  </a>
  <!-- filter  -->
  <div  class="row">
    <div id="collapseExample" class="collapse col-md-12">
        <div class="card m-b-30">

        <form id="subscriptionsForm" action="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}" method="GET">
            <div class="row">

                <div class="col-6 col-md-2 mb-3">
                    <span>@lang('Property type')</span>
                    <select class="form-select" id="property_type_filter" name="property_type_filter">
                    <option value="all" {{ $propertyTypeFilter == 'all' ? 'selected' : '' }}>
                        @lang('All')</option>
                        @foreach ($propertyuniqueIds as $index => $id)
                        <option value="{{ $id }}" {{ $propertyTypeFilter == $id ? 'selected' : '' }}>
                            {{ $propertyUniqueNames[$index] }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2 mb-3">
                    <span>@lang('City')</span>
                    <select class="form-select" id="city_filter" name="city_filter">
                        <option value="all" {{ $cityFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                            @foreach ($uniqueIds as $index => $id)
                            <option value="{{ $id }}"
                                data-url="{{ route('Gallary.GetDistrictByCity', $id) }}"
                                {{ $cityFilter == $id ? 'selected' : '' }}>
                                {{ $uniqueNames[$index] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2 mb-3">
                    <span>@lang('district')</span>
                    <select class="form-select" id="district_filter" name="district_filter">
                        <option value="all" {{ $districtFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                            @foreach ($districts->unique('district_id') as $index => $district)
                            <option value="{{ $district->district_id }}"
                                {{ $districtFilter == $district->district_id ? 'selected' : '' }}>
                                {{ $district->DistrictData->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2 mb-3">
                    <span>@lang('Project')</span>
                    <select class="form-select"  id="project_filter" name="project_filter">
                        <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>
                            @lang('All')</option>
                            @foreach ($projectuniqueIds as $index => $id)
                            <option value="{{ $id }}" {{ $projectFilter == $id ? 'selected' : '' }}>
                                {{ $projectUniqueNames[$index] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2 mb-3">
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
                <div class="col-6 col-md-2 mb-3">
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
                <div class="col-4 col-md-2 mb-3">
                    <span>@lang('Ads with images')</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="hasImageFilter"
                            name="has_image_filter" {{ $hasImageFilter ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-4 col-md-2 mb-3">
                    <span>@lang('Ads with price')</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="hasPriceFilter"
                            name="has_price_filter" {{ $hasPriceFilter ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="col-4 col-md-2 mb-3">
                    <span>@lang('Available For Daily Rent')</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="daily_rent" name="daily_rent"
                            {{ $daily_rent ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="text-center col-md-3 mt-3">
                    <button type="submit"
                        class="w-auto btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                        <a href="{{ route('gallery.showByName', ['name' => $gallery->gallery_name]) }}"
                        class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                        style="margin-bottom: 0!important;">@lang('Cancel') @lang('Filter')</a>

                </div>
            </div>
        </form>
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
            <div class="card h-200">
        <div class="card-body text-center">
          <div class="dropdown btn-pinned">

            <span class="pb-1">{{ $unit->getRentPriceByType() }}
                @lang('SAR') / {{ __($unit->rent_type_show) }}</span>

          </div>
          <div class="d-flex align-items-center justify-content-start">
            <a  class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
            data-bs-toggle="modal"
            data-bs-target="#onboardHorizontalImageModal{{$unit->id}}">
             <i class="ti-xs me-1 ti ti-share me-1"></i></a
            >
            <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
            data-bs-toggle="modal"
            data-bs-target="#basicModal"><i class="ti ti-heart ti-sm"></i
            ></a>
          </div>
          <div class="mx-auto my-3">
            <a href="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery->gallery_name, 'id' => $unit->id]) }}" class="card-hover-border-default">
            @if ($unit->UnitImages->isNotEmpty())
            <img src="{{ url($unit->UnitImages->first()->image) }}" alt="Avatar Image" class="rounded-square"  width="140"  height="140" />
            @else
            <img src="{{ url('Offices/Projects/default.svg') }}" alt="Avatar Image" class="rounded-square"  width="140"  height="140" />

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
            <a href="tel:+{{ $broker->key_phone }} {{ $broker->mobile }}" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
              ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a
            >
            <a href="https://web.whatsapp.com/send?phone=tel:+{{ $broker->key_phone }} {{$broker->mobile}}" target="_blank" class="btn btn-label-secondary btn-icon"
              ><i class="ti ti-message ti-sm"></i
            ></a>
          </div>
        </div>
      </div>
    </div>

    @include('Home.Gallery.inc.share')
    @include('Home.Gallery.inc.unitInterest')

   @endforeach
  </div>

  </div>

</section>

@include('Home.layouts.inc.__addSubscriberModal')

<script>
    // Add an event listener to the submit button
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
    function redirectToCreateBroker() {
        window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
    }

    function redirectToCreateOffice() {
        window.location.href = "{{ route('Home.Offices.CreateOffice') }}";

    }

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



<script src="{{ URL::asset('dashboard/js/custom.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all table headers
        const headers = document.querySelectorAll('th');

        // Add click event listeners to each header
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = document.querySelector('tbody');
                const rows = Array.from(table.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const direction = header.dataset.sortDirection || 'asc';

                // Remove sort indicators from other headers
                headers.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    delete h.dataset.sortDirection;
                });

                // Sort the rows based on the content of the clicked column
                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.children[index].textContent.trim();
                    const bValue = b.children[index].textContent.trim();

                    if (direction === 'asc') {
                        return aValue.localeCompare(bValue);
                    } else {
                        return bValue.localeCompare(aValue);
                    }
                });

                // Update the sort direction indicator
                header.classList.toggle('asc', direction === 'asc');
                header.classList.toggle('desc', direction === 'desc');
                header.dataset.sortDirection = direction === 'asc' ? 'desc' : 'asc';

                // Reorder the rows in the table
                table.innerHTML = '';
                sortedRows.forEach(row => table.appendChild(row));
            });
        });

        // Initially sort the table by the first column in ascending order
        const initialHeader = headers[0];
        initialHeader.click();
    });
</script>

@push('scripts')
<script>
    function copyToClipboard(selector) {
        // Get the input element
        var copyText = document.querySelector(selector);

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        document.execCommand("copy");

        // Optionally, you can provide feedback to the user
        alertify.success(@json(__('copy done')));
    }
</script>
@endpush
@endsection

