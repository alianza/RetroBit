<?php

DEFINE("DB_USER", "root");
DEFINE("DB_PASS", "");
DEFINE("DB_NAME", "retrobit");

try {

    $db = new PDO("mysql:host=localhost;dbname=".constant("DB_NAME"), DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo $e->getMessage();
}

//For DELETE, INSERT and UPDATE queries
function doPDOSend(string $query, PDO $db, array $array = null) : bool{
    $stmt = $db->prepare($query);
    if ($array != null) { return $stmt->execute($array); } else { return $stmt->execute(); }
}

//For SELECT queries with single row
function doPDOGet(string $query,PDO $db, array $array = null) : array {
    $stmt = $db->prepare($query);
    if ($array != null) { $stmt->execute($array); } else { $stmt->execute(); }
    if ($stmt->rowCount() == 0) { return []; } else { return $stmt->fetch(PDO::FETCH_ASSOC); }
}

//For SELECT queries with multiple rows
function doPDOGetStmt(string $query,PDO $db, array $array = null) : PDOStatement {
    $stmt = $db->prepare($query);
    if ($array != null) { $stmt->execute($array); } else { $stmt->execute(); }
    return $stmt;
}

/**
 * @param $row
 */
function displayActivation($row)
{
    $id = $row['id'];
    if (!empty($row['name'])) { $name = $row['name']; } else { $name = "Unknown"; }
    $time = $row['time'];
    $audio = $row['audio'];
    $visual = $row['visual'];

    echo("
        <form class='card' action='index.php?page=activation&id=$id' method='post'>
        
        <div>
            <span>$name #$id</span>

            <span>At: $time</span>
        </div>
        <div>    
            <img alt='Visual' title='Visual indication' src='img/icons/" . ($audio == 1 ? 'volume' : 'mute') . ".png'>
            <img alt='Audible' title='Audible indication' src='img/icons/" . ($visual == 1 ? 'visual' : 'blind') . ".png'>
        </div>        
            <a href='#' onclick='this.closest(\"form\").submit(); return false;'>Open</a>
                    
        </form>");
}
