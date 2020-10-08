<h2>All Activations</h2>

<?php

    include_once("../dbconfig.php");

    $stmt = doPDOGetStmt("SELECT * FROM `activation` ORDER BY id DESC", $db, null);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        displayActivation($row);

    }

    if ($stmt->rowCount() == 0) {
        echo("<div id='notice'>No activations yet...</div>");
    }
