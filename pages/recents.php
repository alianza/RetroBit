<h2>Recent Activations</h2>

<div class="cards_container">

<?php

//    include_once("../dbconfig.php");

    $stmt = doPDOGetStmt("SELECT * FROM (SELECT activation.*, DATE_FORMAT(activation.time,'%d-%m-%Y %H:%i:%s') as formattedTime, config.name FROM activation
                                LEFT JOIN config on activation.retrobitId = config.id ORDER BY id DESC LIMIT 10) Var1
                                ORDER BY id DESC", $db, null);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        displayActivation($row);
    }

    if ($stmt->rowCount() == 0) {
        echo("</div><div id='notice'>No activations yet...</div>");
    }

?>

</div>

<a href="index.php?page=activations">All activations</a> <a href="index.php?page=config">Configuration</a>
