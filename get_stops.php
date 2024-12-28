<?php

require('include/functions.inc.php');

if(isset($_GET['rout_id']) && isset($_GET['rout_long_name'])) {

    $rout_id = $_GET['rout_id'];
    $rout_long_name = $_GET['rout_long_name'];

    $stops = getStops($rout_id, $rout_long_name);


    echo json_encode($stops);
}
?>