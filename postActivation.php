<?php

include_once("dbconfig.php");

if (isset($_GET['sample']) && $_GET['sample'] != "" &&
    isset($_GET['audio']) && $_GET['audio'] != "" &&
    isset($_GET['visual']) && $_GET['visual'] != "" &&
    isset($_GET['retrobitId']) && $_GET['retrobitId'] != "" &&
    isset($_GET['alert_repeat']) && $_GET['alert_repeat'] != "" &&
    isset($_GET['sound_frequency']) && $_GET['sound_frequency'] != "" &&
    isset($_GET['sound_length']) && $_GET['sound_length'] != "" &&
    isset($_GET['visual_color']) && $_GET['visual_color'] != "") {

    $sample = $_GET['sample'];
    $audio = $_GET['audio'];
    $visual = $_GET['visual'];
    $retrobitId = $_GET['retrobitId'];
    $alert_repeat = $_GET['alert_repeat'];
    $sound_frequency = $_GET['sound_frequency'];
    $sound_length = $_GET['sound_length'];
    $visual_color = $_GET['visual_color'];

    if (isset($sample) && isset($audio) && isset($visual)) {

        echo("Activation: Sample: $sample Audio: $audio Visual $visual \n");

//        $currentTimeStamp = date("F j, Y \a\t g:ia"); // Timestamp created on database server

        if (doPDOSend("INSERT INTO activation (sample, audio, visual, retrobitId, alert_repeat, sound_frequency, sound_length, visual_color)
            VALUES (:sample, :audio, :visual, :retrobitId, :alert_repeat, :sound_frequency, :sound_length, :visual_color)",
            $db, array(':sample' => $sample, ':audio' => $audio, ':visual' => $visual, ':retrobitId' => $retrobitId, ':alert_repeat' => $alert_repeat,
            ':sound_frequency' => $sound_frequency, ':sound_length' => $sound_length, ':visual_color' => $visual_color)))
        {   echo("<div id='notice'>Sample: $sample Audio: $audio Visual $visual RetroID $retrobitId AlertRepeat $alert_repeat soundFreq $sound_frequency SoundLength $sound_length visualColor $visual_color</div>");
        } else {
            echo "<div id='notice'>Failure!</div>";
        }
    }
} else {
    echo("Not all url data given");
}

