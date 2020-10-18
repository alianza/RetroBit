<h2>All Activations</h2>

<div class="cards_container">

<?php

    include_once("../dbconfig.php");

    $stmt = doPDOGetStmt("SELECT activation.*,DATE_FORMAT(activation.time,'%d-%m-%Y %H:%i:%s') as formattedTime, config.name FROM activation
                                INNER JOIN config on activation.retrobitId = config.id ORDER BY id DESC",
                                $db, null);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        displayActivation($row);
    }

    if ($stmt->rowCount() == 0) {
        echo("<div id='notice'>No activations yet...</div>");
    }

    ?>

</div>
