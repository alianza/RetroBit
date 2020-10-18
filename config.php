<?php

include_once("dbconfig.php");

if (isset($_GET['retrobitId']) && $_GET['retrobitId'] != '') {

    $retrobitId = $_GET['retrobitId'];

    $result = doPDOGet("SELECT * FROM config WHERE id = :id",$db ,array(':id' => $retrobitId));

    echo json_encode($result);

} else {

    echo("No Retrobit id given");

}