<h2>Current Activations</h2>

<?php

include_once("../dbconfig.php");

$stmt = doPDOGetStmt("SELECT activation.*, config.name FROM activation LEFT JOIN config on activation.retrobitId = config.id WHERE DATE_SUB(NOW(), INTERVAL 1 MINUTE) < time", $db, null);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $id = $row['id'];
    $time = $row['time'];
    $sample = $row['sample'];
    $audio = $row['audio'];
    $visual = $row['visual'];

    displayActivation($row);

}

if ($stmt->rowCount() == 0) {
    echo("</div><div id='notice'>No current activations...</div>");
}

?>
