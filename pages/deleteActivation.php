<?php

include_once("../dbconfig.php");

if(isset($_GET['id']) && $_GET['id'] != "") {

    $id = $_GET['id'];

    if (doPDOSend("DELETE FROM activation WHERE id = :id", array(':id' => $id), $db) -> rowCount() > 0) {
        echo("<div id='stopRefresh'></div>");
        echo("<div id='melding'>Activation with id: $id successfully deleted</div>");
    } else {
        echo("<div id='stopRefresh'></div>");
        echo("<div id='melding'>Activation with id: $id was NOT deleted</div>");
    }
}

?>

<a href="index.php">Back home</a>
