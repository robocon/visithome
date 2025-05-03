<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

</head>

<body>
    <p>https://leafletjs.com/examples.html</p>
    <style>
        #map {
            height: 180px;
        }
    </style>
    <div id="map"></div>
    <script>
        var map = L.map('map').setView([18.286754, 459.506146], 16);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);


        const marker = L.marker([18.286754, 459.506146]).addTo(map)
            .bindPopup('<b>Hello world!</b><br />I am a popup.').openPopup();

        // 18.286754, 459.506146

        // const popup = L.popup()
        //     .setLatLng([18.286754, 459.506146])
        //     .setContent('I am a standalone popup.')
        //     .openOn(map);

        function onMapClick(e) {
            // เปลี่ยนจาก popup เป็น marker ได้
            marker 
                .setLatLng(e.latlng)
                .setContent(`You clicked the map at ${e.latlng.toString()}`)
                .openOn(map);
        }

        map.on('click', onMapClick);
    </script>
</body>

</html>