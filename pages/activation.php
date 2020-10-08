<?php

//    include_once("../dbconfig.php");

    echo("<div id='stopRefresh'></div>");

    if (isset($_GET['id']) && $_GET['id'] != '') {
        $id = $_GET['id'];

        try {

            $result = doPDOGet("SELECT * FROM activation WHERE id = :id",$db, array(':id' => $id));

            $id = $result['id'];
            $time = $result['time'];
            $sample = $result['sample'];
            $audio = $result['audio'];
            $visual = $result['visual'];
            $retrobitId = $result['retrobitId'];

            echo("<h2>Activation at: $time</h2>");

            echo(" 
     <form class='card' action='index.php?page=deleteActivation&id=$id' method='post'>
    
                <h3>#$id</h3>
            
                <span id='time'>Time: $time</span>
                
                <span id='audio'>Audio: " . ($audio == 1 ? 'Yes' : 'No') . "</span>
                
                <span id='visual'>Visual: " . ($visual == 1 ? 'Yes' : 'No') . "</span>
                
                <span id='sample'>Sample: $sample</span>
                
                <span id='sample'>RetrobitId: $retrobitId</span>
                
                <a href='#' onclick='this.closest(\"form\").submit(); return false;'>Delete</a>
                
        </form>");

        } catch (PDOException $e) {

            echo("<div id='notice'>");

            echo $e->getMessage();

            echo("</div");

        }

    }

    ?>
