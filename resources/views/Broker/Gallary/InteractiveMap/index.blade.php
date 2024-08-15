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

            <!-- Filter Dropdowns -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <select id="adTypeFilter" class="form-select">
                        <option value="">@lang('Select Ad Type')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="propertyTypeFilter" class="form-select">
                        <option value="">@lang('Select Property Type')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="typeUseFilter" class="form-select">
                        <option value="">@lang('Select Type Use')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="cityFilter" class="form-select">
                        <option value="">@lang('Select City')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="districtFilter" class="form-select">
                        <option value="">@lang('Select District')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="projectFilter" class="form-select">
                        <option value="">@lang('Select Project')</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @include('Admin.layouts.Inc._errors')
                    <div id="map" style="width: 100%; height: 500px;"></div>
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
                    return (!adType || item.ad_type == adType) &&
                           (!propertyType || item.property_type == propertyType) &&
                           (!typeUse || item.type_use == typeUse) &&
                           (!city || item.city_id == city) &&
                           (!district || item.district_id == district) &&
                           (!project || item.project_id == project);
                });

                // Clear existing markers
                map.eachLayer(function(layer) {
                    if (layer.type === 'symbol') {
                        map.removeLayer(layer.id);
                    }
                });

                // Add filtered markers
                addMarkers(filteredItems);
            }

            // Attach filter event handlers
            $('#adTypeFilter, #propertyTypeFilter, #typeUseFilter, #cityFilter, #districtFilter, #projectFilter').change(function() {
                filterItems();
            });
        </script>
    @endpush
@endsection
