<div id="map" style="height: 100vh;"></div>

<!-- Modal for Help Me Decide -->
<div class="modal fade" id="helpMeDecideModal" tabindex="-1" aria-labelledby="helpMeDecideLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="helpMeDecideLabel">@lang('Enter Your Home and Work Locations')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="homeCoordinates" class="form-label">@lang('Home Location (lat,long)')</label>
            <input type="text" class="form-control" id="homeCoordinates" placeholder="17.5486111,44.25125">
          </div>
          <div class="mb-3">
            <label for="workCoordinates" class="form-label">@lang('Work Location (lat,long)')</label>
            <input type="text" class="form-control" id="workCoordinates" placeholder="17.5486111,44.25125">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
          <button type="button" id="calculateDistanceBtn" class="btn btn-primary">@lang('Calculate Distance')</button>
        </div>
      </div>
    </div>
  </div>


<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />

<!-- Include Mapbox JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

<link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapboxAccessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY20yZGRnYjdtMTFzYjJtcjF2bWZzYXI1MyJ9.S9E63v7J_e7I5iCuEiLZSw'; // Replace with your actual token
        mapboxgl.accessToken = mapboxAccessToken;

        let mapInitialized = false;
        let map; // Define map variable in the outer scope
        var items = @json($allItems);

        // Add event listener for initializing map when the tab is clicked
        document.querySelector('button[data-bs-target="#navs-justified-gallery"]').addEventListener('click', function () {
            if (!mapInitialized) {
                map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [45.0, 23.8859],
                    zoom: 5
                });


                // Optional: Add map controls
                map.addControl(new mapboxgl.NavigationControl());

                // Function to add markers and popups
                function addMarkers(filteredItems) {
                    filteredItems.forEach(function(item) {
                        if (item.lat_long) {
                            var coordinates = item.lat_long.split(',');
                            var showRoute = '#';
                            var rentPriceAndType = '';

                            var galleryName = item.broker_data ? item.broker_data.gallery_data?.gallery_name :
                                              item.office_data ? item.office_data.gallery_data?.gallery_name : '';

                            if (item.isGalleryUnit) {
                                showRoute = `{{ route('gallery.showUnitPublic', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`.replace(':gallery_name', galleryName).replace(':id', item.id);
                                rentPriceAndType = `${item.rentPrice} @lang('SAR') / ${item.rent_type_show}`;
                            } else if (item.isGalleryProject) {
                                showRoute = `{{ route('Home.showPublicProject', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`.replace(':gallery_name', galleryName).replace(':id', item.id);
                            } else if (item.isGalleryProperty) {
                                showRoute = `{{ route('Home.showPublicProperty', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`.replace(':gallery_name', galleryName).replace(':id', item.id);
                            }
                            console.log(item);

                            // Create marker and popup with "ساعدني في اتخاذ القرار" button and inputs
                            new mapboxgl.Marker()
                                .setLngLat([parseFloat(coordinates[1]), parseFloat(coordinates[0])])
                                .setPopup(new mapboxgl.Popup({ offset: 25 })
                                .setHTML(`
                                    <a href="${showRoute}" target="_blank" class="card-popup" style="text-decoration: none;">
                                        <div id="popup-${item.id}" style="width: 230px; cursor: pointer; display: flex; flex-direction: row; align-items: center;">
                                            <div style="flex: 1;">
                                                <img src="${item.unit_images && item.unit_images.length > 0 ? item.unit_images[0].image : 'Offices/Projects/default.svg'}" alt="${item.name}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                                            </div>
                                            <div style="flex: 2; padding-left: 10px;">
                                                <h6>${item.name || item.ad_name}</h6>
                                                <p><i class="ti ti-building-arch"></i> ${item.property_type_data ? item.property_type_data.name : ''} / ${item.type ? item.type : ''}</p>
                                                ${item.isGalleryUnit ? `<p><i class="ti ti-bell-dollar"></i> ${rentPriceAndType ? `<span class="pb-1">${rentPriceAndType}</span>` : ''}</p>` : ''}
                                                <p>
                                                    ${item.isGalleryUnit ?
                                                        (item.project_data ? `<span class="badge bg-label-secondary mt-1">${item.project_data.name}</span>` : '') +
                                                        " " +
                                                        (item.property_data ? `<span class="badge bg-label-secondary mt-1">${item.property_data.name}</span>` : '') +
                                                        ` <span class="badge bg-label-secondary mt-1">@lang('Unit')</span>`
                                                    : item.isGalleryProperty ?
                                                        (item.project_data ? `<span class="badge bg-label-secondary mt-1">${item.project_data.name}</span>` : '') +
                                                        ` <span class="badge bg-label-secondary mt-1">@lang('property')</span>`
                                                    : item.isGalleryProject ?
                                                        `<span class="badge bg-label-secondary mt-1">@lang('Project')</span>`
                                                    : ''}
                                                </p>
                                                <p><i class="ti ti-map-pin"></i> ${item.city_data ? item.city_data.name : ''}</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div style="padding-top: 10px;">
                                        <button class="btn btn-success mt-2" onclick="showDecisionInputs(${item.id})">ساعدني في اتخاذ القرار</button>
                                        <div id="decision-inputs-${item.id}" style="display:none; margin-top: 10px;">
                                            <input type="text" id="work-coordinates-${item.id}" placeholder="مكان العمل (lat,long)" class="form-control mt-1">
                                            <input type="text" id="home-coordinates-${item.id}" placeholder="مكان المنزل (lat,long)" class="form-control mt-1">
                                            <button class="btn btn-info mt-2" onclick="calculateDistance(${item.id}, '${item.lat_long}')">احسب المسافة</button>
                                            <div id="distance-output-${item.id}" class="mt-2"></div>
                                        </div>
                                    </div>
                                `))
                            .addTo(map);
                        }
                    });
                }

                addMarkers(items);

                mapInitialized = true;
            }
        });
    });

    function showDecisionInputs(id) {
        document.getElementById(`decision-inputs-${id}`).style.display = 'block';
    }

    function calculateDistance(id, itemCoordinates) {
        const workCoordinates = document.getElementById(`work-coordinates-${id}`).value.split(',');
        const homeCoordinates = document.getElementById(`home-coordinates-${id}`).value.split(',');
        const itemLatLong = itemCoordinates.split(',');

        const workLatLng = [parseFloat(workCoordinates[1]), parseFloat(workCoordinates[0])];
        const homeLatLng = [parseFloat(homeCoordinates[1]), parseFloat(homeCoordinates[0])];
        const itemLatLng = [parseFloat(itemLatLong[1]), parseFloat(itemLatLong[0])];

        // حساب المسافة
        const workDistance = calculateLatLongDistance(parseFloat(workCoordinates[0]), parseFloat(workCoordinates[1]), parseFloat(itemLatLong[0]), parseFloat(itemLatLong[1]));
        const homeDistance = calculateLatLongDistance(parseFloat(homeCoordinates[0]), parseFloat(homeCoordinates[1]), parseFloat(itemLatLong[0]), parseFloat(itemLatLong[1]));

        const speed = 60; // السرعة بالكيلومترات في الساعة
        const workTime = workDistance / speed;
        const homeTime = homeDistance / speed;

        const workTimeInHours = Math.floor(workTime);
        const workTimeInMinutes = Math.round((workTime - workTimeInHours) * 60);

        const homeTimeInHours = Math.floor(homeTime);
        const homeTimeInMinutes = Math.round((homeTime - homeTimeInHours) * 60);

        // عرض المسافة والزمن
        document.getElementById(`distance-output-${id}`).innerHTML = `
            <p>المسافة من مكان العمل: ${workDistance.toFixed(2)} كم</p>
            <p>الزمن المستغرق من مكان العمل: ${workTimeInHours} ساعات و ${workTimeInMinutes} دقائق</p>
            <p>المسافة من المنزل: ${homeDistance.toFixed(2)} كم</p>
            <p>الزمن المستغرق من المنزل: ${homeTimeInHours} ساعات و ${homeTimeInMinutes} دقائق</p>
        `;

        // رسم الخطوط على الخريطة
        drawRoute(id, itemLatLng, workLatLng, homeLatLng);
    }

    function drawRoute(id, itemLatLng, workLatLng, homeLatLng) {
        // مسار العمل
        map.addLayer({
            id: `route-work-${id}`,
            type: 'line',
            source: {
                type: 'geojson',
                data: {
                    type: 'Feature',
                    properties: {},
                    geometry: {
                        type: 'LineString',
                        coordinates: [itemLatLng, workLatLng]
                    }
                }
            },
            layout: {
                'line-join': 'round',
                'line-cap': 'round'
            },
            paint: {
                'line-color': '#FF5733',
                'line-width': 5
            }
        });

        // مسار المنزل
        map.addLayer({
            id: `route-home-${id}`,
            type: 'line',
            source: {
                type: 'geojson',
                data: {
                    type: 'Feature',
                    properties: {},
                    geometry: {
                        type: 'LineString',
                        coordinates: [itemLatLng, homeLatLng]
                    }
                }
            },
            layout: {
                'line-join': 'round',
                'line-cap': 'round'
            },
            paint: {
                'line-color': '#33FF57',
                'line-width': 5
            }
        });
    }

    function calculateLatLongDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // نصف قطر الأرض بالكيلومترات
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // المسافة بالكيلومترات
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
</script>

