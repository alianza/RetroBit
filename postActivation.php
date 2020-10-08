<?php

include_once("dbconfig.php");

if (isset($_GET['sample']) && $_GET['sample'] != "" &&
    isset($_GET['audio']) && $_GET['audio'] != "" &&
    isset($_GET['visual']) && $_GET['visual'] != "" &&
    isset($_GET['retrobitId']) && $_GET['retrobitId'] != "") {

    $sample = $_GET['sample'];
    $audio = $_GET['audio'];
    $visual = $_GET['visual'];
    $retrobitId = $_GET['retrobitId'];

    if (isset($sample) && isset($audio) && isset($visual)) {

        echo("Activation: Sample: $sample Audio: $audio Visual $visual \n");

//        $currentTimeStamp = date("F j, Y \a\t g:ia"); // Timestamp created on database server

        if (doPDOSend("INSERT INTO activation (sample, audio, visual, retrobitId) VALUES (:sample, :audio, :visual, :retrobitId)",
            $db, array(':sample' => $sample, 'audio' => $audio, 'visual' => $visual, 'retrobitId' => $retrobitId)
                ) -> rowCount() > 0)
        {   echo("<div id='notice'>Sample: $sample Audio: $audio Visual $visual</div>");
        } else {
            echo "<div id='notice'>Failure!</div>";
        }
    }
} else {
    echo("Not all url data given");
}

