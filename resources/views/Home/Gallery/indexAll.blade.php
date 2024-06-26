@extends('Home.layouts.home.app')
@section('content')
    <section class="section-py first-section-pt">
        <div class="container">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">الرئيسية</a>/
                </span>المعرض</h4>

            <div class="row rounded-5">
                <div class="col-12 rounded-5">
                    <div class="card mb-4 rounded-5">

                        {{-- <div class="user-profile-header-banner rounded-5">
                            <img src="{{ asset($gallery->gallery_cover) }}" alt="Gallery Cover" class="img-fluid"
                                style="height: 200px; width: 100%;">

                        </div> --}}

                    </div>
                </div>
            </div>
            <!--/ Header -->
            <div class="card-body">
                <a class="btn btn-primary me-1" data-bs-toggle="collapse" href="#collapseExample" role="button"
                    aria-expanded="false" aria-controls="collapseExample">
                    @lang('Filter')
                </a>
                <!-- filter  -->
                <div class="row">
                    <div id="collapseExample" class="collapse col-md-12">
                        <div class="card m-b-30">
                            <form action="{{ route('gallery.showAllGalleries') }}" method="GET">
                                <div class="row">

                                    <div class="col-6 col-md-2 mb-3">
                                        <span>@lang('Property type')</span>
                                        <select class="form-select" id="property_type_filter" name="property_type_filter">
                                            <option value="all" {{ $propertyTypeFilter == 'all' ? 'selected' : '' }}>
                                                @lang('All')</option>
                                            @foreach ($propertyuniqueIds as $index => $id)
                                                <option value="{{ $id }}"
                                                    {{ $propertyTypeFilter == $id ? 'selected' : '' }}>
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
                                        <select class="form-select" id="project_filter" name="project_filter">
                                            <option value="all" {{ $projectFilter == 'all' ? 'selected' : '' }}>
                                                @lang('All')</option>
                                            @foreach ($projectuniqueIds as $index => $id)
                                                <option value="{{ $id }}"
                                                    {{ $projectFilter == $id ? 'selected' : '' }}>
                                                    {{ $projectUniqueNames[$index] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-6 col-md-2 mb-3">
                                        <span>@lang('Type use')</span>
                                        <select class="form-select" id="type_use_filter" name="type_use_filter">
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
                                        <select class="form-select" id="ad_type_filter" name="ad_type_filter">
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
                                                <input class="form-control" name="price_from" id="price_from"
                                                    placeholder="من" value="{{ request()->input('price_from', null) }}"
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
                                            <input class="form-check-input" type="checkbox" id="daily_rent"
                                                name="daily_rent" {{ $daily_rent ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="text-center col-md-3 mt-3">
                                        <button type="submit"
                                            class="w-auto btn btn-primary mt-2 btn-sm">@lang('Filter')</button>
                                        <a href="{{ route('gallery.showAllGalleries') }}"
                                            class="clear-filter w-auto btn btn-danger mt-2 btn-sm"
                                            style="margin-bottom: 0!important;">@lang('Cancel') @lang('Filter')</a>

                                    </div>
                                </div>
                            </form>
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
                                            <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#onboardHorizontalImageModal{{ $unit->id }}"><i
                                                    class="ti ti-share ti-sm"></i></a>
                                            @guest

                                                <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalToggle">
                                                    <i class="ti ti-heart ti-sm"></i>

                                                </a>

                                            @endguest

                                            @auth
                                                {{-- <a class="btn btn-label-secondary btn-icon d-flex align-items-center me-3"
            data-bs-toggle="modal"
            data-bs-target="#basicModal"
            data-unit-id="{{ $unit->id }}"
            data-user-id="{{ $unit->BrokerData->user_id }}"
            >
            <i class="ti ti-heart ti-sm"></i>
            </a> --}}

                                                @if (auth()->user())
                                                    @php
                                                        $isFavorite = App\Models\FavoriteUnit::where(
                                                            'unit_id',
                                                            $unit->id,
                                                        )
                                                            ->where('finder_id', auth()->user()->id)
                                                            ->exists();
                                                    @endphp
                                                    @if (Auth::user()->hasPermission('Add-property-as-favorite') ||
                                                            Auth::user()->hasPermission('Add-property-as-favorite-admin'))
                                                        @if ($isFavorite)
                                                            <form method="POST"
                                                                action="{{ route('remove-from-favorites') }}">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-label-danger btn-icon d-flex align-items-center me-3">
                                                                    <i class="ti ti-heart ti-sm"></i>
                                                                </button>
                                                                <input type="hidden" name="unit_id"
                                                                    value="{{ $unit->id }}">
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('add-to-favorites') }}">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-label-secondary btn-icon d-flex align-items-center me-3">
                                                                    <i class="ti ti-heart ti-sm"></i>
                                                                </button>
                                                                <input type="hidden" name="unit_id"
                                                                    value="{{ $unit->id }}">
                                                                <input type="hidden" name="owner_id"
                                                                    value="{{ $unit->BrokerData->user_id }}">
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
                                            @endauth

                                        </div>
                                        <div class="mx-auto my-3">
                                            @php
                                                $gallery_name = $unit->gallery->gallery_name;
                                            @endphp
                                            <a href="{{ route('gallery.showUnitPublic', ['gallery_name' => $gallery_name, 'id' => $unit->id]) }}"
                                                class="card-hover-border-default">
                                                @if ($unit->UnitImages->isNotEmpty())
                                                    <img src="{{ url($unit->UnitImages->first()->image) }}"
                                                        alt="Avatar Image" class="rounded-square" width="140"
                                                        height="140" />
                                                @else
                                                    <img src="{{ url('Offices/Projects/default.svg') }}"
                                                        alt="Avatar Image" class="rounded-square" width="140"
                                                        height="140" />
                                                @endif
                                            </a>
                                        </div>
                                        <h4 class="mb-1 card-title">{{ $unit->number_unit ?? '' }}</h4>
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
                                            <a href="javascript:;" class="me-1"
                                                style="
             @if (!$unit->daily_rent) visibility:hidden @endif">
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
                                        @auth
                                            <div class="d-flex align-items-center justify-content-center">
                                                @if (Auth::user()->hasPermission('Show-broker-phone') || Auth::user()->hasPermission('Show-broker-phone-admin'))
                                                    <a href="tel:+{{ $unit->BrokerData->key_phone }} {{ $unit->BrokerData->mobile }}"
                                                        target="_blank"
                                                        class="btn btn-primary d-flex align-items-center me-3"><i
                                                            class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                                @endif
                                                @if (Auth::user()->hasPermission('Send-message-to-broker') ||
                                                        Auth::user()->hasPermission('Send-message-to-broker-admin'))
                                                    <a href="https://web.whatsapp.com/send?phone=tel:+{{ $unit->BrokerData->key_phone }} {{ $unit->BrokerData->mobile }}"
                                                        target="_blank" class="btn btn-label-secondary btn-icon"><i
                                                            class="ti ti-message ti-sm"></i></a>
                                                @endif
                                            </div>
                                        @endauth
                                        @guest
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a target="_blank" class="btn btn-primary d-flex align-items-center me-3"><i
                                                        class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a>
                                                <a target="_blank" class="btn btn-label-secondary btn-icon"><i
                                                        class="ti ti-message ti-sm"></i></a>
                                            </div>
                                        @endguest

                                        {{-- <div class="d-flex align-items-center justify-content-center">
            <a href="tel:+{{ $broker->key_phone }} {{$broker->mobile }}" target="_blank" class="btn btn-primary d-flex align-items-center me-3"
              ><i class="ti-xs me-1 ti ti-phone me-1"></i>@lang('تواصل')</a
            >
            <a href="https://web.whatsapp.com/send?phone=tel:+{{ $broker->key_phone }} {{ $broker->mobile}}" target="_blank" class="btn btn-label-secondary btn-icon"
              ><i class="ti ti-message ti-sm"></i
            ></a>
          </div> --}}
                                    </div>
                                </div>
                            </div>

                            @include('Home.Gallery.inc.share')
                            @include('Home.Gallery.inc.unitInterest')
                        @endforeach

                    </div>

                </div>
            </div>
    </section>


    @include('Home.layouts.inc.__addSubscriberModal')

    <script>
        function reloadUnits() {
            // Get selected filter values
            var city = document.getElementById('city_filter').value;
            var project = document.getElementById('project_filter').value;
            var type = document.getElementById('ad_type_filter').value;
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

        Attach event listeners to select elements
        $(document).ready(function() {
            $('#city_filter, #project_filter, #ad_type_filter, #price_from, #price_to').change(function() {
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

        function redirectToCreateBroker() {
            window.location.href = "{{ route('Home.Brokers.CreateBroker') }}";
        }

        function redirectToCreatePropertyFinder() {
            window.location.href = "{{ route('Home.PropertyFinders.CreatePropertyFinder') }}";
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
@endsection

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
        $(document).ready(function() {
            $('.whatsapp-share-btn').on('click', function() {
                var unitId = $(this).data('unit-id');
                var inputId = "galleryNameCopy_" + unitId;
                var urlToShare = $("#" + inputId).val();

                var textToShare = @json(__('Share this unit from Amlak'));
                var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(textToShare +
                    " " + urlToShare);

                window.open(whatsappUrl, '_blank');
            });
        });

        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId);
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");

            alertify.success(@json(__('copy done')));
        }
    </script>
@endpush
