/* =========================================
   VACCI CARE - LOGOUT JAVASCRIPT
========================================= */

document.addEventListener("DOMContentLoaded", function () {

    const logoutBtn = document.getElementById("logoutBtn");


    /* =====================================
       LOG OUT
    ===================================== */

    if (!logoutBtn) {
        return;
    }

    logoutBtn.addEventListener("click", function () {

        const loginUrl = logoutBtn.getAttribute("href");

        logoutBtn.innerHTML = `
            <i class="bi bi-hourglass-split"></i>
            Logging Out...
        `;

        logoutBtn.style.pointerEvents = "none";

        setTimeout(function () {

            window.location.href = loginUrl;

        }, 700);

        return false;

    });

});
