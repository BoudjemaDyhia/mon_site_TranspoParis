

<?php
$pageTitle = "Trajet";
$mainClass = "expert";
$titreH1 = "Trajet<span class='paris_jo' style=' margin-left: 10px; '>Sélectionné</span>";
$textPge =' ';
$afficherBoutonCommencer = false;

require('include/header.inc.php');
require('include/functions_depart_dest.inc.php');

?>



<?php



if (isset($_GET['departure']) && isset($_GET['arrival']) && isset($_GET['departure_date']) && isset($_GET['departure_time']) && isset($_GET['journey'])) {
    $departureName = $_GET['departure'];
    $arrivalName = $_GET['arrival'];
    $date = $_GET['departure_date'];
    $time = $_GET['departure_time'];
    $journeyIndex = $_GET['journey'];

    // Fetch journey details from Navitia API
    $departureIdentifier = searchStationIdentifier($departureName);
    $arrivalIdentifier = searchStationIdentifier($arrivalName);
    $inputDateTime = $date . ' ' . $time;

    if (validateDateTime($inputDateTime) && $departureIdentifier && $arrivalIdentifier) {
        $navitiaDateTime = convertToNavitiaFormat($inputDateTime);
        $apiKey = '882863bd-bbb0-4f8b-a8c0-5212f183a5ac';
        $url = 'https://api.navitia.io/v1/coverage/fr-idf/journeys?from=' . urlencode($departureIdentifier) . '&to=' . urlencode($arrivalIdentifier). '&datetime=' . urlencode($navitiaDateTime). '&datetime_represents=departure';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $apiKey
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            echo "Failed to retrieve data from Navitia API";
        } else {
            echo "<section class='main_journey-container'>";
            $data = json_decode($response, true);
            echo "<a href='index.php?departure=" . urlencode($departureName) . "&arrival=" . urlencode($arrivalName) . "&departure_date=" . urlencode($date) . "&departure_time=" . urlencode($time) . "#journeysContainer' class='return_link'>Retour aux résultats</a>";
            echo '<h2 class="results_tilitle">Détails du trajet</h2>';
            echo "<div class='journey-selected'>";
            echo "<div class='depart'>";
            echo '<i class="fa-solid fa-location-dot" style="color: #1a242c;"></i><span>'. $departureName . '</span>';
            echo "</div>";
            echo '<i class="fa-solid fa-arrow-right fa-rotate-90" style="color: #1a242c;"></i>';
            echo "<div class='arrival'>";
            echo '<i class="fa-regular fa-circle-dot" style="color: #1a242c;"></i><span>' . $arrivalName .'</span>';
            echo "</div>";
            echo "</div>";

            if (isset($data['journeys'][$journeyIndex]['sections'])) {
                $routeData = [];
                echo "<div class='journey_container'>";
                echo "<div class='section'>";
                foreach ($data['journeys'][$journeyIndex]['sections'] as $section) {
                    if ($section['type'] == 'public_transport') {

                   // Coordonnées de la station de départ
                   $departureLatitude = $section['from']['stop_point']['coord']['lat'];
                   $departureLongitude = $section['from']['stop_point']['coord']['lon'];
                   // Coordonnées de la station d'arrivée
                   $arrivalLatitude = $section['to']['stop_point']['coord']['lat'];
                   $arrivalLongitude = $section['to']['stop_point']['coord']['lon'];

                   // Add departure and arrival coordinates to routeData array along with color
                   $routeData[] = [
                       'coords' => [[$departureLatitude, $departureLongitude], [$arrivalLatitude, $arrivalLongitude]],
                       'color' => '#' . $section['display_informations']['color'],
                       'line' => $section['display_informations']['code'],
                   ];

                        echo "<div class='transport-details'>";
                        echo "<div class='depart-station'>";
                        echo "<div class='top'>";
                        echo "<div class='left'>";
                        if($section['display_informations']['commercial_mode'] == 'Bus'){
                            echo "<span class='bus_line' style='background-color:#{$section['display_informations']['color']}; color:#{$section['display_informations']['text_color']}'>";
                            echo $section['display_informations']['code'];
                            echo "</span>";
                        }else{
                            getImage($section['type'], $section['display_informations']['code'], $section['display_informations']['color'],$section['display_informations']['text_color'], $section['display_informations']['commercial_mode']);
                        }
                        echo "<span class='depart-name'>" . $section['from']['name'] ."</span>";
                        echo "</div>";
                        echo "<div class='right'>";
                        echo "<span>" . decodeTime($section['base_departure_date_time']) ."</span>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='bottom'>";
                        echo "<span class='line-details'>". $section['display_informations']['commercial_mode'] . " " .$section['display_informations']['code'] .  "</span>";
                        echo "<span class='line-direction'> Vers <span class='line-direction-name'>". $section['display_informations']['direction'] . "</span></span>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                       /* echo "<span>Take " . $section['display_informations']['direction'] . " (" . $section['display_informations']['code'] . ") from " . $section['from']['name'] . " to " . $section['to']['name'] . "</span>";*/

                    } elseif ((isset($section['mode']) && $section['mode'] == 'walking') ||(isset($section['transfer_type']) && $section['transfer_type'] == 'walking')) {

                        /*
                        if ($section['from']['name'] != $section['to']['name']) {
                            if (decodeTime($section['departure_date_time']) != decodeTime($section['arrival_date_time'])){
                            echo "<div class='walk-details'>";
                            echo "<div class='top'>";
                            echo "<div class='left'>";
                            getImage($section['type']);
                            echo "<span>" . $section['from']['name'] .  "</span>";
                            echo "</div>";
                            echo "<div class='right'>";
                            echo "<span>" . decodeTime($section['departure_date_time']) .  "</span>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='bottom'>";
                            echo "<span class='walk-treatment'>";
                            echo "Marcher " . differenceMinutes(decodeTime($section['departure_date_time']), decodeTime($section['arrival_date_time'])) . " min";
                            echo "</span>";
                            echo "</div>";
                            if($section['to']['name'] === $arrivalName){
                            echo "<div class='last_dest'>";
                            echo "<div class='left'>";
                            echo '<i class="fa-regular fa-circle-dot fa-xl" style="color: #1a242c;"></i>';
                            echo "<span>" . $section['to']['name'] .  "</span>";
                            echo "</div>";
                            echo "<div class='right'>";
                            echo "<span>" . decodeTime($section['arrival_date_time']) .  "</span>";
                            echo "</div>";
                            echo "</div>";
                            }
                            echo "</div>";
                        }
                    }*/

                    
                        if ($section['from']['name'] != $section['to']['name']) {
                            echo "<div class='walk-details'>";
                            echo "<div class='top'>";
                            echo "<div class='left'>";
                            getImage($section['type']);
                            echo "<span>" . $section['from']['name'] .  "</span>";
                            echo "</div>";
                            if (decodeTime($section['departure_date_time']) != decodeTime($section['arrival_date_time'])){
                            echo "<div class='right'>";
                            echo "<span>" . decodeTime($section['departure_date_time']) .  "</span>";
                            echo "</div>";
                        }
                            echo "</div>";
                            echo "<div class='bottom'>";
                            echo "<span class='walk-treatment'>";
                            echo "Marcher " . differenceMinutes(decodeTime($section['departure_date_time']), decodeTime($section['arrival_date_time'])) . " min";
                            echo "</span>";
                            echo "</div>";
                            if($section['to']['name'] === $arrivalName){
                            echo "<div class='last_dest'>";
                            echo "<div class='left'>";
                            echo '<i class="fa-regular fa-circle-dot fa-xl" style="color: #1a242c;"></i>';
                            echo "<span>" . $section['to']['name'] .  "</span>";
                            echo "</div>";
                            echo "<div class='right'>";
                            echo "<span>" . decodeTime($section['arrival_date_time']) .  "</span>";
                            echo "</div>";
                            echo "</div>";
                            }
                            echo "</div>";
                    }


                    }
                    elseif(isset($section['type']) && $section['type'] == 'waiting'){
                        echo "<div class='wait-details'>";
                        echo '<i class="fa-solid fa-person fa-2xl" style="color: #000000;"></i>';
                        echo "<span>Attendre " . differenceMinutes(decodeTime($section['departure_date_time']), decodeTime($section['arrival_date_time'])) . " min</span>";
                        echo "</div>";
                    }

                    // Check if stop points are available
                    if (isset($section['stop_date_times'])) {
                        echo "<section class='gare-list'>";
                        echo '<h4>Arrêts</h4>';
                        echo '<ul class="listeGares">';
                        $lastStop = end($section['stop_date_times']);
                        foreach ($section['stop_date_times'] as $stop) {
                            if( $section['display_informations']['commercial_mode'] === 'Bus' &&($stop == $lastStop)){
                                echo "<li>";
                                echo "" . $stop['stop_point']['label'] . "";
                                echo "</li>";
                            }
                            elseif (($stop['stop_point']['label'] != $section['from']['name'])){
                                if($stop['stop_point']['label'] != $arrivalName){
                                    echo "<li>";
                                    echo "" . $stop['stop_point']['label'] . "";
                                    echo "</li>";
                                }
                            }

                            /*elseif (($stop['stop_point']['label'] != $section['from']['name']) &&($stop != $lastStop)){
                            echo "<li>";
                            echo "" . $stop['stop_point']['label'] . "";
                            echo "</li>";
                            }*/

                        }
                        echo "</ul>";
                        if ($section['to']['name'] ===  $arrivalName){
                            echo "<div class='last-station'>";
                            echo "<div class='left'>";
                            echo '<i class="fa-regular fa-circle-dot fa-xl" style="color: #1a242c;"></i>';
                            echo "<span class='arrival-name'>" . $section['to']['name'] ."</span>";
                            echo "</div>";
                            echo "<div class='right'>";
                            echo "<span>" . decodeTime($section['arrival_date_time']) ."</span>";
                            echo "</div>";
                            echo "</div>";
                        }
                        echo "</section>";
                    }
                }
                echo "</div>";
  // Afficher la carte et les lignes de trajet
  echo '<div id="map' . $journeyIndex . '" class="map_container" style="height: 400px; width: 650px;"></div>';
  echo '<script src="https://cdn.jsdelivr.net/npm/leaflet-polylineDecorator@1.1.0/leaflet.polylineDecorator.min.js"></script>';
  echo '<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />';
  echo '<script>
  document.addEventListener("DOMContentLoaded", function() {
      initMap' . $journeyIndex . '();
  });

  function initMap' .$journeyIndex. '() {
      var map' . $journeyIndex. ' = L.map("map' .$journeyIndex . '").setView([' . $routeData[0]["coords"][0][0] . ', ' . $routeData[0]["coords"][0][1] . '], 13);
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution: "© OpenStreetMap contributors"
      }).addTo(map' . $journeyIndex . ');';

      // Ajouter les marqueurs de départ et d'arrivée
      echo 'var departureMarker = L.marker([' . $routeData[0]["coords"][0][0] . ', ' . $routeData[0]["coords"][0][1] . ']).addTo(map' . $journeyIndex . ');
      departureMarker.bindPopup("Departure: ' . $data['journeys'][$journeyIndex]['sections'][0]['from']['name'] . '");
      var arrivalMarker = L.marker([' . $routeData[count($routeData) - 1]["coords"][1][0] . ', ' . $routeData[count($routeData) - 1]["coords"][1][1] . ']).addTo(map' . $journeyIndex . ');
      arrivalMarker.bindPopup("Arrival: ' . end($data['journeys'][$journeyIndex]['sections'])['to']['name'] . '");';


      // Add polylines for each line
    foreach ($routeData as $data) {
        echo 'var polyline = L.polyline(' . json_encode($data["coords"]) . ', { color: "' . $data["color"] . '" }).addTo(map' . $journeyIndex . ');
            polyline.bindPopup("Line: ' . $data["line"] . '");';
    }

      echo '}
      </script>';
      echo "</div>";
      echo "</section>";
            } else {
                echo "No sections found for this journey.";
            }
        }
    } else {
        echo "Invalid input or unable to find station identifiers for the provided station names.";
    }
} else {
    echo "Missing parameters. Please provide departure, arrival, date, time, and journey index.";
}

?>




<?php require('include/footer.inc.php'); ?>