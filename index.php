<?php
$pageTitle = "Transpo Paris";
$mainClass = "expert";
$titreH1 = "Transpo<span class='paris_jo'>Paris2024</span>";
$textPge ='Votre guide de transport pour une navigation fluide au cœur des Jeux Olympiques Paris 2024 ! Découvrez les horaires des trains, RER et métro en Île-de-France, et planifiez vos itinéraires en toute simplicité avec TranspoParis2024';
$afficherBoutonCommencer = true;


require('include/header.inc.php');
require('include/functions_depart_dest.inc.php');

?>


<div class="container" id="main_content">
    <h2>Où allons-nous ?</h2>
    <form id="stationForm" action="index.php" method="get">
        <fieldset class="fieldset_deplacement">
            <div class="top">
        <div class="dropdown">
            <label for="departure">Départ</label>
            <input type="text" id="departure" name="departure" required autocomplete="off">
            <div id="departureSuggestions" class="dropdown-content"></div>
        </div>
        <a id="swapStations"><i class="fa-solid fa-arrow-right-arrow-left fa-xl" style="color: #D7C379;"></i></a>

        <div class="dropdown">
            <label for="arrival">Arrivée</label>
            <input type="text" id="arrival" name="arrival" required autocomplete="off">
            <div id="arrivalSuggestions" class="dropdown-content"></div>
        </div>
        </div>
        <div class="bottom">
        <div class="left">
        <?php date_default_timezone_set('Europe/Paris'); ?>
        <label for="departure_date">Date et Heure du départ</label>
        <input type="date" id="departure_date" name="departure_date" required value="<?php echo date('Y-m-d'); ?>">
        <input type="time" id="departure_time" name="departure_time" required value="<?php echo date('H:i'); ?>">
        </div>
        <div class="right">
        <button id="searchJourneys" type="submit">Rechercher</button>
        </div>
        </div>
        </fieldset>
    </form>
</div>

<div id="journeysContainer">
    <?php
    // Vérifier si des paramètres sont passés dans l'URL
    if (isset($_GET['departure'], $_GET['arrival'], $_GET['departure_date'], $_GET['departure_time'])) {

        $departureName = $_GET['departure'];
        $arrivalName = $_GET['arrival'];
        $date = $_GET['departure_date'];
        $time = $_GET['departure_time'];
        setcookie('last_journey', json_encode([
            'departure' => $departureName,
            'arrival' => $arrivalName,
            'departure_date' => $date,
            'departure_time' => $time
        ]), time() + (7 * 24 * 60 * 60), '/');

        include('search_journeys.php');
        logSearch($departureName, $arrivalName);
    }
    ?>
</div>


<?php
echo '<section id="last_search">';
echo '<h3 class="last_search_tilte">Dernière Recherche</h3>';
echo "<div class='search_results'>";

if(isset($_COOKIE['last_journey'])) {
    $lastJourneyData = json_decode($_COOKIE['last_journey'], true);


    $departureName_cookie = $lastJourneyData['departure'];
    $arrivalName_cookie = $lastJourneyData['arrival'];
    $date_cookie = $lastJourneyData['departure_date'];
    $time_cookie = $lastJourneyData['departure_time'];


    echo "<span>". $departureName_cookie . "</span>";
    echo "<div class='arrival'>";
    echo '<i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i><span>' . $arrivalName_cookie .'</span>';
    echo "</div>";
    echo '<span style=" font-size: 19px; font-weight: 400;">Partir le '. $date_cookie . ' à ' . $time_cookie . '</span>';
} else {
    echo '<span class="cookie_na">Aucune recherche effectuée</span>';
}

echo '</div>';
echo '</section>';
?>

<section class="cartes" id="services">
    <h2 class="titre">Services</h2>
    <div class="contetnt">
        <a href="#main_content" class="link-carte">
        <div class="carte">
            <div class="icon">
            <i class="fa-solid fa-location-dot"></i>
            </div>
            <div class="info">
                <h3>Itinéraires</h3>
                <p>Planifiez vos déplacements avec précision pour ne rien manquer de l'action</p>
            </div>
        </div>
        </a>
        <a href="prochain_passage.php" class="link-carte">
        <div class="carte">
            <div class="icon">
            <i class="fa-regular fa-clock"></i>
            </div>
            <div class="info">
                <h3>Horaires</h3>
                <p>Consultez ici les prochains passages de trains pour vous déplacer en toute simplicité</p>
            </div>
        </div>
        </a>
        <a href="stats.php" class="link-carte">
        <div class="carte">
            <div class="icon">
            <i class="fa-solid fa-chart-simple"></i>
            </div>
            <div class="info">
                <h3>Statistiques</h3>
                <p>Découvrez les statistiques des gares les plus consultées sur notre site officiel pendant les Jeux Olympiques</p>
            </div>
        </div>
        </a>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#swapStations').click(function() {
            var departureValue = $('#departure').val();
            var arrivalValue = $('#arrival').val();

            // Swap the values
            $('#departure').val(arrivalValue);
            $('#arrival').val(departureValue);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#departure, #arrival').on('input', function () {
            var input = $(this).val();
            var fieldId = $(this).attr('id');
            var suggestionsDiv = $('#' + fieldId + 'Suggestions');

            if (input.length >= 2) {
                $.ajax({
                    url: 'fetch_stations.php', 
                    method: 'POST',
                    data: { query: input },
                    success: function (response) {
                        suggestionsDiv.html(response);
                        suggestionsDiv.addClass('show');
                    }
                });
            } else {
                suggestionsDiv.removeClass('show');
            }
        });

        $(document).on('click', '.dropdown-content div', function () {
            var suggestion = $(this).text();
            var fieldId = $(this).parent().prev().attr('id');
            $('#' + fieldId).val(suggestion);
            $(this).parent().removeClass('show');
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-content').removeClass('show');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#voirPlusBtn').click(function() {
            $('#journeyContainer').toggle(); 
        });
    });
</script>

<?php require('include/footer.inc.php'); ?>



