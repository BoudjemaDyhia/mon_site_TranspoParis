<?php

require('include/functions.inc.php');


if(isset($_GET['lineName']) && isset($_GET['transportMode'])) {

    $lineName = $_GET['lineName'];
    $transportMode = $_GET['transportMode'];
    $routInfo = getRoutInfo($lineName, $transportMode);

    // Retourner le résultat au format JSON
    echo json_encode($routInfo);
}
?>