


<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
<link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.css" rel="stylesheet" />
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.0/mapbox-gl-directions.js"></script>

<div id="map" style="height: 100vh;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapboxAccessToken = 'pk.eyJ1IjoiYmx1ZWNvZGVrc2EiLCJhIjoiY20yZGRnYjdtMTFzYjJtcjF2bWZzYXI1MyJ9.S9E63v7J_e7I5iCuEiLZSw';
        mapboxgl.accessToken = mapboxAccessToken;

        let mapInitialized = false;
        let map;
        var items = @json($allItems);
        document.querySelector('button[data-bs-target="#navs-justified-gallery"]').addEventListener('click', function () {
            if (!mapInitialized) {
                initializeMap();
                addMarkers(items);
                mapInitialized = true;
            }
        });
    });
    var items = @json($allItems);
    console.log(items)

    function initializeMap() {
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [45.0, 23.8859],
            zoom: 5
        });
        map.addControl(new mapboxgl.NavigationControl());
    }
    function addMarkers(items) {
        items.forEach(function(item) {
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
        return `
        <div class="w-500">
            <a href="${showRoute}" target="_blank" class="card-popup">
                <div style="display: flex; gap: 1rem;">
                    <img src="${item.unit_images?.[0]?.image || 'Offices/Projects/default.svg'}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
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
                <input type="text" id="work-coordinates-${item.id}" placeholder="مكان العمل" class="form-control mt-1">
                <input type="text" id="home-coordinates-${item.id}" placeholder="مكان المنزل" class="form-control mt-1">
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

    function showDecisionInputs(id) {
        document.getElementById(`decision-inputs-${id}`).style.display = 'block';
    }

    function calculateDistance(id, itemCoordinates) {
        const workLatLng = getLatLong(id, 'work-coordinates');
        const homeLatLng = getLatLong(id, 'home-coordinates');
        const itemLatLng = itemCoordinates.split(',').map(parseFloat);

        if (workLatLng && homeLatLng) {
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
