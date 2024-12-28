
<?php
// Add the link to Leaflet CSS
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />';

// Add the script tag for Leaflet JavaScript
echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';

// Add the map container div
echo '<div id="map' . $journeyIndex . '" class="map_container" style="height: 400px; width: 100%;"></div>';

// Add var_dump here to inspect $routeData
var_dump($routeData);

// Start the JavaScript section
echo '<script>';
echo 'document.addEventListener("DOMContentLoaded", function() {';

// Initialize the map
echo 'var map' . $journeyIndex . ' = L.map("map' . $journeyIndex . '").setView([' . $routeData[0]["coords"][0][0] . ', ' . $routeData[0]["coords"][0][1] . '], 13);';
echo 'L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors"
}).addTo(map' . $journeyIndex . ');';

// Add polylines
foreach ($routeData as $segment) {
    $coords = $segment["coords"];
    $color = $segment["color"];
    echo 'var polyline = L.polyline(' . json_encode($coords) . ', {color: "' . $color . '"}).addTo(map' . $journeyIndex . ');';
}

// Add departure and arrival markers
echo 'var departureMarker = L.marker([' . $routeData[0]["coords"][0][0] . ', ' . $routeData[0]["coords"][0][1] . ']).addTo(map' . $journeyIndex . ');
    departureMarker.bindPopup("Departure: ' . $data['journeys'][$journeyIndex]['sections'][0]['from']['name'] . '");
    var arrivalMarker = L.marker([' . end($routeData)["coords"][1][0] . ', ' . end($routeData)["coords"][1][1] . ']).addTo(map' . $journeyIndex . ');
    arrivalMarker.bindPopup("Arrival: ' . end($data['journeys'][$journeyIndex]['sections'])['to']['name'] . '");';

echo '});';
echo '</script>';
?>
