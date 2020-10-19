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
                        $("span", this).each(function (index) {
                            (index === 1 ? messageContent += " " : null);
                            messageContent += $(this).text();
                        })
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

function previewTone(frequency, length) {
    // create web audio api context
    const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    // create Oscillator node
    let oscillator = audioCtx.createOscillator();
    // We create a gain intermediary
    const volume = audioCtx.createGain();
    // Then connect the volume to the context destination
    volume.connect(audioCtx.destination);
    // We can set & modify the gain knob
    volume.gain.value = 0.1;

    oscillator.type = 'square';
    oscillator.frequency.setValueAtTime(frequency, audioCtx.currentTime); // value in hertz
    oscillator.connect(volume);
    oscillator.start(audioCtx.currentTime);
    oscillator.stop(audioCtx.currentTime + length/1000); // convert seconds to ms
}
