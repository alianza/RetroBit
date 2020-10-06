<!DOCTYPE html>
<html lang="en">

<?php
include_once("dbconfig.php");

include_once("header.php");

?>

<div id="page">

    <?php

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "home";
    }

    if ($page) {
//            include("pages/" . $page . ".php");
    }
    ?>

</div>

<script>
    let refreshInterval = null;

    getPage();

    checkForRefresh();

    function checkForRefresh() {
        console.log("stopRefresh elem: " + document.getElementById("stopRefresh"));
        if (document.getElementById("stopRefresh") == null) {
            if (refreshInterval == null) {
                refreshInterval = setInterval(getPage, 2000);
            }
        } else {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    }

    function getPage() {
        let url = 'pages/<?php echo($page);?>.php';

        <?php
        if (isset($_GET['id']) && $_GET['id'] != "") {
            echo("url = url + '?id=" . $_GET['id'] . "';");
        }
        ?>

        fetch(url)
            .then(response => response.text())
            .then(data => document.getElementById('page').innerHTML = data.toString())
            .then(checkForRefresh)
            .finally(console.log("Fetched: " + url.toString()));
    }

    function stopInterval() {
        clearInterval(refreshInterval);
    }
</script>

<?php

include_once("footer.php");
?>
