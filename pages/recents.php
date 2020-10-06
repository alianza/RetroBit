<h2>Past Activations</h2>

<div class="cards_container">
<?php

    include_once("../dbconfig.php");

    try {
        $sql = "SELECT * FROM (SELECT * FROM activation ORDER BY id DESC LIMIT 10) Var1 ORDER BY id DESC";
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

        echo ("
        <form class='card' action='index.php?page=activation&id=$id' method='post'>
        
            <span>#$id</span>

            <span>At: $time</span>
                        
            <a href='#' onclick='this.closest(\"form\").submit(); return false;'>Open</a>
                    
        </form>");

    }

    if ($stmt->rowCount() == 0) {
        echo("</div><div id='melding'>No activations yet...</div>");
    }

?>

</div>

<a href="index.php?page=activations">All activations</a>
