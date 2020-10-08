<!DOCTYPE html>
<html lang="en">

<?php

$pagesToAutoRefresh = array("home", "activations");

include_once("dbconfig.php");

include_once("header.php");

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = "home";
}

?>

<div id="page" class="<?php echo($page) ?>">

    <?php if ($page && !in_array($page, $pagesToAutoRefresh)) { include("pages/" . $page . ".php"); } ?>

</div>

<?php include_once("js.php"); include_once("footer.php"); ?>
