const jokeSettings = {
    "async": true,
    "crossDomain": true,
    "url": "https://sv443.net/jokeapi/v2/joke/Programming?blacklistFlags=nsfw,racist",
    "method": "GET",
    "headers": {
        "x-rapidapi-host": "jokeapi-v2.p.rapidapi.com",
        "x-rapidapi-key": "e10c0e0e0emsh0c581dfda27dbc7p136454jsnf33f5d3999ac"
    }
};

function doJoke() {
    $("#joke").each(function () {
        $(this).hide(500, function () {
            this.remove();
            console.log("Remove: " + this);
        });
    });

    setTimeout(function () {
    $.ajax(jokeSettings).done(function (joke) {
            console.log(joke);
            if (joke.type === "twopart") {
                $('#header').after("<div id='joke'><img alt='close' onclick='$(this).parent().hide(500)' src='img/icons/close_icon.png'>" + joke.setup + "<br><strong>" + joke.delivery + "</strong></div>")
            } else {
                $('#header').after("<div id='joke'><img alt='close' onclick='$(this).parent().hide(500)' src='img/icons/close_icon.png'>" + joke.joke + "</div>")
            }
        });

    }, 500);
}

timeout = setTimeout(function () { doJoke() }, 1000);

interval = setInterval(function () { doJoke() }, 30000);
