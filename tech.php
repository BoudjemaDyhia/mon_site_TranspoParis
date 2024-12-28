<?php

$titreH1 = "Interactions<span class='paris_jo' style=' margin-left: 10px; '>APIs</span>";
$textPge =' ';
$afficherBoutonCommencer = false;



$pageTitle = "Developper";
$mainClass = "expert";
require('include/header.inc.php');
require('include/functions.inc.php');

?>

<h2 class="techtitle">Interactions avec les APIs</h2>

<section id="exo1">
    <div lang="en-CA" xml:lang="en-CA">
    <h2>Astronomy Picture of The Day</h2>
    <?php echo getAPODData(); ?>
    </div>
</section>

<section id="exo2">
    <h2>Position Géographique</h2>
    <?php echo getGeoPluginLocation(); ?>
</section>

<section id="exo3">
    <h2>Autres Informations sur la position</h2>
    <?php echo getIpinfoDetails(); ?>
</section>

<section id="exo4">
    <h2>Autres Informations sur l'Adresse IP</h2>
    <?php echo getWhatIsMyIpDetails(); ?>
</section>

<section id="exo5">
    <h2>Informations Fichiers CSV</h2>
    <?php echo getGeoPluginCSVData();
    
    ?>
</section>


<?php
require('include/footer.inc.php');
?>
