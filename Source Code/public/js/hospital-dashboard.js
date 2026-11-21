document.addEventListener("DOMContentLoaded", function () {

    /* ==========================================
       SIDEBAR TOGGLE
    ========================================== */

    const sidebar = document.getElementById("hospitalSidebar");
    const toggleButton = document.getElementById("sidebarToggle");

    if (sidebar && toggleButton) {

        toggleButton.addEventListener("click", function () {

            sidebar.classList.toggle("open");

        });

    }


    /* ==========================================
       CLOSE SIDEBAR WHEN CLICKING OUTSIDE
       ON MOBILE
    ========================================== */

    document.addEventListener("click", function (event) {

        if (!sidebar || !toggleButton) {
            return;
        }

        const isMobile = window.innerWidth <= 1000;

        if (!isMobile) {
            return;
        }

        if (
            sidebar.classList.contains("open") &&
            !sidebar.contains(event.target) &&
            !toggleButton.contains(event.target)
        ) {

            sidebar.classList.remove("open");

        }

    });


    /* ==========================================
       NOTIFICATION BUTTON
    ========================================== */

    const notificationButton =
        document.querySelector(".notification-btn");

    if (notificationButton) {

        notificationButton.addEventListener("click", function () {

            notificationButton.classList.toggle("notification-active");

        });

    }


    /* ==========================================
       RESIZE HANDLING
    ========================================== */

    window.addEventListener("resize", function () {

        if (window.innerWidth > 1000 && sidebar) {

            sidebar.classList.remove("open");

        }

    });

});