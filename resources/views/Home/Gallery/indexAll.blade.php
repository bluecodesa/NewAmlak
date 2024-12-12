@extends('Home.layouts.home.app')
@section('title', __('Gallary'))
@section('content')
    <style>
        .sticky-carousel-wrapper {
            top: 0;
            width: 100%;
            height: 200px;
            z-index: 1000;
            background: #fff;
            overflow: hidden;
        }
    </style>

    <section class="section-py first-section-pt">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-1"><span class="text-muted fw-light"><a href="{{ route('welcome') }}">@lang('Home')</a>/
                </span>المعرض</h4>

            @if ($advertisings->isNotEmpty())

                <div class="sticky-carousel-wrapper mb-2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div
                                    class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                                    <!-- Carousel wrapper -->
                                    <div id="advertisementCarousel" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($advertisings as $index => $advertisement)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    @php
                                                        $isImage = in_array(
                                                            pathinfo($advertisement->content, PATHINFO_EXTENSION),
                                                            ['jpg', 'jpeg', 'png', 'gif'],
                                                        );
                                                    @endphp

                                                    @if (!empty($advertisement->ad_url))
                                                        <a href="{{ $advertisement->ad_url }}" target="_blank">
                                                            @if ($isImage)
                                                                <img src="{{ asset($advertisement->content) }}"
                                                                    class="d-block w-100 h-100" alt="Advertisement Image">
                                                            @else
                                                                <video class="d-block w-100 h-100" autoplay muted>
                                                                    <source src="{{ asset($advertisement->content) }}"
                                                                        type="video/mp4">
                                                                    @lang('Your browser does not support the video tag.')
                                                                </video>
                                                            @endif
                                                        </a>
                                                    @else
                                                        @if ($isImage)
                                                            <img src="{{ asset($advertisement->content) }}"
                                                                class="d-block w-100 h-100" alt="Advertisement Image">
                                                        @else
                                                            <video class="d-block w-100 h-100" autoplay muted>
                                                                <source src="{{ asset($advertisement->content) }}"
                                                                    type="video/mp4">
                                                                @lang('Your browser does not support the video tag.')
                                                            </video>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#advertisementCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#advertisementCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            <!--/ Header -->
            <div class="row" style="text-align: center;">
                <div class="col-8">
                <a class="btn btn-primary mb-2" data-bs-toggle="collapse" href="#collapseExample" role="button"
                    aria-expanded="false" aria-controls="collapseExample">
                    @lang('Filter')
                </a>
            </div>
            <div class="col-4">

                <select id="sortDropdown" class="form-control" onchange="sortItems()">
                    {{-- <option value="">ترتيب حسب...</option> --}}
                    <option value="newest">@lang('Newest to Oldest')</option>
                    <option value="highest_price">الأعلى سعر (ايجار شهري)</option>
                    <option value="lowest_price">الأقل سعر (ايجار شهري)</option>
                    <option value="largest_space">الأكبر مساحة</option>
                    <option value="smallest_space">الأقل مساحة</option>
                </select>
            </div>
            </div>
            <!-- filter  -->
            <div class="row mb-3" style="text-align: center;">
                <div id="collapseExample" class="collapse col-md-12">
                    <div class="card m-b-30">
                        <form action="{{ route('gallery.showAllGalleries') }}" method="GET">
                            <div class="row m-2">

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
                                            @foreach ($uniqueIdIistricts as $index => $id)
                                            <option value="{{ $id }}"
                                                {{ $districtFilter == $id ? 'selected' : '' }}>
                                                {{ $uniqueDistrictNames[$index] }}
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
                                        @foreach (['rent', 'sale'] as $type)
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
            </div>
            <!--/ filter pills -->
            {{-- <div class="divider divider-success">
                        <div class="divider-text">@lang('Units')</div>
                    </div> --}}

            <!-- Connection Cards -->
            <div class="nav-align-top nav-tabs-shadow mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-justified-home"
                            aria-controls="navs-justified-home"
                            aria-selected="true">
                            <i class="tf-icons ti ti-list ti-xs me-1"></i> @lang('List')
                            <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $allItems->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-justified-gallery" aria-controls="navs-justified-gallery"
                            aria-selected="false">
                            <i class="tf-icons ti ti-map ti-xs me-1"></i> @lang('Interactive Map')
                            <span
                                class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $allItems->count() }}</span>
                        </button>
                    </li>
                </ul>

                <!-- Wrapping tab content -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-justified-home" role="tabpanel">
                        @include('Home.Gallery._inc_main_gallery.list')
                    </div>
                    <div class="tab-pane fade" id="navs-justified-gallery" role="tabpanel">
                        @include('Home.Gallery._inc_main_gallery.interactive_map')
                    </div>
                </div>
            </div>




        </div>
    </section>


    @include('Home.layouts.inc.__addSubscriberModal')

    <script>


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

                var textToShare = @json(__('Share this unit from Town'));
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
    <script>
    // function sortItems() {
    //     const sortOrder = document.getElementById('sortDropdown').value;
    //     const url = new URL(window.location.href);
    //     url.searchParams.set('sort_order', sortOrder);
    //     window.location.href = url;
    // }
        // This function sets the selected option based on the query parameter
        function setSortOrder() {
        const urlParams = new URLSearchParams(window.location.search);
        const sortOrder = urlParams.get('sort_order');

        const sortDropdown = document.getElementById('sortDropdown');

        if (sortOrder) {
            // Set the dropdown value to the selected sort_order from the URL
            sortDropdown.value = sortOrder;

            // Update the placeholder option text based on the selected value
            const selectedOption = sortDropdown.options[sortDropdown.selectedIndex];
            const placeholderOption = sortDropdown.querySelector('option[value=""]');
            placeholderOption.textContent = selectedOption.textContent;
        }
    }

    // This function updates the URL when the dropdown value is changed
    function sortItems() {
        const sortOrder = document.getElementById('sortDropdown').value;
        const url = new URL(window.location.href);
        url.searchParams.set('sort_order', sortOrder);
        window.location.href = url;
    }

    // Run this on page load to set the correct selected option
    window.onload = setSortOrder;
</script>

@endpush
