document.addEventListener("DOMContentLoaded", function () {

    const childSelect = document.getElementById("childSelect");

    if (childSelect) {

        childSelect.addEventListener("change", function () {

            const selectedChild = this.value;

            console.log("Selected child:", selectedChild);

            /*
             * Frontend only:
             * Later database/backend integration
             * can be added here.
             */

        });

    }


    /* =========================================
       BOOK APPOINTMENT BUTTON
    ========================================= */

    const appointmentButtons =
        document.querySelectorAll(".schedule-action-btn");

    appointmentButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            window.location.href = "book-vaccination.php";

        });

    });


    /* =========================================
       SIDEBAR TOGGLE
       Uses existing dashboard sidebar
    ========================================= */

    const sidebarToggle =
        document.getElementById("sidebarToggle");

    const dashboardSidebar =
        document.getElementById("dashboardSidebar");

    if (sidebarToggle && dashboardSidebar) {

        sidebarToggle.addEventListener("click", function () {

            dashboardSidebar.classList.toggle("active");

        });

    }

});