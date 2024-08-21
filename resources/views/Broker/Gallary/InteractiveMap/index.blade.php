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
            <div class="toggle-container m-2" style="display: flex; justify-content: center; gap: 10px;">
                <button id="myPropertiesBtn" class="btn btn-primary active">@lang('My Properties')</button>
                <button id="allPropertiesBtn" class="btn btn-secondary">@lang('All Properties')</button>
            </div>
            
            
            <!-- Map Container -->

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
                        <option value="">@lang('district')</option>
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
    </div>
</div>

@push('scripts')
<!-- Include Mapbox CSS -->
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />

<!-- Include Mapbox JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY2x6djJiaGZhMDNvdzJoc2djN2k4eHM0MiJ9.eOLXc1f7RLgcsbeIS4Us0Q'; // Replace with your Mapbox access token

    // Initialize Mapbox
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [45.0, 23.8859],
        zoom: 5
    });

    // Initial items (My Properties)
    var items = @json($allItems);
    var allItemsProperties = @json($allItemsProperties);

    function addMarkers(filteredItems) {
        filteredItems.forEach(function(item) {
            if (item.lat_long) {
                var coordinates = item.lat_long.split(',');
                var showRoute = '#';
                var rentPriceAndType = '';

                if (item.isGalleryUnit) {
                    showRoute = `{{ route('Broker.Unit.show', ':id') }}`.replace(':id', item.id);
                    rentPriceAndType = `${item.rentPrice} @lang('SAR') / ${item.rent_type_show }`;
                } else if (item.isGalleryProject) {
                    showRoute = `{{ route('Broker.Project.show', ':id') }}`.replace(':id', item.id);
                } else if (item.isGalleryProperty) {
                    showRoute = `{{ route('Broker.Property.show', ':id') }}`.replace(':id', item.id);
                }
                new mapboxgl.Marker()
                    .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
                    .setPopup(new mapboxgl.Popup({ offset: 25 })
                        .setHTML(`
                        <div id="popup-${item.id}" style="width: 200px; cursor: pointer; display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <h6>${item.name || item.ad_name}</h6>
                            ${item.isGalleryUnit ? `
                            <p>
                                <i class="ti ti-bell-dollar"></i>${rentPriceAndType ? `<span class="pb-1">${rentPriceAndType}</span>` : ''}
                            </p>
                             ` : ''}
                            ${!item.isGalleryProject ? `
                                <p>
                                    <i class="ti ti-building-arch"></i> ${item.property_type_data ? item.property_type_data.name : ''} / ${item.type ? item.type : ''}
                                </p>
                            ` : ''} 
                            <p>
                                ${item.isGalleryUnit ? 
                                    (item.ProjectData ? `<span class="badge bg-label-secondary mt-1">${item.ProjectData.name}</span>` : '') + 
                                    " " + 
                                    (item.PropertyData ? `<span class="badge bg-label-secondary mt-1">${item.PropertyData.name}</span>` : '') + 
                                    ` <span class="badge bg-label-secondary mt-1">@lang('Unit')</span>`
                                : item.isGalleryProperty ? 
                                    (item.ProjectData ? `<span class="badge bg-label-secondary mt-1">${item.ProjectData.name}</span>` : '') + 
                                    ` <span class="badge bg-label-secondary mt-1">@lang('Property')</span>` 
                                : item.isGalleryProject ? 
                                    `<span class="badge bg-label-secondary mt-1">@lang('Project')</span>` 
                                : ''}
                            </p>
                            <p>
                                <i class="ti ti-map-pin"></i> ${item.city_data ? item.city_data.name : ''} / ${item.district_data ? item.district_data.name : ''}
                            </p>
                            <a href="${showRoute}" target="_blank" class="btn btn-primary mt-2">@lang('Show')</a>
                        </div>

                        `))
                    .addTo(map);
            }
        });
    }

    // Initial markers for My Properties
    addMarkers(items);

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

                // Add filtered markers to the first map
                addMarkers(filteredItems);

            }

            // Attach filter event handlers for the first map
            $('#adTypeFilter, #propertyTypeFilter, #typeUseFilter, #cityFilter, #districtFilter, #projectFilter').change(function() {
                filterItems();
            });

    // Toggle functionality
    document.getElementById('myPropertiesBtn').addEventListener('click', function() {
        $('#myPropertiesBtn').addClass('btn-primary').removeClass('btn-secondary');
        $('#allPropertiesBtn').addClass('btn-secondary').removeClass('btn-primary');

        // Remove existing markers
        $('.mapboxgl-marker').remove();

        // Add markers for My Properties
        addMarkers(items);
    });

    document.getElementById('allPropertiesBtn').addEventListener('click', function() {
        $('#myPropertiesBtn').addClass('btn-secondary').removeClass('btn-primary');
        $('#allPropertiesBtn').addClass('btn-primary').removeClass('btn-secondary');

        // Remove existing markers
        $('.mapboxgl-marker').remove();

        // Add markers for All Properties
        addMarkers(allItemsProperties);
    });
</script>
@endpush
@endsection
