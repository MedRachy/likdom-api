window._ = require("lodash");

const bootstrap = require("bootstrap");
window.bootstrap = bootstrap;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    // encryption: true,
});

window.Echo.channel("reservation-created-channel").listen(
    "ReservationCreated",
    (e) => {
        var toastContainer = document.getElementById("toast-container");
        var toastElement =
            '<div id="toast-id' +
            '" class="toast align-items-center text-white bg-primary" role="alert" data-bs-autohide="false" aria-live="assertive" aria-atomic="true">' +
            '<div class="d-flex">' +
            '<div class="toast-body">' +
            "Nouvelle " +
            e.type +
            ' : <a class="text-decoration-none text-white" href="/admin/' +
            e.type +
            "/" +
            e.id +
            '">cliquer ici</a>' +
            "</div>" +
            '<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
            "</div>" +
            "</div>";
        toastContainer.insertAdjacentHTML("afterbegin", toastElement);
        var toastInit = document.getElementById("toast-id");
        var toast = new bootstrap.Toast(toastInit);
        toast.show();
    }
);
