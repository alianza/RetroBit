<?php

//include_once("../dbconfig.php");

echo("<div id='stopRefresh'></div>");

$id = $name = $audio = $visual = $threshold = $alert_repeat = $sound_frequency = $sound_length = $visual_color = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['id'])) { $id = $_POST['id']; }

    if (isset($_POST['submit']) || isset($_POST['delete'])) {

        if (isset($_POST['name'])) { $name = $_POST['name']; }
        if (isset($_POST['audio'])) { $audio = 1; } else { $audio = 0; }
        if (isset($_POST['visual'])) { $visual = 1; } else { $visual = 0; }
        if (isset($_POST['threshold'])) {$threshold = $_POST['threshold'];}
        if (isset($_POST['alert_repeat'])) {$alert_repeat = $_POST['alert_repeat'];}
        if (isset($_POST['sound_frequency'])) {$sound_frequency = $_POST['sound_frequency'];}
        if (isset($_POST['sound_length'])) {$sound_length = $_POST['sound_length'];}
        if (isset($_POST['visual_color'])) {$visual_color = hexdec($_POST['visual_color']);}

        if (isset($_POST['submit'])) {

            if (doPDOSend("UPDATE config SET name = :new_name, audio = :new_audio, visual = :new_visual, 
                            threshold = :new_threshold, alert_repeat = :new_alert_repeat, sound_frequency = :new_sound_frequency, 
                            sound_length = :new_sound_length, visual_color = :new_visual_color WHERE id = :old_id", $db,
                array(':new_name' => $name, ':new_audio' => $audio, 'new_visual' => $visual, 'new_threshold' => $threshold,
                    ':new_alert_repeat' => $alert_repeat, ':new_sound_frequency' => $sound_frequency,
                    ':new_sound_length' => $sound_length, ':new_visual_color' => $visual_color, ':old_id' => $id))) {
                echo("<div id='notice'>Successfully updated $name</div>");
            } else {
                echo("<div id='notice'>Not updated</div>");
            }
        } else if (isset($_POST['delete'])) {
            if (doPDOSend("DELETE FROM config WHERE id = :id", $db, array(':id' => $id))) {
                echo("<div id='notice'>Config for $name successfully deleted</div>");
            } else {
                echo("<div id='notice'>Config for $name was NOT deleted</div>");
            }
        }
    } else if (isset($_POST['new_retrobit'])) {
        if (doPDOSend("INSERT INTO config () VALUES ()", $db, null)) {
            echo("<div id='notice'>New RetroBit created</div>");
        } else {
            echo("<div id='notice'>No new RetroBit created</div>");
        }
    }
}

$stmt = doPDOGetStmt("SELECT * FROM config", $db, null);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo("
    <details " . ($row['id'] === $id ? 'open': '') . " >
         <summary>{$row["name"]}</summary>
         <form method='post' enctype='multipart/form-data'>
          <div class='field'>
            <label for='name'>Name</label>
            <input type='text' id='name' name='name' value='{$row['name']}'>
         </div>
         <div class='field'>
            <label for='audio'>Audio alert</label>
            <input type='checkbox' id='audio' name='audio' " . ($row['audio'] == 1 ? 'checked' : '') . ">
         </div>  
         <div class='field'> 
            <label for='audio'>Visual alert</label>
            <input type='checkbox' id='visual' name='visual' " . ($row['visual'] == 1 ? 'checked' : '') . ">
         </div>  
         <div class='field'>    
            <label for='threshold'>Sound threshold</label>
            <input type='number' id='threshold' name='threshold' value='{$row["threshold"]}'>
         </div>
         <div class='field'>    
            <label for='alert_repeat'>Alert repeat</label>
            <input type='number' id='alert_repeat' name='alert_repeat' value='{$row["alert_repeat"]}'>
         </div>
         <div class='field'>    
            <label for='sound_frequency'>Audio frequency (hz)</label>
            <input type='number' id='sound_frequency' name='sound_frequency' value='{$row["sound_frequency"]}'>
         </div>
         <div class='field'>    
            <label for='sound_length'>Sound length</label>
            <input type='number' id='sound_length' name='sound_length' value='{$row["sound_length"]}'>
         </div>
         <div class='field'>    
            <label for='visual_color'>Visual alert color</label>
            <input type='color' id='visual_color' name='visual_color' value='" . "#".substr("000000".dechex($row["visual_color"]),-6) . "'>
         </div>      
         
            <input type='hidden' name='id' value='{$row["id"]}'>
            <br>
         <div class='field'> 
            <input type='submit' name='submit' value='Update'>
         </div>  
         <div class='field'> 
            <input type='submit' name='delete' value='Remove {$row["name"]}'>
         </div>  
        </form>
    </details>
    ");

}

// TODO Add color config (html5 color picker)

?>

<form method='post' enctype='multipart/form-data'>
    <input type="submit" name="new_retrobit" class="fab material-icons" value="add">
</form>
