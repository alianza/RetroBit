<?php

include_once("dbconfig.php");

if (isset($_GET['retrobitId']) && $_GET['retrobitId'] != '') {

    $retrobitId = $_GET['retrobitId'];

    $result = doPDOGet("SELECT * FROM config WHERE id = :id",$db ,array(':id' => $retrobitId));

    if (!empty($result)) {
        echo json_encode($result);
    } else {
        http_response_code(204);
    }

} else {

    echo("No Retrobit id given");

}
