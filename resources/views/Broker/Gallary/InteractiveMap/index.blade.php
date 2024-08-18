@extends('Admin.layouts.app')

@section('title', __('Interactive Map'))

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class=""><a href="{{ route('Broker.home') }}" class="text-muted fw-light">@lang('dashboard') /</a>
                    @lang('Interactive Map')</h4>
            </div>
        </div>
        <div class="nav-align-top nav-tabs-shadow mb-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-home" aria-controls="navs-justified-home"
                        aria-selected="true">
                        <i class="tf-icons ti ti-home ti-xs me-1"></i> @lang('عقارتي')
                        <span
                            class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">{{ $units->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-profile" aria-controls="navs-justified-profile"
                        aria-selected="false" tabindex="-1">
                        <i class="tf-icons ti ti-cards ti-xs me-1"></i> @lang('جميع العقارات')
                    </button>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="navs-justified-home" role="tabpanel">



                            <!-- Filter Dropdowns -->
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <select id="adTypeFilter" class="form-select">
                                <option value="">@lang('Ad type')</option>
                                <option value="rent">@lang('rent')</option>
                                <option value="sale">@lang('sale')</option>
                                <option value="rent and sale">@lang('rent and sale')</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="propertyTypeFilter" class="form-select">
                                <option value="">@lang('Property type')</option>
                                <!-- Populate property types dynamically -->
                                @foreach($propertyTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="typeUseFilter" class="form-select">
                                <option value="">@lang('Type use')</option>
                                <!-- Populate usages dynamically -->
                                @foreach($usages as $usage)
                                    <option value="{{ $usage->id }}">{{ $usage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="cityFilter" class="form-select">
                                <option value="">@lang('City')</option>
                                <!-- Populate cities dynamically -->
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="districtFilter" class="form-select">
                                <option value="">@lang('districts')</option>
                                <!-- Populate districts dynamically -->
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="projectFilter" class="form-select">
                                <option value="">@lang('Project')</option>
                                <!-- Populate projects dynamically -->
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @include('Admin.layouts.Inc._errors')
                            <div id="map" style="width: 100%; height: 70vh;"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-justified-profile" role="tabpanel">
                    @include('Broker.Gallary.InteractiveMap._AllProperties')
                </div>
            </div>

                </div>

            </div>
        </div>

    @push('scripts')
        <!-- Include Mapbox CSS -->
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />

        <!-- Include Mapbox JS -->
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY2x6djJiaGZhMDNvdzJoc2djN2k4eHM0MiJ9.eOLXc1f7RLgcsbeIS4Us0Q'; // Replace with your Mapbox access token

            // Initialize Mapbox map
            var map = new mapboxgl.Map({
                container: 'map', // ID of the element where the map will be displayed
                style: 'mapbox://styles/mapbox/streets-v11', // Map style
                center: [45.0, 23.8859], // Center of Saudi Arabia [lng, lat]
                zoom: 5 // Initial map zoom level
            });



            var items = @json($allItems);

            // Function to add markers
            function addMarkers(filteredItems) {
            filteredItems.forEach(function(item) {
            if (item.lat_long) {
                var coordinates = item.lat_long.split(',');
                new mapboxgl.Marker()
                    .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // Add a popup with details
                        .setHTML(`
                            <div style="width: 200px;">
                                <h6>${item.name || item.ad_name}</h6>
                                <p><strong>@lang('Ad Type'):</strong> ${item.ad_type}</p>
                                <p><strong>@lang('Property Type'):</strong> ${item.property_type}</p>
                                <p><strong>@lang('City'):</strong> ${item.city_name}</p>
                                <p><strong>@lang('District'):</strong> ${item.district_name}</p>
                                <p><strong>@lang('Project'):</strong> ${item.project_name}</p>
                            </div>
                        `))
                    .addTo(map);
            }
        });
    }

            // Initial markers
            addMarkers(items);
       // Function to filter items
       function filterItems() {
                var adType = $('#adTypeFilter').val();
                var propertyType = $('#propertyTypeFilter').val();
                var typeUse = $('#typeUseFilter').val();
                var city = $('#cityFilter').val();
                var district = $('#districtFilter').val();
                var project = $('#projectFilter').val();

                var filteredItems = items.filter(function(item) {
                    return (!adType || item.type == adType) &&
                           (!propertyType || item.property_type_id == propertyType) &&
                           (!typeUse || item.property_usage_id == typeUse) &&
                           (!city || item.city_id == city) &&
                           (!district || item.district_id == district) &&
                           (!project || item.project_id == project);
                });

                // Remove existing markers
                $('.mapboxgl-marker').remove();

                // Add filtered markers
                addMarkers(filteredItems);
            }

            // Attach filter event handlers
            $('#adTypeFilter, #propertyTypeFilter, #typeUseFilter, #cityFilter, #districtFilter, #projectFilter').change(function() {
                filterItems();
            });


            var mapAll = new mapboxgl.Map({
            container: 'mapAll', // ID of the element where the map will be displayed
            style: 'mapbox://styles/mapbox/streets-v11', // Map style
            center: [45.0, 23.8859], // Center of Saudi Arabia [lng, lat]
            zoom: 5 // Initial map zoom level
        });



var allItemsProperties = @json($allItemsProperties);

// Function to add markers
function addAllMarkers(filteredItems) {
filteredItems.forEach(function(item) {
if (item.lat_long) {
    var coordinates = item.lat_long.split(',');
    new mapboxgl.Marker()
        .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
        .setPopup(new mapboxgl.Popup({ offset: 25 }) // Add a popup with details
            .setHTML(`
                <div style="width: 200px;">
                    <h6>${item.name || item.ad_name}</h6>
                    <p><strong>@lang('Ad Type'):</strong> ${item.ad_type}</p>
                    <p><strong>@lang('Property Type'):</strong> ${item.property_type}</p>
                    <p><strong>@lang('City'):</strong> ${item.city_name}</p>
                    <p><strong>@lang('District'):</strong> ${item.district_name}</p>
                    <p><strong>@lang('Project'):</strong> ${item.project_name}</p>
                </div>
            `))
        .addTo(mapAll);
}
});
}

// Initial markers
addAllMarkers(allItemsProperties);

        </script>

    @endpush
@endsection
