<?php
include 'config.php';
?>
<!doctype html>
<!--
 @license
 Copyright 2019 Google LLC. All Rights Reserved.
 SPDX-License-Identifier: Apache-2.0
-->
<html>

<head>
    <title>Add Map</title>
    <script src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script>

</head>

<body>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

/*
 * Property styles in unhighlighted state.
 */
.property {
  align-items: center;
  background-color: #FFFFFF;
  border-radius: 50%;
  color: #263238;
  display: flex;
  font-size: 14px;
  gap: 15px;
  height: 30px;
  justify-content: center;
  padding: 4px;
  position: relative;
  position: relative;
  transition: all 0.3s ease-out;
  width: 30px;
}

.property::after {
  border-left: 9px solid transparent;
  border-right: 9px solid transparent;
  border-top: 9px solid #FFFFFF;
  content: "";
  height: 0;
  left: 50%;
  position: absolute;
  top: 95%;
  transform: translate(-50%, 0);
  transition: all 0.3s ease-out;
  width: 0;
  z-index: 1;
}
.property .icon {
  align-items: center;
  display: flex;
  justify-content: center;
  color: #FFFFFF;
}

.property .icon svg {
  height: 20px;
  width: auto;
}

.property .details {
  display: none;
  flex-direction: column;
  flex: 1;
}

.property.highlight .icon svg {
  width: 50px;
  height: 50px;
}


/*
 * House icon colors.
 */
.property.highlight:has(.fa-house) .icon {
  color: var(--house-color);
}

.property:not(.highlight):has(.fa-house) {
  background-color: var(--house-color);
}

.property:not(.highlight):has(.fa-house)::after {
  border-top: 9px solid var(--house-color);
}
    </style>
    <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>

    <!-- prettier-ignore -->
    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
        })
        ({
            key: "<?=GOOGLE_MAP_KEY;?>",
            v: "weekly"
        });
    </script>
    <script>
        // Initialize and add the map
        var map;

        async function initMap() {
            // The location of Uluru
            const position = {
                lat: 18.286936932494427,
                lng: 99.50597742958915
            };
            // Request needed libraries.
            //@ts-ignore
            const {Map, InfoWindow } = await google.maps.importLibrary("maps");
            const {AdvancedMarkerElement} = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 16,
                center: position,
                mapId: "4504f8b37365c3d0",
            });

            const infoWindow = new InfoWindow();

            /*
            infoWindow.open(map);
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();
                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });
                infoWindow.setContent(
                    JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
                );
                infoWindow.open(map);
            });
            */


            const position2 = {lat: 18.28633927080087, lng: 99.50619375927566};
            const marker2 = new AdvancedMarkerElement({
                map,
                position: position2,
                gmpClickable: true,
                gmpDraggable: true,
                title: "This marker is draggable.",
                
            });
            marker2.addListener("gmp-click", (event) => {
                const position = marker2.position;

                infoWindow.close();
                infoWindow.setContent(marker2.title);
                infoWindow.open(marker2.map, marker2);
            });
            marker2.addListener("dragend", (event) => {
                const position = marker2.position;

                infoWindow.close();
                infoWindow.setContent(`Pin dropped at: ${position.lat}, ${position.lng}`);
                infoWindow.open(marker2.map, marker2);
            });
            


            /**
             * Multiple Markers
             */

             const properties = [
                {
                    name: "House 1",
                    address: "Address House 1",
                    position: {
                        lat: 18.286441141103037, 
                        lng: 99.50037805216482,
                    },
                },
                {
                    name: "House 2",
                    address: "Address House 2",
                    position: {
                        lat: 18.284027762634818, 
                        lng: 99.50038981459369,
                    },
                },
                {
                    name: "House 3",
                    address: "Address House 3",
                    position: {
                        lat: 18.28423150589536, 
                        lng: 99.50341534636249,
                    },
                },
            ];

            
            for (const property of properties) {
                const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                    map,
                    // content: buildContent(property),
                    position: property.position,
                    title: property.name,
                });

                AdvancedMarkerElement.addListener("gmp-click", (event) => {
                    const position = AdvancedMarkerElement.position;

                    infoWindow.close();
                    infoWindow.setContent(AdvancedMarkerElement.title);
                    infoWindow.open(AdvancedMarkerElement.map, AdvancedMarkerElement);
                });

                // AdvancedMarkerElement.addListener("click", () => {
                //     toggleHighlight(AdvancedMarkerElement, property);
                // });
            }
            
            // function toggleHighlight(markerView, property) {
            //     if (markerView.content.classList.contains("highlight")) {
            //         markerView.content.classList.remove("highlight");
            //         markerView.zIndex = null;
            //     } else {
            //         markerView.content.classList.add("highlight");
            //         markerView.zIndex = 1;
            //     }
            // }

            // function buildContent(property) {
            //     const content = document.createElement("div");

            //     content.classList.add("property");
            //     content.innerHTML = `
            //         <div>${property.name}</div>
            //         <div>${property.address}</div>
            //         `;
            //     return content;
            // }

            // document.getElementById("delete-markers").addEventListener("click", deleteMarkers);

        } // End initMap

        initMap();


        let markers = [];
        function addMarker() {

            let infoWindow = new google.maps.InfoWindow();

            const defPosition = {lat: map.getCenter().lat(), lng: map.getCenter().lng()};
            

// const icon = document.createElement("div");

// icon.innerHTML = '<i class="fa fa-pizza-slice fa-lg"></i>';

// const faPin = new PinElement({
//   glyph: icon,
//   glyphColor: "#ff8300",
//   background: "#FFD514",
//   borderColor: "#ff8300",
// });


            const marker = new google.maps.marker.AdvancedMarkerElement({
                map,
                position: defPosition,
                title: "New Marker",
                content: buildContent(),
                gmpDraggable: true,
            });
            markers.push(marker);
            marker.addListener("gmp-click", (event) => {
                const position = marker.position;

                // infoWindow.close();
                // infoWindow.setContent(marker.title);
                // infoWindow.open(marker.map, marker);

                toggleHighlight(marker);
            });

            marker.addListener("dragend", (event) => {
                const newPosition = marker.position;

                // infoWindow.close();
                // infoWindow.setContent(`Pin dropped at: ${newPosition.lat}, ${newPosition.lng}`);
                // infoWindow.open(marker.map, marker);
            });

        }

        function toggleHighlight(markerView, property) {
  if (markerView.content.classList.contains("highlight")) {
    markerView.content.classList.remove("highlight");
    markerView.zIndex = null;
  } else {
    markerView.content.classList.add("highlight");
    markerView.zIndex = 1;
  }
}
        

        function buildContent(){
            const content = document.createElement("div");
            // content.classList.add("property");
            content.innerHTML = `<div class="icon">
        <i aria-hidden="true" class="fa fa-icon fa-home" title="home"></i>
        <span class="fa-sr-only">home</span>
    </div>
    <div><strong>New</strong> Map html</div>`;
            return content;
        }

        function delMarker(){
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }
        
    </script>
    <form action="javascript:void(0);" method="post">
        <div>
            <button type="button" onclick="addMarker()">Add marker</button>
            <button type="button" onclick="delMarker()">Remove marker</button>
        </div>
    </form>
    <p>https://developers.google.com/maps/documentation/javascript/advanced-markers/add-marker</p>
    <script></script>
</body>

</html>