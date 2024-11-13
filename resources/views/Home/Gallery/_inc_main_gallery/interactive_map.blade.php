{{-- <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
<link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js"></script>

<div id="map" style="height: 100vh;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapboxAccessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY2x6djJiaGZhMDNvdzJoc2djN2k4eHM0MiJ9.eOLXc1f7RLgcsbeIS4Us0Q';
        mapboxgl.accessToken = mapboxAccessToken;

        let mapInitialized = false;
        let map;
        var items = @json($mapItems);
        document.querySelector('button[data-bs-target="#navs-justified-gallery"]').addEventListener('click', function () {
            if (!mapInitialized) {
                initializeMap();
                addMarkers(items);
                mapInitialized = true;
            }
        });
    });

    function initializeMap() {
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [45.0, 23.8859],
            zoom: 5
        });
        map.addControl(new mapboxgl.NavigationControl());
    }

    function addMarkers(filteredItems) {
        console.log(filteredItems);
        filteredItems.forEach(function(item) {
            if (item.lat_long) {
                const coordinates = item.lat_long.split(',').map(parseFloat);
                const popupHtml = generatePopupHtml(item);

                new mapboxgl.Marker()
                    .setLngLat([coordinates[1], coordinates[0]])
                    .setPopup(new mapboxgl.Popup({ offset: 25 }).setHTML(popupHtml))
                    .addTo(map);
            }
        });
    }

    function generatePopupHtml(item) {
    const showRoute = getShowRoute(item);
    const rentPriceAndType = item.isGalleryUnit ? `${item.rentPrice} @lang('SAR') / ${item.rent_type_show}` : '';
    const imageUrl = item.unit_images?.[0]?.image
                   || item.project_images?.[0]?.image
                   || item.property_image
                   || '{{ asset("Offices/Projects/default.svg") }}';
    return `
        <div class="w-500">
            <a href="${showRoute}" target="_blank" class="card-popup">
                <div style="display: flex; gap: 1rem;">
                    <img src="${imageUrl}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                    <div>
                        <h6>${item.name || item.ad_name}</h6>
                        <p>${item.property_type_data?.name || ''} / ${item.type || ''}</p>
                        ${item.isGalleryUnit ? `<p>${rentPriceAndType}</p>` : ''}
                        <p>${item.city_data?.name || ''}</p>
                    </div>
                </div>
            </a>
            <button class="btn btn-success mt-2" onclick="showDecisionInputs(${item.id})">ساعدني في اتخاذ القرار</button>
            <div id="decision-inputs-${item.id}" style="display:none;">
                <input type="text" id="work-location-${item.id}" placeholder="مكان العمل" class="form-control mt-1" onclick="setActiveInput('work-location-${item.id}')" onkeyup="searchPlaces(event, 'work-location-${item.id}')">
                <input type="text" id="home-location-${item.id}" placeholder="مكان المنزل" class="form-control mt-1" onclick="setActiveInput('home-location-${item.id}')" onkeyup="searchPlaces(event, 'home-location-${item.id}')">
                <div id="search-results-${item.id}" class="search-results"></div>
                <button class="btn btn-info mt-2" onclick="calculateDistance(${item.id})">احسب المسافة</button>
                <div id="distance-output-${item.id}"></div>
            </div>
        </div>
    `;
}



    function setActiveInput(inputId) {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => input.classList.remove('active-input-id'));
        document.getElementById(inputId).classList.add('active-input-id');
        document.getElementById(`search-results-${inputId.split('-')[2]}`).innerHTML = ''; // إفراغ نتائج البحث
    }

    function searchPlaces(event, inputId) {
        const query = event.target.value;
        const searchResultsDiv = document.getElementById(`search-results-${inputId.split('-')[2]}`);

        if (query.length > 2) {
            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${mapboxgl.accessToken}`)
                .then(response => response.json())
                .then(data => {
                    const results = data.features.map(feature => {
                        return `<div class="result" onclick="selectPlace('${feature.place_name}', '${inputId}')">${feature.place_name}</div>`;
                    }).join('');
                    searchResultsDiv.innerHTML = results;
                })
                .catch(error => console.error('Error fetching places:', error));
        } else {
            searchResultsDiv.innerHTML = ''; // إفراغ نتائج البحث إذا كان الإدخال أقل من 3 أحرف
        }
    }

    function selectPlace(placeName, inputId) {
        document.getElementById(inputId).value = placeName;
        document.getElementById(`search-results-${inputId.split('-')[2]}`).innerHTML = ''; // إفراغ نتائج البحث بعد الاختيار
    }

    function getShowRoute(item) {
        const galleryName = item.broker_data?.gallery_data?.gallery_name || item.office_data?.gallery_data?.gallery_name || '';
        const routeMapping = {
            'unit': `{{ route('gallery.showUnitPublic', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`,
            'project': `{{ route('Home.showPublicProject', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`,
            'property': `{{ route('Home.showPublicProperty', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`
        };
        return routeMapping[item.isGalleryUnit ? 'unit' : item.isGalleryProject ? 'project' : 'property']
            .replace(':gallery_name', galleryName).replace(':id', item.id);
    }

    function showDecisionInputs(id) {
        document.getElementById(`decision-inputs-${id}`).style.display = 'block';
    }

    function calculateDistance(id) {
        const workLocation = document.getElementById(`work-location-${id}`).value;
        const homeLocation = document.getElementById(`home-location-${id}`).value;

        if (workLocation && homeLocation) {
   getRoute(itemLatLng, workLatLng, id, 'work');
            getRoute(itemLatLng, homeLatLng, id, 'home');
        }
    }

    function getLatLong(id, inputId) {
        const value = document.getElementById(`${inputId}-${id}`).value;
        return value.split(',').map(parseFloat);
    }

    function getRoute(start, end, id, type) {
        const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${start[1]},${start[0]};${end[1]},${end[0]}?geometries=geojson&access_token=${mapboxgl.accessToken}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0].geometry.coordinates;
                    addLineLayer(`route-${type}-${id}`, route, type === 'work' ? '#FF5733' : '#33FF57');
                    displayDistance(id, start, end, type, data.routes[0].distance);
                }
            })
            .catch(error => console.error('Error fetching route:', error));
    }

    function displayDistance(id, start, end, type, distance) {
        document.getElementById(`distance-output-${id}`).innerHTML += `
            <p>المسافة من ${type === 'work' ? 'مكان العمل' : 'المنزل'}: ${(distance / 1000).toFixed(2)} كم</p>
        `;
    }

    function addLineLayer(id, coordinates, color) {
        if (map.getLayer(id)) map.removeLayer(id);
        if (map.getSource(id)) map.removeSource(id);

        map.addLayer({
            id,
            type: 'line',
            source: { type: 'geojson', data: { type: 'Feature', geometry: { type: 'LineString', coordinates } } },
            layout: { 'line-join': 'round', 'line-cap': 'round' },
            paint: { 'line-color': color, 'line-width': 4 }
        });
    }
</script>

<style>
    .search-results {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        position: absolute;
        background-color: white;
        z-index: 1000;
    }
    .result {
        padding: 10px;
        cursor: pointer;
    }
    .result:hover {
        background-color: #f0f0f0;
    }
</style> --}}





    <link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js"></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js'></script>

    <div id="map" style="height: 100vh;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapboxAccessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY20yZGRnYjdtMTFzYjJtcjF2bWZzYXI1MyJ9.S9E63v7J_e7I5iCuEiLZSw';
            mapboxgl.accessToken = mapboxAccessToken;

            let mapInitialized = false;
            let map;
            var items = @json($mapItems);

            document.querySelector('button[data-bs-target="#navs-justified-gallery"]').addEventListener('click', function() {
                if (!mapInitialized) {
                    initializeMap();
                    addMarkers(items);
                    mapInitialized = true;
                }
            });
        });

        function initializeMap() {
            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [45.0, 23.8859],
                zoom: 5
            });
            map.addControl(new mapboxgl.NavigationControl());
        }

        function addMarkers(filteredItems) {
            filteredItems.forEach(function(item) {
                if (item.lat_long) {
                    const coordinates = item.lat_long.split(',').map(parseFloat);
                    const popupHtml = generatePopupHtml(item);

                    new mapboxgl.Marker()
                        .setLngLat([coordinates[1], coordinates[0]])
                        .setPopup(new mapboxgl.Popup({
                            offset: 25
                        }).setHTML(popupHtml))
                        .addTo(map);
                }
            });
        }

        function generatePopupHtml(item) {
            const showRoute = getShowRoute(item);
            const rentPriceAndType = item.isGalleryUnit ? `${item.rentPrice} @lang('SAR') / ${item.rent_type_show}` : '';
            const imageUrl = item.unit_images?.[0]?.image
                        || item.project_images?.[0]?.image
                        || item.property_image
                        || '{{ asset("Offices/Projects/default.svg") }}';
            return `
                <div class="w-500">
                    <a href="${showRoute}" target="_blank" class="card-popup">
                        <div style="display: flex; gap: 1rem;">
                            <img src="${imageUrl}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                            <div>
                                <h6>${item.name || item.ad_name}</h6>
                                <p>${item.property_type_data?.name || ''} / ${item.type || ''}</p>
                                ${item.isGalleryUnit ? `<p>${rentPriceAndType}</p>` : ''}
                                <p>${item.city_data?.name || ''}</p>
                            </div>
                        </div>
                    </a>
                <button class="btn btn-success mt-2 mb-2" onclick="toggleDecisionInputs(${item.id})">ساعدني في اتخاذ القرار</button>
                <div id="decision-inputs-${item.id}" style="display:none;">
                    <div id="work-coordinates-${item.id}" class="form-control m-2 mb-2"></div>
                    <div id="home-coordinates-${item.id}" class="form-control m-2 mb-2"></div>
                    <button class="btn btn-info mt-2" onclick="calculateDistance(${item.id}, '${item.lat_long}')">احسب المسافة</button>
                    <div id="distance-output-${item.id}"></div>
                </div>
            </div>
            `;
        }

        function getShowRoute(item) {
            const galleryName = item.broker_data?.gallery_data?.gallery_name || item.office_data?.gallery_data?.gallery_name || '';
            const routeMapping = {
                'unit': `{{ route('gallery.showUnitPublic', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`,
                'project': `{{ route('Home.showPublicProject', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`,
                'property': `{{ route('Home.showPublicProperty', ['gallery_name' => ':gallery_name', 'id' => ':id']) }}`
            };
            return routeMapping[item.isGalleryUnit ? 'unit' : item.isGalleryProject ? 'project' : 'property']
                .replace(':gallery_name', galleryName).replace(':id', item.id);
        }

        function toggleDecisionInputs(id) {
            const decisionInputs = document.getElementById(`decision-inputs-${id}`);
            if (decisionInputs.style.display === 'none' || decisionInputs.style.display === '') {
                decisionInputs.style.display = 'block';

                // إضافة Geocoder لمكان العمل
                const workGeocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    placeholder: 'ابحث عن مكان العمل',
                    mapboxgl: mapboxgl,
                    flyTo: false
                });
                document.getElementById(`work-coordinates-${id}`).replaceWith(workGeocoder.onAdd(map));

                // إضافة Geocoder لمكان المنزل
                const homeGeocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    placeholder: 'ابحث عن مكان المنزل',
                    mapboxgl: mapboxgl,
                    flyTo: false
                });
                document.getElementById(`home-coordinates-${id}`).replaceWith(homeGeocoder.onAdd(map));

                // حفظ الإحداثيات عند اختيار مكان
                workGeocoder.on('result', function(e) {
                    decisionInputs.dataset.workCoordinates = `${e.result.center[1]},${e.result.center[0]}`;
                });
                homeGeocoder.on('result', function(e) {
                    decisionInputs.dataset.homeCoordinates = `${e.result.center[1]},${e.result.center[0]}`;
                });
            } else {
                decisionInputs.style.display = 'none';
            }
        }

        function calculateDistance(id, itemCoordinates) {
            const decisionInputs = document.getElementById(`decision-inputs-${id}`);
            const workLatLng = decisionInputs.dataset.workCoordinates.split(',').map(parseFloat);
            const homeLatLng = decisionInputs.dataset.homeCoordinates.split(',').map(parseFloat);
            const itemLatLng = itemCoordinates.split(',').map(parseFloat);

            // مسح النتائج السابقة
            document.getElementById(`distance-output-${id}`).innerHTML = '';

            if (workLatLng && homeLatLng) {
                getRoute(itemLatLng, workLatLng, id, 'work');
                getRoute(itemLatLng, homeLatLng, id, 'home');
            }
        }

        function getRoute(start, end, id, type) {
            const url = `https://api.mapbox.com/directions/v5/mapbox/driving/${start[1]},${start[0]};${end[1]},${end[0]}?geometries=geojson&access_token=${mapboxgl.accessToken}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.routes && data.routes.length > 0) {
                        const route = data.routes[0].geometry.coordinates;
                        addLineLayer(`route-${type}-${id}`, route, type === 'work' ? '#FF5733' : '#33FF57');
                        displayDistance(id, start, end, type, data.routes[0].distance, data.routes[0].duration);
                    }
                })
                .catch(error => console.error('Error fetching route:', error));
        }

        function displayDistance(id, start, end, type, distance, duration) {
            const distanceKm = (distance / 1000).toFixed(2);
            const durationMinutes = (duration / 60).toFixed(2);
            document.getElementById(`distance-output-${id}`).innerHTML += `
                <p>المسافة من ${type === 'work' ? 'مكان العمل' : 'المنزل'}: ${distanceKm} كم</p>
            `;
            // <p>الزمن المتوقع: ${durationMinutes} دقيقة</p>

            // إضافة نصوص توضيحية على الخريطة
            new mapboxgl.Marker({ color: type === 'work' ? '#FF5733' : '#33FF57' })
                .setLngLat(end)
                .setPopup(new mapboxgl.Popup().setHTML(`<p>المسافة: ${distanceKm} كم<br>الزمن: ${durationMinutes} دقيقة</p>`))
                .addTo(map);
        }

        function addLineLayer(id, coordinates, color) {
            if (map.getLayer(id)) map.removeLayer(id);
            if (map.getSource(id)) map.removeSource(id);

            map.addLayer({
                id,
                type: 'line',
                source: { type: 'geojson', data: { type: 'Feature', geometry: { type: 'LineString', coordinates } } },
                layout: { 'line-join': 'round', 'line-cap': 'round' },
                paint: { 'line-color': color, 'line-width': 4 }
            });
        }
    </script>





