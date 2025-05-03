<?php 
include_once 'config.php';

if(isLogin()===false){
    header('Location: login_page.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
    html{
        height:100%;
    }
    body{
        margin:0px;
        height:100%;
    }
    #map {
        height: 100%;
    }
    </style>
    <script type="text/javascript" src="https://api.longdo.com/map/?key=<?=LONGDO_KEY;?>"></script>
    <script>
        var map;
        var currentLocation;
        var marker;
        function init() {
            // default เป็น รพ.ศูนย์ฯ
            map = new longdo.Map({
                zoom: 16,
                location: {
                    lon: 99.50614155954202,
                    lat: 18.28686564875173
                },
                placeholder: document.getElementById('map'),
                lastView: false
            });

            const locationList = [
                { location: { lon: 99.50766518712044, lat: 18.283809092960112 }, options: { title: 'Marker 1', detail: 'Detail Marker 1' } },
                { location: { lon: 99.50300887227058, lat: 18.285948387953756 }, options: { title: 'Marker 2', detail: 'Detail Marker 2' } },
                { location: { lon: 99.51002553105354, lat: 18.288209899675525 }, options: { title: 'Marker 3', detail: 'Detail Marker 3' } },
            ];

            for (let index = 0; index < locationList.length; index++) {
                const element = locationList[index];
                map.Overlays.add(
                    new longdo.Marker(element.location, element.options)
                );
            }
            
            
            map.Ui.DPad.visible(false);
            map.Ui.Zoombar.visible(false);
            map.Ui.Geolocation.visible(false);
            map.Ui.Terrain.visible(false);
            map.Ui.LayerSelector.visible(false);
        }

        // แทนที่ body onload="init()"
        window.onload = init;

        async function setMarker() {
            currentLocation = map.location();

            document.getElementById('locationLat').innerHTML = currentLocation.lat;
            document.getElementById('locationLon').innerHTML = currentLocation.lon;

            /*
            var marker = new longdo.Marker({lat: currentLocation.lat,lon: currentLocation.lon},{
                title: 'Custom Marker',
                icon: {
                    html: '<div style="background: green; width: 50px; height: 22px; text-align: center;"><b>Marker</b></div>',
                    offset: { x: 25, y: 11 }
                },
                popup: {
                    html: '<div style="background: #eeeeff;"><button onclick="delMarker('+marker+')">ลบ</button></div>'
                }
            });
            */
            
            map.Overlays.clear();

            var marker = new longdo.Marker({lat: currentLocation.lat,lon: currentLocation.lon});
            map.Overlays.add(marker);

            map.Event.bind(longdo.EventName.OverlayClick, function(overlay) {

                var popup2 = new longdo.Popup({ lon: currentLocation.lon, lat: currentLocation.lat },
                {
                    title: 'Popup',
                    detail: 'Popup detail...',
                    // loadDetail: updateDetail,
                    // size: { width: 200, height: 200 },
                    closable: true
                });

                map.Overlays.add(popup2);

            });

            const p = await getGeocoding(currentLocation.lat, currentLocation.lon);
            document.getElementById('address').value = JSON.stringify(p);
        }

        async function getGeocoding(lat, lon){
            let url = 'https://api.longdo.com/map/services/address?lon='+lon+'&lat='+lat+'&noelevation=1&key=<?=LONGDO_KEY;?>';

            const response = await fetch(url);
            const body = await response.json();

            return body;
        }

        function delMarker(marker){
            map.Overlays.remove(marker);
        }
        function removeMarker(){
            map.Overlays.clear();
        }
        
    </script>
</head>
<body>
    <p>https://map.longdo.com/docs/</p>
    <div style="width:100%; height: 400px;">
        <div id="map"></div>
    </div>
    <div>
        <button type="button" onclick="setMarker();">Pin mark</button>
        <button type="button" onclick="removeMarker()">Remove</button>
    </div>
    <div>
        Location: Lat: <span id="locationLat"></span> Lon: <span id="locationLon"></span>
    </div>
    <div>
        <textarea name="" id="address" style="width:100%; height:100px;"></textarea>
    </div>
    <div>
        <button type="button" onclick="doLogout()">Logout</button>
    </div>
    
    <script>
        async function doLogout(){

            let formData = new FormData();
            formData.append('action', 'logout');

            await sendPost('login.php', formData).then((res)=>{
                if(res.status===200){
                    window.location.href = 'login_page.php';
                }
            });
        }

        async function sendPost(url, formData){
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            return data;
        }
    </script>
</body>
</html>