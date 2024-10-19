<!-- Home/Gallery/_inc_main_gallery/interactive_map.blade.php -->
<div id="map" style="height: 100vh;"></div>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />

<!-- Include Mapbox JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the mapbox map when the tab is clicked
        const mapboxAccessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY20yZGRnYjdtMTFzYjJtcjF2bWZzYXI1MyJ9.S9E63v7J_e7I5iCuEiLZSw'; // Replace with your actual token

        let mapInitialized = false; // To avoid re-initializing the map
        var items = @json($allItems);

document.querySelector('button[data-bs-target="#navs-justified-gallery"]').addEventListener('click', function() {
    if (!mapInitialized) {
        mapboxgl.accessToken = mapboxAccessToken;
        const map = new mapboxgl.Map({
            container: 'map', // The id of the div where the map will be rendered
            style: 'mapbox://styles/mapbox/streets-v11', // Mapbox style
            center: [45.0, 23.8859],
            zoom: 5 // Default zoom level
        });

        // Optional: Add map controls
        map.addControl(new mapboxgl.NavigationControl());
console.log(items);
        // Optional: Add markers based on your items
        function addMarkers(filteredItems) {
            console.log(allItems);
            filteredItems.forEach(function(item) {
                if (item.lat_long) {
                    var coordinates = item.lat_long.split(',');
                    var showRoute = '#';
                    var rentPriceAndType = '';

                    var galleryName = item.broker_data ? item.broker_data.gallery_data?.gallery_name :
                                      item.office_data ? item.office_data.gallery_data?.gallery_name : '';

                    // Determine the correct show route and rent price/type
                    if (item.isGalleryUnit) {
                        showRoute = `{{ route('gallery.showUnitPublic', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`
                                    .replace(':gallery_name', galleryName)
                                    .replace(':id', item.id);
                        rentPriceAndType = `${item.rentPrice} @lang('SAR') / ${item.rent_type_show}`;
                    } else if (item.isGalleryProject) {
                        showRoute = `{{ route('Home.showPublicProject', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`
                                    .replace(':gallery_name', galleryName)
                                    .replace(':id', item.id);
                    } else if (item.isGalleryProperty) {
                        showRoute = `{{ route('Home.showPublicProperty', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`
                                    .replace(':gallery_name', galleryName)
                                    .replace(':id', item.id);
                    }

                    // Create the map marker and popup content
                    new mapboxgl.Marker()
                        .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
                        .setPopup(new mapboxgl.Popup({ offset: 25 })
                            .setHTML(`
                                <div id="popup-${item.id}" style="width: 200px; cursor: pointer; display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    <h6>${item.name || item.ad_name}</h6>
                                    ${!item.isGalleryProject ? `
                                        <p>
                                            <i class="ti ti-building-arch"></i> ${item.property_type_data ? item.property_type_data.name : ''} / ${item.type ? item.type : ''}
                                        </p>
                                    ` : ''}
                                    ${item.isGalleryUnit ? `
                                        <p>
                                            <i class="ti ti-bell-dollar"></i> ${rentPriceAndType ? `<span class="pb-1">${rentPriceAndType}</span>` : ''}
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
                                            ` <span class="badge bg-label-secondary mt-1">@lang('property')</span>`
                                        : item.isGalleryProject ?
                                            `<span class="badge bg-label-secondary mt-1">@lang('Project')</span>`
                                        : ''}
                                    </p>
                                    <p>
                                        <i class="ti ti-map-pin"></i> ${item.city_data ? item.city_data.name : ''}
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

                mapInitialized = true;
            }
        });
    });
</script>
