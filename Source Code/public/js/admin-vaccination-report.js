document.addEventListener("DOMContentLoaded", function () {

    const reportType =
        document.getElementById("reportType");

    const childReport =
        document.getElementById("childReport");

    const dateReport =
        document.getElementById("dateReport");

    const vaccineReport =
        document.getElementById("vaccineReport");


    if (reportType) {

        reportType.addEventListener("change", function () {

            const value = this.value;


            if (value === "all") {

                childReport.style.display = "block";
                dateReport.style.display = "block";
                vaccineReport.style.display = "block";

            }


            else if (value === "child") {

                childReport.style.display = "block";
                dateReport.style.display = "none";
                vaccineReport.style.display = "none";

                scrollToSection(childReport);

            }


            else if (value === "date") {

                childReport.style.display = "none";
                dateReport.style.display = "block";
                vaccineReport.style.display = "none";

                scrollToSection(dateReport);

            }


            else if (value === "vaccine") {

                childReport.style.display = "none";
                dateReport.style.display = "none";
                vaccineReport.style.display = "block";

                scrollToSection(vaccineReport);

            }

        });

    }

});



function scrollToSection(section) {

    if (!section) {
        return;
    }

    setTimeout(function () {

        section.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });

    }, 100);

}



function printReport(sectionId) {

    const section =
        document.getElementById(sectionId);

    if (!section) {
        return;
    }

    window.print();

}