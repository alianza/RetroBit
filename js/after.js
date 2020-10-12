    let refreshInterval;

    // Details tag animation handler listener
    document.querySelectorAll("details summary").forEach(elem => {
        elem.addEventListener("click", function() {animateSpoiler(elem)});
    });

    document.querySelectorAll("#notice").forEach(elem => {
        setTimeout(function () { $(elem).hide(500); }, 5000)
    });

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
