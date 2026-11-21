document.addEventListener("DOMContentLoaded", function () {

    const sidebar =
        document.getElementById("dashboardSidebar");

    const mobileMenuBtn =
        document.getElementById("mobileMenuBtn");

    const overlay =
        document.getElementById("dashboardOverlay");


    /* =====================================================
       OPEN SIDEBAR
    ===================================================== */

    function openSidebar() {

        if (!sidebar) {
            return;
        }

        sidebar.classList.add("open");

        if (overlay) {
            overlay.classList.add("show");
        }

        document.body.style.overflow = "hidden";
    }


    /* =====================================================
       CLOSE SIDEBAR
    ===================================================== */

    function closeSidebar() {

        if (!sidebar) {
            return;
        }

        sidebar.classList.remove("open");

        if (overlay) {
            overlay.classList.remove("show");
        }

        document.body.style.overflow = "";
    }


    /* =====================================================
       MOBILE MENU BUTTON
    ===================================================== */

    if (mobileMenuBtn) {

        mobileMenuBtn.addEventListener(
            "click",
            function () {

                if (
                    sidebar &&
                    sidebar.classList.contains("open")
                ) {

                    closeSidebar();

                } else {

                    openSidebar();

                }

            }
        );

    }


    /* =====================================================
       OVERLAY
    ===================================================== */

    if (overlay) {

        overlay.addEventListener(
            "click",
            function () {

                closeSidebar();

            }
        );

    }


    /* =====================================================
       CLOSE SIDEBAR AFTER LINK CLICK
    ===================================================== */

    const navLinks =
        document.querySelectorAll(
            ".dashboard-nav-link"
        );


    navLinks.forEach(function (link) {

        link.addEventListener(
            "click",
            function () {

                if (window.innerWidth <= 900) {
                    closeSidebar();
                }

            }
        );

    });


    /* =====================================================
       RESIZE
    ===================================================== */

    window.addEventListener(
        "resize",
        function () {

            if (window.innerWidth > 900) {
                closeSidebar();
            }

        }
    );


    /* =====================================================
       ESCAPE KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Escape") {
                closeSidebar();
            }

        }
    );

});