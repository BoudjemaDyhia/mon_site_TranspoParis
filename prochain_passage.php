<?php

$pageTitle = "Horaires";
$mainClass = "expert";
$titreH1 = "Prochains <span class='paris_jo' style=' margin-left: 10px; '>Passages</span>";
$textPge ='Consultez ici les prochains passages de trains pour vous déplacer en toute simplicité';
$afficherBoutonCommencer = false;

require('include/header.inc.php');
require('include/functions.inc.php');
require('include/lignes.inc.php');

?>



<h2 class="sm-title">Horaires des prochains passages</h2>
<section id="main_content">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="ligne-form">
    <div class="ligne-type">
        <ul>
            <li class="selected" id="rer"><figure class="svg-logo"><svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 283.46 283.46">
	        <title>Paris transit icons - RER</title>
	        <rect width="265.015" height="265.015" rx="54.565" x="9.2225" y="9.2225" fill="currentcolor" stroke="currentcolor" stroke-width="18.445"/>
	        <path fill="currentcolor" d="M243.43,119.77c0-19.13-14.18-28-28-28H188.86c-5,0-7.79,3.89-7.79,8.15V183.2c0,5,5,7.43,9.56,7.43,5.32,0,9.57-2.47,9.57-7.43V151h8.15l15.94,35.78a7,7,0,0,0,6.74,3.89c5.66,0,13.82-5.31,10.63-11.68l-15.24-31.89c9.21-4.62,17-12.76,17-27.29M171.5,181.42c0-4.26-2.84-8.85-7.8-8.85H136.77V148.12h22.32a7.93,7.93,0,0,0,7.8-8.15c0-4.25-2.84-8.16-7.8-8.16H136.77V109.49h24.81c5,0,7.79-5,7.79-8.85,0-4.26-2.83-8.86-7.79-8.86H125.43c-5,0-7.79,3.89-7.79,8.15v82.91c0,5,5,7.44,9.57,7.44H163.7c5,0,7.8-5,7.8-8.86m-65.21-61.65c0-19.13-14.16-28-28-28H51.73c-4.95,0-7.79,3.89-7.79,8.15V183.2c0,5,5,7.43,9.56,7.43,5.31,0,9.56-2.47,9.56-7.43V151h8.16l16,35.78a7,7,0,0,0,6.73,3.89c5.67,0,13.81-5.31,10.63-11.68L89.29,147.06c9.22-4.62,17-12.76,17-27.29m117.29,2.13c0,12-11,14.87-17.71,14.87H200.2v-28.7h6.72c8.87,0,16.66,3.91,16.66,13.83m-137.12,0c0,12-11,14.87-17.72,14.87H63.06v-28.7h6.75c8.85,0,16.65,3.91,16.65,13.83"/>
            </svg></figure>
            <span class="text-ligne">RER</span>
            </li>

            <li id="train"><figure class="svg-logo"><svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 283.46 283.46">
	        <title>Paris transit icons - Train</title>
	        <rect width="265.015" height="265.015" rx="54.565" x="9.2225" y="9.2225" fill="currentcolor" stroke="currentcolor" stroke-width="18.445"/>
	        <path fill="currentcolor" d="M183.87,204.6a13.27,13.27,0,0,0,1.67-1.29c5.09-4.13,9.85-10.45,13.31-20.25,4.83-13.73,8.24-26,9.18-41.12,1.31-18.6-6.35-47.53-11.43-61l-1.77-4.75c-1.09-3-5.26-9.47-12.65-17.18-6.36-6.62-12.47-7.11-21.77-7.11H122.65c-9.3,0-15.4.49-21.77,7.11-7.4,7.68-11.57,14.15-12.65,17.18l-1.78,4.78C81.37,94.41,73.72,123.34,75,142c.94,15.06,4.36,27.31,9.21,41.09,3.45,9.82,8.2,16.12,13.3,20.25a16.88,16.88,0,0,0,1.69,1.27l-27.5,30.58a6.87,6.87,0,0,0,0,9,5.31,5.31,0,0,0,8.06,0l9.5-10.54H193.8l9.48,10.54a5.32,5.32,0,0,0,8.07,0,6.89,6.89,0,0,0,0-9Zm-9.23-11.15a9.44,9.44,0,1,1,9.45-9.45,9.46,9.46,0,0,1-9.45,9.45M89.16,132.9c-5.77,0,3.3-50.66,7.43-50.66h88.85c4.49,0,15,50.66,8,50.66ZM98.78,184a9.45,9.45,0,1,1,9.45,9.45A9.44,9.44,0,0,1,98.78,184m1.92,36.9,10.12-11.25a55.65,55.65,0,0,0,12.8,1.13h35.82a55.57,55.57,0,0,0,12.79-1.13l10.13,11.25Z"/>
            </svg></figure>
            <span class="text-ligne">Train</span>
            </li>

            <li id="metro"><figure class="svg-logo"><svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 283.46 283.46">
	        <title>Paris transit icons - Paris Métro</title>
	        <circle cx="141.73" cy="141.73" r="132.515" fill="currentcolor" stroke="currentcolor" stroke-width="18.43"/>
	        <path fill="currentcolor" d="M212.25,205.15V81.5c0-7.09-3.9-14.53-15.6-14.53-8.85,0-12.4,3.9-16.29,11.69l-38.27,79.73h-.35L103.11,78.66C99.21,70.87,95.67,67,86.81,67,75.12,67,71.22,74.41,71.22,81.5V205.15c0,6.74,5.32,10.64,11.7,10.64,5.66,0,12-3.9,12-10.64V113h.36L130.4,184.6c2.47,5,5.67,7.8,11.34,7.8s8.85-2.84,11.33-7.8L188.15,113h.36v92.12c0,6.74,6.37,10.64,12.05,10.64,6.37,0,11.69-3.9,11.69-10.64"/>
            </svg></figure>
            <span class="text-ligne">Métro</span>
            </li>
        </ul>
    </div>
    <h3 class="labeltext">Sélectionnez une ligne</h3>
    <div class="LinesInfo">
    <input type="hidden" name="lineName" id="lineName" value="">
    <input type="hidden" name="transportMode" id="transportMode" value="">
        <div id="lignes">

        </div>
    </div>

    <div id="gares">
        <label for="gare" class="labeltext" style=" position: relative; bottom: 10px;">Sélectionnez une gare</label>
        <select id="gare" name="gare" class="one">
            <option value="">Sélectionnez une gare</option>
        </select>
    </div>

    <div class="ligne-form-button">
    <button type="submit">Rechercher</button>
    </div>

</form>

</section>

<section class="results">
    <h3 class="resultstext">Résultats de recherche</h3>
    <div class="horaire-result">
    <?php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['gare'])) {

    $arRName = $_GET['gare'];


    $lineName = isset($_GET['lineName']) ? $_GET['lineName'] : null;
    $transportMode = isset($_GET['transportMode']) ? $_GET['transportMode'] : null;


    if ($lineName && $transportMode) {

        $routInfo = getRoutInfo($lineName, $transportMode);

        if ($routInfo) {

            iledefrance($arRName, $routInfo['rout_id'], $transportMode);

        } else {

            echo "Erreur lors de la récupération des informations de la ligne.";
        }
    } else {

        echo "Veuillez sélectionner une ligne et un mode de transport.";
    }
}



?>
    </div>
</section>


<script>
$(document).ready(function() {
    $("#lignes").html(<?php echo json_encode($lignes_rer); ?>);

    $(".ligne-type li").click(function() {
        $(".ligne-type li").removeClass("selected");
        $(this).addClass("selected");

        $("#gare").empty().append('<option value="">Sélectionnez une gare</option>');

        var type = $(this).attr('id');

        switch(type) {
            case 'rer':
                $("#lignes").html(<?php echo json_encode($lignes_rer); ?>);
                break;
            case 'train':
                $("#lignes").html(<?php echo json_encode($lignes_train); ?>);
                break;
            case 'metro':
                $("#lignes").html(<?php echo json_encode($lignes_metro); ?>);
                break;
            default:
                break;
        }
    });

    $("#lignes").on('click', 'li', function() {
        $(this).addClass("clicked").siblings().removeClass("clicked");

        var lineName = $(this).attr("id");

        var transportMode;
        if ($("#lignes_rer").length) {
            transportMode = "rail";
        } else if ($("#lignes_train").length) {
            transportMode = "rail";
        } else if ($("#lignes_metro").length) {
            transportMode = "metro";
        }

        $("#lineName").val(lineName);
    $("#transportMode").val(transportMode);

        $.ajax({
            url: 'get_rout_info.php', 
            type: 'GET',
            data: { lineName: lineName, transportMode: transportMode }, 
            success: function(response) {
                var routInfo = JSON.parse(response); 
                var rout_id = routInfo.rout_id;
                var rout_long_name = routInfo.rout_long_name;

                $.ajax({
                    url: 'get_stops.php',
                    type: 'GET',
                    data: { rout_id: rout_id, rout_long_name: rout_long_name }, 
                    success: function(response) {
                        var stops = JSON.parse(response); 

                        var select = $("#gare");
                        select.empty(); 
                        select.append('<option value="">Sélectionnez une gare</option>'); 

                        $.each(stops, function(index, stop) {
                            select.append('<option value="' + stop + '">' + stop + '</option>');
                        });
                    }
                });
            }
        });
    });
});
</script>
<?php

require('include/footer.inc.php');

?>

