<h2>Current Activations</h2>

<?php

include_once("../dbconfig.php");

try {
    $sql = "SELECT * FROM `activation` WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < time";
    $stmt = $db->prepare($sql);
    $stmt->execute();

} catch (PDOException $e) {

    echo("<div id='melding'>");

    echo $e->GetMessage();

    echo("</div>");

}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $id = $row['id'];
    $time = $row['time'];
    $sample = $row['sample'];
    $audio = $row['audio'];
    $visual = $row['visual'];

    echo " 
     
     <form class='card'  action='index.php?page=activation&id=$id' method='post'>
        
                <span>#$id</span>
    
                <span>At: $time</span>
                
                <a href='#' onclick='this.closest(\"form\").submit(); return false;'>Open</a>
                    
        </form>";

}

if ($stmt->rowCount() == 0) {
    echo("</div><div id='melding'>No current activations...</div>");
}

?>
