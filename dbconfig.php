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

function doPDOSend(string $query, array $array, PDO $db) : PDOStatement {
    $stmt = $db->prepare($query);
    $stmt->execute($array);
    return $stmt;
}

function doPDOGet(string $query, array $array, PDO $db) : array {
    $stmt = $db->prepare($query);
    $stmt->execute($array);
    if ($stmt->rowCount() == 0) {
        return [];
    } else {
        return $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
