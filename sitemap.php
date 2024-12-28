<?php

/**
 * @file sitemap.php
 * @brief Plan du site répertoriant les différentes pages et liens disponibles sur le site web
 * @author Massinissa BELHARET
 * @version 1.0
 */


declare(strict_types=1);

$titreH1 = "Plan du<span class='paris_jo' style=' margin-left: 10px; '>Site</span>";
$textPge =' ';
$afficherBoutonCommencer = false;

$pageTitle = "Plan du Site";
$mainClass = "expert";
require('include/header.inc.php');
require_once('include/functions.inc.php');
?>

<div class="plan">
<section>
    <h2 class="sm-title">Sommaire</h2>
    <ul>
        <li><a href="index.php?style=<?php echo $styleParam; ?>">Itinéraires</a></li>
        <li><a href="prochain_passage.php?style=<?php echo $styleParam; ?>">Horaires</a></li>
        <li><a href="stats.php?style=<?php echo $styleParam; ?>">Statistiques</a></li>
        <li><a href="tech.php?style=<?php echo $styleParam; ?>">Developper</a></li>
    </ul>
</section>
</div>


<?php
require('include/footer.inc.php');
?>
