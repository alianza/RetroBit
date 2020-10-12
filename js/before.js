let notificationBlock = false;

function checkForCurrentActivations() {
    let elems;
    if (!notificationBlock) {
        setTimeout(function () {
            elems = $(".currents .card");
            console.log(elems);
            let messageContent = "";
            if (elems.length > 0) {
                if (checkPermissions()) {
                    elems.each(function () {
                        if (messageContent !== "") {
                            messageContent += ", "
                        }
                        messageContent += $("span", this).text();
                    });
                } else {
                    return;
                }
                notify(messageContent);
                toggleBlock();
                startTimer();
            }
        }, 50);
    }
}

function startTimer() {
    setTimeout(function () { toggleBlock(); }, 65000); // Pause notifications for 65 seconds
}

function toggleBlock() {
    notificationBlock = !notificationBlock;
    console.log("Notifications Blocked: " + notificationBlock);
    return notificationBlock;
}

function checkPermissions() {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
        return false;
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        return true;
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                return true;
            }
        });
    }
    return false;
    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}

function notify(messageContent) {
    console.log("Sent Notification");
    new Notification(messageContent);
}
