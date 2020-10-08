<?php

//include_once("../dbconfig.php");

echo("<div id='stopRefresh'></div>");

if(isset($_GET['id']) && $_GET['id'] != "") {

    $id = $_GET['id'];

    if (doPDOSend("DELETE FROM activation WHERE id = :id", $db, array(':id' => $id))) {
        echo("<div id='notice'>Activation with id: $id successfully deleted</div>");
    } else {
        echo("<div id='notice'>Activation with id: $id was NOT deleted</div>");
    }
}

?>

<a href="index.php">Back home</a>
