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

if ($page == "home") {
    echo("<script src='js/joke.js'></script>");
}

?>

<div id="page" class="<?php echo($page) ?>">

    <?php if ($page && !in_array($page, $pagesToAutoRefresh)) { include("pages/" . $page . ".php"); } ?>

</div>

<script>
    <?php if (in_array($page, $pagesToAutoRefresh)) { ?>
        getPage();
        refreshInterval = setInterval(getPage, 2000);
    <?php } ?>

    function getPage() {
        let url = 'pages/<?php echo($page);?>.php';

        <?php if (isset($_GET['id']) && $_GET['id'] != "") { echo("url = url + '?id=" . $_GET['id'] . "';"); } ?>

        fetch(url,).then(response => response.text())
            .then(data => document.getElementById('page').innerHTML = data.toString())
            .then(console.log("Fetched: " + url.toString()), checkForCurrentActivations());
    }
</script>

<script src="js/after.js"></script>

<?php include_once("footer.php"); ?>
