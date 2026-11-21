document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | PRINT REPORT
    |--------------------------------------------------------------------------
    */

    const printButton =
        document.getElementById("printReport");

    if (printButton) {

        printButton.addEventListener(
            "click",
            function () {

                window.print();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR TOGGLE
    |--------------------------------------------------------------------------
    */

    const sidebarToggle =
        document.getElementById("sidebarToggle");

    const sidebar =
        document.getElementById("dashboardSidebar");

    if (sidebarToggle && sidebar) {

        sidebarToggle.addEventListener(
            "click",
            function () {

                sidebar.classList.toggle(
                    "sidebar-open"
                );

            }
        );

    }

});