<h2>Current Activations</h2>

<?php

//include_once("../dbconfig.php");

$stmt = doPDOGetStmt("SELECT * FROM `activation` WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < time", $db, null);


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $id = $row['id'];
    $time = $row['time'];
    $sample = $row['sample'];
    $audio = $row['audio'];
    $visual = $row['visual'];

    echo (" 
     <form class='card'  action='index.php?page=activation&id=$id' method='post'>
        
                <span>#$id</span>
    
                <span>At: $time</span>
                
                <a href='#' onclick='this.closest(\"form\").submit(); return false;'>Open</a>
                    
        </form>");

}

if ($stmt->rowCount() == 0) {
    echo("</div><div id='notice'>No current activations...</div>");
}

?>
