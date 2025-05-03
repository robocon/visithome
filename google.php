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
</head>

<body>
    <style>
        #map {
            height: 400px;
            width: 100%;
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
        let map;

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
                mapId: "DEMO_MAP_ID",
            });

            const infoWindow = new InfoWindow();

            // The marker, positioned at Uluru
            // const marker = new AdvancedMarkerElement({
            //     map: map,
            //     position: position,
            //     title: "Uluru",
            // });


            const position2 = {lat: 18.28633927080087, lng: 99.50619375927566};
            const marker2 = new AdvancedMarkerElement({
                map: map,
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
            marker2.addListener("gmp-dragend", (event) => {
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



        }

        initMap();
    </script>
</body>

</html>