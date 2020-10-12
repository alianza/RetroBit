<?php

    include_once("dbconfig.php");

    $id = $time = $sample = $audio = $visual = $retrobitId = $sound_frequency = $sound_length = $visual_color = $name = null;

    if (isset($_GET['id']) && $_GET['id'] != '') {
        $id = $_GET['id'];

        try {

            $result = doPDOGet("SELECT activation.*, config.name FROM activation 
                                      LEFT JOIN config ON activation.retrobitId = config.id WHERE activation.id = :id",
                                      $db, array(':id' => $id));

            if (!empty($result)) {
                $id = $result['id'];
                $time = $result['time'];
                $sample = $result['sample'];
                $audio = $result['audio'];
                $visual = $result['visual'];
                $retrobitId = $result['retrobitId'];
                $sound_frequency = $result['sound_frequency'];
                $sound_length = $result['sound_length'];
                $visual_color = $result['visual_color'];
                if (!empty($result['name'])) { $name = $result['name']; } else { $name = "Unknown"; }
            }

            echo("<h2>Activation at: $time</h2>");

            echo(" 
     <form class='card' action='index.php?page=deleteActivation&id=$id' method='post'>
    
                <h3>$name #$id</h3>
                <span id='time'>Time: $time</span>
                <span id='audio'>Audio: " . ($audio == 1 ? 'Yes' : 'No') . "</span>
                <span id='visual'>Visual: " . ($visual == 1 ? 'Yes' : 'No') . "</span>
                <span id='sample'>Sample: $sample</span>
                <span id='sample'>RetrobitId: $retrobitId</span>
                <span id='sample'>Sound Frequency: $sound_frequency</span>
                <span id='sample'>Sound Length: $sound_length</span>
                <span id='sample'>Visual Color: $visual_color</span>
                
                <input type='submit' name='delete' value='Remove'>
        </form>");

        } catch (PDOException $e) {

            echo("<div id='notice'>");

            echo $e->getMessage();

            echo("</div");

        }

    } else {

        echo("
        <div id='notice'>No activation id given...</div>
        ");
    }

    ?>

<form class="card">
    <h3>Info!</h3>
    <dl>
        <dt>Name</dt>
        <dd>The name of the RetroBit responsible for this activation</dd>

        <dt>Time</dt>
        <dd>Time of activation</dd>

        <dt>Sample</dt>
        <dd>Recorded sample when activated. Gives an indication of how loud the sound was that triggered the activation</dd>

        <dt>Audio</dt>
        <dd>If the activation had Audio Cue's</dd>

        <dt>Visual</dt>
        <dd>If the activation had Visual Cue's</dd>

        <dt>RetroBit ID</dt>
        <dd>The unique ID of the RetroBit responsible for this activation</dd>

        <dt>Sound Frequency</dt>
        <dd>The sound frequency used for this activation in hertz</dd>

        <dt>Sound Length</dt>
        <dd>The length of each audible cue</dd>

        <dt>Visual Color</dt>
        <dd>The color of the visual cue</dd>
    </dl>
</form>
