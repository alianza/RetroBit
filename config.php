<?php

include_once("dbconfig.php");

if (isset($_GET['retrobitId']) && $_GET['retrobitId'] != '') {

    $retrobitId = $_GET['retrobitId'];

    $result = doPDOGet("SELECT * FROM config WHERE id = :id", array(':id' => $retrobitId), $db);

    echo json_encode($result);

} else {

    echo("No Retrobit id given");

}

// TODO Config Crud per retrobit
// TODO Add color config (html5 color picker)
