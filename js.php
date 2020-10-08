<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    let refreshInterval;

    // Details tag animation handler listener
    document.querySelectorAll('details summary').forEach(elem => {
        elem.addEventListener("click", function() {animateSpoiler(elem)});
    })

    document.querySelectorAll('#notice').forEach(elem => {
        setTimeout(function () {
            $(elem).hide(500);
        }, 5000)
    })

    <?php if (in_array($page, $pagesToAutoRefresh)) { ?>

    getPage();

    refreshInterval = setInterval(getPage, 2000);

    <?php } ?>

    function getPage() {
        let url = 'pages/<?php echo($page);?>.php';

        <?php
        if (isset($_GET['id']) && $_GET['id'] != "") {
            echo("url = url + '?id=" . $_GET['id'] . "';");
        }
        ?>

        fetch(url,)
            .then(response => response.text())
            .then(data => document.getElementById('page').innerHTML = data.toString())
            .finally(console.log("Fetched: " + url.toString()));
    }

    function animateSpoiler(elem) {
        const elemParent = $(elem).parent();
        const elemParentHeight = elemParent.innerHeight();

        if (elem.getAttribute('open') == null) {
            document.body.style.overflowX = 'hidden';

            setTimeout(() => {
                elemParent.get(0).animate([
                    {height: elemParentHeight + "px"},
                    {height: elemParent.innerHeight() + "px"}
                ], {
                    duration: 250,
                    easing: 'ease-in-out'
                });
            }, 0);
        } else {
            document.body.style.overflowX = 'inherit';

            elemParent.get(0).animate([
                {height: elemParent.innerHeight() + "px"},
                {height: elemParentHeight + "px"}
            ], {
                duration: 250,
                easing: 'ease-in',
            });
        }
    }
</script>
