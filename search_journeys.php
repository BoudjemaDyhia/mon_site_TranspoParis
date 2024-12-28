<?php

$departureName = $_GET['departure'];
$arrivalName = $_GET['arrival'];
$date = $_GET['departure_date'];
$time = $_GET['departure_time'];


// Utiliser les données pour rechercher les trajets
$departureIdentifier = searchStationIdentifier($departureName);
$arrivalIdentifier = searchStationIdentifier($arrivalName);
$inputDateTime = $date . ' ' . $time;

if (validateDateTime($inputDateTime)) {
    $navitiaDateTime = convertToNavitiaFormat($inputDateTime);

    // Vérifier si les identifiants de station sont trouvés
    if ($departureIdentifier && $arrivalIdentifier) {
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
            $data = json_decode($response, true);
            echo '<h3>Votre Trajet</h3>';
            echo "<div class='search_results'>";
            echo "<span>". $departureName . "</span>";
            echo "<div class='arrival'>";
            echo '<i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i><span>' . $arrivalName .'</span>';
            echo "</div>";
            echo '<span style=" font-size: 19px; font-weight: 400;">Partir le '. $date . ' à ' . $time . '</span>';

            echo "</div>";
            if (isset($data['journeys'])) {
                echo '<h3>Meilleurs Résultats</h3>';
                foreach ($data['journeys'] as $index => $journey) {
                    echo "<div class='journey'>";
                    echo "<a href='journey.php?departure=" . urlencode($departureName) . "&arrival=" . urlencode($arrivalName) . "&departure_date=" . urlencode($date) . "&departure_time=" . urlencode($time) . "&journey=" . $index . "'>";
                    echo "<div class='top'>";
                    echo "<div class='left'>";
                    // Passer à travers les sections du trajet
                    if (isset($journey['sections'])) {
                        foreach ($journey['sections'] as $sectionIndex => $section) {
                            $skipArrow = false;
                            if (isset($section['mode'])) {
                                if ($section['mode'] == 'walking') {
                                    if ($section['from']['name'] != $section['to']['name']) {
                                // Appeler la fonction getImage avec le type de section
                                getImage($section['type']);
                                if ($sectionIndex < count($journey['sections']) - 1) {
                                    // Insérer l'image de la flèche
                                    echo '<div class="point"></div>';
                                }
                        }
                                }
                            } elseif ($section['type'] == 'public_transport') {
                                // Appeler la fonction getImage avec le type, le code, la couleur et le mode commercial de la section
                                getImage($section['type'], $section['display_informations']['code'], $section['display_informations']['color'], $section['display_informations']['text_color'], $section['display_informations']['commercial_mode']);
                                for ($i = $sectionIndex + 1; $i < count($journey['sections']); $i++) {
                                    $nextSection = $journey['sections'][$i];
                                    if ((isset($nextSection['mode']) && $nextSection['mode'] == 'walking') && ($nextSection['from']['name'] != $nextSection['to']['name'])) {
                                        $skipArrow = true;
                                        break;
                                    } elseif ($nextSection['type'] == 'public_transport') {
                                        $skipArrow = true;
                                        break;
                                    }
                                }
                                if ($skipArrow) {
                                    if ($sectionIndex < count($journey['sections']) - 1) {
                                        // Insérer l'image de la flèche
                                        echo '<div class="point"></div>';
                                    }
                            }
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='right'>";
                    if (isset($journey['fare']['total']['value'])) {
                        echo "<span class='journey_info'>" . centimesToEuros($journey['fare']['total']['value']) . " € </span>";
                    } else {
                        echo "<span class='journey_info'>Price information not available</span>";
                    }
                    echo "</div>";
                    echo "</div>";

                    echo "<div class='bottom'>";
                    echo "<div class='left'>";
                    // Afficher les informations de trajet en dehors de la div trajet mais à l'intérieur de la balise <a>
                    echo "<span class='journey_info'>" . decodeTime($journey['departure_date_time']) . "</span>";
                    echo '<i class="fa-solid fa-arrow-right" style="color: #000000;"></i>';
                    echo "<span class='journey_info'>" . decodeTime($journey['arrival_date_time']) . "</span>";
                    echo "</div>";
                    echo "<div class='right'>";
                    echo "<span class='journey_info'>" . formatDuration($journey['duration']) . "</span>";
                    echo "<span class='time_min'>min</span>";
                    echo "</div>";
                    echo "</div>";

                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "No journeys found.";
            }
        }
    } else {
        echo "Error: Unable to find station identifiers for the provided station names.";
    }
}


?>
